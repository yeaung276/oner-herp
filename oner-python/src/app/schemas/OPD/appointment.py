import datetime
from typing import Optional
from pydantic import BaseModel
from app.models.OPD.appointment import Source, Status
from app.schemas.OPD.doctor import DoctorRes
from app.schemas.EMR.patient import PatientRes
            
class AppointmentInput(BaseModel):
    patient_id: int
    doctor_id: int
    appointment_time: datetime.datetime
    status: int
    source: str

class AppointmentRes(BaseModel):
    id: int
    queue_ticket_number: str
    doctor_id: int
    doctor: DoctorRes
    patient_id: int
    patient: PatientRes
    appointment_time: datetime.datetime
    status: int
    source: str
   
    class Config:
        orm_mode = True

class AppointmentDetail(AppointmentRes):
    pass