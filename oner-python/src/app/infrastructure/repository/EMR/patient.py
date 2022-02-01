from typing import List
from app.infrastructure.repository.common import BaseRepository
from app.infrastructure.models import Patient
from app.core.Entity.EMR.patient import Patient as PatientDTO


class PatientRepositiory(BaseRepository):
    def persist(self,patient:PatientDTO) -> PatientDTO:
        new_patient = Patient(**patient.dict(exclude={'id','patient_id','created_time'}))
        return PatientDTO.from_orm(self.create(new_patient))
        
    def update(self,patient:PatientDTO) -> PatientDTO:
        patient_orm = self.read(Patient,patient.id)
        return PatientDTO.from_orm(
            super().update(patient_orm,patient.dict(exclude={'id','patient_id','created_time'}))
        )
        
    def getAllPatients(self) -> List[PatientDTO]:
        patients = self.readAll(Patient)
        return [PatientDTO.from_orm(patient) for patient in patients]
    
    def getById(self,id:int) -> PatientDTO:
        patient_orm = self.read(Patient,id)
        return PatientDTO.from_orm(patient_orm)