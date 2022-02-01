from typing import Protocol
from app.core.Entity.Inventory.inventory import Inventory

from app.core.Entity.accounting.cashier import PatientServiceUsedRecord
from app.core.Entity.accounting.service_item import ServiceItem


class CashierRepo(Protocol):
    
    def persistPatientServiceUsed(self,item:PatientServiceUsedRecord) -> PatientServiceUsedRecord:
        ...
        
    def getInventory(self,inventory_id:int) -> Inventory:
        ...
        
    def getServiceItem(self,id:int) -> ServiceItem:
        ...