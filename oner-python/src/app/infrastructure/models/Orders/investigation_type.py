from enum import auto
from sqlalchemy.sql.sqltypes import String
from sqlalchemy import Column
from app.models.baseModel import BaseModel

class InvestigationType(BaseModel):
    __tablename__='investigation_type'
    
    name=Column(String)