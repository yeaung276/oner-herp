import datetime
from typing import List
from app.core.Entity.ot_labour.labour import Labour as LabourDTO, LabourUsageItem as LabourUsageItemDTO
from app.infrastructure.repository.common import BaseRepository

from app.infrastructure.models.ot_labour.labour import Labour, LabourUsageItem


        
class LabourRepository(BaseRepository):
    def getAll(self) -> Labour:
        return self.readAll(Labour) 
    
    def getById(self,id:int) -> LabourDTO:
        return LabourDTO.from_orm(self.read(Labour,id))
    
    def persist(self,labour:LabourDTO) -> LabourDTO:
        new_labour = Labour(**labour.dict(exclude={'id','patient','usage_item'}))
        new_labour = self.create(new_labour)
        return LabourDTO.from_orm(new_labour)
    
    def update(self,labour:LabourDTO) -> LabourDTO:
        labour_orm = self.read(Labour,labour.id)
        labour_orm = super().update(labour_orm,labour.dict(exclude={'id','patient','usage_item'}))
        return LabourDTO.from_orm(labour_orm)
        
    def persistUsageItem(self,item:LabourUsageItemDTO) -> LabourUsageItemDTO:
        new_usage_item = LabourUsageItem(**item.dict(exclude={'id','pharmacy_item'}))
        new_usage_item = self.create(new_usage_item)
        return LabourUsageItemDTO.from_orm(new_usage_item)
        
    def updateUsageItem(self,item:LabourUsageItemDTO) -> LabourUsageItemDTO:
        usage_item_orm = self.read(LabourUsageItem,item.id)
        usage_item_orm = super().update(usage_item_orm,item.dict(exclude={'id','pharmacy_item'}))
        return LabourUsageItemDTO.from_orm(usage_item_orm)
        
    def deleteUsageItem(self,item:LabourUsageItemDTO) -> None:
        usage_item_orm = self.read(LabourUsageItem,item.id)
        super().delete(usage_item_orm)