from fastapi import APIRouter

from app.controllers.auth import auth
# from app.controllers.EMR.patient import patRoute
# from app.controllers.OPD.doctor import docRoute
# from app.controllers.OPD.appointment import appointmentRoute
from app.controllers.Inventory.supplier import supplierRoute
from app.controllers.Inventory.pharmacy_item import pharmacyItemRoute
from app.controllers.HR.position import postitionRoute
from app.controllers.HR.department import departmentRoute
from app.controllers.HR.employee import employeeRoute
from app.controllers.EMR.operation import operationRoute
from app.controllers.Inventory.unit import unitRoute
from app.controllers.Inventory.inventory import inventoryRoute
from app.controllers.EMR.treatment import treatmentRoute
from app.controllers.EMR.labour import labourRoute

router = APIRouter()

router.include_router(auth)
router.include_router(supplierRoute)
router.include_router(pharmacyItemRoute)
router.include_router(postitionRoute)
router.include_router(departmentRoute)
router.include_router(employeeRoute)
router.include_router(operationRoute)
router.include_router(unitRoute)
router.include_router(inventoryRoute)
router.include_router(treatmentRoute)
router.include_router(labourRoute)
# router.include_router(patRoute)
# router.include_router(docRoute)
# router.include_router(appointmentRoute)