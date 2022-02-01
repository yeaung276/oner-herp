import enum
from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import DateTime, Enum, Integer, String
from sqlalchemy import Column
from app.models.baseModel import BaseModel

class Status(enum.Enum):
    open = 1
    confirm = 2
    vital_sign_complete = 3
    consultation_in_progress = 4
    consultation_complete = 5
    complete = 6
    cancelled = 7

class Source(enum.Enum):
    Walk_In = 'Walk In'
    Phone_Call = 'phone_call'
    Online = 'online'

class Appointment(BaseModel):
    __tablename__='appointment'

    queue_ticket_number = Column(String)
    patient_id = Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient', uselist=False)
    doctor_id = Column(Integer,ForeignKey('doctor.id'))
    doctor = relationship('Doctor',uselist=False)
    appointment_time=Column(DateTime)
    status = Column(Integer)
    source = Column(String)