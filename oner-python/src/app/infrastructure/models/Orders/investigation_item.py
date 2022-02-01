from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Integer, String
from sqlalchemy import Column
from app.models.baseModel import BaseModel

class InvestigationItem(BaseModel):
    __tablename__='investigation_item'
   
    investigation_type_id=Column(Integer,ForeignKey('investigation_type.id'))
    investigation_type=relationship('InvestigationType')
    investigation_category_id=Column(Integer,ForeignKey('investigation_category.id'))
    investigation_category=relationship('InvestigationCategory')
    name=Column(String)
    description=Column(String)
