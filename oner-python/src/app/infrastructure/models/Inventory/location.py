from sqlalchemy.sql.sqltypes import Integer, String
from sqlalchemy import Column
from app.infrastructure.models.baseModel import BaseModel

class StoreLocation(BaseModel):
    __tablename__='store_locations'

    name=Column(String)
    description=Column(String)