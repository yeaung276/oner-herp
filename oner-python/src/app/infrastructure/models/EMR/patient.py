import enum
from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import Sequence
from sqlalchemy.sql.sqltypes import Date, Enum, Integer
from sqlalchemy import Column, String
from app.infrastructure.models import BaseModel
from app.infrastructure.models.baseModel import Base

class Gender(enum.Enum):
    Male = 'Male'
    Female = 'Female'
class Patient(BaseModel):
    __tablename__='patient'

    patient_id_seq = Sequence('patient_id_seq',start=1,increment=1,metadata=Base.metadata)
    id = Column(Integer, index=True, autoincrement=True, primary_key=True)
    patient_id = Column(Integer,nullable=True)
    name = Column(String)
    gender = Column(Enum(Gender))
    date_of_birth = Column(Date)
    age = Column(Integer)
    address = Column(String)
    phone = Column(String)
    blood_group = Column(String)
    # medical_records = relationship('MedicalRecord',uselist=True)
    # prescriptions = relationship('Prescription',uselist=True)
    # investigations = relationship('InvestigationResult',uselist=True)
