from dependencies.user import get_current_user
from fastapi import Depends
from sqlalchemy.orm import Session

from database import get_db
from app.infrastructure.models import User

def service(dependencies:dict={}):
    def service_decorator(service):
        def wrapped_service(db:Session=Depends(get_db),user:User=Depends(get_current_user)):
            modf_service = service()
            for key,repo in dependencies.items():
                setattr(modf_service,key,repo(db,user))
            return modf_service
        
        return wrapped_service
    return service_decorator
    