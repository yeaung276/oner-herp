from enum import auto
from sqlalchemy.sql.sqltypes import String
from sqlalchemy import Column
from app.infrastructure.models import BaseModel

class Supplier(BaseModel):
    __tablename__='supplier'

    dealer=Column(String(32))
    company=Column(String(32))
    credit_term=Column(String(10))
    address=Column(String)
    contact=Column(String)
    remark=Column(String)