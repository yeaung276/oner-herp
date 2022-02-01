from sqlalchemy.sql.sqltypes import Integer, String
from sqlalchemy import Column
from app.models.baseModel import BaseModel

class InvestigationCategory(BaseModel):
    __tablename__='investigation_category'
   
    name=Column(String)