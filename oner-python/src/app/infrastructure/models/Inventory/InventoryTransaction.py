from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import DateTime, Integer, String, Text
from sqlalchemy import Column
from sqlalchemy.orm import relationship
from app.infrastructure.models.baseModel import BaseModel

class InventoryTransaction(BaseModel):
    __tablename__='pharmacy_inventory_transaction'

    inventory_id = Column(Integer,ForeignKey('inventorys.id'))
    inventory = relationship('Inventory')
    relation_id = Column(Integer)
    relation_type = Column(String)
    transaction_type = Column(String)
    type = Column(String,nullable=False)
    quantity = Column(Integer)
    unit = Column(String)
    moving_average_price = Column(Integer)
    purchasing_price = Column(Integer)
    selling_price = Column(Integer)
    opening_balance = Column(Integer)
    closing_balance = Column(Integer)
    note = Column(Text)
