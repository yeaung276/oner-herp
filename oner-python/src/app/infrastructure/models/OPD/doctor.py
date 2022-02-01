from enum import auto
from sqlalchemy import Column, String, Enum, Boolean, Integer,Date
from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import BigInteger
from app.models.baseModel import BaseModel


class Doctor(BaseModel):
    __tablename__ = 'doctor'
   
    employee_id = Column(BigInteger, ForeignKey('employee.id'),unique=True)
    employee = relationship('Employee', uselist=False)
    schedule = Column(String)
    opd_charge_id = Column(Integer, ForeignKey('service_item.id'))
    opd_charge = relationship('ServiceItem',foreign_keys=[opd_charge_id],uselist=False)
    ipd_charge_id = Column(Integer, ForeignKey('service_item.id'))
    ipd_charge = relationship('ServiceItem',foreign_keys=[ipd_charge_id], uselist=False)