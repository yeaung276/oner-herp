from typing import List
from fastapi import APIRouter, Depends
from app.core.Entity.HR.employee import Position
from app.core.Entity.auth.user import User
from app.core.Protocol.HR.employee import PositionRepo
from app.infrastructure.repository.HR.HRRepositiory import PositionRepositiory

from app.core.Service.HR.position import PositionService
from dependencies.user import get_current_user_v2

postitionRoute = APIRouter(
    tags=['HR'],
    prefix=''
)

@postitionRoute.get('/positions')
async def getAllPositions(repo:PositionRepo=Depends(PositionRepositiory),user:User=Depends(get_current_user_v2)):
    return PositionService(repo,user).getAllPosition()

@postitionRoute.post('/positions')
async def createPosition(position:Position,repo:PositionRepo=Depends(PositionRepositiory),user:User=Depends(get_current_user_v2)):
    return PositionService(repo,user).addPosition(position)

@postitionRoute.put('/positions/{id}')
async def updatePosition(id:int,position:Position,repo:PositionRepo=Depends(PositionRepositiory),user:User=Depends(get_current_user_v2)):
    return PositionService(repo,user).updatePosition(id,position)

@postitionRoute.delete('/positions/{id}')
async def deletePosition(id:int,repo:PositionRepo=Depends(PositionRepositiory),user:User=Depends(get_current_user_v2)):
    PositionService(repo,user).deletePosition(id)
    return {'detail': 'operation succeed'}