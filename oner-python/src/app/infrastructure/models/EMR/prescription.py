from sqlalchemy.orm import relation, relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Date, Integer
from sqlalchemy import Column, String
from app.models.baseModel import BaseModel

class PrescriptionItem(BaseModel):
    __tablename__ = 'prescription_item'

    prescription_id = Column(Integer,ForeignKey('prescription.id'))
    pharmacy_item_id = Column(Integer,ForeignKey('pharmacy_item.id'))
    pharmacy_item = relationship('PharmacyItem')
    instruction = Column(String)


class Prescription(BaseModel):
    __tablename__ = 'prescription'

    doctor_id = Column(Integer,ForeignKey('doctor.id'))
    doctor = relationship('Doctor')
    patient_id = Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient',back_populates='prescriptions')
    items = relationship('PrescriptionItem')


    