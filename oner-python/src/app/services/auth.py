from typing import List, Tuple
from fastapi import HTTPException,status
from sqlalchemy.exc import IntegrityError
from sqlalchemy.orm.session import Session

from app.infrastructure.models import Role, User
from app.schemas.user import UserRegister
from exceptions.auth import UNAUTHORIZED
from exceptions.common import NOT_FOUND

from utils.hash import verify,create_token,hash

class AuthService:
    """auth services"""
    def __init__(self,db:Session,user:User):
        self.db = db
        self.user = user
        
    def getAllUsers(self) -> List[User]:
        return self.db.query(User).all()
    
    def updateUser(self,id:int,data:dict) -> User:
        user = self.db.query(User).get(id)
        if user is None:
            raise NOT_FOUND
        user.username = data['username']
        user.role = data['role']
        user.fullname = data['fullname']
        return user

    def register(self,user:UserRegister)->User:
        try:
            new_user = User(**user.get_hashed())
            self.db.add(new_user)
            self.db.commit()
            self.db.refresh(new_user)
            return user
        except IntegrityError:
            raise HTTPException(status_code=404)

    def login(self,username,password) -> Tuple[str,User]:
        user = self.db.query(User).filter(User.username==username).first()
        if not verify(password,user.password):
            raise UNAUTHORIZED
        try:
            token = create_token(user)
        except:
            raise HTTPException(
                    status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
                    detail= 'Cannot create credentials'
            )
        return token,user
        
    def change_password(self,new_password:str,old_password:str):
        try:
            if not verify(old_password,self.user.password):
                raise UNAUTHORIZED
            self.user.password = hash(new_password)
        except:
            raise UNAUTHORIZED
            