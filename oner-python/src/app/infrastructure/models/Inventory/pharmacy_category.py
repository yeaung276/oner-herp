from enum import auto
from sqlalchemy.sql.sqltypes import Integer, String
from sqlalchemy import Column
from app.infrastructure.models.baseModel import BaseModel

class PharmacyCategory(BaseModel):
    __tablename__='pharmacy_category'

    name=Column(String)
    description=Column(String)