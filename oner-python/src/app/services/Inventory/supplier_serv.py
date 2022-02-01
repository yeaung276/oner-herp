from typing import List
from app.infrastructure.models import Supplier
from app.infrastructure.repository import SupplierRepository
from dependencies.decorators import service

dependent_repos = {
    'supplier_repo': SupplierRepository
}
@service(dependencies=dependent_repos)
class SupplierService:
    supplier_repo:SupplierRepository
    
    def getAllSuppliers(self) -> List[Supplier]:
        return self.supplier_repo.readAll(Supplier)
    
    def getSupplier(self,id:int) -> Supplier:
        return self.supplier_repo.read(Supplier,id)
    
    def addSupplier(self,supplier:dict) -> Supplier:
        new_supplier = Supplier(**supplier)
        self.supplier_repo.createReturnId(new_supplier)
        return new_supplier
    
    def updateSupplier(self,id:int,supplier_data:dict) -> Supplier:
        supplier = self.supplier_repo.read(Supplier,id)
        self.supplier_repo.update(supplier,supplier_data)
        return supplier
    
    def deleteSupplier(self,id:int) -> None:
        supplier = self.supplier_repo.read(Supplier,id)
        self.supplier_repo.delete(supplier)