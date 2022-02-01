from typing import List
from fastapi import APIRouter, Depends
from fastapi_pagination import Params
from fastapi_pagination.default import Page
from app.core.Entity.Inventory.inventory import Inventory
from app.core.Entity.auth.user import User
from app.core.Protocol.inventory.inventory import InventoryRepo
from app.core.Protocol.ot_labour.operation import OperationRepo
from app.core.Protocol.pharmacy.pharmacy_item import PharmacyItemRepo
from app.core.Service.inventory.inventory import InventoryService

from app.infrastructure.repository.Inventory.inventory_repo import InventoryRepository
from app.infrastructure.repository.Pharmacy.pharmacy_item import PharmacyItemRepository
from app.infrastructure.repository.ot_labour.operation import OperationRepository
from app.schemas.Inventory.inventory import InventoryInput, TransferInput

from dependencies.user import get_current_user_v2

inventoryRoute = APIRouter(
    tags=['Inventory'],
    prefix='/inventory'
)

@inventoryRoute.get('/get_available_items/{location_id}')
async def getAvailable(location_id:int,
                  repo:InventoryRepo=Depends(InventoryRepository),
                  user:User=Depends(get_current_user_v2)):
    return InventoryService(repo,user).get_available_items(location_id)

@inventoryRoute.get('/get_units/{pharmacy_item_id}')
async def getUnit(pharmacy_item_id:int,
                  repo:InventoryRepo=Depends(InventoryRepository),
                  pharmacy_repo:PharmacyItemRepo=Depends(PharmacyItemRepository),
                  user:User=Depends(get_current_user_v2)):
    pharmacy_item = pharmacy_repo.getById(pharmacy_item_id)
    return InventoryService(repo,user).get_units(pharmacy_item)

@inventoryRoute.post('/add')
async def createInventory(
                request:InventoryInput,
                repo:InventoryRepo=Depends(InventoryRepository),
                user:User=Depends(get_current_user_v2)):
    return InventoryService(repo,user).addInventory(**request.dict())

@inventoryRoute.get('/get_non_zero_inventories')
async def getNonZeroInventories( 
                repo:InventoryRepo=Depends(InventoryRepository),
                user:User=Depends(get_current_user_v2)):
    return repo.getAllNonZeroInventorys()

@inventoryRoute.put('/update/{id}')
async def updateInventory(   
                id: int,
                request:InventoryInput,
                repo:InventoryRepo=Depends(InventoryRepository),
                user:User=Depends(get_current_user_v2)):
    return InventoryService(repo,user).updateInventory(id,request.dict())

@inventoryRoute.delete('/delete/{id}')
async def deleteInventory(   
                id:int,
                repo:InventoryRepo=Depends(InventoryRepository),
                user:User=Depends(get_current_user_v2)):
    inventory = repo.getById(id)
    return InventoryService(repo,user).deleteInventory(inventory)

@inventoryRoute.get('/by_location/{location_id}',response_model=Page[Inventory])
async def getByLocationId( 
                location_id:int,
                params:Params = Depends(),
                repo:InventoryRepo=Depends(InventoryRepository),
                user:User=Depends(get_current_user_v2)):
    return repo.get_inventory_by_location_paginated(location_id,params)

@inventoryRoute.get('/get_for_transfer')
async def getInventoryForTransfer(
                location_id:int,
                pharmacy_item_id:int,
                repo:InventoryRepo=Depends(InventoryRepository),
                user:User=Depends(get_current_user_v2)):
    return InventoryService(repo,user).get_inventory_for_transfer(location_id,pharmacy_item_id)

@inventoryRoute.get('/search/{location_id}')
async def search(location_id:int,
                query:str, 
                repo:InventoryRepo=Depends(InventoryRepository),
                user:User=Depends(get_current_user_v2)):
    return InventoryService(repo,user).searchInventory(location_id,query)

@inventoryRoute.get('/{id}')
async def getById(
                id:int,
                repo:InventoryRepo=Depends(InventoryRepository),
                user:User=Depends(get_current_user_v2)):
    return repo.getById(id)

@inventoryRoute.get('/export_by_location/{location_id}',response_model=List[Inventory])
async def export(
    location_id:int,
    repo:InventoryRepo=Depends(InventoryRepository),
    user:User=Depends(get_current_user_v2)):
    return repo.export(location_id)

@inventoryRoute.get('/get_inventory_info/{location_id}')
async def getInventoryInfo(
    location_id:int,
    repo:InventoryRepo=Depends(InventoryRepository),
    user:User=Depends(get_current_user_v2)):
    return InventoryService(repo,user).get_info(location_id)

@inventoryRoute.post('/transfer')
async def transfer(
    request:TransferInput,
    repo:InventoryRepo=Depends(InventoryRepository),
    user:User=Depends(get_current_user_v2)):
    return InventoryService(repo,user).transfer(**request.dict())

@inventoryRoute.get('/track-source/{transaction_id}')
async def track_source(
    transaction_id:int,
    repo:InventoryRepo=Depends(InventoryRepository),
    user:User=Depends(get_current_user_v2)):
    return InventoryService(repo,user).track_source(transaction_id)

