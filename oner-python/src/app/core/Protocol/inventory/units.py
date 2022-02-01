from typing import Protocol

from app.core.Entity.Inventory.inventory import Unit

class UnitRepo(Protocol):
    def persist(self,unit:Unit) -> Unit:
        ...
    
    def update(self,unit:Unit) -> Unit:
        ...
    
    def delete(self,unit:Unit) -> None:
        ...