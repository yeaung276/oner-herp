from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Date, Integer
from sqlalchemy import Column, String
from app.models.baseModel import BaseModel

class MedicalRecord(BaseModel):
    __tablename__ = 'medical_record'

    # foreign keys
    patient_id = Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient',back_populates='medical_records')
    doctor_id = Column(Integer,ForeignKey('doctor.id'))
    doctor = relationship('Doctor')
    # core assessments
    height = Column(String)
    weight = Column(String)
    # wearable/vital sign
    upper_blood_pressure = Column(String)
    lower_blood_pressure = Column(String)
    pulse_rate = Column(String)
    respiratory_rate = Column(String)
    temperature = Column(String)
    rbs = Column(String)
    spo2 = Column(String)
    nurse_remark = Column(String)
    # problem
    doctor_assessment = Column(String)
    diagnosis = Column(String)
    treatment_procedure = Column(String)