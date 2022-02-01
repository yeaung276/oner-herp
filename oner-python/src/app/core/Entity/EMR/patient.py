import enum
import datetime
from typing import Any, Optional
from pydantic import BaseModel

class Gender(enum.Enum):
    Male = 'Male'
    Female = 'Female'

class Patient(BaseModel):
    id: Optional[int]
    patient_id: Optional[int]
    name: str
    phone: str
    age: str
    gender: Any
    created_time: datetime.datetime
    date_of_birth: Optional[datetime.date]
    blood_group: Optional[str]
    address: Optional[str]
    
    class Config:
        orm_mode = True
