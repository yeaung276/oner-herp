from pydantic import BaseModel

class User(BaseModel):
    id: int
    username: str
    fullname: str
    role: str
    
    class Config:
        orm_mode = True