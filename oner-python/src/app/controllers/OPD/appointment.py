from datetime import date
from typing import List, Optional
from fastapi import APIRouter, Depends
from sqlalchemy.orm.session import Session

from app.models.baseModel import User
from app.schemas.OPD.appointment import AppointmentDetail, AppointmentInput, AppointmentRes
from app.services.OPD.appointments import AppointmentService
from database import get_db
from dependencies.auth import get_user


appointmentRoute = APIRouter(
    tags=['OPD'],
    prefix='/OPD'
)

@appointmentRoute.get('/appointments',response_model=List[AppointmentRes])
async def getAllAppointments(
    date:Optional[date]=None,
    db:Session=Depends(get_db),
    user:User=Depends(get_user(['admin']))
    ):
    if date is not None:
        return AppointmentService(db,user).getAppointmentsByDate(date)
    else:
        return AppointmentService(db,user).getAllAppointments()

@appointmentRoute.get('/appointments/{id}',response_model=AppointmentDetail)
async def getAppointment(
    id:int,
    db:Session=Depends(get_db),
    user:User=Depends(get_user(['admin']))
    ):
    return AppointmentService(db,user).getAppointment(id)

@appointmentRoute.post('/appointments',response_model=AppointmentDetail)
async def createAppointment(
    patient:AppointmentInput,
    db:Session=Depends(get_db),
    user:User=Depends(get_user(['admin']))
    ):
    return AppointmentService(db,user).addAppointment(patient.dict(exclude_unset=True))

@appointmentRoute.post('/appointments/next/{id}')
async def appointmentNextStage(
    id:int,
    db:Session=Depends(get_db),
    user:User=Depends(get_user(['admin']))
    ):
    AppointmentService(db,user).nextStage(id)
    return {'detail': 'Operation succeed'}

@appointmentRoute.put('/appointments/{id}',response_model=AppointmentDetail)
async def updateAppointment(
    id:int,
    patient:AppointmentInput,
    db:Session=Depends(get_db),
    user:User=Depends(get_user(['admin']))
    ):
    return AppointmentService(db,user).updateAppointment(id,patient.dict(exclude_unset=True))

@appointmentRoute.delete('/appointments/{id}')
async def deleteAppointment(
    id:int,
    db:Session=Depends(get_db),
    user:User=Depends(get_user(['admin']))
    ):
    AppointmentService(db,user).deleteAppointment(id)
    return {'detail': 'operation succeed'}