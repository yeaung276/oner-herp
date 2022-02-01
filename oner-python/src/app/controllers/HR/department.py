from typing import List
from fastapi import APIRouter, Depends
from app.core.Entity.HR.employee import Department
from app.core.Entity.auth.user import User
from app.core.Protocol.HR.employee import DepartmentRepo
from app.core.Service.HR.department import DepartmentService
from app.infrastructure.repository.HR.HRRepositiory import DepartmentRepositiory

from dependencies.user import get_current_user_v2

departmentRoute = APIRouter(
    tags=['HR'],
    prefix=''
)

@departmentRoute.get('/departments')
async def getAllDepartments(repo:DepartmentRepo=Depends(DepartmentRepositiory),user:User=Depends(get_current_user_v2)):
    return DepartmentService(repo,user).getAllDepartment()

@departmentRoute.post('/departments')
async def createDepartment(department:Department,repo:DepartmentRepo=Depends(DepartmentRepositiory),user:User=Depends(get_current_user_v2)):
    return DepartmentService(repo,user).addDepartment(department)

@departmentRoute.put('/departments/{id}')
async def updateDepartment(id:int,department:Department,repo:DepartmentRepo=Depends(DepartmentRepositiory),user:User=Depends(get_current_user_v2)):
    return DepartmentService(repo,user).updateDepartment(id,department)

@departmentRoute.delete('/departments/{id}')
async def deleteDepartment(id:int,repo:DepartmentRepo=Depends(DepartmentRepositiory),user:User=Depends(get_current_user_v2)):
    DepartmentService(repo,user).deleteDepartment(id)
    return {'detail': 'operation succeed'}