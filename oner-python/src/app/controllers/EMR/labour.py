from typing import List
from fastapi import APIRouter, Depends
from app.core.Protocol.accounting.cashier import CashierRepo
from app.core.Protocol.inventory.inventory import InventoryRepo
from app.core.Protocol.ot_labour.labour import LabourRepo
from app.core.Service.Cashier.cashier import CashierService
from app.core.Service.inventory.inventory import InventoryService
from app.core.Service.ot_labour.labour import LabourService
from app.infrastructure.repository.Inventory.inventory_repo import InventoryRepository
from app.infrastructure.repository.cashier.cashier import CashierRepository
from app.infrastructure.repository.ot_labour.labour import LabourRepository
from dependencies.user import get_current_user_v2
from exceptions.common import SUCCEED, SUCCEED_WITH_ID

# Entity
from app.core.Entity.auth.user import User
from app.core.Entity.ot_labour.operation import State
from app.core.Entity.Inventory.pharmacy import PharmacyItem
#protocols
from app.core.Protocol.pharmacy.pharmacy_item import PharmacyItemRepo
#service

#repository
from app.infrastructure.repository.Pharmacy.pharmacy_item import PharmacyItemRepository
#input/output schema
from app.schemas.EMR.ot_labour import LabourInput, LabourList, OTLabourAutoBill,  UsageItemInput
from exceptions.opd import CANNOT_MODIFY


labourRoute = APIRouter(
    prefix='/ot_labour',
    tags=['EMR']
)

@labourRoute.post('/create_labour')
async def registerLabour(data:LabourInput,repo:LabourRepo=Depends(LabourRepository),user:User=Depends(get_current_user_v2)):
    labour = LabourService(repo,user).registerLabour(**data.dict())
    return SUCCEED_WITH_ID(labour.id)

@labourRoute.delete('/delete_labour/{id}')
async def deleteLabour(id:int,repo:LabourRepo=Depends(LabourRepository),user:User=Depends(get_current_user_v2)):
    labour = repo.getById(id)
    LabourService(repo,user).deleteLabour(labour)
    return SUCCEED

@labourRoute.get('/labours',response_model=List[LabourList])
async def getLabours(repo:LabourRepo=Depends(LabourRepository),user:User=Depends(get_current_user_v2)):
    return repo.getAll()

@labourRoute.get('/labours/{id}')
async def getLabour(id:int,repo:LabourRepo=Depends(LabourRepository),user:User=Depends(get_current_user_v2)):
    return repo.getById(id)

@labourRoute.post('/add_labour_usage_item/{id}')
async def addUsageItem(id:int,data:UsageItemInput,
                       repo:LabourRepo=Depends(LabourRepository),
                       pharmacy_repo:PharmacyItemRepo=Depends(PharmacyItemRepository),
                       user:User=Depends(get_current_user_v2)):
    labour = repo.getById(id)
    if labour.state == State.close:
        raise CANNOT_MODIFY
    pharmacy_item = PharmacyItem.from_orm(pharmacy_repo.getById(data.pharmacy_item_id))
    LabourService(repo,user).addUsageItem(labour,pharmacy_item,inventory_id=data.inventory_id,quantity=data.quantity,unit=data.unit)
    return SUCCEED

@labourRoute.post('/remove_labour_usage_item/{id}')
async def removeUsageItem(id:int,data:UsageItemInput,
                       repo:LabourRepo=Depends(LabourRepository),
                       pharmacy_repo:PharmacyItemRepo=Depends(PharmacyItemRepository),
                       user:User=Depends(get_current_user_v2)):
    labour = repo.getById(id)
    if labour.state == State.close:
        raise CANNOT_MODIFY
    pharmacy_item = PharmacyItem.from_orm(pharmacy_repo.getById(data.pharmacy_item_id))
    LabourService(repo,user).removeUsageItem(labour,pharmacy_item)
    return SUCCEED

@labourRoute.post('/labour_autobill/{id}')
async def autoBill(id:int,
                   request:OTLabourAutoBill,
                       repo:LabourRepo=Depends(LabourRepository),
                       inv_repo:InventoryRepo=Depends(InventoryRepository),
                       cashier_repo:CashierRepo=Depends(CashierRepository),
                       user:User=Depends(get_current_user_v2)):
    labour = repo.getById(id)
    labour.info = request.json()
    if labour.state == State.close:
        raise CANNOT_MODIFY
    InventoryService(inv_repo,user).addConsumption(labour.usage_item,f'Operation Id: {labour.id}')
    cashierService = CashierService(cashier_repo,user)
    cashierService.labourBills(labour)
    cashierService.autoBillConsumption(labour.patient,labour.usage_item,note=f'Operation Id: {labour.id}')
    LabourService(repo,user).autobill(labour)
    return SUCCEED
