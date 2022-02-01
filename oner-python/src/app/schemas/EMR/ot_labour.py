from pydantic import BaseModel
from typing import List, Optional
from datetime import datetime

from app.core.Entity.ot_labour.operation import OperationRoom,State

class Patient(BaseModel):
    id: int
    name: str
    created_time: datetime
    class Config:
        orm_mode=True

class InformList(BaseModel):
    id: Optional[int]
    patient_id: int
    patient: Optional[Patient]
    surgeon: str
    anasthetic: str
    operation_datetime: datetime
    class Config:
        orm_mode=True
    
class OperationList(BaseModel):
    id: Optional[int]
    patient_id: int
    patient: Optional[Patient]
    surgeon: str
    anasthetic: str
    start_time: datetime
    state: State
    class Config:
        orm_mode=True
        
class LabourList(BaseModel):
    id: Optional[int]
    patient_id: int
    patient: Optional[Patient]
    surgeon: str
    anasthetic: str
    start_time: datetime
    state: State
    class Config:
        orm_mode=True
    
class InformInput(BaseModel):
    patient_id: int
    inpatient_id: Optional[int] = None
    operation_datetime: datetime
    anasthetic: str
    surgeon: str
    diagnosis: Optional[str] = None
    operation: str
    unit_of_blood_reserved: Optional[str] = None
    lab_order_id: Optional[int] = None
    
class OperationInput(BaseModel):
    patient_id: int
    anasthetic: str
    anasthesia: str
    surgeon: str
    room: OperationRoom
    start_time: datetime
    end_time: datetime
    outcome: str
    
class LabourInput(BaseModel):
    patient_id: int
    anasthetic: str
    anasthesia: str
    surgeon: str
    start_time: datetime
    end_time: datetime
    outcome: str
    
class UsageItemInput(BaseModel):
    pharmacy_item_id:int
    quantity: int
    inventory_id: int
    unit: str
    
class OTLabourAutoBill(BaseModel):
    class Items(BaseModel):
        service_item_id: int
        quantity: int
        
    items: List[Items]