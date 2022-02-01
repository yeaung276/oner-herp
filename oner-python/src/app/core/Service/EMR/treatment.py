from app.core.Entity.Inventory.pharmacy import PharmacyItem
from app.core.Entity.EMR.treatment_usage import State
from app.core.Protocol.EMR.treatment import TreatmentRepo
from app.core.Entity.auth.user import User
from app.core.Entity.EMR.treatment_usage import TreatmentUsage, TreatmentUsageItem
from exceptions.opd import CANNOT_MODIFY

class TreatmentService:
    def __init__(self, repo:TreatmentRepo, user:User) -> None:
        self.repo = repo
        self.user = user
        
    def create_usage(self,**kargs) -> TreatmentUsage:
        return self.repo.persistUsage(TreatmentUsage(**kargs))
        
    def add_usage_item(self,treatment_id:int,item:PharmacyItem,**kargs) -> None:
        treatment = self.repo.getById(treatment_id)
        if treatment.state==State.close:
            raise CANNOT_MODIFY
        usage = treatment.hasItem(item)
        if usage is None:
            self.repo.persistUsageItem(TreatmentUsageItem(
                pharmacy_item_id=item.id,
                treatment_usage_id=treatment.id,
                inventory_id=kargs.get('inventory_id'),
                quantity=kargs.get('quantity'),
                unit=kargs.get('unit')
            ))
        else:
            usage.quantity = usage.quantity+kargs.get('quantity')
            self.repo.updateUsageItem(usage)
            
    def remove_usage_item(self,treatment_id:int,item:PharmacyItem,**kargs) -> None:
        treatment = self.repo.getById(treatment_id)
        if treatment.state==State.close:
            raise CANNOT_MODIFY
        usage = treatment.hasItem(item)
        self.repo.deleteUsageItem(usage)
        
    def autobill(self,treatment:TreatmentUsage) -> None:
        treatment.state = State.close
        self.repo.updateUsage(treatment)