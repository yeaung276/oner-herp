from database import engine
from app.infrastructure.models.baseModel import *

# HR models
from app.infrastructure.models.HR.department import *
from app.infrastructure.models.HR.position import *
from app.infrastructure.models.HR.employee import * 

# EMR models
from app.infrastructure.models.EMR.patient import *
from app.infrastructure.models.EMR.treatment_usage_item import *
# from app.models.EMR.prescription import *
# from app.models.EMR.medical_record import *
# from app.models.EMR.investigation_results import *

# # cashier models
# from app.models.Cashier.bill import *
# from app.models.Cashier.deposit import *
# from app.models.Cashier.payment import *
from app.infrastructure.models.Cashier.service_item import *
from app.infrastructure.models.Cashier.service_used_record import *

# # OPD models
# from app.models.OPD.appointment import *
# from app.models.OPD.doctor import *

# # Orders models
# from app.models.Orders.investigation_category import *
# from app.models.Orders.investigation_item import *
# from app.models.Orders.investigation_order import *
# from app.models.Orders.investigation_type import *

# # Pharmacy models
from app.infrastructure.models.Inventory.pharmacy_category import *
from app.infrastructure.models.Inventory.pharmacy_item import *
# 
# inventory models
from app.infrastructure.models.Inventory.supplier import *
from app.infrastructure.models.Inventory.unit import *
from app.infrastructure.models.Inventory.inventory import *
from app.infrastructure.models.Inventory.location import *
from app.infrastructure.models.Inventory.InventoryTransaction import *

# operation models
from app.infrastructure.models.ot_labour.inform import *
from app.infrastructure.models.ot_labour.operation import *
from app.infrastructure.models.ot_labour.labour import *

# Base.metadata.create_all(bind=engine, checkfirst=True)


