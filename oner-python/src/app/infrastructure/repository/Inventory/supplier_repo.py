from app.infrastructure.models import Supplier
from app.infrastructure.repository import BaseRepository


class SupplierRepository(BaseRepository):
    def createReturnId(self,supplier:Supplier) -> Supplier:
        super().create(supplier)
        self._db.commit()
        self._db.refresh(supplier)
        