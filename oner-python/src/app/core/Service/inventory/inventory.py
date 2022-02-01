import functools
from datetime import datetime, timedelta
from typing import List
from app.core.CONSTANTS import MAINSTORE_LOCATION_ID
from app.core.Entity.Inventory.inventory import Inventory, InventoryLight, InventoryTransaction, Unit
from app.core.Entity.Inventory.pharmacy import PharmacyItem
from app.core.Entity.ot_labour.operation import Operation, UsageItem
from app.core.Protocol.inventory.inventory import InventoryRepo
from app.core.Entity.auth.user import User
from exceptions.inventory import NO_SERVICE_ITEM, SUPPLIER_SOURCE_ERROR, TRANSFER_SOURCE_ERROR

from utils.utils import inventoryFilterForExpiry

class InventoryService:
    def __init__(self,inventory_repo:InventoryRepo,user:User) -> None:
        self.inventory_repo = inventory_repo
        
    def get_inventory_for_transfer(self,location_id:int,pharmacy_item_id:int) -> List[Inventory]:
        return self.inventory_repo.get_by_pharmacy_id(location_id,pharmacy_item_id)
        
    def get_info(self,location_id:int) -> dict:
        inventorys = self.inventory_repo.getInventoryforValuation(location_id)
        return {
            'total': functools.reduce(lambda y,x: y+x.purchasing_price*x.balance,inventorys,0),
            'expiry': [{
                    'limit': 0,
                    'date': datetime.now().date(),
                    'items': list(filter(inventoryFilterForExpiry(-1,0),inventorys))
                },
                {
                    'limit': 1,
                    'date': datetime.now().date() + timedelta(days=30),
                    'items': list(filter(inventoryFilterForExpiry(0,1),inventorys))
                },
                {
                    'limit': 2,
                    'date': datetime.now().date() + timedelta(days=60),
                    'items': list(filter(inventoryFilterForExpiry(1,2),inventorys))
                },
                {
                    'limit': 3,
                    'date': datetime.now().date() + timedelta(days=90),
                    'items': list(filter(inventoryFilterForExpiry(2,3),inventorys))
                },
                {
                    'limit': 6,
                    'date': datetime.now().date() + timedelta(days=360),
                    'items': list(filter(inventoryFilterForExpiry(3,6),inventorys))
                },
                ]
        }
        
    def get_units(self,pharmacy_item:PharmacyItem) -> List[Unit]:
        return self.inventory_repo.get_units(pharmacy_item)
    
    def get_available_items(self,location_id) -> List[InventoryLight]:
        inventorys = self.inventory_repo.get_inventory_by_location(location_id)
        available = filter(lambda x: x.balance>0, inventorys)
        return list(available)
    
    def addInventory(self,**kargs) -> Inventory:
        new_inventory = Inventory(**kargs)
        new_inventory.balance = 0
        return self.inventory_repo.persist(new_inventory)
        
    def updateInventory(self,id:int,data:dict) -> Inventory:
        inventory = self.inventory_repo.getById(id)
        for key,value in data.items():
            setattr(inventory,key,value)
        self.inventory_repo.update(inventory)
        
    def deleteInventory(self,inventory:Inventory) -> None:
        self.inventory_repo.delete(inventory)
        
    def searchInventory(self,location_id,query) -> List[Inventory]:
        return self.inventory_repo.search(location_id,query)
    
    def createTransaction(self,**kargs) -> None:
        inventory:Inventory = kargs.get('inventory',None)
        if inventory.service_item is None:
            raise ValueError(f'service item for inventory {inventory.name} is not found')
        new_transaction = InventoryTransaction(
                inventory_id=inventory.id,
                transaction_type=kargs.get('transaction_type'),
                type=kargs.get('type'),
                quantity=kargs.get('quantity'),
                unit=inventory.unit,
                purchasing_price=inventory.purchasing_price,
                selling_price=inventory.service_item.charge,
                opening_balance=inventory.balance,
                closing_balance=self.__get_closing_balance(kargs.get('type'),inventory.balance,kargs.get('quantity')),
                note=kargs.get('note')
            )
        self.inventory_repo.createTransaction(new_transaction)
    
    def addConsumption(self,items:List[UsageItem],note:str) -> None:
        for item in items:
            inventory = self.inventory_repo.getById(item.inventory_id)
            if inventory.service_item is None:
                raise ValueError(f'service item for inventory {inventory.name} is not found')
            new_transaction = InventoryTransaction(
                inventory_id=inventory.id,
                transaction_type='Consumption',
                type='out',
                quantity=item.quantity,
                unit=inventory.unit,
                purchasing_price=inventory.purchasing_price,
                selling_price=inventory.service_item.charge,
                opening_balance=inventory.balance,
                closing_balance=self.__get_closing_balance('out',inventory.balance,item.quantity),
                note=note
            )
            self.inventory_repo.createTransaction(new_transaction)
    
    def transfer(self,**kargs) -> None:
        s_inv = self.inventory_repo.getById(kargs.get('from_inventory_id'))
        d_inv = self.inventory_repo.getById(kargs.get('to_inventory_id'))
        out_trans = InventoryTransaction(
            inventory_id=s_inv.id,
            transaction_type=kargs.get('from_transaction_type'),
            type='out',
            quantity=kargs.get('from_quantity'),
            unit=s_inv.unit,
            purchasing_price=s_inv.purchasing_price,
            selling_price=[s_inv.service_item.charge if s_inv.service_item is not None else 0][0],
            opening_balance=s_inv.balance,
            closing_balance=self.__get_closing_balance('out',s_inv.balance,kargs.get('from_quantity')),
            note=kargs.get('note')
        ) 
        self.inventory_repo.createTransaction(out_trans)
        in_trans = InventoryTransaction(
            inventory_id=d_inv.id,
            transaction_type=kargs.get('to_transaction_type'),
            type='in',
            quantity=kargs.get('to_quantity'),
            unit=d_inv.unit,
            purchasing_price=d_inv.purchasing_price,
            selling_price=[d_inv.service_item.charge if d_inv.service_item is not None else 0][0],
            opening_balance=d_inv.balance,
            closing_balance=self.__get_closing_balance('in',d_inv.balance,kargs.get('to_quantity')),
            note=kargs.get('note')
        )
        self.inventory_repo.createTransaction(in_trans)
        
    def track_source(self,transaction_id:int) -> dict:
        try:
            mainstore_incoming,dept_remainaing = self.__get_incoming_form_mainstore(transaction_id)
        except ValueError:
            mainstore_incoming, dept_remainaing = None,None
        try:
            if mainstore_incoming is None:
                raise ValueError
            supplier_incoming,store_remaining = self.__get_mainstore_supplier(mainstore_incoming)
        except ValueError:
            supplier_incoming,store_remaining = None, None
        return {
            'transfer': mainstore_incoming,
            'transfer_remaining': dept_remainaing,
            'supplier': supplier_incoming,
            'mainstore_remaining': store_remaining
        }
        
    def __get_incoming_form_mainstore(self,transaction_id:int) -> InventoryTransaction:
        transaction = self.inventory_repo.get_transaction_by_id(transaction_id)
        incoming = self.inventory_repo.get_last_transaction(transaction.inventory_id,transaction_id,'Incoming from Main Store')
        if transaction.opening_balance > incoming.quantity:
            prev_batch_closing = transaction.closing_balance - incoming.quantity
            incoming = self.inventory_repo.get_last_transaction(transaction.inventory_id,incoming.id,'Incoming from Main Store')
            return incoming, prev_batch_closing 
        return incoming,incoming.inventory.balance
    
    def __get_mainstore_supplier(self,transfer_transaction:InventoryTransaction) -> InventoryTransaction:
        transfer = self.inventory_repo.find_transfer(MAINSTORE_LOCATION_ID,transfer_transaction.id)
        incoming = self.inventory_repo.get_last_transaction(transfer.inventory_id,transfer.id,'Incoming from Supplier')
        if transfer.opening_balance > incoming.quantity:
            prev_batch_closing = transfer.closing_balance - incoming.quantity
            incoming = self.inventory_repo.get_last_transaction(transfer.inventory_id,incoming.id,'Incoming from Supplier')
            return incoming, prev_batch_closing 
        return incoming,incoming.inventory.balance
        
    def __get_closing_balance(self,type:str,opening_balance:int,quantity:int) -> int:
        if type=='out':
            closing = opening_balance - quantity
            if closing < 0:
                raise ValueError('Inventory out of stock')
            return closing
        elif type=='in':
            return opening_balance + quantity
        
        
    
