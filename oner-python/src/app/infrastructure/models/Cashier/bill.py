from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Date, Integer
from sqlalchemy import Column, String
from app.models.baseModel import BaseModel


class BillItem(BaseModel):
    __tablename__ = 'bill_item'

    bill_id = Column(ForeignKey('bill.id'))
    service_used_id = Column(ForeignKey('service_used_record.id'))
    service_used = relationship('ServiceUsedRecord',uselist=False)


class Bill(BaseModel):
    __tablename__ = 'bill'

    patient_id = Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient')
    counter = Column(Integer)
    total_cost = Column(Integer)