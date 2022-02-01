from typing import List
from fastapi_pagination import Params
from fastapi_pagination.paginator import paginate
from sqlalchemy.sql.functions import func

from app.infrastructure.models import Unit, Inventory, PharmacyItem, InventoryTransaction
from app.infrastructure.repository.common import BaseRepository
from app.core.Entity.Inventory.pharmacy import PharmacyItem as PharmacyItemDTO
from app.core.Entity.Inventory.inventory import InventoryLight, InventoryTransaction as InventoryTransactionDTO, InventoryValue, Unit as UnitDTO, Inventory as InventoryDTO

class InventoryRepository(BaseRepository):
    def get_units(self,pharmacy_item:PharmacyItemDTO) -> List[UnitDTO]:
        units_orm = self._db.query(Unit).filter(Unit.pharmacy_item_id==pharmacy_item.id).all()
        return [UnitDTO.from_orm(unit) for unit in units_orm]
    
    def get_inventory_by_location(self,location_id:int) -> List[InventoryLight]:
        inventorys = self._db.query(Inventory).filter(Inventory.location_id==location_id).all()
        return [InventoryLight.from_orm(inv) for inv in inventorys]
    
    def get_by_pharmacy_id(self,location_id:int,pharmacy_item_id:int) -> List[InventoryDTO]:
        items = self._db.query(Inventory).filter(Inventory.location_id==location_id).filter(Inventory.relation_id==pharmacy_item_id).all()
        return [InventoryDTO.from_orm(item) for item in items]
    
    def get_inventory_by_location_paginated(self,location_id:int,params:Params,hide_zero:bool=False):
        query = self._db.query(Inventory).filter(Inventory.location_id==location_id)
        if hide_zero:
            query = query.filter(Inventory.balance>0)
        return paginate(query.all(),params)
    
    def search(self,location_id:int,query:str) -> List[InventoryDTO]:
        inventorys = self._db.query(Inventory) \
            .filter(Inventory.location_id==location_id) \
            .join(Inventory.pharmacy_item) \
            .filter(
                Inventory.name.like('%'+query+'%') |
                Inventory.description.like('%'+query+'%') |
                (PharmacyItem.universal_product_code==query) |
                (str(Inventory.id)==query)
            ).all()
        return [InventoryDTO.from_orm(inv) for inv in inventorys]
    
    def get_item_master(self) -> List[PharmacyItemDTO]:
        pharmacy_items = self.readAll(PharmacyItem)
        return [PharmacyItemDTO.from_orm(item) for item in pharmacy_items]
    
    def persist(self,inv:InventoryDTO) -> InventoryDTO:
        inventory_orm = Inventory(**inv.dict(exclude={'id','pharmacy_item','location','service_item','type'}),type=inv.type.value)
        return InventoryDTO.from_orm(self.create(inventory_orm))
        
    def update(self,inv:InventoryDTO) -> InventoryDTO:
        inventory_orm = self.read(Inventory,inv.id)
        invorm = super().update(inventory_orm,inv.dict(exclude={'id','pharmacy_item','service_item','location','balance'}))
        return InventoryDTO.from_orm(invorm)
        
    def delete(self,inv:InventoryDTO) -> None:
        inventory_orm = self.read(Inventory,inv.id)
        super().delete(inventory_orm)
        
    def getById(self,id:int) -> InventoryDTO:
        inv = self.read(Inventory,id)
        return InventoryDTO.from_orm(inv)
    
    def createTransaction(self,transaction:InventoryTransactionDTO) -> None:
        inv = self.read(Inventory,transaction.inventory_id)
        new_transaction = InventoryTransaction(**transaction.dict(exclude={'id','inventory','created_time'}),relation_id=0)
        super().create(new_transaction)
        inv.balance = transaction.closing_balance
        self._db.flush()
    
    def export(self,location_id:int) -> Inventory:
        return self._db.query(Inventory).filter(Inventory.location_id==location_id).all()
    
    def getInventoryforValuation(self,location_id:int) -> List[InventoryValue]:
        inventories = self._db.query(Inventory).filter(Inventory.location_id==location_id).all()
        return [InventoryValue.from_orm(inventory) for inventory in inventories]
    
    def getAllNonZeroInventorys(self) -> List[InventoryValue]:
        inventories = self._db.query(Inventory).filter(Inventory.balance>0)
        return [InventoryValue.from_orm(inventory) for inventory in inventories]
    
    def get_transaction_by_id(self,transaction_id:int) -> InventoryTransactionDTO:
        return InventoryTransactionDTO.from_orm(self.read(InventoryTransaction,transaction_id))
    
    def get_last_transaction(self,inventory_id:int,transaction_id:int,transaction_type:str) -> InventoryTransaction:
        transaction = self._db.query(InventoryTransaction) \
            .filter(InventoryTransaction.inventory_id==inventory_id) \
            .filter(InventoryTransaction.transaction_type==transaction_type) \
            .filter(InventoryTransaction.id<transaction_id) \
            .order_by(InventoryTransaction.id.desc()).first()
        return InventoryTransactionDTO.from_orm(transaction)
    
    def find_transfer(self,location_id:int,transfer_transaction_id:int) -> InventoryTransactionDTO:
        transaction = self.read(InventoryTransaction,transfer_transaction_id)
        transfer = self._db.query(InventoryTransaction).join(InventoryTransaction.inventory) \
            .filter(Inventory.location_id==location_id) \
            .filter( Inventory.relation_id==transaction.inventory.relation_id) \
            .filter(InventoryTransaction.transaction_type==transaction.inventory.location.name) \
            .filter(func.date(InventoryTransaction.created_time)==transaction.created_time.date()) \
            .first()
        return InventoryTransactionDTO.from_orm(transfer)