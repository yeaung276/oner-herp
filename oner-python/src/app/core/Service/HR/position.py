from typing import List
from app.core.Entity.auth.user import User
from app.core.Entity.HR.employee import Position
from app.core.Protocol.HR.employee import PositionRepo


class PositionService:
    def __init__(self,position_repo:PositionRepo,user:User)->None:
        self.position_repo = position_repo
        self.user = user
    
    def getAllPosition(self) -> List[Position]:
        return self.position_repo.list()
    
    def addPosition(self,position:Position) -> Position:
        new_position = self.position_repo.persist(position)
        return new_position
    
    def updatePosition(self,id:int,position:Position) -> Position:
        new_position = position.copy()
        new_position.id = id
        self.position_repo.update(new_position)
        return new_position
    
    def deletePosition(self,id:int) -> None:
        position = self.position_repo.getById(id)
        self.position_repo.delete(position)