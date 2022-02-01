from sqlalchemy import Column, String, Enum, Boolean, Integer,Date
from sqlalchemy.orm import relationship
from sqlalchemy.sql.schema import ForeignKey
from app.core.Entity.HR.employee import MaritalStatus, Status
from app.infrastructure.models.baseModel import BaseModel

class Employee(BaseModel):
    __tablename__='employee'

    name = Column(String)
    gender = Column(String)
    education = Column(String)
    marital_status = Column(Enum(MaritalStatus))
    number_of_children = Column(Integer)
    live_with_spouse_parent = Column(Boolean)
    phone_number = Column(String)
    emergency_contact_phone = Column(String)
    date_of_birth = Column(Date)
    nrc_number = Column(String)
    bank_account_number = Column(String)
    address = Column(String)
    position_id = Column(Integer, ForeignKey('position.id'))
    department_id = Column(Integer, ForeignKey('department.id'))
    status = Column(Enum(Status))

    position = relationship('Position', uselist=False)
    department = relationship('Department', uselist=False)