from typing import List
from fastapi import APIRouter, Depends
from app.core.Entity.auth.user import User
from app.core.Protocol.inventory.units import UnitRepo
from app.core.Service.inventory.unit import UnitService

from app.infrastructure.repository.Inventory.unit_repo import UnitRepository

from app.schemas.Inventory.pharmacy_item import UnitInput
from dependencies.user import get_current_user_v2

unitRoute = APIRouter(
    tags=['Inventory'],
    prefix='/unit'
)

@unitRoute.post('/add')
async def addUnit(request:UnitInput,repo:UnitRepo=Depends(UnitRepository),user:User=Depends(get_current_user_v2)):
    return UnitService(repo,user).add(**request.dict())

@unitRoute.post('/update_equavilent/{id}')
async def updateEquavilent(id:int,equavilent:float,repo:UnitRepo=Depends(UnitRepository),user=Depends(get_current_user_v2)):
    unit = repo.getById(id)
    return UnitService(repo,user).updateEquivalent(unit,equavilent)

@unitRoute.post('/remove/{id}')
async def remove(id:int,repo:UnitRepo=Depends(UnitRepository),user=Depends(get_current_user_v2)):
    unit = repo.getById(id)
    return UnitService(repo,user).remove(unit)
