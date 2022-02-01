from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import DateTime, Integer, String
from sqlalchemy import Column
from app.infrastructure.models import BaseModel

class OTInform(BaseModel):
    __tablename__='ot_inform'
   
    patient_id = Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient')
    inpatient_id = Column(Integer)
    operation_datetime = Column(DateTime)
    anasthetic = Column(String)
    surgeon = Column(String)
    diagnosis = Column(String,nullable=True)
    operation = Column(String)
    unit_of_blood_reserved = Column(String,nullable=True)
    lab_order_id = Column(Integer,nullable=True)
