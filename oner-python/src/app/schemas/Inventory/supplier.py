from datetime import datetime
from pydantic import BaseModel
from pydantic.types import constr

class SupplierInput(BaseModel):
    dealer: constr(max_length=32)
    company: constr(max_length=32)
    credit_term: constr(max_length=10)
    address: str
    contact: str
    remark: str
    
class SupplierResp(BaseModel):
    id: int
    dealer: str
    company: str
    address: str
    class Config:
        orm_mode = True
        
class SupplierDetail(SupplierResp):
    credit_term: str
    contact: str
    remark: str