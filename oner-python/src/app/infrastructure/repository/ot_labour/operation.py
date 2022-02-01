import datetime
from typing import List
from app.core.Entity.ot_labour.operation import Inform as InformDTO, Operation as OperationDTO, UsageItem as UsageItemDTO
from app.infrastructure.repository.common import BaseRepository

from app.infrastructure.models.ot_labour.operation import Operation, OperationUsageItem
from app.infrastructure.models.ot_labour.inform import OTInform


class InformRepository(BaseRepository):
    def getAll(self) -> List[OTInform]:
        return self.readAll(OTInform)
    
    def getById(self,id:int) -> OTInform:
        return self.read(OTInform,id)
    
    def persist(self,inform:InformDTO) -> InformDTO:
        new_inform = OTInform(**inform.dict(exclude={'id','patient'}))
        new_inform = self.create(new_inform)
        return InformDTO.from_orm(new_inform)
    
    def update(self,inform:InformDTO) -> InformDTO:
        inform_orm = self.read(OTInform,inform.id)
        inform_orm = super().update(inform_orm,inform.dict(exclude={'id','patient'}))
        return InformDTO.from_orm(inform_orm)
    
    def delete(self,inform:InformDTO) -> None:
        inform_orm = self.read(OTInform,inform.id)
        super().delete(inform_orm)
        
class OperationRepository(BaseRepository):
    def getAll(self) -> List[Operation]:
        return self.readAll(Operation)
    
    def getById(self,id:int) -> Operation:
        return self.read(Operation,id)
    
    def persist(self,operation:OperationDTO) -> OperationDTO:
        new_operation = Operation(**operation.dict(exclude={'id','patient','usage_item'}))
        new_operation = self.create(new_operation)
        return OperationDTO.from_orm(new_operation)
    
    def update(self,operation:OperationDTO) -> OperationDTO:
        operation_orm = self.read(Operation,operation.id)
        operation_orm = super().update(operation_orm,operation.dict(exclude={'id','patient','usage_item'}))
        return OperationDTO.from_orm(operation_orm)
    
    def delete(self,inform:InformDTO) -> None:
        operation_orm = self.read(Operation,inform.id)
        super().delete(operation_orm)
        
    def persistUsageItem(self,item:UsageItemDTO) -> UsageItemDTO:
        new_usage_item = OperationUsageItem(**item.dict(exclude={'id','pharmacy_item'}))
        new_usage_item = self.create(new_usage_item)
        return UsageItemDTO.from_orm(new_usage_item)
        
    def updateUsageItem(self,item:UsageItemDTO) -> UsageItemDTO:
        usage_item_orm = self.read(OperationUsageItem,item.id)
        usage_item_orm = super().update(usage_item_orm,item.dict(exclude={'id','pharmacy_item'}))
        return UsageItemDTO.from_orm(usage_item_orm)
        
    def deleteUsageItem(self,item:UsageItemDTO) -> None:
        usage_item_orm = self.read(OperationUsageItem,item.id)
        super().delete(usage_item_orm)