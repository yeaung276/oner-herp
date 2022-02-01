from app.infrastructure.models.baseModel import User
from app.core.Entity.auth.user import User as UserDTO
from database import get_db
import setup
from datetime import datetime
from typing import List
from fastapi import Depends
from fastapi.security import OAuth2PasswordBearer
from jose.exceptions import ExpiredSignatureError
from sqlalchemy.orm import Session
from jose import jwt, JWTError

from exceptions.auth import TOKEN_EXPIRE, TOKEN_UNVALID

oauth2_scheme = OAuth2PasswordBearer(tokenUrl="token")


async def get_current_user(token:str=Depends(oauth2_scheme),db:Session=Depends(get_db)) -> User:
    try:
        payload = jwt.decode(token, setup.SECRET_KEY, algorithms=[setup.ALGORITHM])
        return db.query(User).get(payload['sub'])
    except ExpiredSignatureError:
        raise TOKEN_EXPIRE
    except JWTError:
        raise TOKEN_UNVALID
    
async def get_current_user_v2(token:str=Depends(oauth2_scheme),db:Session=Depends(get_db)) -> UserDTO:
    try:
        payload = jwt.decode(token, setup.SECRET_KEY, algorithms=[setup.ALGORITHM])
        user = db.query(User).get(payload['sub'])
        return UserDTO.from_orm(user)
    except ExpiredSignatureError:
        raise TOKEN_EXPIRE
    except JWTError:
        raise TOKEN_UNVALID
    

