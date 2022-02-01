from typing import List
from app.core.Entity.auth.user import User
from app.core.Entity.HR.employee import Department
from app.core.Protocol.HR.employee import DepartmentRepo


class DepartmentService:
    def __init__(self,department_repo:DepartmentRepo,user:User)->None:
        self.department_repo = department_repo
        self.user = user
    
    def getAllDepartment(self) -> List[Department]:
        return self.department_repo.list()
    
    def addDepartment(self,department:Department) -> Department:
        new_department = self.department_repo.persist(department)
        return new_department
    
    def updateDepartment(self,id:int,department:Department) -> Department:
        new_department = department.copy()
        new_department.id = id
        self.department_repo.update(new_department)
        return new_department
    
    def deleteDepartment(self,id:int) -> None:
        department = self.department_repo.getById(id)
        self.department_repo.delete(department)