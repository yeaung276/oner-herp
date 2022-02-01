from typing import Optional
from pydantic import BaseModel
from datetime import date

class InventoryInput(BaseModel):
    name: str
    type: str
    description: str
    relation_id: int
    location_id: int
    unit: str
    purchasing_price: int
    batch_number: int
    expiry_date: Optional[date] = None
    
class TransferInput(BaseModel):
    from_inventory_id: int
    to_inventory_id: int
    from_quantity: int
    to_quantity: int
    from_transaction_type: str
    to_transaction_type: str
    note: str