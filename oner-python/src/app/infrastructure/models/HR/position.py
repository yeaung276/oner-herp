from sqlalchemy.sql.sqltypes import Integer
from sqlalchemy import Column, String
from app.infrastructure.models.baseModel import BaseModel


class Position(BaseModel):
    __tablename__='position'

    name = Column(String)
    description = Column(String)