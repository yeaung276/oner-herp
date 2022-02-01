from sqlalchemy.sql.sqltypes import Integer
from sqlalchemy import Column, String
from app.infrastructure.models.baseModel import BaseModel


class Department(BaseModel):
    __tablename__='department'

    name = Column(String)
    description = Column(String)