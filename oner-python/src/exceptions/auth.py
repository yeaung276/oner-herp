from fastapi import HTTPException,status
    
credentials_exception = HTTPException(
    status_code=status.HTTP_401_UNAUTHORIZED,
    detail="Could not validate credentials",
    headers={"WWW-Authenticate": "Bearer"},
)

UNAUTHORIZED = HTTPException(
    status_code=status.HTTP_401_UNAUTHORIZED,
    detail='Unauthorized'
)

TOKEN_EXPIRE = HTTPException(
    status_code=status.HTTP_401_UNAUTHORIZED,
    detail='Token Expire'
)

TOKEN_UNVALID = HTTPException(
    status_code=status.HTTP_401_UNAUTHORIZED,
    detail='Signature verification failed'
)

RESTRICTED = HTTPException(
    status_code=status.HTTP_403_FORBIDDEN,
    detail='Resource Restricted'
)