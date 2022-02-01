import datetime
from typing import Optional
from pydantic import BaseModel

class _employee(BaseModel):
        id: int
        name: str
        phone_number: str
        class Config:
            orm_mode = True
            
class DoctorInput(BaseModel):
    employee_id: int
    schedule: str


class DoctorRes(BaseModel):
    id: int
    schedule: str
    employee_id: int
    opd_charge_id: int
    ipd_charge_id: int
   
    employee: _employee
    class Config:
        orm_mode = True

class DoctorDetail(DoctorRes):
    pass