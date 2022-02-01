from typing import List
from sqlalchemy.orm.session import Session

from app.models.baseModel import User
from app.models import Patient
from app.services.common import CRUDService

class PatientService:
    """patient services"""
    def __init__(self,db:Session,user:User):
        self._db = db
        self._user = user
        self.crud = CRUDService(self._db,self._user)

    def getAllPatients(self) -> List[Patient]:
        return self.crud.readAll(Patient)

    def getPatient(self,id:int) -> Patient:
        return self.crud.read(Patient,id)

    def addPatient(self,payload:dict) -> Patient:
        new_patient = Patient(**payload)
        self.crud.create(new_patient)
        self._db.commit()
        self._db.refresh(new_patient)
        return new_patient

    def updatePatient(self,id:int,payload:dict) -> Patient:
        patient = self.crud.read(Patient,id)
        self.crud.update(patient,payload)
        self._db.commit()
        self._db.refresh(patient)
        return patient

    def deletePatient(self,id:int) -> None:
        patient = self.crud.read(Patient,id)
        self.crud.delete(patient)