import enum
from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Boolean, Enum, Integer, String
from sqlalchemy import Column
from app.models.baseModel import BaseModel

class Status(enum.Enum):
    open='open'
    confirm='confirm'
    complete='complete'
    cancelled='cancelled'

class Source(enum.Enum):
    ipd='ipd'
    opd="opd"
    urgent='urgent'
    external='external'

class InvestigationOrderItem(BaseModel):
    __tablename__='investigation_order_item'
    
    investigation_order_id=Column(Integer,ForeignKey('investigation_order.id'))
    investigation_order=relationship('InvestigationOrder',back_populates='items')
    investigation_item_id=Column(Integer,ForeignKey('investigation_item.id'))
    investigation_item=relationship('InvestigationItem')


class InvestigationOrder(BaseModel):
    __tablename__='investigation_order'
    
    patient_id=Column(Integer,ForeignKey('patient.id'))
    patient=relationship('Patient',foreign_keys=[patient_id])
    bill_patient_id=Column(Integer,ForeignKey('patient.id'))
    bill_patient=relationship('Patient',foreign_keys=[bill_patient_id])
    requested_doctor_id=Column(Integer,ForeignKey('doctor.id'))
    requested_doctor=relationship('Doctor')
    requested_doctor_note=Column(String)
    investigation_type_id=Column(Integer,ForeignKey('investigation_type.id'))
    investigation_type=relationship('InvestigationType')
    items=relationship('InvestigationOrderItem',uselist=True)
    status=Column(Enum(Status))
    source=Column(Enum(Source))