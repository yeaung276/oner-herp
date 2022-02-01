from typing import List
from app.core.Entity.EMR.treatment_usage import TreatmentUsage as TreatmentUsageDTO, TreatmentUsageItem as TreatmentUsageItemDTO
from app.infrastructure.models.EMR.treatment_usage_item import TreatmentUsage, TreatmentUsageItem
from app.infrastructure.repository.common import BaseRepository
from exceptions.common import NOT_FOUND

class TreatmentUsageRepository(BaseRepository):

    def getById(self,id:int) -> TreatmentUsageDTO:
        return TreatmentUsageDTO.from_orm(self.read(TreatmentUsage,id))
    
    def getByReferenceId(self,id:int):
        treatment = self._db.query(TreatmentUsage).filter(TreatmentUsage.reference_id==id).first()
        if treatment is None:
            raise NOT_FOUND
        return treatment
        
    def persistUsage(self,usage:TreatmentUsageDTO) -> TreatmentUsageDTO:
        treatment_usage_orm = TreatmentUsage(**usage.dict(exclude={'id','patient','usage_items','created_time'}))
        return TreatmentUsageDTO.from_orm(self.create(treatment_usage_orm))
    
    def updateUsage(self,usage:TreatmentUsageDTO) -> TreatmentUsageDTO:
        treatment_orm = self.read(TreatmentUsage,usage.id)
        treatment_orm = super().update(treatment_orm,usage.dict(exclude={'id','patient','usage_items','created_time'}))
        return TreatmentUsageDTO.from_orm(treatment_orm)
        
    def persistUsageItem(self,item:TreatmentUsageItemDTO) -> TreatmentUsageItemDTO:
        new_usage_item = TreatmentUsageItem(**item.dict(exclude={'id','pharmacy_item'}))
        new_usage_item = self.create(new_usage_item)
        return TreatmentUsageItemDTO.from_orm(new_usage_item)
        
    def updateUsageItem(self,item:TreatmentUsageItemDTO) -> TreatmentUsageItemDTO:
        usage_item_orm = self.read(TreatmentUsageItem,item.id)
        usage_item_orm = super().update(usage_item_orm,item.dict(exclude={'id','pharmacy_item'}))
        return TreatmentUsageItemDTO.from_orm(usage_item_orm)
        
    def deleteUsageItem(self,item:TreatmentUsageItemDTO) -> None:
        usage_item_orm = self.read(TreatmentUsageItem,item.id)
        super().delete(usage_item_orm)
        
    def getTreatmentWithType(self,type:str) -> List[TreatmentUsageDTO]:
        treatments = self._db.query(TreatmentUsage).filter(TreatmentUsage.type==type).all()
        return [TreatmentUsageDTO.from_orm(treatment) for treatment in treatments]