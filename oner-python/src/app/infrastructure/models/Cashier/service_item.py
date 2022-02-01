import enum
from sqlalchemy import Column, String, Enum, Integer
from sqlalchemy.orm import backref, relationship
from sqlalchemy.orm.relationships import foreign
from sqlalchemy.sql.schema import ForeignKey
from app.infrastructure.models.baseModel import Base
# from app.models.baseModel import BaseModel

class accounting_category(enum.Enum):
    consultation = 'Consultation'
    opd = "Opd"
    room_charges = "Room Changes"
    haemo = "Haemo"
    endo = "Endo"
    ct = "CT"
    x_ray = "X-Ray"
    ultrasound = "Ultrasound"
    ecg = "Ecg"
    pharmacy = "Pharmacy"
    lab = "Lab"

# class ServiceItem(BaseModel):
#     __tablename__='service_item'
#     id=Column(Integer, index=True, autoincrement=True, primary_key=True)
#     name=Column(String)
#     service_type=Column(String)
#     relation_id=Column(Integer)
#     accounting_category=Column(Enum(accounting_category))
#     charge=Column(Integer)

class ServiceItem(Base):
    __tablename__='service_item'
    id = Column(Integer,primary_key=True,autoincrement=True)
    relation_id = Column(Integer,index=True)
    service_type=Column(String(255))
    name=Column(String(255))
    description=Column(String(255))
    charge=Column(String(255))
    