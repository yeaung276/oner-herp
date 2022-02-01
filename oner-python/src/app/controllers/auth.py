from typing import List
from fastapi import APIRouter,Depends
from fastapi.security.oauth2 import OAuth2PasswordRequestForm
from sqlalchemy.orm import Session
from app.infrastructure.models import Role,User

from app.services.auth import AuthService
from app.schemas.user import ChangePassword, CredentialReturn, Login, UserRegister, UserRes
from dependencies.auth import check_access
from dependencies.user import get_current_user
from database import get_db


auth = APIRouter(
    tags=['auth']
)

@auth.post('/register')
async def register(user:UserRegister, db:Session=Depends(get_db)):
    auth = AuthService(db,None)
    return auth.register(user)

@auth.get('/users',dependencies=[Depends(check_access(['admin']))],response_model=List[UserRes])
async def getUsers(db:Session = Depends(get_db), user:User=Depends(get_current_user)):
    auth = AuthService(db,user)
    return auth.getAllUsers()

@auth.put('/users/{id}',dependencies=[Depends(check_access(['admin']))])
async def updateUser(id:int,payload:UserRes,db:Session = Depends(get_db), user:User=Depends(get_current_user)):
    auth = AuthService(db,user)
    auth.updateUser(id,payload.dict(exclude_unset=True))
    return {'detail': 'Operation succeed.'}

@auth.post('/login')
async def login(login:Login, db:Session=Depends(get_db)):
    auth = AuthService(db,None)
    token,user = auth.login(login.username,login.password)
    return CredentialReturn(username=login.username,role=user.role,token=token)

@auth.post('/change_password')
async def changePassword(payload:ChangePassword, db:Session=Depends(get_db),user:User=Depends(get_current_user)):
    auth = AuthService(db,user)
    auth.change_password(payload.new_password,payload.old_password)
    return {'message': 'done'}

@auth.post('/token')
async def token(form_data: OAuth2PasswordRequestForm = Depends(),db:Session=Depends(get_db)):
    auth = AuthService(db,None)
    token,_ = auth.login(form_data.username,form_data.password)
    return {
        'access_token': token,
        'token_type': 'bearer'
    }