from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Date, Integer
from sqlalchemy import Column, String
from app.models.baseModel import BaseModel

class Payment(BaseModel):
    __tablename__='payment'

    patient_id = Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient')
    bill_id = Column(Integer,ForeignKey('bill.id'))
    collected_amount = Column(Integer)