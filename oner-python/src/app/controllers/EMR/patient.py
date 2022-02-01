from typing import List
from fastapi import APIRouter, Depends
from app.core.Service.EMR.patient import PatientService
from app.schemas.EMR.patient import PatientInput
from dependencies.user import get_current_user_v2
from app.core.Entity.auth.user import User

from app.core.Protocol.EMR.patient import PatientRepo
from app.infrastructure.repository.EMR.patient import PatientRepositiory

patRoute = APIRouter(
    tags=['EMR'],
    prefix='/EMR'
)

@patRoute.get('/getpatients')
async def getAllPatients( 
            repo:PatientRepo=Depends(PatientRepositiory),
            user:User=Depends(get_current_user_v2)):
    return repo.getAllPatients()

@patRoute.get('/getpatient/{id}')
async def getPatient(
    id:int,
    repo:PatientRepo=Depends(PatientRepositiory),
    user:User=Depends(get_current_user_v2)):
    return PatientService(repo,user).getPatientInfo(id)

@patRoute.post('/register_patient')
async def registerPatient(
    request:PatientInput,
    repo:PatientRepo=Depends(PatientRepositiory),
    user:User=Depends(get_current_user_v2)):
    return PatientService(repo,user).registerPatient(**request.dict())
    
@patRoute.post('/update_patient_info/{id}')
async def updatePatient( 
    id:int,
    request:PatientInput,
    repo:PatientRepo=Depends(PatientRepositiory),
    user:User=Depends(get_current_user_v2)):
    return PatientService(repo,user).updatePatientInfo(id,**request.dict())
