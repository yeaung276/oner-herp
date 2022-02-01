from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from sqlalchemy.sql.sqltypes import Date, Integer
from sqlalchemy import Column, String
from app.models.baseModel import BaseModel

class InvestigationResultItem(BaseModel):
    __tablename__ = 'investigation_result_item'

    investigation_result_id = Column(Integer,ForeignKey('investigation_result.id'))
    parameter_name = Column(String)
    unit = Column(String)
    range = Column(String)
    file_link = Column(String)

class InvestigationResult(BaseModel):
    __tablename__ = 'investigation_result'

    patient_id = Column(Integer,ForeignKey('patient.id'))
    patient = relationship('Patient',back_populates='investigations')
    investigation_order_id = Column(Integer)
    items = relationship('InvestigationResultItem',uselist=True)
    