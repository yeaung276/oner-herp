<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
    // return json_encode([
    //     'pharmacy_item_id'=> 'required',
    //     'transaction_type'=> 'required',
    //     'quantity'=> 'required',
    //     'moving_average_price'=> 'required',
    //     'purchasing_price'=> 'required',
    //     'selling_price'=> 'required',
    //     'opening_balance'=> 'required',
    //     'closing_balance'=> 'required',
    //     'expired_date'=> 'required',
    //     'note'=> 'required',
        
    // ]);
});
// API route group
$router->group([
    // 'middleware' => 'api',
    'prefix' => 'api'
], function () use ($router) {
    $router->post('bulk_delete', 'ExampleController@bulk_delete');
    $router->post('registers', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    
    
});
// API route group
$router->group([
    'middleware' => ['auth:api','lvl'],
    'prefix' => 'api'
], function () use ($router) {    
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('me', 'AuthController@me');

    $router->post('users', 'UserController@all');
    $router->post('users/add', 'UserController@add');
    $router->post('users/{id}', 'UserController@get');
    $router->post('users/{id}/update', 'UserController@put');
    $router->post('users/{id}/remove', 'UserController@remove');
    
    $router->post('employees', 'EmployeeController@all');
    $router->post('employees/add', 'EmployeeController@add');
    $router->post('employees/{id}', 'EmployeeController@get');
    $router->post('employees/{id}/update', 'EmployeeController@put');
    $router->post('employees/{id}/remove', 'EmployeeController@remove');

    $router->post('roles', 'RoleController@all');
    $router->post('roles/add', 'RoleController@add');
    $router->post('roles/{id}', 'RoleController@get');
    $router->post('roles/{id}/update', 'RoleController@put');
    $router->post('roles/{id}/remove', 'RoleController@remove');

    $router->post('departments', 'DepartmentController@all');
    $router->post('departments/add', 'DepartmentController@add');
    $router->post('departments/{id}', 'DepartmentController@get');
    $router->post('departments/{id}/update', 'DepartmentController@put');
    $router->post('departments/{id}/remove', 'DepartmentController@remove');

    $router->post('positions', 'PositionController@all');
    $router->post('positions/add', 'PositionController@add');
    $router->post('positions/{id}', 'PositionController@get');
    $router->post('positions/{id}/update', 'PositionController@put');
    $router->post('positions/{id}/remove', 'PositionController@remove');

    $router->post('salarys', 'SalaryController@all');
    $router->post('salarys/add', 'SalaryController@add');
    $router->post('salarys/{id}', 'SalaryController@get');
    $router->post('salarys/{id}/update', 'SalaryController@put');
    $router->post('salarys/{id}/remove', 'SalaryController@remove');

    $router->post('attendances', 'AttendanceController@all');
    $router->post('attendances/add', 'AttendanceController@add');
    $router->post('attendances/{id}', 'AttendanceController@get');
    $router->post('attendances/{id}/update', 'AttendanceController@put');
    $router->post('attendances/{id}/remove', 'AttendanceController@remove');

    $router->post('payrolls', 'PayrollController@all');
    $router->post('payrolls/add', 'PayrollController@add');
    $router->post('payrolls/{id}', 'PayrollController@get');
    $router->post('payrolls/{id}/update', 'PayrollController@put');
    $router->post('payrolls/{id}/remove', 'PayrollController@remove');

    $router->post('leave_requests', 'LeaveRequestController@all');
    $router->post('leave_requests/add', 'LeaveRequestController@add');
    $router->post('leave_requests/{id}', 'LeaveRequestController@get');
    $router->post('leave_requests/{id}/update', 'LeaveRequestController@put');
    $router->post('leave_requests/{id}/remove', 'LeaveRequestController@remove');

    $router->post('leave_types', 'LeaveTypeController@all');
    $router->post('leave_types/add', 'LeaveTypeController@add');
    $router->post('leave_types/{id}', 'LeaveTypeController@get');
    $router->post('leave_types/{id}/update', 'LeaveTypeController@put');
    $router->post('leave_types/{id}/remove', 'LeaveTypeController@remove');

    $router->post('doctors', 'DoctorController@all');
    $router->post('doctors/add', 'DoctorController@add');
    $router->post('doctors/{id}', 'DoctorController@get');
    $router->post('doctors/{id}/update', 'DoctorController@put');
    $router->post('doctors/{id}/remove', 'DoctorController@remove');

    $router->post('patients', 'PatientController@all');
    $router->post('patients/add', 'PatientController@add');
    $router->post('patients/{id}', 'PatientController@get');
    $router->post('patients/{id}/update', 'PatientController@put');
    $router->post('patients/{id}/remove', 'PatientController@remove');
    
    $router->post('emergency_patients', 'EmergencyPatientController@all');
    $router->post('emergency_patients/ot', 'EmergencyPatientController@getOT');
    $router->post('emergency_patients/labour', 'EmergencyPatientController@getLabour');
    $router->post('emergency_patients/add', 'EmergencyPatientController@add');
    $router->post('emergency_patients/{id}', 'EmergencyPatientController@get');
    $router->post('emergency_patients/{id}/update', 'EmergencyPatientController@put');
    $router->post('emergency_patients/{id}/remove', 'EmergencyPatientController@remove');

    $router->post('emergency_beds', 'EmergencyBedController@all');
    $router->post('emergency_beds/add', 'EmergencyBedController@add');
    $router->post('emergency_beds/{id}', 'EmergencyBedController@get');
    $router->post('emergency_beds/{id}/update', 'EmergencyBedController@put');
    $router->post('emergency_beds/{id}/remove', 'EmergencyBedController@remove');

    $router->post('emergency_rooms', 'EmergencyRoomController@all');
    $router->post('emergency_rooms/add', 'EmergencyRoomController@add');
    $router->post('emergency_rooms/{id}', 'EmergencyRoomController@get');
    $router->post('emergency_rooms/{id}/update', 'EmergencyRoomController@put');
    $router->post('emergency_rooms/{id}/remove', 'EmergencyRoomController@remove');

    $router->post('emergency_records', 'EmergencyRecordController@all');
    $router->post('emergency_records/add', 'EmergencyRecordController@add');
    $router->post('emergency_records/{id}', 'EmergencyRecordController@get');
    $router->post('emergency_records/{id}/update', 'EmergencyRecordController@put');
    $router->post('emergency_records/{id}/remove', 'EmergencyRecordController@remove');

    $router->post('investigation_categorys', 'InvestigationCategoryController@all');
    $router->post('investigation_categorys/add', 'InvestigationCategoryController@add');
    $router->post('investigation_categorys/{id}', 'InvestigationCategoryController@get');
    $router->post('investigation_categorys/{id}/update', 'InvestigationCategoryController@put');
    $router->post('investigation_categorys/{id}/remove', 'InvestigationCategoryController@remove');

    $router->post('investigation_items', 'InvestigationItemController@all');
    $router->post('investigation_items/add', 'InvestigationItemController@add');
    $router->post('investigation_items/{id}', 'InvestigationItemController@get');
    $router->post('investigation_items/{id}/update', 'InvestigationItemController@put');
    $router->post('investigation_items/{id}/remove', 'InvestigationItemController@remove');

    $router->post('investigation_requests', 'InvestigationRequestController@all');
    $router->post('investigation_requests/add', 'InvestigationRequestController@add');
    $router->post('investigation_requests/bydoctor/{did}', 'InvestigationRequestController@getByDoctor');
    $router->post('investigation_requests/{id}', 'InvestigationRequestController@get');
    $router->post('investigation_requests/{id}/update', 'InvestigationRequestController@put');
    $router->post('investigation_requests/{id}/remove', 'InvestigationRequestController@remove');

    $router->post('investigation_request_items', 'InvestigationRequestItemController@all');
    $router->post('investigation_request_items/add', 'InvestigationRequestItemController@add');
    $router->post('investigation_request_items/{id}', 'InvestigationRequestItemController@get');
    $router->post('investigation_request_items/{id}/update', 'InvestigationRequestItemController@put');
    $router->post('investigation_request_items/{id}/remove', 'InvestigationRequestItemController@remove');

    $router->post('investigation_departments', 'InvestigationDepartmentController@all');
    $router->post('investigation_departments/add', 'InvestigationDepartmentController@add');
    $router->post('investigation_departments/{id}', 'InvestigationDepartmentController@get');
    $router->post('investigation_departments/{id}/update', 'InvestigationDepartmentController@put');
    $router->post('investigation_departments/{id}/remove', 'InvestigationDepartmentController@remove');

    $router->post('appointments', 'AppointmentController@all');
    $router->post('appointments/add', 'AppointmentController@add');
    $router->post('appointments/bydate/{date}', 'AppointmentController@getByDate');
    $router->post('appointments/{id}', 'AppointmentController@get');
    $router->post('appointments/{id}/update', 'AppointmentController@put');
    $router->post('appointments/{id}/remove', 'AppointmentController@remove');

    $router->post('medical_records', 'MedicalRecordController@all');
    $router->post('medical_records/add', 'MedicalRecordController@add');
    $router->post('medical_records/patient/{patientid}', 'MedicalRecordController@getpatienthistory');
    $router->post('medical_records/{id}', 'MedicalRecordController@get');
    $router->post('medical_records/{id}/update', 'MedicalRecordController@put');
    $router->post('medical_records/{id}/remove', 'MedicalRecordController@remove');

    $router->post('suppliers', 'SupplierController@all');
    $router->post('suppliers/add', 'SupplierController@add');
    $router->post('suppliers/{id}', 'SupplierController@get');
    $router->post('suppliers/{id}/update', 'SupplierController@put');
    $router->post('suppliers/{id}/remove', 'SupplierController@remove');

    $router->post('pharmacy_categorys', 'PharmacyCategoryController@all');
    $router->post('pharmacy_categorys/add', 'PharmacyCategoryController@add');
    $router->post('pharmacy_categorys/{id}', 'PharmacyCategoryController@get');
    $router->post('pharmacy_categorys/{id}/update', 'PharmacyCategoryController@put');
    $router->post('pharmacy_categorys/{id}/remove', 'PharmacyCategoryController@remove');

    $router->post('pharmacy_items', 'PharmacyItemController@all');
    $router->post('pharmacy_items/add', 'PharmacyItemController@add');
    $router->post('pharmacy_items/{id}', 'PharmacyItemController@get');
    $router->post('pharmacy_items/{id}/update', 'PharmacyItemController@put');
    $router->post('pharmacy_items/{id}/remove', 'PharmacyItemController@remove');
    
    $router->post('pharmacy_sales', 'PharmacySaleController@all');
    $router->post('pharmacy_sales/ipd', 'PharmacySaleController@getIPD');
    $router->post('pharmacy_sales/opd', 'PharmacySaleController@getOPD');
    $router->post('pharmacy_sales/add', 'PharmacySaleController@add');
    $router->post('pharmacy_sales/{id}', 'PharmacySaleController@get');
    $router->post('pharmacy_sales/{id}/update', 'PharmacySaleController@put');
    $router->post('pharmacy_sales/{id}/remove', 'PharmacySaleController@remove');

    $router->post('pharmacy_sale_receipts', 'PharmacySaleReceiptController@all');
    $router->post('pharmacy_sale_receipts/add', 'PharmacySaleReceiptController@add');
    $router->post('pharmacy_sale_receipts/{id}', 'PharmacySaleReceiptController@get');
    $router->post('pharmacy_sale_receipts/{id}/update', 'PharmacySaleReceiptController@put');
    $router->post('pharmacy_sale_receipts/{id}/remove', 'PharmacySaleReceiptController@remove');
    
    $router->post('pharmacy_sale_items', 'PharmacySaleItemController@all');
    $router->post('pharmacy_sale_items/add', 'PharmacySaleItemController@add');
    $router->post('pharmacy_sale_items/{id}', 'PharmacySaleItemController@get');
    $router->post('pharmacy_sale_items/{id}/update', 'PharmacySaleItemController@put');
    $router->post('pharmacy_sale_items/{id}/remove', 'PharmacySaleItemController@remove');

    $router->post('pharmacy_purchases', 'PharmacyPurchaseController@all');
    $router->post('pharmacy_purchases/add', 'PharmacyPurchaseController@add');
    $router->post('pharmacy_purchases/{id}', 'PharmacyPurchaseController@get');
    $router->post('pharmacy_purchases/{id}/update', 'PharmacyPurchaseController@put');
    $router->post('pharmacy_purchases/{id}/remove', 'PharmacyPurchaseController@remove');

    $router->post('pharmacy_purchase_items', 'PharmacyPurchaseItemController@all');
    $router->post('pharmacy_purchase_items/add', 'PharmacyPurchaseItemController@add');
    $router->post('pharmacy_purchase_items/{id}', 'PharmacyPurchaseItemController@get');
    $router->post('pharmacy_purchase_items/{id}/update', 'PharmacyPurchaseItemController@put');
    $router->post('pharmacy_purchase_items/{id}/remove', 'PharmacyPurchaseItemController@remove');

    $router->post('pharmacy_purchase_payments', 'PharmacyPurchasePaymentController@all');
    $router->post('pharmacy_purchase_payments/add', 'PharmacyPurchasePaymentController@add');
    $router->post('pharmacy_purchase_payments/{id}', 'PharmacyPurchasePaymentController@get');
    $router->post('pharmacy_purchase_payments/{id}/update', 'PharmacyPurchasePaymentController@put');
    $router->post('pharmacy_purchase_payments/{id}/remove', 'PharmacyPurchasePaymentController@remove');

    $router->post('pharmacy_issues', 'PharmacyIssueController@all');
    $router->post('pharmacy_issues/add', 'PharmacyIssueController@add');
    $router->post('pharmacy_issues/{id}', 'PharmacyIssueController@get');
    $router->post('pharmacy_issues/{id}/update', 'PharmacyIssueController@put');
    $router->post('pharmacy_issues/{id}/remove', 'PharmacyIssueController@remove');
    
    $router->post('pharmacy_issue_items', 'PharmacyIssueItemController@all');
    $router->post('pharmacy_issue_items/add', 'PharmacyIssueItemController@add');
    $router->post('pharmacy_issue_items/{id}', 'PharmacyIssueItemController@get');
    $router->post('pharmacy_issue_items/{id}/update', 'PharmacyIssueItemController@put');
    $router->post('pharmacy_issue_items/{id}/remove', 'PharmacyIssueItemController@remove');

    $router->post('pharmacy_inventorys', 'PharmacyInventoryController@all');
    $router->post('pharmacy_inventorys/add', 'PharmacyInventoryController@add');
    $router->post('pharmacy_inventorys/{id}', 'PharmacyInventoryController@get');
    $router->post('pharmacy_inventorys/{id}/update', 'PharmacyInventoryController@put');
    $router->post('pharmacy_inventorys/{id}/remove', 'PharmacyInventoryController@remove');

    $router->post('pharmacy_warehouses', 'PharmacyWarehouseController@all');
    $router->post('pharmacy_warehouses/add', 'PharmacyWarehouseController@add');
    $router->post('pharmacy_warehouses/{id}', 'PharmacyWarehouseController@get');
    $router->post('pharmacy_warehouses/{id}/update', 'PharmacyWarehouseController@put');
    $router->post('pharmacy_warehouses/{id}/remove', 'PharmacyWarehouseController@remove');

    $router->post('prescriptions', 'PrescriptionController@all');
    $router->post('prescriptions/add', 'PrescriptionController@add');
    $router->post('prescriptions/{id}', 'PrescriptionController@get');
    $router->post('prescriptions/{id}/update', 'PrescriptionController@put');
    $router->post('prescriptions/{id}/remove', 'PrescriptionController@remove');

    $router->post('diagnosis_requests', 'DiagnosisRequestController@all');
    $router->post('diagnosis_requests/add', 'DiagnosisRequestController@add');
    $router->post('diagnosis_requests/{id}', 'DiagnosisRequestController@get');
    $router->post('diagnosis_requests/{id}/update', 'DiagnosisRequestController@put');
    $router->post('diagnosis_requests/{id}/remove', 'DiagnosisRequestController@remove');

    $router->post('diagnosis_request_items', 'DiagnosisRequestItemController@all');
    $router->post('diagnosis_request_items/add', 'DiagnosisRequestItemController@add');
    $router->post('diagnosis_request_items/{id}', 'DiagnosisRequestItemController@get');
    $router->post('diagnosis_request_items/{id}/update', 'DiagnosisRequestItemController@put');
    $router->post('diagnosis_request_items/{id}/remove', 'DiagnosisRequestItemController@remove');

    $router->post('diagnosis_reports', 'DiagnosisReportController@all');
    $router->post('diagnosis_reports/add', 'DiagnosisReportController@add');
    $router->post('diagnosis_reports/{id}', 'DiagnosisReportController@get');
    $router->post('diagnosis_reports/{id}/update', 'DiagnosisReportController@put');
    $router->post('diagnosis_reports/{id}/remove', 'DiagnosisReportController@remove');

    $router->post('diagnosis_report_items', 'DiagnosisReportItemController@all');
    $router->post('diagnosis_report_items/add', 'DiagnosisReportItemController@add');
    $router->post('diagnosis_report_items/{id}', 'DiagnosisReportItemController@get');
    $router->post('diagnosis_report_items/{id}/update', 'DiagnosisReportItemController@put');
    $router->post('diagnosis_report_items/{id}/remove', 'DiagnosisReportItemController@remove');

    $router->post('opd_rooms', 'OPDRoomController@all');
    $router->post('opd_rooms/add', 'OPDRoomController@add');
    $router->post('opd_rooms/{id}', 'OPDRoomController@get');
    $router->post('opd_rooms/{id}/update', 'OPDRoomController@put');
    $router->post('opd_rooms/{id}/remove', 'OPDRoomController@remove');

    $router->post('service_categorys', 'ServiceCategoryController@all');
    $router->post('service_categorys/add', 'ServiceCategoryController@add');
    $router->post('service_categorys/{id}', 'ServiceCategoryController@get');
    $router->post('service_categorys/{id}/update', 'ServiceCategoryController@put');
    $router->post('service_categorys/{id}/remove', 'ServiceCategoryController@remove');

    $router->post('service_items', 'ServiceItemController@all');
    $router->post('service_items/add', 'ServiceItemController@add');
    $router->post('service_items/{id}', 'ServiceItemController@get');
    $router->post('service_items/{id}/update', 'ServiceItemController@put');
    $router->post('service_items/{id}/remove', 'ServiceItemController@remove');

    $router->post('bills', 'BillController@all');
    $router->post('bills/add', 'BillController@add');
    $router->post('bills/{id}', 'BillController@get');
    $router->post('bills/{id}/update', 'BillController@put');
    $router->post('bills/{id}/remove', 'BillController@remove');

    $router->post('bill_service_items', 'BillServiceItemController@all');
    $router->post('bill_service_items/add', 'BillServiceItemController@add');
    $router->post('bill_service_items/{id}', 'BillServiceItemController@get');
    $router->post('bill_service_items/{id}/update', 'BillServiceItemController@put');
    $router->post('bill_service_items/{id}/remove', 'BillServiceItemController@remove');

    $router->post('bill_service_receipt', 'BillServiceReceiptController@all');
    $router->post('bill_service_receipt/add', 'BillServiceReceiptController@add');
    $router->post('bill_service_receipt/{id}', 'BillServiceReceiptController@get');
    $router->post('bill_service_receipt/{id}/update', 'BillServiceReceiptController@put');
    $router->post('bill_service_receipt/{id}/remove', 'BillServiceReceiptController@remove');

    $router->post('billing_adjustments', 'BillAdjustmentController@all');
    $router->post('billing_adjustments/add', 'BillAdjustmentController@add');
    $router->post('billing_adjustments/{id}', 'BillAdjustmentController@get');
    $router->post('billing_adjustments/{id}/update', 'BillAdjustmentController@put');
    $router->post('billing_adjustments/{id}/remove', 'BillAdjustmentController@remove');
   
    $router->post('payments', 'PaymentController@all');
    $router->post('payments/add', 'PaymentController@add');
    $router->post('payments/{id}', 'PaymentController@get');
    $router->post('payments/{id}/update', 'PaymentController@put');
    $router->post('payments/{id}/remove', 'PaymentController@remove');

    $router->post('inventory_transactions', 'PharmacyInventoryTransactionController@all');
    $router->post('inventory_transactions/add', 'PharmacyInventoryTransactionController@add');
    $router->post('inventory_transactions/bydates', 'PharmacyInventoryTransactionController@getWithDates');
    $router->post('inventory_transactions/{id}', 'PharmacyInventoryTransactionController@get');
    $router->post('inventory_transactions/{id}/update', 'PharmacyInventoryTransactionController@put');
    $router->post('inventory_transactions/{id}/remove', 'PharmacyInventoryTransactionController@remove');

    $router->post('inventory_unit_conversion', 'PharmacyUnitConversionController@all');
    $router->post('inventory_unit_conversion/add', 'PharmacyUnitConversionController@add');
    $router->post('inventory_unit_conversion/{id}', 'PharmacyUnitConversionController@get');
    $router->post('inventory_unit_conversion/{id}/update', 'PharmacyUnitConversionController@put');
    $router->post('inventory_unit_conversion/{id}/remove', 'PharmacyUnitConversionController@remove');

    $router->post('lab_analyzers', 'LabAnalyzerController@all');
    $router->post('lab_analyzers/add', 'LabAnalyzerController@add');
    $router->post('lab_analyzers/{id}', 'LabAnalyzerController@get');
    $router->post('lab_analyzers/{id}/update', 'LabAnalyzerController@put');
    $router->post('lab_analyzers/{id}/remove', 'LabAnalyzerController@remove');

    $router->post('lab_items', 'LabItemController@all');
    $router->post('lab_items/add', 'LabItemController@add');
    $router->post('lab_items/{id}', 'LabItemController@get');
    $router->post('lab_items/{id}/update', 'LabItemController@put');
    $router->post('lab_items/{id}/remove', 'LabItemController@remove');

    $router->post('general_items', 'GeneralItemController@all');
    $router->post('general_items/add', 'GeneralItemController@add');
    $router->post('general_items/{id}', 'GeneralItemController@get');
    $router->post('general_items/{id}/update', 'GeneralItemController@put');
    $router->post('general_items/{id}/remove', 'GeneralItemController@remove');

    $router->post('store_locations', 'StoreLocationController@all');
    $router->post('store_locations/add', 'StoreLocationController@add');
    $router->post('store_locations/{id}', 'StoreLocationController@get');
    $router->post('store_locations/{id}/update', 'StoreLocationController@put');
    $router->post('store_locations/{id}/remove', 'StoreLocationController@remove'); 

    $router->post('inventorys', 'InventoryController@all');
    $router->post('inventorys/bylocation/{location_id}', 'InventoryController@byLocation');
    $router->post('inventorys/getsaleitems/{location_id}', 'InventoryController@getSaleItem');
    $router->post('inventorys/add', 'InventoryController@add');
    $router->post('inventorys/{id}', 'InventoryController@get');
    $router->post('inventorys/{id}/update', 'InventoryController@put');
    $router->post('inventorys/{id}/remove', 'InventoryController@remove');

    // InvestigationItemRangeController
    $router->post('investigation_item_ranges', 'InvestigationItemRangeController@all');
    $router->post('investigation_item_ranges/add', 'InvestigationItemRangeController@add');
    $router->post('investigation_item_ranges/{id}', 'InvestigationItemRangeController@get');
    $router->post('investigation_item_ranges/{id}/update', 'InvestigationItemRangeController@put');
    $router->post('investigation_item_ranges/{id}/remove', 'InvestigationItemRangeController@remove');
    
    $router->post('transaction_types', 'TransactionTypeController@all');
    $router->post('transaction_types/add', 'TransactionTypeController@add');
    $router->post('transaction_types/{id}', 'TransactionTypeController@get');
    $router->post('transaction_types/{id}/update', 'TransactionTypeController@put');
    $router->post('transaction_types/{id}/remove', 'TransactionTypeController@remove');

    $router->post('deposits', 'DepositController@all');
    $router->post('deposits/add', 'DepositController@add');
    $router->post('deposits/{id}', 'DepositController@get');
    $router->post('deposits/{id}/update', 'DepositController@put');
    $router->post('deposits/{id}/remove', 'DepositController@remove');
    
    $router->post('patient_service_used_records', 'PatientServiceUsedRecordController@all');
    $router->post('patient_service_used_records/add', 'PatientServiceUsedRecordController@add');
    $router->post('patient_service_used_records/datefilter', 'PatientServiceUsedRecordController@getWithDates');
    $router->post('patient_service_used_records/open', 'PatientServiceUsedRecordController@getOpenItems');
    $router->post('patient_service_used_records/search_with_service_item/{id}', 'PatientServiceUsedRecordController@getByServiceId');
    $router->post('patient_service_used_records/{id}', 'PatientServiceUsedRecordController@get');
    $router->post('patient_service_used_records/{id}/update', 'PatientServiceUsedRecordController@put');
    $router->post('patient_service_used_records/{id}/remove', 'PatientServiceUsedRecordController@remove');
    
    $router->post('radiology_request_forms', 'RadiologyRequestFormController@all');
    $router->post('radiology_request_forms/add', 'RadiologyRequestFormController@add');
    $router->post('radiology_request_forms/{id}', 'RadiologyRequestFormController@get');
    $router->post('radiology_request_forms/{id}/update', 'RadiologyRequestFormController@put');
    $router->post('radiology_request_forms/{id}/remove', 'RadiologyRequestFormController@remove');

    $router->post('radiology_report_forms', 'RadiologyReportFormController@all');
    $router->post('radiology_report_forms/add', 'RadiologyReportFormController@add');
    $router->post('radiology_report_forms/{id}', 'RadiologyReportFormController@get');
    $router->post('radiology_report_forms/{id}/update', 'RadiologyReportFormController@put');
    $router->post('radiology_report_forms/{id}/remove', 'RadiologyReportFormController@remove');

    $router->post('ct_test_orders', 'CtTestOrderController@all');
    $router->post('ct_test_orders/confirm','CtTestOrderController@getOpen');
    $router->post('ct_test_orders/complete','CtTestOrderController@getComplete');
    $router->post('ct_test_orders/add', 'CtTestOrderController@add');
    $router->post('ct_test_orders/bydoctor/{did}', 'CtTestOrderController@getByDoctor');
    $router->post('ct_test_orders/{id}', 'CtTestOrderController@get');
    $router->post('ct_test_orders/{id}/update', 'CtTestOrderController@put');
    $router->post('ct_test_orders/{id}/remove', 'CtTestOrderController@remove');
    
    $router->post('ct_test_order_items', 'CtTestOrderItemController@all');
    $router->post('ct_test_order_items/add', 'CtTestOrderItemController@add');
    $router->post('ct_test_order_items/{id}', 'CtTestOrderItemController@get');
    $router->post('ct_test_order_items/{id}/update', 'CtTestOrderItemController@put');
    $router->post('ct_test_order_items/{id}/remove', 'CtTestOrderItemController@remove');

    $router->post('inpatient_records', 'InPatientRecordController@all');
    $router->post('inpatient_records/add', 'InPatientRecordController@add');
    $router->post('inpatient_records/{id}', 'InPatientRecordController@get');
    $router->post('inpatient_records/{id}/update', 'InPatientRecordController@put');
    $router->post('inpatient_records/{id}/remove', 'InPatientRecordController@remove');

    $router->post('inpatient_beds', 'InPatientBedController@all');
    $router->post('inpatient_beds/add', 'InPatientBedController@add');
    $router->post('inpatient_beds/{id}', 'InPatientBedController@get');
    $router->post('inpatient_beds/{id}/update', 'InPatientBedController@put');
    $router->post('inpatient_beds/{id}/remove', 'InPatientBedController@remove');

    $router->post('inpatient_rooms', 'InPatientRoomController@all');
    $router->post('inpatient_rooms/add', 'InPatientRoomController@add');
    $router->post('inpatient_rooms/{id}', 'InPatientRoomController@get');
    $router->post('inpatient_rooms/{id}/update', 'InPatientRoomController@put');
    $router->post('inpatient_rooms/{id}/remove', 'InPatientRoomController@remove');
    
    $router->post('get_open_deposit_by_patient_id/{pid}', 'DepositController@getallopen');
    $router->post('patient_service_used_records_by_patient_id/{pid}', 'PatientServiceUsedRecordController@getallopen');
    $router->post('investigation_requests/patient/{pid}', 'InvestigationRequestController@getbypid');
    $router->post('ct_test_order/patient/{pid}', 'CtTestOrderController@getbypid');
    $router->post('prescriptions/patient/{pid}', 'PrescriptionController@getbypid');

    // POS
    $router->post('inventory_get_all', 'InventoryController@getall');
    $router->post('expiry_items', 'InventoryController@expiryitems');
});