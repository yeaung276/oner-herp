from app.core.Entity.accounting.cashier import PatientServiceUsedRecord as RecordDTO
from app.core.Entity.Inventory.inventory import Inventory as InventoryDTO
from app.core.Entity.accounting.service_item import ServiceItem as ServiceItemDTO
from app.infrastructure.models import Inventory,ServiceUsedRecord,ServiceItem
from app.infrastructure.repository.common import BaseRepository

class CashierRepository(BaseRepository):
    
    def persistPatientServiceUsed(self,item:RecordDTO) -> RecordDTO:
        new_record = ServiceUsedRecord(**item.dict(exclude={'id','patient','service_item'}))
        self.create(new_record)
        self._db.flush()
        
    def getInventory(self,inventory_id:int) -> InventoryDTO:
        return  InventoryDTO.from_orm(self.read(Inventory,inventory_id))
    
    def getServiceItem(self,id:int) -> ServiceItemDTO:
        return ServiceItemDTO.from_orm(self.read(ServiceItem,id))