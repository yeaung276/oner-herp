from typing import List
from datetime import date, datetime
from sqlalchemy.orm.session import Session
from sqlalchemy import func

from app.models.baseModel import User
from app.models import Appointment
from app.services.common import CRUDService
from exceptions.opd import TERMINAL_STAGE

class AppointmentService:
    """appointment services"""
    def __init__(self,db:Session,user:User):
        self._db = db
        self._user = user
        self.crud = CRUDService(self._db,self._user)

    def getAllAppointments(self) -> List[Appointment]:
        return self.crud.readAll(Appointment)

    def getAppointmentsByDate(self,appointment_date:date) -> List[Appointment]:
        return self._db.query(Appointment).filter(func.date(Appointment.appointment_time)==appointment_date).all()

    def getAppointment(self,id:int) -> Appointment:
        return self.crud.read(Appointment,id)

    def addAppointment(self,payload:dict) -> Appointment:
        new_appointment = Appointment(**payload)
        # custom query
        existing_appointments = self._db.query(Appointment).filter(func.date(Appointment.appointment_time)==new_appointment.appointment_time.date(),Appointment.doctor_id==new_appointment.doctor_id).all()
        new_appointment.queue_ticket_number = f'{len(existing_appointments)+1}-{new_appointment.doctor_id}-{new_appointment.appointment_time.strftime("%d%m%y")}'
        self.crud.create(new_appointment)
        self._db.commit()
        self._db.refresh(new_appointment)
        return new_appointment

    def nextStage(self,id:int) -> None:
        appointment = self.crud.read(Appointment,id)
        if appointment.status in [6,7]:
            raise TERMINAL_STAGE
        self.crud.update(appointment,{'status': appointment.status+1})

    def updateAppointment(self,id:int,payload:dict) -> Appointment:
        appointment = self.crud.read(Appointment,id)
        self.crud.update(appointment,payload)
        self._db.commit()
        self._db.refresh(appointment)
        return appointment

    def deleteAppointment(self,id:int) -> None:
        appointment = self.crud.read(Appointment,id)
        self.crud.delete(appointment)