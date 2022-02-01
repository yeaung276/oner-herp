import enum
from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Enum, Integer
from sqlalchemy import Column, String
from app.infrastructure.models import BaseModel


class ServiceUsedRecord(BaseModel):
    __tablename__='patient_service_used_records'

    patient_id=Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient')
    service_item_id = Column(Integer,ForeignKey('service_item.id'))
    service_item = relationship('ServiceItem')
    service_name = Column(String)
    quantity = Column(Integer)
    charge = Column(Integer)
    total_charge = Column(Integer)
    extra = Column(String)
    status = Column(String)