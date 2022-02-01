from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Date, Integer
from sqlalchemy import Column, String
from app.models.baseModel import BaseModel

class Deposit(BaseModel):
    __tablename__='deposit'

    patient_id = Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient')
    amount = Column(Integer)
    bill_id = Column(Integer,default=None)