from app.core.Entity.Inventory.inventory import Unit
from app.core.Entity.auth.user import User
from app.core.Protocol.inventory.units import UnitRepo


class UnitService:
    def __init__(self,unit_repo:UnitRepo,user:User) -> None:
        self.repo = unit_repo
        
    def add(self,name,pharmacy_item_id,uom_equivalent) -> Unit:
        new_unit = Unit(name=name,pharmacy_item_id=pharmacy_item_id,uom_equivalent=uom_equivalent)
        return self.repo.persist(new_unit)
        
    def updateEquivalent(self,unit:Unit,qty:float) -> Unit:
        unit.uom_equivalent = qty
        return self.repo.update(unit)
    
    def remove(self,unit:Unit) -> None:
        self.repo.delete(unit)