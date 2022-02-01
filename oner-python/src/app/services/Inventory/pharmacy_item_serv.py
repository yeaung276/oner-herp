from typing import List
from app.infrastructure.models import PharmacyCategory
from app.infrastructure.models.Inventory.pharmacy_item import PharmacyItem
from app.infrastructure.repository import SupplierRepository
from app.infrastructure.repository.Inventory.pharmacy_item_repo import PharmacyItemRepository
from dependencies.decorators import service

dependent_repos = {
    'category_repo': SupplierRepository,
    'item_repo': PharmacyItemRepository
}
@service(dependencies=dependent_repos)
class PharmacyItemService:
    def addCategory(self,name:str,description:str) -> PharmacyCategory:
        new_category = PharmacyCategory(name=name,description=description)
        self.category_repo.create(new_category)
        return new_category
    
    def getAllCategories(self) -> List[PharmacyCategory]:
        return self.category_repo.readAll(PharmacyCategory)
    
    def updateCategory(self,id:int,data:dict) -> PharmacyCategory:
        category = self.category_repo.read(PharmacyCategory,id)
        self.category_repo.update(category,data)
        return category
    
    def deleteCategory(self,id:int) -> None:
        category = self.category_repo.read(PharmacyCategory,id)
        self.category_repo.delete(category)
        
    def addPharmacyItem(self,pharmacy_item:dict) -> PharmacyItem:
        new_pharmacy_item = PharmacyItem(**pharmacy_item)
        self.item_repo.create(new_pharmacy_item)
        return new_pharmacy_item
    
    def updatePharmacyItem(self,id:int,data:dict) -> PharmacyItem:
        pharmacy_item = self.item_repo.read(PharmacyItem,id)
        self.item_repo.update(pharmacy_item,data)
        return pharmacy_item
    
    def getAllPharmacyItem(self) -> List[PharmacyItem]:
        return self.item_repo.readAll(PharmacyItem)
    
    def getPharmacyItem(self,id:int) -> PharmacyItem:
        return self.item_repo.read(PharmacyItem,id)
    
    def deletePharmacyItem(self,id:int) -> None:
        pharmacy_item = self.item_repo.read(PharmacyItem,id)
        self.item_repo.delete(pharmacy_item)
        