from fastapi import HTTPException,status


TERMINAL_STAGE = HTTPException(
    status_code=status.HTTP_403_FORBIDDEN,
    detail='Appointment is either complete or cancelled'
)

CANNOT_MODIFY = HTTPException(
    status_code=status.HTTP_403_FORBIDDEN,
    detail='Cannot edit close items'
)