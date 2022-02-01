from typing import List, Protocol
from app.core.Entity.Inventory.inventory import Inventory, InventoryLight, InventoryTransaction, InventoryValue, Unit
from app.core.Entity.Inventory.pharmacy import PharmacyItem


class InventoryRepo(Protocol):
    def get_units(self,pharmacy_item:PharmacyItem) -> List[Unit]:
        ...
        
    def get_inventory_by_location(self,location_id:int) -> List[InventoryLight]:
        ...
        
    def get_item_master(self) -> List[PharmacyItem]:
        ...
        
    def persist(self,inv:Inventory) -> Inventory:
        ...
        
    def update(self,inv:Inventory) -> Inventory:
        ...
        
    def delete(self,inv:Inventory) -> None:
        ...
        
    def getById(self,id:int) -> Inventory:
        ...
        
    def search(self,location_id:int,query:str) -> List[Inventory]:
        ...
        
    def createTransaction(self,transaction:InventoryTransaction) -> InventoryTransaction:
        ...
        
    def getInventoryforValuation(self,location_id:int) -> List[InventoryValue]:
        ...
        
    def get_by_pharmacy_id(self,location_id:int,pharmacy_item_id:int) -> List[Inventory]:
        ...
    
    def getAllNonZeroInventorys(self) -> List[InventoryValue]:
        ...
        
    def get_transaction_by_id(self,transaction_id:int) -> InventoryTransaction:
        ...
        
    def get_last_transaction(self,inventory_id:int,transaction_id:int,transaction_type:str) -> InventoryTransaction:
        ...
        
    def find_transfer(self,location_id:int,transfer_transaction_id:int) -> InventoryTransaction:
        ...