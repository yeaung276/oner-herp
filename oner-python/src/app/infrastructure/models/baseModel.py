from datetime import datetime
from fastapi.param_functions import Depends
from sqlalchemy.ext.declarative import AbstractConcreteBase
from sqlalchemy.ext.declarative import declared_attr
from sqlalchemy.sql.functions import func
from sqlalchemy.sql.schema import Column, ForeignKey
from sqlalchemy.sql.sqltypes import BigInteger, DateTime, Integer, String
from sqlalchemy.orm import relationship, Session
from sqlalchemy.ext.declarative import declarative_base

Base = declarative_base()


class User(Base):
    __tablename__='user'

    id = Column(BigInteger, index=True, autoincrement=True, primary_key=True)
    username = Column(String, unique=True)
    fullname = Column(String)
    password = Column(String)
    role = Column(String)

class Role(Base):
    __tablename__='role'

    id = Column(BigInteger, index=True, autoincrement=True, primary_key=True)
    name = Column(String)

class BaseModel(AbstractConcreteBase, Base):
    id = Column(Integer, index=True, autoincrement=True, primary_key=True)
    created_time = Column(DateTime(timezone=True), default=datetime.now())
    updated_time = Column(DateTime(timezone=True), onupdate=datetime.now())
    @declared_attr
    def created_user_id(cls):
        return Column(BigInteger, ForeignKey('user.id'),nullable=False)
    @declared_attr
    def updated_user_id(cls):
        return Column(BigInteger, ForeignKey('user.id'),nullable=False)
    @declared_attr
    def created_user(cls):
        return relationship('User', primaryjoin=lambda: User.id==cls.created_user_id)
    @declared_attr
    def updated_user(cls):
        return relationship('User', primaryjoin=lambda: User.id==cls.updated_user_id)

    def create_stamp(self, user:User):
        self.created_user_id = user.id
        self.updated_user_id = user.id
        self.created_time = datetime.now()
        self.updated_time = datetime.now()

    def update_stamp(self, user:User):
        self.updated_user_id = user.id
        self.updated_time = datetime.now()