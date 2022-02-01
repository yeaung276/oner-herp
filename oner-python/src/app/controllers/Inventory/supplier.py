from typing import List
from fastapi import APIRouter, Depends
from app.schemas.Inventory.supplier import SupplierDetail, SupplierInput, SupplierResp

from app.services.Inventory.supplier_serv import SupplierService
from dependencies.auth import check_access

supplierRoute = APIRouter(
    tags=['Inventory'],
    prefix=''
)

@supplierRoute.get('/suppliers',response_model=List[SupplierResp])
async def getAllSuppliers(service:SupplierService=Depends(SupplierService)):
    return service.getAllSuppliers()

@supplierRoute.get('/suppliers/{id}',response_model=SupplierDetail)
async def getSupplier(id:int,service:SupplierService=Depends(SupplierService)):
    return service.getSupplier(id)

@supplierRoute.post('/suppliers')
async def createSupplier(supplier:SupplierInput,service:SupplierService=Depends(SupplierService)):
    return service.addSupplier(supplier.dict(exclude_unset=True))

@supplierRoute.put('/suppliers/{id}',dependencies=[Depends(check_access(['admin']))],response_model=SupplierDetail)
async def updateSupplier(id:int,supplier:SupplierInput,service:SupplierService=Depends(SupplierService)):
    return service.updateSupplier(id,supplier.dict(exclude_unset=True))

@supplierRoute.delete('/suppliers/{id}',dependencies=[Depends(check_access(['admin']))])
async def deleteSupplier(id:int,service:SupplierService=Depends(SupplierService)):
    service.deleteSupplier(id)
    return {'detail': 'operation succeed'}