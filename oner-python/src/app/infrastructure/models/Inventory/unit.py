from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Float, Integer, String
from sqlalchemy import Column
from app.infrastructure.models import BaseModel

class Unit(BaseModel):
    __tablename__='unit'

    pharmacy_item_id=Column(Integer,ForeignKey('pharmacy_item.id'))
    name=Column(String,nullable=False)
    uom_equivalent=Column(Float)