from datetime import date
from typing import Optional
from pydantic import BaseModel

from core.models.HR.employee import MaritalStatus, Status

class PositionSch(BaseModel):
    id:int
    name:str
    description:str
    class Config:
        orm_mode=True

class DepartmentSch(BaseModel):
    id:Optional[int]
    name:Optional[str]
    description:Optional[str]
    class Config:
        orm_mode=True

class EmployeeInputSch(BaseModel):
    name:Optional[str]
    gender:Optional[str]
    education:Optional[str]
    marital_status:Optional[MaritalStatus]
    number_of_children:Optional[int]
    live_with_spouse_parent:Optional[bool]
    phone:Optional[str]
    emergency_phone:Optional[str]
    date_of_birth:Optional[date]
    nrc_number:Optional[str]
    bank_account_number:Optional[str]
    address:Optional[str]
    position_id:Optional[int]
    department_id:Optional[int]
    status: Optional[Status]

class EmployeeDetailSch(BaseModel):
    name:str
    gender:str
    education:str
    marital_status:MaritalStatus
    number_of_children:int
    live_with_spouse_parent:bool
    phone:str
    emergency_phone:str
    date_of_birth:date
    nrc_number:str
    bank_account_number:str
    address:str
    position:PositionSch
    department:DepartmentSch
    status: Status
    class Config:
        orm_mode=True

class EmployeeCommonSch(BaseModel):
    name: str
    gender: str
    education: str
    position:PositionSch
    department:DepartmentSch
    class Config:
        orm_mode=True