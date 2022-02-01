from sqlalchemy.orm import relationship
from sqlalchemy.sql.expression import null
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Enum, Integer, String, Text
from sqlalchemy import Column
from app.infrastructure.models import BaseModel
from app.core.Entity.EMR.treatment_usage import State


class TreatmentUsage(BaseModel):
    __tablename__='treatment_usage'
    
    patient_id = Column(Integer, ForeignKey('patient.id'))
    patient = relationship('Patient')
    type = Column(String,nullable=False)
    reference_id = Column(Integer,nullable=False,index=True)
    state = Column(Enum(State))
    info = Column(Text)
    usage_items = relationship('TreatmentUsageItem',uselist=True)

class TreatmentUsageItem(BaseModel):
    __tablename__='treatment_usage_item'
    
    treatment_usage_id = Column(Integer,ForeignKey('treatment_usage.id'))
    pharmacy_item_id = Column(Integer,ForeignKey('pharmacy_item.id'))
    pharmacy_item = relationship('PharmacyItem')
    inventory_id = Column(Integer)
    quantity = Column(Integer)
    unit = Column(String)