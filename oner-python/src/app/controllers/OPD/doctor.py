from typing import List
import enum
from fastapi import APIRouter, Depends
from sqlalchemy.orm.session import Session

from app.models.baseModel import User
from app.schemas.OPD.doctor import DoctorDetail, DoctorInput, DoctorRes
from app.services.OPD.doctor import DoctorService
from database import get_db
from dependencies.auth import get_user
from exceptions.common import ROUTE_PARAM_UNRECOGNIZED


docRoute = APIRouter(
    tags=['OPD'],
    prefix='/OPD'
)

class charge_type(enum.Enum):
    opd = 'opd'
    ipd = 'ipd'

@docRoute.get('/doctors',response_model=List[DoctorRes])
async def getAllDoctors(
        db:Session=Depends(get_db),
        user:User=Depends(get_user(['admin']))
    ):
    return DoctorService(db,user).getAllDoctors()

@docRoute.get('/doctors/{id}',response_model=DoctorDetail)
async def getDoctor(
        id:int,
        db:Session=Depends(get_db),
        user:User=Depends(get_user(['admin']))
    ):
    return DoctorService(db,user).getDoctor(id)

@docRoute.post('/doctors',response_model=DoctorDetail)
async def createDoctor(
        doctor:DoctorInput,
        db:Session=Depends(get_db),
        user:User=Depends(get_user(['admin']))
    ):
    return DoctorService(db,user).addDoctor(doctor.dict(exclude_unset=True))

# @docRoute.post('/doctors/charges/{type}')
# async def updateCharges(
#         type: charge_type,
#         service_id: int,
#         doctor_id: int,
#         db:Session=Depends(get_db),
#         user:User=Depends(get_user(['admin']))
#     ):
#     service = DoctorService(db,user)
#     if type is type.ipd.value:
#         service.setIPDCharge(doctor_id,service_id)
#     elif type is type.opd.value:
#         service.setOPDCharge(doctor_id,service_id)
#     else:
#         raise ROUTE_PARAM_UNRECOGNIZED
# TODO: implemented this


@docRoute.put('/doctors/{id}',response_model=DoctorDetail)
async def updateDoctor(
        id:int,
        doctor:DoctorInput,
        db:Session=Depends(get_db),
        user:User=Depends(get_user(['admin']))
    ):
    return DoctorService(db,user).updateDoctor(id,doctor.dict(exclude_unset=True))

@docRoute.delete('/doctors/{id}')
async def deleteDoctor(
        id:int,
        db:Session=Depends(get_db),
        user:User=Depends(get_user(['admin']))
    ):
    DoctorService(db,user).deleteDoctor(id)
    return {'detail': 'operation succeed'}