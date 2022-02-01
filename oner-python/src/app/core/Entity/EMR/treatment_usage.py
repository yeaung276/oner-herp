from datetime import datetime
from pydantic import BaseModel
from typing import List, Optional
import enum

from pydantic.types import Json

from app.core.Entity.EMR.patient import Patient
from app.core.Entity.Inventory.pharmacy import PharmacyItem

class State(enum.Enum):
    open = 'open'
    close = 'close'
    
class TreatmentUsageItem(BaseModel):
    id: Optional[int]
    pharmacy_item_id: int
    pharmacy_item: Optional[PharmacyItem]
    treatment_usage_id: int
    inventory_id: int
    quantity: int
    unit: str
    
    class Config: 
        orm_mode = True

class TreatmentUsage(BaseModel):
    id: Optional[int]
    patient_id: int
    patient: Optional[Patient]
    type: str
    reference_id: int
    state: State = State.open
    usage_items: List[TreatmentUsageItem] = []
    created_time: Optional[datetime]
    info: Optional[Json] = None
    
    def hasItem(self,pharmacy_item:PharmacyItem) -> TreatmentUsageItem:
        return next((item for item in self.usage_items if item.pharmacy_item_id == pharmacy_item.id),None)
    
    class Config: 
        orm_mode = True
        

        