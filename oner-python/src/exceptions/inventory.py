from fastapi import HTTPException,status


NO_SERVICE_ITEM =  lambda inventory_name: HTTPException(
    status_code=status.HTTP_404_NOT_FOUND,
    detail=f'Service Item for Inventory {inventory_name} was not found!'
)

TRANSFER_SOURCE_ERROR = HTTPException(
    status_code=status.HTTP_404_NOT_FOUND,
    detail=f'No transfer source found'
)

SUPPLIER_SOURCE_ERROR = HTTPException(
    status_code=status.HTTP_404_NOT_FOUND,
    detail=f'No supplier source found'
)