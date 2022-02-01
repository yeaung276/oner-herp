import enum
from typing import List, Optional
from pydantic import BaseModel
from datetime import datetime

from pydantic.types import Json


from app.core.Entity.EMR.patient import Patient
from app.core.Entity.Inventory.pharmacy import PharmacyItem
from app.core.Entity.ot_labour.operation import State
    
class LabourUsageItem(BaseModel):
    id: Optional[int]
    pharmacy_item_id: int
    pharmacy_item: Optional[PharmacyItem]
    labour_id: int
    inventory_id: int
    quantity: int
    unit: str
    
    class Config: 
        orm_mode = True
        
class Labour(BaseModel):
    id: Optional[int]
    patient_id: int
    patient: Optional[Patient]
    anasthetic: str
    anasthesia: str
    surgeon: str
    start_time: datetime
    end_time: datetime
    outcome: str
    state: State = State.open
    usage_item: List[LabourUsageItem] = []
    info: Optional[Json] = None
    
    def hasItem(self,pharmacy_item:PharmacyItem) -> LabourUsageItem:
        return next((item for item in self.usage_item if item.pharmacy_item_id == pharmacy_item.id),None)

    class Config:
        orm_mode = True