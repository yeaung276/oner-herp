from typing import List, Protocol

from app.core.Entity.EMR.patient import Patient


class PatientRepo(Protocol):
    def persist(self,patient:Patient) -> Patient:
        ...
        
    def update(self,patient:Patient) -> Patient:
        ...
        
    def getAllPatients(self) -> List[Patient]:
        ...
    
    def getById(self,id:int) -> Patient:
        ...