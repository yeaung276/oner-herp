from __future__ import annotations
from typing import List
import json

from pydantic.types import Json
from app.core.CONSTANTS import ENDO_CHARGES
from app.core.Entity.EMR.patient import Patient
from app.core.Entity.accounting.cashier import PatientServiceUsedRecord
from app.core.Entity.ot_labour.labour import Labour
from app.core.Protocol.accounting.cashier import CashierRepo
from app.core.Entity.auth.user import User
from app.core.Entity.EMR.treatment_usage import TreatmentUsageItem
from app.core.Entity.ot_labour.operation import Operation, UsageItem
from app.core.Entity.EMR.treatment_usage import TreatmentUsage
from exceptions.inventory import NO_SERVICE_ITEM

class CashierService:
    def __init__(self,repo:CashierRepo,user:User) -> None:
        self.repo = repo
        self.user = user
        
    def autoBillConsumption(self,patient:Patient,items:List[UsageItem|TreatmentUsageItem],note:str) -> None:
        for item in items:
            inventory = self.repo.getInventory(item.inventory_id)
            if inventory.service_item is None:
                raise NO_SERVICE_ITEM(inventory.name)
            new_record = PatientServiceUsedRecord(
                patient_id= patient.id,
                service_item_id=inventory.service_item.id,
                service_name=inventory.service_item.name,
                quantity=item.quantity,
                charge=inventory.service_item.charge,
                total_charge=item.quantity * int(inventory.service_item.charge),
                status='open',
                extra=note
            )
            self.repo.persistPatientServiceUsed(new_record)
            
    def endoBills(self,treatment:TreatmentUsage) -> None:
        if treatment.type != 'endoscopy':
            raise ValueError('Not an Endoscopy Treatment')
        info = json.loads(treatment.info)
        for item in info['items']:
            service_item = self.repo.getServiceItem(item['service_item_id'])
            new_record = PatientServiceUsedRecord(
                patient_id= treatment.patient.id,
                service_item_id=service_item.id,
                service_name=service_item.name,
                quantity=item['quantity'],
                charge=service_item.charge,
                total_charge=item['quantity'] * int(service_item.charge),
                status='open',
                extra=f'treatment Id: {treatment.reference_id}'
            )
            self.repo.persistPatientServiceUsed(new_record)
                
    def otBills(self,operation:Operation) -> None:
        info = json.loads(operation.info)
        for item in info['items']:
            service_item = self.repo.getServiceItem(item['service_item_id'])
            new_record = PatientServiceUsedRecord(
                    patient_id= operation.patient.id,
                    service_item_id=service_item.id,
                    service_name=service_item.name,
                    quantity=item['quantity'],
                    charge=service_item.charge,
                    total_charge=item['quantity'] * int(service_item.charge),
                    status='open',
                    extra=f'Operation Id: {operation.id}'
                )
            self.repo.persistPatientServiceUsed(new_record)
            
    def labourBills(self,labour:Labour) -> None:
        info = json.loads(labour.info)
        for item in info['items']:
            service_item = self.repo.getServiceItem(item['service_item_id'])
            new_record = PatientServiceUsedRecord(
                    patient_id= labour.patient.id,
                    service_item_id=service_item.id,
                    service_name=service_item.name,
                    quantity=item['quantity'],
                    charge=service_item.charge,
                    total_charge=item['quantity'] * int(service_item.charge),
                    status='open',
                    extra=f'Operation Id: {labour.id}'
                )
            self.repo.persistPatientServiceUsed(new_record)
        
        
    