import setup
from datetime import datetime, timedelta
from passlib.context import CryptContext
from jose import jwt, JWTError

from app.infrastructure.models.baseModel import User

pwd_context = CryptContext(schemes=['bcrypt'], deprecated='auto')

def hash(password):
    return pwd_context.hash(password)

def verify(plain_passw, hash_passw):
    return pwd_context.verify(plain_passw, hash_passw)

def create_token(user: User):
    expires_delta = timedelta(minutes=int(setup.JWT_EXPIRY_MINUTE))
    expire = datetime.utcnow() + expires_delta
    to_encode = {
        "iat": datetime.utcnow(),
        "exp": expire,
        "nbf": datetime.utcnow(),
        "sub": str(user.id),
        "role": user.role
    }
    token = jwt.encode(to_encode, setup.SECRET_KEY, algorithm=setup.ALGORITHM)
    return token