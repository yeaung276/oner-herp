from pydantic import BaseModel

class ServiceItem(BaseModel):
    id: int
    name: str
    description: str
    charge: str
    
    class Config:
        orm_mode = True