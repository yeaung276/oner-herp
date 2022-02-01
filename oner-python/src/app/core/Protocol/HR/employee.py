from typing import List, Protocol
from app.core.Entity.HR.employee import Department, Employee, EmployeeShallow, Position

class PositionRepo(Protocol):
    def persist(self,data:Position) -> Position:
        ...
        
    def update(self,data:Position) -> Position:
        ...
        
    def delete(self,data:Position) -> None:
        ...
        
    def list(self) -> List[Position]:
        ...
        
    def getById(self,id:int) -> Position:
        ...
        
class DepartmentRepo(Protocol):
    def persist(self,data:Department) -> Department:
        ...
        
    def update(self,data:Department) -> Department:
        ...
        
    def delete(self,data:Department) -> None:
        ...
        
    def list(self) -> List[Department]:
        ...
        
    def getById(self,id:int) -> Department:
        ...
        
class EmployeeRepo(Protocol):
    def persist(self,data:Employee) -> Employee:
        ...
        
    def update(self,data:Employee) -> Employee:
        ...
        
    def list(self) -> List[EmployeeShallow]:
        ...
        
    def getById(self,id:int) -> Employee:
        ...