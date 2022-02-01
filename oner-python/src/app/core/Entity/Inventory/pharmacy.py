

from typing import Optional
from pydantic.main import BaseModel

from app.core.Entity.accounting.service_item import ServiceItem


class Category(BaseModel):
    id: int
    name: str
    class Config:
        orm_mode = True

class PharmacyItem(BaseModel):
    id: Optional[int]
    category: Optional[Category] = None
    pharmacy_category_id: int
    universal_product_code: str    
    brand_name: str
    generic_name: Optional[str] = ''
    form: str
    strength: Optional[str] = ''
    packaging: str
    uom: str
    class Config:
        orm_mode = True
        
class PharmacyItemShallow(BaseModel):
    id: int
    universal_product_code: str    
    brand_name: str
    generic_name: Optional[str] = ''
    packaging: str
    uom: str
    class Config:
        orm_mode = True