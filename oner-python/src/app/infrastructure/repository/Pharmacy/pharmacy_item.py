from app.infrastructure.repository import BaseRepository
from app.infrastructure.models import PharmacyItem


class PharmacyItemRepository(BaseRepository):
    def getById(self,id:int) -> PharmacyItem:
        return self.read(PharmacyItem,id)
    