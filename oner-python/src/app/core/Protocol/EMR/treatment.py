from typing import List, Protocol

from app.core.Entity.EMR.treatment_usage import TreatmentUsage,TreatmentUsageItem


class TreatmentRepo(Protocol):
    def getById(self,id:int) -> TreatmentUsage:
        ...
        
    def getByReferenceId(self,id:int) -> TreatmentUsage:
        ...
        
    def persistUsage(self,usage:TreatmentUsage) -> TreatmentUsage:
        ...
    
    def updateUsage(self,usage:TreatmentUsage) -> TreatmentUsage:
        ...
        
    def persistUsageItem(self,item:TreatmentUsageItem) -> TreatmentUsageItem:
        ...
        
    def updateUsageItem(self,item:TreatmentUsageItem) -> TreatmentUsageItem:
        ...
        
    def deleteUsageItem(self,item:TreatmentUsageItem) -> None:
        ...
        
    def getTreatmentWithType(self,type:str) -> List[TreatmentUsage]:
        ...
    