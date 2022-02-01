from typing import List
from fastapi import APIRouter, Depends
from app.core.Entity.HR.employee import Employee
from app.core.Entity.auth.user import User
from app.core.Protocol.HR.employee import EmployeeRepo
from app.core.Service.HR.department import DepartmentService
from app.core.Service.HR.employee import EmployeeService
from app.infrastructure.repository.HR.HRRepositiory import EmployeeRepositiory

from app.core.Service.HR.position import PositionService
from dependencies.user import get_current_user_v2

employeeRoute = APIRouter(
    tags=['HR'],
    prefix=''
)

@employeeRoute.get('/employees')
async def getAllEmployees(repo:EmployeeRepo=Depends(EmployeeRepositiory),user:User=Depends(get_current_user_v2)):
    return EmployeeService(repo,user).getAllEmployee()

@employeeRoute.get('/employees/{id}')
async def getAllEmployees(id:int,repo:EmployeeRepo=Depends(EmployeeRepositiory),user:User=Depends(get_current_user_v2)):
    return EmployeeService(repo,user).getEmployee(id)

@employeeRoute.post('/employees')
async def createEmployee(employee:Employee,repo:EmployeeRepo=Depends(EmployeeRepositiory),user:User=Depends(get_current_user_v2)):
    return EmployeeService(repo,user).addEmployee(employee)

@employeeRoute.put('/employees/{id}')
async def updateEmployee(id:int,employee:Employee,repo:EmployeeRepo=Depends(EmployeeRepositiory),user:User=Depends(get_current_user_v2)):
    return EmployeeService(repo,user).updateEmployee(id,employee)

@employeeRoute.delete('/employees/{id}')
async def deleteEmployee(id:int,repo:EmployeeRepo=Depends(EmployeeRepositiory),user:User=Depends(get_current_user_v2)):
    EmployeeService(repo,user).deleteEmployee(id)
    return {'detail': 'operation succeed'}