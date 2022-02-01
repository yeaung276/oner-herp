from typing import List
from fastapi import APIRouter, Depends
from app.core.Entity.EMR.treatment_usage import State
from app.core.Protocol.accounting.cashier import CashierRepo
from app.core.Service.Cashier.cashier import CashierService
from app.core.Service.EMR.treatment import TreatmentService
from app.core.Entity.Inventory.pharmacy import PharmacyItem
from app.infrastructure.repository.cashier.cashier import CashierRepository
from app.schemas.EMR.ot_labour import OTLabourAutoBill, UsageItemInput
from app.schemas.EMR.patient import PatientInput
from app.schemas.EMR.treatment import EndoAutoBill, TreatemntInput
from dependencies.user import get_current_user_v2
from app.core.Entity.auth.user import User

from app.core.Protocol.EMR.treatment import TreatmentRepo
from app.infrastructure.repository.EMR.treatment import TreatmentUsageRepository
from app.infrastructure.repository.Pharmacy.pharmacy_item import PharmacyItemRepository
from app.core.Protocol.pharmacy.pharmacy_item import PharmacyItemRepo
from app.core.Protocol.inventory.inventory import InventoryRepo
from app.core.Service.inventory.inventory import InventoryService
from app.infrastructure.repository.Inventory.inventory_repo import InventoryRepository
from exceptions.common import SUCCEED, SUCCEED_WITH_ID
from exceptions.opd import CANNOT_MODIFY

treatmentRoute = APIRouter(
    tags=['EMR'],
    prefix='/treatment'
)

@treatmentRoute.post('/add_treatment/')
async def addTreatment(request:TreatemntInput,
                       repo:TreatmentRepo=Depends(TreatmentUsageRepository),
                       user:User=Depends(get_current_user_v2)):
    return TreatmentService(repo,user).create_usage(**request.dict())

@treatmentRoute.post('/add_usage_item/{id}')
async def addUsageItem(id:int,request:UsageItemInput,
                       repo:TreatmentRepo=Depends(TreatmentUsageRepository),
                       pharmacy_repo:PharmacyItemRepo=Depends(PharmacyItemRepository),
                       user:User=Depends(get_current_user_v2)):
    pharmacy_item = PharmacyItem.from_orm(pharmacy_repo.getById(request.pharmacy_item_id))
    TreatmentService(repo,user).add_usage_item(id,pharmacy_item,**request.dict())
    return SUCCEED

@treatmentRoute.post('/remove_usage_item/{id}')
async def removeUsageItem(id:int,request:UsageItemInput,
                       repo:TreatmentRepo=Depends(TreatmentUsageRepository),
                       pharmacy_repo:PharmacyItemRepo=Depends(PharmacyItemRepository),
                       user:User=Depends(get_current_user_v2)):
    pharmacy_item = PharmacyItem.from_orm(pharmacy_repo.getById(request.pharmacy_item_id))
    TreatmentService(repo,user).remove_usage_item(id,pharmacy_item)
    return SUCCEED

@treatmentRoute.post('/autobill/{id}')
async def autoBill(
                    id:int,
                    request:OTLabourAutoBill,
                    repo:TreatmentRepo=Depends(TreatmentUsageRepository),
                    inv_repo:InventoryRepo=Depends(InventoryRepository),
                    cashier_repo:CashierRepo=Depends(CashierRepository),
                    user:User=Depends(get_current_user_v2)):
    treatment =repo.getById(id)
    treatment.info = request.json()
    if treatment.state == State.close:
        raise CANNOT_MODIFY
    InventoryService(inv_repo,user).addConsumption(treatment.usage_items,f'Treatment Id: {treatment.reference_id}')
    cashier_service = CashierService(cashier_repo,user)
    cashier_service.autoBillConsumption(treatment.patient,treatment.usage_items,note=f'Treatment Id: {treatment.reference_id}')
    cashier_service.endoBills(treatment)
    TreatmentService(repo,user).autobill(treatment)
    return SUCCEED

@treatmentRoute.get('/get_treatments_with_reference/{reference_id}')
async def getTreatmentsWithReference(reference_id:int,
                       repo:TreatmentRepo=Depends(TreatmentUsageRepository),
                       user:User=Depends(get_current_user_v2)):
    return repo.getByReferenceId(reference_id)

@treatmentRoute.get('/get_treatments_with_type/{type}')
async def getTreatmentsWithReference(type:str,
                       repo:TreatmentRepo=Depends(TreatmentUsageRepository),
                       user:User=Depends(get_current_user_v2)):
    return repo.getTreatmentWithType(type)

@treatmentRoute.get('/get_treatment/{id}')
async def getTreatment(id:int,
                       repo:TreatmentRepo=Depends(TreatmentUsageRepository),
                       user:User=Depends(get_current_user_v2)):
    return repo.getById(id)
