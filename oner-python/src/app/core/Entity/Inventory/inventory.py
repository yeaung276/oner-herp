from typing import List, Optional
from pydantic import BaseModel
from datetime import date, datetime
from enum import Enum

from pydantic.fields import Field

from app.core.Entity.Inventory.pharmacy import PharmacyItem
from app.core.Entity.accounting.service_item import ServiceItem

class TransactionInOut(Enum):
    transaction_in = 'in'
    transaction_out = 'out'
    
class InventoryType(Enum):
    pharmacy_item = 'pharmacy_item'
    operation_charges = 'operation_charges'
    endo_charges = 'endo_charges'
    hemodialysis_charges = 'hemodialysis_charges'
    labour_charges = 'labour_charges'
    radiology_charges = 'radiology_charges'

class Location(BaseModel):
    id: Optional[int]
    name: str
    detail: Optional[str] = None
    
    class Config:
        orm_mode = True
        
class TransactionType(BaseModel):
    id: Optional[int]
    name: str
    type: TransactionInOut

class Inventory(BaseModel):
    id: Optional[int]
    name: str
    description: Optional[str] = None
    relation_id: int
    type: Optional[InventoryType]
    pharmacy_item: Optional[PharmacyItem]
    location_id: int
    location: Optional[Location] = None
    balance: int = 0
    unit: str
    purchasing_price: int
    batch_number: int
    expiry_date: Optional[date] = None
    service_item: Optional[ServiceItem]
    
    class Config:
        orm_mode = True
    
class InventoryTransaction(BaseModel):
    id: Optional[int]
    inventory_id: int
    inventory:Optional[Inventory]
    transaction_type: str
    type: str
    quantity: int
    unit: str
    purchasing_price: int
    selling_price: int
    opening_balance: Optional[int]
    closing_balance: Optional[int]
    note: Optional[str] = None
    created_time: Optional[datetime] = None
    
    class Config:
        orm_mode = True
        
class Unit(BaseModel):
    id: Optional[int]
    pharmacy_item_id: int
    name: str
    uom_equivalent: float
    
    class Config:
        orm_mode = True

class InventoryLight(BaseModel):
    id: int
    relation_id: int
    pharmacy_item: Optional[PharmacyItem]
    balance: int
    unit: str
    name: str
    description: str
    batch_number: int
    
    class Config:
        orm_mode = True
        
class InventoryValue(BaseModel):
    id: int
    name: str
    description: str
    expiry_date: Optional[date]
    purchasing_price:int
    balance: int
    unit: str
    location_id: int
    
    class Config:
        orm_mode = True