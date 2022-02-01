from typing import List
from fastapi import APIRouter, Depends
from app.core.Protocol.accounting.cashier import CashierRepo
from app.core.Protocol.inventory.inventory import InventoryRepo
from app.core.Service.Cashier.cashier import CashierService
from app.core.Service.inventory.inventory import InventoryService
from app.infrastructure.repository.Inventory.inventory_repo import InventoryRepository
from app.infrastructure.repository.cashier.cashier import CashierRepository
from dependencies.user import get_current_user_v2
from exceptions.common import SUCCEED, SUCCEED_WITH_ID

# Entity
from app.core.Entity.auth.user import User
from app.core.Entity.ot_labour.operation import Inform,Operation, State
from app.core.Entity.Inventory.pharmacy import PharmacyItem
#protocols
from app.core.Protocol.ot_labour.operation import InformRepo, OperationRepo
from app.core.Protocol.pharmacy.pharmacy_item import PharmacyItemRepo
#service
from app.core.Service.ot_labour.operation import OperationService
from app.core.Service.ot_labour.operation_inform import OperationInformService
#repository
from app.infrastructure.repository.ot_labour.operation import OperationRepository,InformRepository
from app.infrastructure.repository.Pharmacy.pharmacy_item import PharmacyItemRepository
#input/output schema
from app.schemas.EMR.ot_labour import InformInput, InformList, OTLabourAutoBill, OperationInput, OperationList, UsageItemInput
from exceptions.opd import CANNOT_MODIFY


operationRoute = APIRouter(
    prefix='/ot_labour',
    tags=['EMR']
)

@operationRoute.post('/inform')
async def InformOperation(data:InformInput,repo:InformRepo=Depends(InformRepository),user:User=Depends(get_current_user_v2)):
    OperationInformService(repo,user).inform(**data.dict())
    return SUCCEED

@operationRoute.post('/cancel_inform/{id}')
async def cancelInform(id:int,repo:InformRepo=Depends(InformRepository),user:User=Depends(get_current_user_v2)):
    inform = Inform.from_orm(repo.getById(id))
    OperationInformService(repo,user).cancelInform(inform)
    return SUCCEED

@operationRoute.post('/attach_lab_order/{id}')
async def attachLabOrder(id:int,lab_order_id:int,repo:InformRepo=Depends(InformRepository),user:User=Depends(get_current_user_v2)):
    inform = Inform.from_orm(repo.getById(id))
    OperationInformService(repo,user).attach_lab_order(inform,lab_order_id)
    return SUCCEED

@operationRoute.get('/informs',response_model=List[InformList])
async def getInforms(repo:InformRepo=Depends(InformRepository)):
    return repo.getAll()

@operationRoute.get('/informs/{id}',response_model=Inform)
async def getInform(id:int,repo:InformRepo=Depends(InformRepository)):
    return repo.getById(id)

@operationRoute.post('/create_operation')
async def registerOperaiton(data:OperationInput,repo:OperationRepo=Depends(OperationRepository),user:User=Depends(get_current_user_v2)):
    operation = OperationService(repo,user).registerOperation(**data.dict())
    return SUCCEED_WITH_ID(operation.id)

@operationRoute.delete('/delete_operation/{id}')
async def deleteOperation(id:int,repo:OperationRepo=Depends(OperationRepository),user:User=Depends(get_current_user_v2)):
    operation = Operation.from_orm(repo.getById(id))
    OperationService(repo,user).deleteOperation(operation)
    return SUCCEED

@operationRoute.get('/operations',response_model=List[OperationList])
async def getOperations(repo:OperationRepo=Depends(OperationRepository),user:User=Depends(get_current_user_v2)):
    return repo.getAll()

@operationRoute.get('/operations/{id}',response_model=Operation)
async def getOperation(id:int,repo:OperationRepo=Depends(OperationRepository),user:User=Depends(get_current_user_v2)):
    return repo.getById(id)

@operationRoute.post('/add_usage_item/{id}')
async def addUsageItem(id:int,data:UsageItemInput,
                       repo:OperationRepo=Depends(OperationRepository),
                       pharmacy_repo:PharmacyItemRepo=Depends(PharmacyItemRepository),
                       user:User=Depends(get_current_user_v2)):
    operation = Operation.from_orm(repo.getById(id))
    if operation.state == State.close:
        raise CANNOT_MODIFY
    pharmacy_item = PharmacyItem.from_orm(pharmacy_repo.getById(data.pharmacy_item_id))
    OperationService(repo,user).addUsageItem(operation,pharmacy_item,inventory_id=data.inventory_id,quantity=data.quantity,unit=data.unit)
    return SUCCEED

@operationRoute.post('/remove_usage_item/{id}')
async def removeUsageItem(id:int,data:UsageItemInput,
                       repo:OperationRepo=Depends(OperationRepository),
                       pharmacy_repo:PharmacyItemRepo=Depends(PharmacyItemRepository),
                       user:User=Depends(get_current_user_v2)):
    operation = Operation.from_orm(repo.getById(id))
    if operation.state == State.close:
        raise CANNOT_MODIFY
    pharmacy_item = PharmacyItem.from_orm(pharmacy_repo.getById(data.pharmacy_item_id))
    OperationService(repo,user).removeUsageItem(operation,pharmacy_item)
    return SUCCEED

@operationRoute.post('/autobill/{id}')
async def autoBill(id:int,
                       request:OTLabourAutoBill,
                       repo:OperationRepo=Depends(OperationRepository),
                       inv_repo:InventoryRepo=Depends(InventoryRepository),
                       cashier_repo:CashierRepo=Depends(CashierRepository),
                       user:User=Depends(get_current_user_v2)):
    operation = Operation.from_orm(repo.getById(id))
    operation.info = request.json()
    print(request,'req')
    if operation.state == State.close:
        raise CANNOT_MODIFY
    InventoryService(inv_repo,user).addConsumption(operation.usage_item,f'Operation Id: {operation.id}')
    cashierService = CashierService(cashier_repo,user)
    cashierService.otBills(operation)
    cashierService.autoBillConsumption(operation.patient,operation.usage_item,note=f'Operation Id: {operation.id}')
    OperationService(repo,user).autobill(operation)
    return SUCCEED
