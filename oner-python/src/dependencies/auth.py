import setup
from datetime import datetime
from typing import List
from fastapi import Depends
from fastapi.security import OAuth2PasswordBearer
from jose.exceptions import ExpiredSignatureError
from sqlalchemy.orm import Session
from jose import jwt, JWTError

from exceptions.auth import RESTRICTED, TOKEN_EXPIRE, TOKEN_UNVALID

oauth2_scheme = OAuth2PasswordBearer(tokenUrl="token")

def check_access(access_roles:List[str]):
    async def check_access_with_current_role(token:str=Depends(oauth2_scheme)) -> None:
        try:
            payload = jwt.decode(token, setup.SECRET_KEY, algorithms=[setup.ALGORITHM])
            if payload['role'] not in access_roles:
                raise RESTRICTED
        except ExpiredSignatureError:
            raise TOKEN_EXPIRE
        except JWTError:
            raise TOKEN_UNVALID

    return check_access_with_current_role