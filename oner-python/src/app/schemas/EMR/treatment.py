from typing import Optional
from pydantic import BaseModel

class TreatemntInput(BaseModel):
    patient_id: int
    type: str
    reference_id: int
    info: Optional[str] = None
    
class EndoAutoBill(BaseModel):
    biopsy_upper: bool
    biopsy_lower: bool
    biopsy_fomalin: bool
    sternious: bool
    