from typing import Optional
from pydantic import BaseModel
from app.core.Entity.EMR.patient import Patient
from app.core.Entity.accounting.service_item import ServiceItem

class PatientServiceUsedRecord(BaseModel):
    id: Optional[int]
    patient_id: int
    patient: Optional[Patient]
    service_item_id: int
    service_item: Optional[ServiceItem]
    service_name: str
    quantity: int
    charge: int
    total_charge: int
    status: str
    extra: str
    
    class Config:
        orm_mode = True
    