
from app.core.Entity.Inventory.pharmacy import PharmacyItem
from app.core.Protocol.ot_labour.operation import OperationRepo
from app.core.Entity.auth.user import User
from app.core.Entity.ot_labour.operation import Operation, State, UsageItem

class OperationService:
    def __init__(self,op_repo:OperationRepo,user:User) -> None:
        self.op_repo = op_repo
        
    def registerOperation(self,**kargs) -> Operation:
        operation = Operation(**kargs)
        self.__notify(f'patient {operation.patient_id} done an operation')
        return self.op_repo.persist(operation)
        
    def deleteOperation(self,operation:Operation) -> None:
        self.op_repo.delete(operation)
        
    def __notify(self,message) -> None:
        print(message)
        
    def addUsageItem(self,operation:Operation,item:PharmacyItem,inventory_id:int,quantity:int,unit:str) -> None:
        usage = operation.hasItem(item)
        if usage is None:
            self.op_repo.persistUsageItem(UsageItem(operation_id=operation.id,pharmacy_item_id=item.id,quantity=quantity,inventory_id=inventory_id,unit=unit))
        else:
            usage.quantity = usage.quantity+quantity
            self.op_repo.updateUsageItem(usage)
            
    # def removeUsageItem(self,operation:Operation,item:PharmacyItem,quantity:int) -> None:
    #     usage = operation.hasItem(item)
    #     if usage.quantity<quantity:
    #         self.op_repo.delete(usage)
    #     else:
    #         usage.quantity = usage.quantity - quantity
    #         self.op_repo.update(usage)
    
    def removeUsageItem(self,operation:Operation,item:PharmacyItem) -> None:
        usage = operation.hasItem(item)
        self.op_repo.deleteUsageItem(usage)

            
    def autobill(self,operation:Operation) -> None:
        operation.state = State.close
        self.op_repo.update(operation)
            
        
        
