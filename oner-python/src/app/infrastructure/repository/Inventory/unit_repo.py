from app.infrastructure.models import Unit
from app.core.Entity.Inventory.inventory import Unit as UnitDTO
from app.infrastructure.repository.common import BaseRepository

class UnitRepository(BaseRepository):
    def persist(self,unit:UnitDTO) -> UnitDTO:
        new_unit = Unit(**unit.dict(exclude={'id'}))
        return UnitDTO.from_orm(self.create(new_unit))
    
    def update(self,unit:UnitDTO) -> UnitDTO:
        unit_orm = self.read(Unit,unit.id)
        return UnitDTO.from_orm(super().update(unit_orm,unit.dict(exclude={'id'})))
    
    def delete(self,unit:UnitDTO) -> None:
        unit_orm = self.read(Unit,unit.id)
        super().delete(unit_orm)
        
    def getById(self,id:int) -> UnitDTO:
        return UnitDTO.from_orm(self.read(Unit,id))