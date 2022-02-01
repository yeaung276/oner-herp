
from app.core.Entity.EMR.patient import Patient
from app.core.Entity.auth.user import User
from app.core.Protocol.EMR.patient import PatientRepo


class PatientService:
    def __init__(self,patient_repo:PatientRepo,user:User) -> None:
        self.repo = patient_repo
        
    def registerPatient(self,**kargs) -> Patient:
        patient = Patient(**kargs)
        return self.repo.persist(patient)
    
    def getPatientInfo(self,patient_id:int) -> Patient:
        return self.repo.getById(patient_id)
    
    def updatePatientInfo(self,patient_id,**kargs) -> Patient:
        patient = self.repo.getById(patient_id)
        for key,value in patient.dict(exclude={'id','patient_id','created_time'}):
            if kargs.get(key,None) is not None:
                setattr(patient,key,kargs[key])
        return self.repo.update(patient)