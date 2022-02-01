
from app.core.Entity.Inventory.pharmacy import PharmacyItem
from app.core.Protocol.ot_labour.labour import LabourRepo
from app.core.Entity.auth.user import User
from app.core.Entity.ot_labour.labour import Labour, State, LabourUsageItem

class LabourService:
    def __init__(self,op_repo:LabourRepo,user:User) -> None:
        self.repo = op_repo
        self.user = user
        
    def registerLabour(self,**kargs) -> Labour:
        labour = Labour(**kargs)
        self.__notify(f'patient {labour.patient_id} done an operation')
        return self.repo.persist(labour)
        
    def deleteLabour(self,labour:Labour) -> None:
        self.repo.delete(labour)
        
    def __notify(self,message) -> None:
        print(message)
        
    def addUsageItem(self,labour:Labour,item:PharmacyItem,inventory_id:int,quantity:int,unit:str) -> None:
        usage = labour.hasItem(item)
        if usage is None:
            self.repo.persistUsageItem(LabourUsageItem(labour_id=labour.id,pharmacy_item_id=item.id,quantity=quantity,inventory_id=inventory_id,unit=unit))
        else:
            usage.quantity = usage.quantity+quantity
            self.repo.updateUsageItem(usage)
    
    def removeUsageItem(self,labour:Labour,item:PharmacyItem) -> None:
        usage = labour.hasItem(item)
        self.repo.deleteUsageItem(usage)

            
    def autobill(self,labour:Labour) -> None:
        labour.state = State.close
        self.repo.update(labour)
            
        
        
