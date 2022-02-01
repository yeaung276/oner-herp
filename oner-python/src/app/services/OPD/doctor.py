# from typing import List
# from sqlalchemy.orm.session import Session
# from sqlalchemy.exc import IntegrityError
# from app.infrastructure.models.baseModel import User
# from app.infrastructure.models import Doctor
# from exceptions.common import DUPLICATE

# class DoctorService:
#     """doctor services"""
#     def __init__(self,db:Session,user:User):
#         self._db = db
#         self._user = user
#         self.crud = CRUDService(self._db,self._user)

#     def getAllDoctors(self) -> List[Doctor]:
#         return self.crud.readAll(Doctor)

#     def getDoctor(self,id:int) -> Doctor:
#         return self.crud.read(Doctor,id)

#     def addDoctor(self,payload:dict) -> Doctor:
#         new_doctor = Doctor(**payload)
#         try:
#             self.crud.create(new_doctor)
#             self._db.commit()
#             self._db.refresh(new_doctor)
#         except IntegrityError as error:
#             raise DUPLICATE(error)
#         return new_doctor

#     def updateDoctor(self,id:int,payload:dict) -> Doctor:
#         doctor = self.crud.read(Doctor,id)
#         self.crud.update(doctor,payload)
#         self._db.commit()
#         self._db.refresh(doctor)
#         return doctor

#     def setOPDCharge(self,id:int,service_id:int) -> None:
#         doctor = self.crud.read(Doctor,id)
#         self.crud.update(doctor,{"opd_charge": service_id})
    
#     def setIPDCharge(self,id:int,service_id:int) -> None:
#         doctor = self.crud.read(Doctor,id)
#         self.crud.update(doctor,{"ipd_charge": service_id})

#     def deleteDoctor(self,id:int) -> None:
#         doctor = self.crud.read(Doctor,id)
#         self.crud.delete(doctor)