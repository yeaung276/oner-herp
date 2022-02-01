from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import DateTime, Integer, String
from sqlalchemy import Column
from sqlalchemy.orm import relationship
from app.infrastructure.models.baseModel import BaseModel

class Inventory(BaseModel):
    __tablename__='inventorys'

    name = Column(String,nullable=False)
    description = Column(String)
    relation_id = Column(Integer,ForeignKey('pharmacy_item.id'))
    type = Column(String,nullable=False)
    pharmacy_item = relationship('PharmacyItem')
    location_id = Column(Integer,ForeignKey('store_locations.id'))
    location = relationship('StoreLocation')
    balance = Column(Integer)
    unit = Column(String)
    purchasing_price = Column(Integer)
    batch_number = Column(Integer)
    expiry_date = Column(DateTime)
    service_item = relationship('ServiceItem',primaryjoin="and_(foreign(Inventory.relation_id)==remote(ServiceItem.relation_id), "
                                "remote(ServiceItem.service_type)==foreign(Inventory.type))",uselist=False,viewonly=True)

