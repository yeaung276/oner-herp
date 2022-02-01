from typing import List
from app.core.Entity.HR.employee import Position as PositionDTO
from app.core.Entity.HR.employee import Department as DepartmentDTO
from app.core.Entity.HR.employee import Employee as EmployeeDTO, EmployeeShallow as EmployeeShallowDTO
from app.infrastructure.repository.common import BaseRepository

from app.infrastructure.models import Position,Department,Employee


class PositionRepositiory(BaseRepository):
    def persist(self,position:PositionDTO) -> PositionDTO:
        new_position = Position(**position.dict(exclude={'id'}))
        new_position = self.create(new_position)
        return PositionDTO.from_orm(new_position)
    
    def update(self,position:PositionDTO) -> PositionDTO:
        position_orm = self.read(Position,position.id)
        super().update(position_orm,position.dict(exclude={'id'}))
        
    def list(self) -> List[PositionDTO]:
        postitions = self.readAll(Position)
        return [PositionDTO.from_orm(position) for position in postitions]
    
    def delete(self,position:PositionDTO) -> None:
        position_orm = self.read(Position,position.id)
        super().delete(position_orm)
        
    def getById(self,id: int) -> PositionDTO:
        position_orm = self.read(Position,id)
        return PositionDTO.from_orm(position_orm)
    
class DepartmentRepositiory(BaseRepository):
    def persist(self,department:DepartmentDTO) -> DepartmentDTO:
        new_department = Department(**department.dict(exclude={'id'}))
        new_department = self.create(new_department)
        return DepartmentDTO.from_orm(new_department)
    
    def update(self,department:DepartmentDTO) -> DepartmentDTO:
        department_orm = self.read(Department,department.id)
        super().update(department_orm,department.dict(exclude={'id'}))
        
    def list(self) -> List[DepartmentDTO]:
        departments = self.readAll(Department)
        return [DepartmentDTO.from_orm(department) for department in departments]
    
    def delete(self,department:DepartmentDTO) -> None:
        department_orm = self.read(Department,department.id)
        super().delete(department_orm)
        
    def getById(self,id: int) -> DepartmentDTO:
        department_orm = self.read(Department,id)
        return DepartmentDTO.from_orm(department_orm)
    
class EmployeeRepositiory(BaseRepository):
    def persist(self,employee:EmployeeDTO) -> EmployeeDTO:
        new_employee = Employee(**employee.dict(exclude={'id','position','department'}))
        new_employee = self.create(new_employee)
        return EmployeeDTO.from_orm(new_employee)
    
    def update(self,employee:EmployeeDTO) -> EmployeeDTO:
        employee_orm = self.read(Employee,employee.id)
        super().update(employee_orm,employee.dict(exclude={'id','position','department'}))
        return EmployeeDTO.from_orm(employee_orm)
        
    def list(self) -> List[EmployeeShallowDTO]:
        employees = self.readAll(Employee)
        return [EmployeeShallowDTO.from_orm(employee) for employee in employees]
    
    def delete(self,employee:EmployeeDTO) -> None:
        employee_orm = self.read(Employee,employee.id)
        super().delete(employee_orm)
        
    def getById(self,id: int) -> EmployeeDTO:
        employee_orm = self.read(Employee,id)
        return EmployeeDTO.from_orm(employee_orm)
    
    
    