import enum
from typing import List, Optional
from pydantic import BaseModel
from datetime import datetime
from pydantic.types import Json

from sqlalchemy.sql.sqltypes import Boolean

from app.core.Entity.EMR.patient import Patient
from app.core.Entity.Inventory.pharmacy import PharmacyItem

class OperationRoom(enum.Enum):
    room_1 = 'room_1'
    room_2 = 'room_2'
    room_3 = 'room_3'
    room_5 = 'room_5'
    
class State(enum.Enum):
    open = 'open'
    close = 'close'

class Inform(BaseModel):
    id: Optional[int]
    patient_id: int
    patient: Optional[Patient]
    inpatient_id: Optional[int]
    operation_datetime: datetime
    anasthetic: str
    surgeon: str
    diagnosis: Optional[str]
    operation: str
    unit_of_blood_reserved: Optional[str]
    lab_order_id: Optional[int]

    class Config:
        orm_mode = True
    
class UsageItem(BaseModel):
    id: Optional[int]
    pharmacy_item_id: int
    pharmacy_item: Optional[PharmacyItem]
    operation_id: int
    inventory_id: int
    quantity: int
    unit: str
    
    class Config: 
        orm_mode = True
        
class Operation(BaseModel):
    id: Optional[int]
    patient_id: int
    patient: Optional[Patient]
    anasthetic: str
    anasthesia: str
    surgeon: str
    room: OperationRoom
    start_time: datetime
    end_time: datetime
    outcome: str
    state: State = State.open
    usage_item: List[UsageItem] = []
    info: Optional[Json] = None
    
    def hasItem(self,pharmacy_item:PharmacyItem) -> UsageItem:
        return next((item for item in self.usage_item if item.pharmacy_item_id == pharmacy_item.id),None)

    class Config:
        orm_mode = True
        
    

    