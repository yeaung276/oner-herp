import datetime
from typing import Optional
from pydantic import BaseModel

from app.core.Entity.EMR.patient import Gender

class PatientInput(BaseModel):
    name: str
    age: int
    date_of_birth: Optional[datetime.date] = None
    gender: Gender
    blood_group: Optional[str] = None
    phone: str
    address: Optional[str] = None
