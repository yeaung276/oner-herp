from datetime import datetime
from typing import Optional
from pydantic import BaseModel

class Category(BaseModel):
    id: Optional[int]
    name: str
    description: Optional[str] = ''
    
    class Config:
        orm_mode = True
        
class PharmacyItemInput(BaseModel):
    universal_product_code: str
    pharmacy_category_id: int
    brand_name: str
    generic_name: Optional[str] = ''
    form: Optional[str] = ''
    strength: Optional[str] = ''
    packaging: Optional[str] = ''
    uom: str
    
class PharmacyItemRes(BaseModel):
    id: int
    universal_product_code: str    
    brand_name: str
    generic_name: Optional[str] = ''
    packaging: str
    uom: str
    class Config:
        orm_mode = True
        
class PharmacyItemDetail(PharmacyItemRes):
    class Category(BaseModel):
        id: int
        name: str
        class Config:
            orm_mode = True
    form: str
    strength: str
    category: Optional[Category] = None
    class Config:
        orm_mode = True
        
class UnitInput(BaseModel):
    pharmacy_item_id: int
    name:str
    uom_equivalent: float
        
        
