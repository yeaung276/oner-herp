from typing import List
from app.core.Entity.auth.user import User
from app.core.Entity.HR.employee import Employee, EmployeeShallow
from app.core.Protocol.HR.employee import EmployeeRepo


class EmployeeService:
    def __init__(self,employee_repo:EmployeeRepo,user:User)->None:
        self.employee_repo = employee_repo
        self.user = user
    
    def getAllEmployee(self) -> List[EmployeeShallow]:
        return self.employee_repo.list()
    
    def getEmployee(self,id:int) -> Employee:
        return self.employee_repo.getById(id)
    
    def addEmployee(self,employee:Employee) -> Employee:
        new_employee = self.employee_repo.persist(employee)
        return new_employee
    
    def updateEmployee(self,id:int,employee:Employee) -> Employee:
        new_employee = employee.copy()
        new_employee.id = id
        return self.employee_repo.update(new_employee)
    
    def deleteEmployee(self,id:int) -> None:
        employee = self.employee_repo.getById(id)
        self.employee_repo.delete(employee)