from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Integer, String
from sqlalchemy.orm import relationship
from sqlalchemy import Column
from app.infrastructure.models.baseModel import BaseModel

class PharmacyItem(BaseModel):
    __tablename__='pharmacy_item'

    pharmacy_category_id=Column(Integer,ForeignKey('pharmacy_category.id'))
    category=relationship('PharmacyCategory')
    universal_product_code=Column(String)
    brand_name=Column(String)
    generic_name=Column(String)
    form=Column(String)
    strength=Column(String)
    packaging=Column(String)
    uom=Column(String)
    service_item=relationship('ServiceItem',primaryjoin="and_(remote(ServiceItem.relation_id)==foreign(PharmacyItem.id),ServiceItem.service_type=='pharmacy_item')")