from typing import List, Protocol

from app.core.Entity.ot_labour.operation import Inform, Operation, UsageItem


class InformRepo(Protocol):

    def persist(self,inform:Inform) -> Inform:
        ...
    
    def update(self,inform:Inform) -> Inform:
        ...
        
    def delete(self,inform:Inform) -> None:
        ...

class OperationRepo(Protocol):
    def getById(self,id:int) -> Operation:
        ...
        
    def persist(self,operation:Operation) -> Operation:
        ...
        
    def update(self,operation:Operation) -> Operation:
        ...
        
    def delete(self,operation:Operation) -> None:
        ...
        
    def persistUsageItem(self,item:UsageItem) -> UsageItem:
        ...
        
    def updateUsageItem(self,item:UsageItem) -> UsageItem:
        ...
        
    def deleteUsageItem(self,item:UsageItem) -> None:
        ...
