from typing import List
from fastapi import APIRouter, Depends
from app.infrastructure.models.Inventory.pharmacy_item import PharmacyItem
from app.schemas.Inventory.pharmacy_item import Category, PharmacyItemDetail, PharmacyItemInput, PharmacyItemRes

from app.services.Inventory.pharmacy_item_serv import PharmacyItemService

pharmacyItemRoute = APIRouter(
    tags=['Inventory'],
    prefix=''
)

# category routes
@pharmacyItemRoute.get('/categories',response_model=List[Category])
async def getAllCategories(service:PharmacyItemService=Depends(PharmacyItemService)):
    return service.getAllCategories()

@pharmacyItemRoute.post('/categories')
async def createCategory(category:Category,service:PharmacyItemService=Depends(PharmacyItemService)):
    return service.addCategory(**category.dict(exclude_unset=True))

@pharmacyItemRoute.put('/categories/{id}',response_model=Category)
async def updateCategory(id:int,category:Category,service:PharmacyItemService=Depends(PharmacyItemService)):
    return service.updateCategory(id,category.dict(exclude_unset=True))

@pharmacyItemRoute.delete('/categories/{id}')
async def deleteCategory(id:int,service:PharmacyItemService=Depends(PharmacyItemService)):
    service.deleteCategory(id)
    return {'detail': 'operation succeed'}

# pharmacy item routes
@pharmacyItemRoute.get('/pharmacy_items',response_model=List[PharmacyItemRes])
async def getAllPharmacyItems(service:PharmacyItemService=Depends(PharmacyItemService)):
    return service.getAllPharmacyItem()

@pharmacyItemRoute.get('/pharmacy_items/{id}',response_model=PharmacyItemDetail)
async def getPharmacyItem(id:int,service:PharmacyItemService=Depends(PharmacyItemService)):
    return service.getPharmacyItem(id)

@pharmacyItemRoute.post('/pharmacy_items')
async def createPharmacyItem(data:PharmacyItemInput,service:PharmacyItemService=Depends(PharmacyItemService)):
    return service.addPharmacyItem(data.dict())

@pharmacyItemRoute.put('/pharmacy_items/{id}')
async def updatePharmacyItem(id:int,data:PharmacyItemInput,service:PharmacyItemService=Depends(PharmacyItemService)):
    return service.updatePharmacyItem(id,data.dict(exclude_unset=True))

@pharmacyItemRoute.delete('/pharmacy_items/{id}')
async def deletePharmacyItem(id:int,service:PharmacyItemService=Depends(PharmacyItemService)):
    service.deletePharmacyItem(id)
    return {'detail': "Operation succeed!"}