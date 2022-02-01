from app.core.Protocol.ot_labour.operation import InformRepo
from app.core.Entity.auth.user import User
from app.core.Entity.ot_labour.operation import Inform


class OperationInformService:
    def __init__(self,inform_repo:InformRepo, user:User) -> None:
        self.inform_repo = inform_repo
        
    def inform(self,**kargs) -> None:
        inform = Inform(**kargs)
        self.inform_repo.persist(inform)
        self.__notify(f'patient {inform.patient_id} scheduled an operation at {inform.operation_datetime}')
        
    def attach_lab_order(self,inform:Inform,lab_order_id:int) -> None:
        inform.lab_order_id = lab_order_id
        self.inform_repo.update(inform)
        
    def cancelInform(self,inform:Inform) -> None:
        self.inform_repo.delete(inform)
        
    def __notify(self,message) -> None:
        print(message)