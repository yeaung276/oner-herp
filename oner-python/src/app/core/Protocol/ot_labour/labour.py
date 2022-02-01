from typing import List, Protocol

from app.core.Entity.ot_labour.labour import Labour, LabourUsageItem


class LabourRepo(Protocol):
    def getById(self,id:int) -> Labour:
        ...
        
    def persist(self,operation:Labour) -> Labour:
        ...
        
    def update(self,operation:Labour) -> Labour:
        ...
        
    def delete(self,operation:Labour) -> None:
        ...
        
    def persistUsageItem(self,item:LabourUsageItem) -> LabourUsageItem:
        ...
        
    def updateUsageItem(self,item:LabourUsageItem) -> LabourUsageItem:
        ...
        
    def deleteUsageItem(self,item:LabourUsageItem) -> None:
        ...
