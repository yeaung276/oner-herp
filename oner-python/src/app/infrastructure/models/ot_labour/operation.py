from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import DateTime, Enum, Integer, String, Text
from sqlalchemy import Column
from app.infrastructure.models import BaseModel
from app.core.Entity.ot_labour.operation import OperationRoom, State

class Operation(BaseModel):
    __tablename__='operation'
   
    patient_id = Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient')
    anasthetic = Column(String)
    surgeon = Column(String)
    anasthesia = Column(String)
    room = Column(Enum(OperationRoom))
    start_time = Column(DateTime)
    end_time = Column(DateTime)
    outcome = Column(String)
    state = Column(Enum(State))
    usage_item = relationship('OperationUsageItem',uselist=True)
    info = Column(Text)
    
class OperationUsageItem(BaseModel):
    __tablename__='operation_usage_item'
    
    operation_id = Column(Integer,ForeignKey('operation.id'))
    pharmacy_item_id = Column(Integer,ForeignKey('pharmacy_item.id'))
    pharmacy_item = relationship('PharmacyItem')
    inventory_id = Column(Integer)
    quantity = Column(Integer)
    unit = Column(String)