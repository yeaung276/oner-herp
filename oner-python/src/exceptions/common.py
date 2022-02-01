from fastapi import HTTPException,status

NOT_FOUND = HTTPException(
    status_code=status.HTTP_404_NOT_FOUND,
    detail= 'Resoucse not found'
)

ROUTE_PARAM_UNRECOGNIZED = HTTPException(
    status_code=status.HTTP_400_BAD_REQUEST,
    detail= 'Route params unrecognized'
)

SUCCEED = {  'detail': 'Operation Succeed'}

SUCCEED_WITH_ID = lambda id: {
    'detail': "Operation Succeed",
    'id': id
}



