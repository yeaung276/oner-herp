from pydantic import BaseModel
from typing import Optional
from datetime import date
from enum import Enum

class MaritalStatus(Enum):
    Single = 'Single'
    Married = 'Married'
    Divorced = 'Divorced'

class Status(Enum):
    full_time = 'full_time'
    part_time = 'part_time'
    resigned = 'resigned'

class Position(BaseModel):
    id: Optional[int]
    name: str
    description: str
    
    class Config:
        orm_mode = True
    
class Department(BaseModel):
    id: Optional[int]
    name: str
    description: str
    
    class Config:
        orm_mode = True
    
class Employee(BaseModel):
    id: Optional[int]
    name:str
    gender:str
    education:Optional[str]
    marital_status:Optional[MaritalStatus]
    number_of_children:Optional[int]
    live_with_spouse_parent:Optional[bool]
    phone_number:Optional[str]
    emergency_contact_phone:Optional[str]
    date_of_birth:Optional[date]
    nrc_number:Optional[str]
    bank_account_number:Optional[str]
    address:Optional[str]
    position_id:int
    position:Optional[Position]
    department:Optional[Department]
    department_id:int
    status: Optional[Status]
    
    class Config:
        orm_mode = True

class EmployeeShallow(BaseModel):
    id: int
    name:str
    gender:Optional[str]
    marital_status:Optional[MaritalStatus]
    phone_number:Optional[str]
    emergency_contact_phone:Optional[str]
    address:Optional[str]
    position:Position
    department:Department
    status: Optional[Status]
    class Config:
        orm_mode=True
