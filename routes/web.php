<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

use App\Http\Controller\FarmerController;
use App\Http\Controller\CargoController;
use App\Http\Controller\CF\CFserviceController;
use App\Http\Controller\GroupController;
use App\Http\Controller\MemberController;
use App\Http\Controller\LandController;
use App\Http\Controller\SupplierController;
use App\Http\Controller\ProductController;
use App\Http\Controller\UnitController;
use App\Http\Controller\PurchaseController;
use App\Http\Controller\SalesController;
use App\Http\Controllers\AzamPesa\IndexController;
use App\Http\Controller\Single_warehouseController;
use App\Http\Controller\Orders_Client_ManipulationsController;
use App\Http\Controller\Warehouse_backendController;

//use ;
use App\Models\Counter;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/',"HomeController@index")->name('home')->middleware('auth');
Route::any('tracking',"Courier\CourierMovementController@tracking")->name('tracking');

//testing input
Route::group(['prefix' => 'testing_input'], function () {
Route::get('file-import','Admin\JournalImportController@importView')->name('import-view');
Route::post('import','Admin\JournalImportController@import')->name('import');
Route::post('sample','Admin\JournalImportController@sample')->name('sample');
});


// start affiliate routes
Route::group(['prefix' => 'affiliate'], function () {
    
Route::get('users', 'Affiliate\UsersController@affiliate')->name('affiliate.users')->middleware('auth');

Route::get('register', 'Auth\RegisterController@affiliate_register')->name('affiliate.register_view');

Route::post('register','Auth\RegisterController@affiliate_register_store')->name('affiliate.register');




});
/*
Route::group(['prefix'=>'farmer'],function()
{
    Route::get('register','FarmerController@register')->middleware('auth');
})->middleware('auth');
*/


//my rooot


// start farming routes
// Route::group(['prefix' => 'farmings'], function () {
// Route::resource('/farming_cost','farming\Farming_costController')->middleware('auth');
// Route::resource('/cost_centre','farming\Cost_CentreController')->middleware('auth');
// Route::resource('/farming_process','farming\Farming_processController')->middleware('auth');
// Route::resource('/crop_type','farming\CropTypeController')->middleware('auth');
// Route::resource('/seed_type','farming\FeedTypeController')->middleware('auth');
// Route::resource('/farm_program','farming\FarmProgramController')->middleware('auth');
// Route::resource('/crops_monitoring','farming\Crops_MonitoringController')->middleware('auth');
// Route::resource('/register_assets','farming\Farmer_assetsController')->middleware('auth');
// Route::resource('/lime_base','farming\LimeBaseController')->middleware('auth');
// Route::get('/landview',"farming\Farmer_assetsController@index1" )->middleware('auth');
// Route::get('/landdelete/{$id}',"farming\Farmer_assetsController@destroy2" )->middleware('auth');
// Route::get('getFarm',"farming\Farmer_assetsController@getFarm" )->middleware('auth');

// Route::resource('seeds_type',"farming\Seeds_TypesController" )->middleware('auth');
// Route::resource('pesticide_type',"farming\PesticideTypeController" )->middleware('auth');
// Route::get('download',array('as'=>'download','uses'=>'farming\Crops_MonitoringController@download'))->middleware('auth');
// // end farming routes
// });

// start crop life cycle routes
// Route::group(['prefix' => 'crop_lifecycles'], function () {
// Route::resource('irrigation','CropLifeCycle\IrrigationController')->middleware('auth');
// // end crop life cycle routes
// });

// start shop routes
Route::group(['prefix' => 'shops'], function () {
Route::resource('items', 'shop\ItemsController')->middleware('auth');
Route::resource('purchase','shop\PurchaseController')->middleware('auth');
Route::get('findPrice', 'shop\PurchaseController@findPrice')->middleware('auth');  
Route::resource('sales','shop\SalesController')->middleware('auth');
Route::resource('payments', 'shop\PaymentsController')->middleware('auth');
Route::resource('invoice_payment', 'shop\Invoice_paymentController')->middleware('auth');
Route::resource('invoicepdf', 'shop\PDFController')->middleware('auth');
Route::get('pdfview',array('as'=>'pdfview','uses'=>'PDFController@pdfview'))->middleware('auth');
});


// start AzamPesa routes

 Route::any('/index', [IndexController::class, 'index'])->name('azampay.index');
 Route::any('/store', [IndexController::class, 'store'])->name('azampesa.store');
 
//Route::group(['prefix' => 'azampesa'], function () {
//Route::resource('azampesa2', 'AzamPesa\IndexController')->middleware('auth');
//});

//Orders Routes
Route::group(['prefix' => 'orders'], function () {
Route::resource('orders','orders\OrdersController')->middleware('auth');
Route::any('quotationList','orders\OrdersController@quotationList')->middleware('auth');
Route::any('quotationDetails/{id}','orders\OrdersController@quotationDetails')->middleware('auth');
});

//Seasson Routes
Route::group(['prefix' => 'farming_season'], function () {

Route::resource('/seasson','farming\SeassonController')->middleware('auth');
Route::resource('/cropslifecycle','farming\CropsLifeCycleController')->middleware('auth');
Route::any('editLifeCycle',array('as'=>'editLifeCycle','uses'=>'farming\CropsLifeCycleController@editLifeCycle'))->middleware('auth');
Route::any('deleteLifeCycle',array('as'=>'deleteLifeCycle','uses'=>'farming\CropsLifeCycleController@deleteLifeCycle'))->middleware('auth');
Route::get('findFarm',"farming\SeassonController@findFarm" )->middleware('auth');
Route::get('findLime',"farming\CropsLifeCycleController@findLime" )->middleware('auth');
Route::get('findSeed',"farming\CropsLifeCycleController@findSeed" )->middleware('auth');
Route::get('findPesticide',"farming\CropsLifeCycleController@findPesticide" )->middleware('auth');
Route::get('monitorModal', 'farming\CropsLifeCycleController@discountModal')->middleware('auth');
Route::post('save_monitor', 'farming\CropsLifeCycleController@save_monitor')->name('monitor.save')->middleware('auth');
});

Route::get('home',"HomeController@index" )->middleware('auth');


Route::group(['prefix' => 'farmer_management'], function () {

Route::get('farmer','FarmerController@index')->middleware('auth');
//Route::post('save','FarmerController@store')->middleware('auth');
Route::get('farmer/{id}/edit','FarmerController@edit')->middleware('auth');
//Route::resource('farmer','FarmerController')->middleware('auth');
Route::post('farmer/update/{id}','FarmerController@update')->middleware('auth');
Route::post('farmer/save','FarmerController@store')->middleware('auth');
Route::get('farmer/{id}/delete','FarmerController@destroy')->middleware('auth');
Route::get('farmer/{id}/show','FarmerController@show')->middleware('auth');
Route::get('findRegion', 'FarmerController@findRegion')->middleware('auth');  
Route::get('findDistrict', 'FarmerController@findDistrict')->middleware('auth');  
Route::get('assign_farmer','FarmerController@assign_farmer')->middleware('auth');
Route::post('save_farmer', 'FarmerController@save_farmer')->name('farmer.save')->middleware('auth');
Route::get('farmerModal', 'FarmerController@discountModal')->middleware('auth');


Route::post('group/{id}/update','GroupController@update')->middleware('auth');
Route::get('manage-group','GroupController@index')->middleware('auth');
Route::post('group/save','GroupController@store')->middleware('auth');
Route::get('group/{id}/delete','GroupController@destroy')->middleware('auth');

Route::get('farmer/group/{id}/add','MemberController@index')->middleware('auth');
Route::get('farmer/group/','MemberController@show')->middleware('auth');

route::post('save','MemberController@store')->middleware('auth');

route::get('land','LandController@index')->middleware('auth');
route::post('land/save','LandController@store')->middleware('auth');
route::get('land/{id}/delete','LandController@destroy')->middleware('auth');
route::post('land/{id}/edit','LandController@update')->middleware('auth');
//oute::get('test',[App\Http\Livewire\Counter::class, 'render'])->middleware('auth');

});

Route::group(['prefix' => 'project'], function () {
   Route::resource('project', 'Project\ProjectController')->middleware('auth');
   Route::get('project_change_status/{id}/{status}', 'Project\ProjectController@change_status')->name('project.change_status')->middleware('auth'); 
   Route::get('projectModal', 'Project\ProjectController@discountModal')->middleware('auth');    
   Route::get('saveCategory', 'Project\ProjectController@saveCategory')->middleware('auth');
    Route::post('assign_user', 'Project\ProjectController@assign_user')->name('project.assign_user')->middleware('auth');

    Route::post('save_project_details', 'Project\ProjectController@save_details')->name('save.project_details')->middleware('auth');
    Route::get('edit_project_details/{type}/{type_id}', 'Project\ProjectController@edit_details')->name('edit.project_details')->middleware('auth'); 
    Route::post('update_project_details', 'Project\ProjectController@update_details')->name('update.project_details')->middleware('auth');
     Route::get('delete_project_details/{type}/{type_id}', 'Project\ProjectController@delete_details')->name('delete.project_details')->middleware('auth'); 
Route::get('approve_purchase/{id}', 'Project\ProjectController@approve_purchase')->name('project.approve_purchase')->middleware('auth'); 
 Route::get('convert_to_invoice/{id}', 'Project\ProjectController@convert_to_invoice')->name('project.convert_to_invoice')->middleware('auth'); 
 Route::get('findInvoice', 'Project\ProjectController@findInvoice')->middleware('auth'); 
  Route::post('multiple_approve', 'Project\ProjectController@multiple_approve')->name('project_expenses.approve')->middleware('auth');
 Route::any('project_file_preview', 'Project\ProjectController@file_preview')->name('project_file.preview');

    Route::resource('milestone', 'Project\MilestoneController')->middleware('auth');
    Route::resource('ticket', 'Project\TicketController')->middleware('auth');
    Route::resource('calendar', 'Project\CalendarController')->middleware('auth');
    
    Route::resource('task', 'Project\TaskController')->middleware('auth');
    Route::get('task_change_status/{id}/{status}', 'Project\TaskController@change_status')->name('task.change_status')->middleware('auth'); 
    
    Route::get('taskModal', 'Project\TaskController@discountModal')->middleware('auth'); 
    Route::post('assign_user_task', 'Project\TaskController@assign_user')->name('task.assign_user')->middleware('auth');
    
    
    Route::post('save_task_details', 'Project\TaskController@save_details')->name('save.task_details')->middleware('auth');
    Route::get('edit_task_details/{type}/{type_id}', 'Project\TaskController@edit_details')->name('edit.task_details')->middleware('auth'); 
    Route::post('update_task_details', 'Project\TaskController@update_details')->name('update.task_details')->middleware('auth');
     Route::get('delete_task_details/{type}/{type_id}', 'Project\TaskController@delete_details')->name('delete.task_details')->middleware('auth'); 
 Route::any('task_file_preview', 'Project\TaskController@file_preview')->name('task_file.preview');
 
 
    
    Route::get('addCategory', 'Project\TaskController@addCategory')->middleware('auth');
    
});
//clearing and forwading
Route::group(['prefix' => 'cf'], function () {
   Route::resource('cargo_type', 'CF\CargoController')->middleware('auth');

   Route::resource('cf_service', 'CF\CFserviceController')->middleware('auth');
   Route::post('cf_store_details', 'CF\CFserviceController@storage_details')->name('save.storage_details')->middleware('auth');
  Route::post('cf_charge_details', 'CF\CFserviceController@charge_details')->name('save.charge_details')->middleware('auth');
   Route::get('update_amount/{id}', 'CF\CFserviceController@updateAmount')->name('update_amount')->middleware('auth');
   Route::get('delete_det/{type}/{type_id}','CF\CFserviceController@delete_details')->name('cf_delete_details')->middleware('auth');
  Route::post('update_det', 'CF\CFserviceController@cf_update_details')->name('update_det')->middleware('auth');

   Route::resource('cf', 'CF\ProjectController')->middleware('auth');
   Route::get('cf_change_status/{id}/{status}', 'CF\ProjectController@change_status')->name('cf.change_status')->middleware('auth'); 
   Route::get('cfModal', 'CF\ProjectController@discountModal')->middleware('auth');    
   Route::get('cf_saveCategory', 'CF\ProjectController@saveCategory')->middleware('auth');
    Route::post('assign_user', 'CF\ProjectController@assign_user')->name('cf.assign_user')->middleware('auth');

    Route::post('save_cf_details', 'CF\ProjectController@save_details')->name('save.cf_details')->middleware('auth');
    Route::get('edit_cf_details/{type}/{type_id}', 'CF\ProjectController@edit_details')->name('edit.cf_details')->middleware('auth'); 
    Route::post('update_cf_details', 'CF\ProjectController@update_details')->name('update.cf_details')->middleware('auth');
     Route::get('delete_cf_details/{type}/{type_id}', 'CF\ProjectController@delete_details')->name('delete.cf_details')->middleware('auth'); 

Route::get('approve_purchase/{id}', 'CF\ProjectController@approve_purchase')->name('cf.approve_purchase')->middleware('auth'); 
 Route::get('convert_to_invoice/{id}', 'CF\ProjectController@convert_to_invoice')->name('cf.convert_to_invoice')->middleware('auth'); 
 Route::get('cf_findInvoice', 'CF\ProjectController@findInvoice')->middleware('auth'); 
  Route::post('multiple_approve', 'CF\ProjectController@multiple_approve')->name('cf_expenses.approve')->middleware('auth');
 Route::any('cf_file_preview', 'CF\ProjectController@file_preview')->name('cf_file.preview');

    Route::resource('cf_milestone', 'CF\MilestoneController')->middleware('auth');
    Route::resource('cf_ticket', 'CF\TicketController')->middleware('auth');
    Route::resource('cf_calendar', 'CF\CalendarController')->middleware('auth');
    
    Route::resource('cf_task', 'CF\TaskController')->middleware('auth');
    Route::get('cf_change_status/{id}/{status}', 'CF\TaskController@change_status')->name('task.change_status')->middleware('auth'); 
    
    Route::get('taskModal', 'CF\TaskController@discountModal')->middleware('auth'); 
    Route::post('assign_user_task', 'CF\TaskController@assign_user')->name('task.assign_user')->middleware('auth');
    
    
    Route::post('save_task_cf_details', 'CF\TaskController@save_details')->name('save.task_cf_details')->middleware('auth');
    Route::get('edit_task_cf_details/{type}/{type_id}', 'CF\TaskController@edit_details')->name('edit.task_cf_details')->middleware('auth'); 
    Route::post('update_task_cf_details', 'CF\TaskController@update_details')->name('update.task_cf_details')->middleware('auth');
     Route::get('delete_task_cf_details/{type}/{type_id}', 'CF\TaskController@delete_details')->name('delete.task_cf_details')->middleware('auth'); 
    Route::get('cf_addCategory', 'CF\TaskController@addCategory')->middleware('auth');
    
    Route::resource('pacel_cf', 'CF_Pacel\PacelController')->middleware('auth');
    Route::get('pacel_approve/{id}', 'Pacel\PacelController@approve')->name('pacel.approve')->middleware('auth'); 
    Route::get('pacel_cancel/{id}', 'Pacel\PacelController@cancel')->name('pacel.cancel')->middleware('auth');  
});

//leads
Route::resource('leads', 'Leads\LeadsController')->middleware('auth');
Route::get('leadsModal', 'Leads\LeadsController@discountModal')->middleware('auth');    
Route::get('addStatus', 'Leads\LeadsController@addStatus')->middleware('auth');
Route::get('addSource', 'Leads\LeadsController@addSource')->middleware('auth');
Route::post('save_lead_details', 'Leads\LeadsController@save_details')->name('save.lead_details')->middleware('auth');
Route::get('edit_lead_details/{type}/{type_id}', 'Leads\LeadsController@edit_details')->name('edit.lead_details')->middleware('auth'); 
Route::post('update_lead_details', 'Leads\LeadsController@update_details')->name('update.lead_details')->middleware('auth');
Route::get('delete_lead_details/{type}/{type_id}', 'Leads\LeadsController@delete_details')->name('delete.lead_details')->middleware('auth'); 
Route::any('leads_file_preview', 'Leads\LeadsController@file_preview')->name('leads_file.preview');




//livewire
Route::view('contacts', 'contacts')->middleware('auth');
Route::view('test','livewiretest')->middleware('auth');
Route::view('input-order','agrihub.iorder')->middleware('auth');

//supplier
Route::group(['prefix' => 'pos'], function () {

Route::any('activity', 'POS\PurchaseController@summary'); 

Route::group(['prefix' => 'purchases'], function () {
Route::resource('supplier', 'shop\SupplierController')->middleware('auth');
Route::resource('items', 'POS\ItemsController')->middleware('auth');
 Route::post('item_import','POS\ImportItemsController@import')->name('item.import');
 Route::post('update_quantity','POS\ItemsController@update_quantity')->name('items.update_quantity');
    Route::post('item_sample','POS\ImportItemsController@sample')->name('item.sample');
Route::resource('purchase', 'POS\PurchaseController')->middleware('auth');

Route::get('findInvPrice', 'POS\PurchaseController@findPrice')->middleware('auth'); 
Route::get('invModal', 'POS\PurchaseController@discountModal')->middleware('auth');
Route::get('approve_purchase/{id}', 'POS\PurchaseController@approve')->name('purchase.approve')->middleware('auth'); 
Route::get('cancel/{id}', 'POS\PurchaseController@cancel')->name('purchase.cancel')->middleware('auth'); 
Route::get('receive/{id}', 'POS\PurchaseController@receive')->name('purchase.receive')->middleware('auth'); 
Route::get('make_payment/{id}', 'POS\PurchaseController@make_payment')->name('purchase.pay')->middleware('auth'); 
Route::get('purchase_pdfview',array('as'=>'purchase_pdfview','uses'=>'POS\PurchaseController@inv_pdfview'))->middleware('auth');
Route::get('order_payment/{id}', 'orders\OrdersController@order_payment')->name('purchase_order.pay')->middleware('auth');
Route::resource('purchase_payment', 'POS\PurchasePaymentController')->middleware('auth');
Route::any('creditors_report', 'POS\PurchaseController@creditors_report')->middleware('auth');
 Route::resource('pos_issue', 'POS\GoodIssueController')->middleware('auth');
 Route::get('findQuantity', 'POS\GoodIssueController@findQuantity'); 
 Route::get('issue_approve/{id}', 'POS\GoodIssueController@approve')->name('pos_issue.approve')->middleware('auth');
Route::get('purchaseModal', 'POS\GoodIssueController@discountModal'); 

//serial_routes-purchase
Route::resource('purchase_serial', 'POS\PurchaseSerialController')->middleware('auth');
Route::get('findSerialInvPrice', 'POS\PurchaseSerialController@findPrice')->middleware('auth'); 
Route::get('invSerialModal', 'POS\PurchaseSerialController@discountModal')->middleware('auth');
Route::get('approve_purchase_serial/{id}', 'POS\PurchaseSerialController@approve')->name('purchase_serial.approve')->middleware('auth'); 
Route::get('cancel_serial/{id}', 'POS\PurchaseSerialController@cancel')->name('purchase_serial.cancel')->middleware('auth'); 
Route::get('receive_serial/{id}', 'POS\PurchaseSerialController@receive')->name('purchase_serial.receive')->middleware('auth'); 
Route::get('make_serial_payment/{id}', 'POS\PurchaseSerialController@make_payment')->name('purchase_serial.pay')->middleware('auth'); 
Route::get('purchase_serial_pdfview',array('as'=>'purchase_serial_pdfview','uses'=>'POS\PurchaseSerialController@inv_pdfview'))->middleware('auth');
Route::resource('purchase_serial_payment', 'POS\PurchaseSerialPaymentController')->middleware('auth');
Route::get('list', 'POS\PurchaseSerialController@list')->name('pos.list')->middleware('auth');
Route::post('save_pos_reference', 'POS\PurchaseSerialController@save_reference')->name('pos.reference')->middleware('auth');

Route::resource('debit_note', 'POS\ReturnPurchasesController')->middleware('auth');
      Route::get('findinvoice', 'POS\ReturnPurchasesController@findPrice')->middleware('auth'); 
 Route::get('findinvoice2', 'POS\ReturnPurchasesController@findPrice2')->middleware('auth'); 
      Route::get('showInvoice', 'POS\ReturnPurchasesController@showInvoice')->middleware('auth'); 
    Route::get('editshowInvoice', 'POS\ReturnPurchasesController@editshowInvoice')->middleware('auth'); 
      Route::get('findinvQty', 'POS\ReturnPurchasesController@findQty')->middleware('auth'); 
    Route::get('approve_debit_note/{id}', 'POS\ReturnPurchasesController@approve')->name('debit_note.approve')->middleware('auth'); 
    Route::get('cancel_debit_note/{id}', 'POS\ReturnPurchasesController@cancel')->name('debit_note.cancel')->middleware('auth'); 
    Route::get('receive_debit_note/{id}', 'POS\ReturnPurchasesController@receive')->name('debit_note.receive')->middleware('auth'); 
    Route::get('make_debit_note_payment/{id}', 'POS\ReturnPurchasesController@make_payment')->name('debit_note.pay')->middleware('auth'); 
    Route::resource('debit_note_payment', 'POS\ReturnPurchasesPaymentController')->middleware('auth');
    Route::get('debit_note_pdfview',array('as'=>'debit_note_pdfview','uses'=>'POS\ReturnPurchasesController@debit_note_pdfview'))->middleware('auth');
});
Route::group(['prefix' => 'sales'], function () {

  Route::resource('client', 'ClientController')->middleware('auth');

  Route::resource('profoma_invoice', 'POS\ProfomaInvoiceController')->middleware('auth');
  Route::get('convert_to_invoice/{id}', 'POS\ProfomaInvoiceController@convert_to_invoice')->name('invoice.convert_to_invoice')->middleware('auth'); 
  Route::any('debtors_report', 'POS\InvoiceController@debtors_report')->middleware('auth');
  Route::resource('invoice', 'POS\InvoiceController')->middleware('auth');  
  Route::get('findInvPrice', 'POS\InvoiceController@findPrice')->middleware('auth'); 
  Route::get('findInvQuantity', 'POS\InvoiceController@findQuantity'); 
  Route::get('invModal', 'POS\InvoiceController@discountModal')->middleware('auth');
  Route::get('approve_purchase/{id}', 'POS\InvoiceController@approve')->name('invoice.approve')->middleware('auth');  
  Route::get('cancel/{id}', 'POS\InvoiceController@cancel')->name('invoice.cancel')->middleware('auth'); 
  Route::get('receive/{id}', 'POS\InvoiceController@receive')->name('invoice.receive')->middleware('auth'); 
  Route::get('make_payment/{id}', 'POS\InvoiceController@make_payment')->name('pos_invoice.pay')->middleware('auth'); 

  Route::get('pos_profoma_pdfview',array('as'=>'pos_profoma_pdfview','uses'=>'POS\ProfomaInvoiceController@invoice_pdfview'))->middleware('auth');
  Route::get('pos_invoice_pdfview',array('as'=>'pos_invoice_pdfview','uses'=>'POS\InvoiceController@invoice_pdfview'))->middleware('auth');
  Route::get('order_payment/{id}', 'orders\OrdersController@order_payment')->name('purchase_order.pay')->middleware('auth');
  Route::resource('pos_invoice_payment', 'POS\InvoicePaymentController')->middleware('auth');

//serial_routes-invoice
 Route::resource('invoice_serial', 'POS\InvoiceSerialController')->middleware('auth');  
  Route::get('findInvSalesPrice', 'POS\InvoiceSerialController@findPrice')->middleware('auth'); 
  Route::get('invSalesModal', 'POS\InvoiceSerialController@discountModal')->middleware('auth');
  Route::get('approve_invoice_serial/{id}', 'POS\InvoiceSerialController@approve')->name('invoice_serial.approve')->middleware('auth');  
  Route::get('cancel_invoice_serial/{id}', 'POS\InvoiceSerialController@cancel')->name('invoice_serial.cancel')->middleware('auth'); 
  Route::get('receive_invoice_serial/{id}', 'POS\InvoiceSerialController@receive')->name('invoice_serial.receive')->middleware('auth'); 
  Route::get('make_invoice_serial_payment/{id}', 'POS\InvoiceSerialController@make_payment')->name('invoice_serial.pay')->middleware('auth'); 
 Route::get('invoice_serial_pdfview',array('as'=>'invoice_serial_pdfview','uses'=>'POS\InvoiceSerialController@invoice_pdfview'))->middleware('auth');
  Route::resource('invoice_serial_payment', 'POS\InvoiceSerialPaymentController')->middleware('auth');

  Route::resource('credit_note', 'POS\ReturnInvoiceController')->middleware('auth');
  Route::get('findinvoice', 'POS\ReturnInvoiceController@findPrice')->middleware('auth'); 
    Route::get('findinvoice2', 'POS\ReturnInvoiceController@findPrice2')->middleware('auth'); 
  Route::get('showInvoice', 'POS\ReturnInvoiceController@showInvoice')->middleware('auth'); 
Route::get('editshowInvoice', 'POS\ReturnInvoiceController@editshowInvoice')->middleware('auth'); 
  Route::get('findinvQty', 'POS\ReturnInvoiceController@findQty')->middleware('auth'); 
Route::get('approve_credit_note/{id}', 'POS\ReturnInvoiceController@approve')->name('credit_note.approve')->middleware('auth'); 
Route::get('cancel_credit_note/{id}', 'POS\ReturnInvoiceController@cancel')->name('credit_note.cancel')->middleware('auth'); 
Route::get('receive_credit_note/{id}', 'POS\ReturnInvoiceController@receive')->name('credit_note.receive')->middleware('auth'); 
Route::get('make_credit_note_payment/{id}', 'POS\ReturnInvoiceController@make_payment')->name('credit_note.pay')->middleware('auth'); 
Route::resource('credit_note_payment', 'POS\ReturnInvoicePaymentController')->middleware('auth');
Route::get('credit_note_pdfview',array('as'=>'credit_note_pdfview','uses'=>'POS\ReturnInvoiceController@credit_note_pdfview'))->middleware('auth');
  });
  
  Route::any('pharmacy_activity', 'Pharmacy\POS\PurchaseController@summary'); 

 Route::group(['prefix' => 'pharmacy_sales'], function () {

  Route::resource('pharmacy_client', 'Pharmacy\ClientController')->middleware('auth');

  Route::resource('pharmacy_proforma_invoice', 'Pharmacy\POS\ProfomaInvoiceController')->middleware('auth');
  Route::get('pharmacy_convert_to_invoice/{id}', 'Pharmacy\POS\ProfomaInvoiceController@convert_to_invoice')->name('pharmacy_invoice.convert_to_invoice')->middleware('auth'); 
 Route::get('pharmacy_proforma_invoice_pdfview',array('as'=>'pharmacy_proforma_invoice_pdfview','uses'=>'Pharmacy\POS\ProfomaInvoiceController@invoice_pdfview'))->middleware('auth');
Route::resource('pharmacy_invoice', 'Pharmacy\POS\InvoiceController')->middleware('auth');
Route::any('pharmacy_debtors_report', 'Pharmacy\POS\InvoiceController@debtors_report')->middleware('auth');
  Route::get('findBatch', 'Pharmacy\POS\InvoiceController@findBatch')->middleware('auth'); 
  Route::get('pharmacy_findInvPrice', 'Pharmacy\POS\InvoiceController@findPrice')->middleware('auth'); 
Route::get('pharmacy_findQty', 'Pharmacy\POS\InvoiceController@findQty')->middleware('auth'); 
  Route::get('pharmacy_invModal', 'Pharmacy\POS\InvoiceController@discountModal')->middleware('auth');
  Route::get('pharmacy_approve_purchase/{id}', 'Pharmacy\POS\InvoiceController@approve')->name('pharmacy_invoice.approve')->middleware('auth'); 
  Route::get('pharmacy_cancel/{id}', 'Pharmacy\POS\InvoiceController@cancel')->name('pharmacy_invoice.cancel')->middleware('auth'); 
  Route::get('pharmacy_receive/{id}', 'Pharmacy\POS\InvoiceController@receive')->name('pharmacy_invoice.receive')->middleware('auth'); 
  Route::get('pharmacy_make_payment/{id}', 'Pharmacy\POS\InvoiceController@make_payment')->name('pharmacy_pos_invoice.pay')->middleware('auth'); 
  Route::get('pharmacy_pos_invoice_pdfview',array('as'=>'pharmacy_pos_invoice_pdfview','uses'=>'Pharmacy\POS\InvoiceController@invoice_pdfview'))->middleware('auth');
  Route::get('pharmacy_pos_note_pdfview',array('as'=>'pharmacy_pos_note_pdfview','uses'=>'Pharmacy\POS\InvoiceController@note_pdfview'))->middleware('auth');
  Route::get('pharmacy_order_payment/{id}', 'Pharmacy\orders\OrdersController@order_payment')->name('pharmacy_purchase_order.pay')->middleware('auth');
  Route::resource('pharmacy_pos_invoice_payment', 'Pharmacy\POS\InvoicePaymentController')->middleware('auth');
Route::get('download_pharmacy_reference/{id}', 'Pharmacy\POS\InvoiceController@download_reference')->name('pharmacy_invoice.reference')->middleware('auth'); 
Route::get('download_pharmacy_delivery/{id}', 'Pharmacy\POS\InvoiceController@download_delivery')->name('pharmacy_invoice.delivery')->middleware('auth'); 
Route::post('save_delivery','Pharmacy\POS\InvoiceController@save_delivery')->name('pharmacy_save.delivery');

 Route::resource('pharmacy_serial_invoice', 'Pharmacy\POS\InvoiceSerialController')->middleware('auth');
  Route::get('pharmacy_serial_findInvPrice', 'Pharmacy\POS\InvoiceSerialController@findPrice')->middleware('auth'); 
  Route::get('pharmacy_serial_invModal', 'Pharmacy\POS\InvoiceSerialController@discountModal')->middleware('auth');
  Route::get('pharmacy_serial_approve_purchase/{id}', 'Pharmacy\POS\InvoiceSerialController@approve')->name('pharmacy_serial_invoice.approve')->middleware('auth'); 
  Route::get('pharmacy_serial_cancel/{id}', 'Pharmacy\POS\InvoiceSerialController@cancel')->name('pharmacy_serial_invoice.cancel')->middleware('auth'); 
  Route::get('pharmacy_serial_receive/{id}', 'Pharmacy\POS\InvoiceSerialController@receive')->name('pharmacy_serial_invoice.receive')->middleware('auth'); 
  Route::get('pharmacy_serial_make_payment/{id}', 'Pharmacy\POS\InvoiceSerialController@make_payment')->name('pharmacy_serial_pos_invoice.pay')->middleware('auth'); 
  Route::get('pharmacy_serial_pos_invoice_pdfview',array('as'=>'pharmacy_serial_pos_invoice_pdfview','uses'=>'Pharmacy\POS\InvoiceSerialController@invoice_pdfview'))->middleware('auth');
  Route::get('pharmacy_serial_pos_note_pdfview',array('as'=>'pharmacy_serial_pos_note_pdfview','uses'=>'Pharmacy\POS\InvoiceSerialController@note_pdfview'))->middleware('auth');
  Route::resource('pharmacy_serial_invoice_payment', 'Pharmacy\POS\InvoiceSerialPaymentController')->middleware('auth');

  Route::resource('pharmacy_credit_note', 'Pharmacy\POS\ReturnInvoiceController')->middleware('auth');
  Route::get('pharmacy_findinvoice', 'Pharmacy\POS\ReturnInvoiceController@findPrice')->middleware('auth'); 
  Route::get('pharmacy_showInvoice', 'Pharmacy\POS\ReturnInvoiceController@showInvoice')->middleware('auth'); 
  Route::get('pharmacy_editshowInvoice', 'Pharmacy\POS\ReturnInvoiceController@editshowInvoice')->middleware('auth'); 
  Route::get('pharmacy_findinvQty', 'Pharmacy\POS\ReturnInvoiceController@findQty')->middleware('auth'); 
Route::get('pharmacy_approve_credit_note/{id}', 'Pharmacy\POS\ReturnInvoiceController@approve')->name('pharmacy_credit_note.approve')->middleware('auth'); 
Route::get('pharmacy_cancel_credit_note/{id}', 'Pharmacy\POS\ReturnInvoiceController@cancel')->name('pharmacy_credit_note.cancel')->middleware('auth'); 
Route::get('pharmacy_receive_credit_note/{id}', 'Pharmacy\POS\ReturnInvoiceController@receive')->name('pharmacy_credit_note.receive')->middleware('auth'); 
Route::get('pharmacy_credit_note_payment/{id}', 'Pharmacy\POS\ReturnInvoiceController@make_payment')->name('pharmacy_credit_note.pay')->middleware('auth'); 
Route::get('pharmacy_credit_note_pdfview',array('as'=>'pharmacy_credit_note_pdfview','uses'=>'Pharmacy\POS\ReturnInvoiceController@credit_note_pdfview'))->middleware('auth');
Route::resource('pharmacy_credit_note_payment', 'Pharmacy\POS\ReturnInvoicePaymentController')->middleware('auth');
  });
  
  
  Route::group(['prefix' => 'pharmacy_purchases'], function () {
Route::resource('pharmacy_supplier', 'Pharmacy\shop\SupplierController')->middleware('auth');
Route::resource('pharmacy_items', 'Pharmacy\POS\ItemsController')->middleware('auth');
Route::post('pharmacy_import','Pharmacy\POS\ImportItemsController@import')->name('pharmacy.import');
    Route::post('pharmacy_sample','Pharmacy\POS\ImportItemsController@sample')->name('pharmacy.sample');
Route::get('addSupplier', 'Pharmacy\POS\PurchaseController@addSupplier')->middleware('auth'); 
Route::get('addCategory', 'Pharmacy\POS\ItemsController@addCategory')->middleware('auth');


Route::get('pharmacy_findInvPrice', 'Pharmacy\POS\PurchaseController@findPrice')->middleware('auth'); 
Route::get('pharmacy_invModal', 'Pharmacy\POS\PurchaseController@discountModal')->middleware('auth');
Route::get('pharmacy_approve_purchase/{id}', 'Pharmacy\POS\PurchaseController@approve')->name('pharmacy_purchase.approve')->middleware('auth'); 
Route::get('pharmacy_cancel/{id}', 'Pharmacy\POS\PurchaseController@cancel')->name('pharmacy_purchase.cancel')->middleware('auth'); 
Route::get('pharmacy_receive/{id}', 'Pharmacy\POS\PurchaseController@receive')->name('pharmacy_purchase.receive')->middleware('auth'); 
Route::get('pharmacy_make_payment/{id}', 'Pharmacy\POS\PurchaseController@make_payment')->name('pharmacy_purchase.pay')->middleware('auth'); 
Route::get('pharmacy_purchase_pdfview',array('as'=>'pharmacy_purchase_pdfview','uses'=>'Pharmacy\POS\PurchaseController@inv_pdfview'))->middleware('auth');
Route::get('pharmacy_order_payment/{id}', 'Pharmacy\orders\OrdersController@order_payment')->name('pharmacy_purchase_order.pay')->middleware('auth');
Route::resource('pharmacy_purchase_payment', 'Pharmacy\POS\PurchasePaymentController')->middleware('auth');
Route::any('pharmacy_creditors_report', 'Pharmacy\POS\PurchaseController@creditors_report')->middleware('auth');


Route::resource('pharmacy_purchase', 'Pharmacy\POS\PurchaseController')->middleware('auth');
Route::resource('pharmacy_purchase_serial','Pharmacy\POS\PurchaseSerialController')->middleware('auth');
Route::get('pharmacy_approve_purchase_serial/{id}', 'Pharmacy\POS\PurchaseSerialController@approve')->name('pharmacy_purchase_serial.approve')->middleware('auth'); 
Route::get('pharmacy_serial_cancel/{id}', 'Pharmacy\POS\PurchaseSerialController@cancel')->name('pharmacy_purchase_serial.cancel')->middleware('auth'); 
Route::get('pharmacy_serial_receive/{id}', 'Pharmacy\POS\PurchaseSerialController@receive')->name('pharmacy_purchase_serial.receive')->middleware('auth'); 
Route::get('pharmacy_serial_make_payment/{id}', 'Pharmacy\POS\PurchaseSerialController@make_payment')->name('pharmacy_purchase_serial.pay')->middleware('auth'); 
Route::get('pharmacy_serial_purchase_pdfview',array('as'=>'pharmacy_serial_purchase_pdfview','uses'=>'Pharmacy\POS\PurchaseSerialController@inv_pdfview'))->middleware('auth');
Route::resource('pharmacy_purchase_serial_payment', 'Pharmacy\POS\PurchaseSerialPaymentController')->middleware('auth');
Route::get('pharmacy_serialModal', 'Pharmacy\POS\PurchaseSerialController@discountModal')->middleware('auth');
Route::get('purchase_list', 'Pharmacy\POS\PurchaseController@purchase_list')->name('pharmacy.purchase_list')->middleware('auth');
Route::post('save_batch', 'Pharmacy\POS\PurchaseController@save_batch')->name('pharmacy.batch')->middleware('auth');
Route::get('serial_list', 'Pharmacy\POS\PurchaseSerialController@list')->name('pharmacy.list')->middleware('auth');
Route::post('save_serial_reference', 'Pharmacy\POS\PurchaseSerialController@save_reference')->name('pharmacy.reference')->middleware('auth');
});




Route::any('retail_activity', 'Retail\POS\PurchaseController@summary'); 

Route::group(['prefix' => 'retail_sales'], function () {

 Route::resource('retail_client', 'Retail\ClientController')->middleware('auth');
 
 


 Route::resource('retail_proforma_invoice', 'Retail\POS\ProfomaInvoiceController')->middleware('auth');
 Route::get('retail_convert_to_invoice/{id}', 'Retail\POS\ProfomaInvoiceController@convert_to_invoice')->name('retail_invoice.convert_to_invoice')->middleware('auth'); 
Route::get('retail_proforma_invoice_pdfview',array('as'=>'retail_proforma_invoice_pdfview','uses'=>'Retail\POS\ProfomaInvoiceController@invoice_pdfview'))->middleware('auth');
Route::resource('retail_invoice', 'Retail\POS\InvoiceController')->middleware('auth');
Route::any('retail_debtors_report', 'Retail\POS\InvoiceController@debtors_report')->middleware('auth');
 Route::get('findBatch', 'Retail\POS\InvoiceController@findBatch')->middleware('auth'); 
 Route::get('retail_findInvPrice', 'Retail\POS\InvoiceController@findPrice')->middleware('auth'); 
Route::get('retail_findQty', 'Retail\POS\InvoiceController@findQty')->middleware('auth'); 
 Route::get('retail_invModal', 'Retail\POS\InvoiceController@discountModal')->middleware('auth');
 Route::get('retail_approve_purchase/{id}', 'Retail\POS\InvoiceController@approve')->name('retail_invoice.approve')->middleware('auth'); 
 Route::get('retail_cancel/{id}', 'Retail\POS\InvoiceController@cancel')->name('retail_invoice.cancel')->middleware('auth'); 
 Route::get('retail_receive/{id}', 'Retail\POS\InvoiceController@receive')->name('retail_invoice.receive')->middleware('auth'); 
 Route::get('retail_make_payment/{id}', 'Retail\POS\InvoiceController@make_payment')->name('retail_pos_invoice.pay')->middleware('auth'); 
 Route::get('retail_pos_invoice_pdfview',array('as'=>'retail_pos_invoice_pdfview','uses'=>'Retail\POS\InvoiceController@invoice_pdfview'))->middleware('auth');
 Route::get('retail_pos_note_pdfview',array('as'=>'retail_pos_note_pdfview','uses'=>'Retail\POS\InvoiceController@note_pdfview'))->middleware('auth');
 Route::get('retail_order_payment/{id}', 'Retail\orders\OrdersController@order_payment')->name('retail_purchase_order.pay')->middleware('auth');
 Route::resource('retail_pos_invoice_payment', 'Retail\POS\InvoicePaymentController')->middleware('auth');
Route::get('download_retail_reference/{id}', 'Retail\POS\InvoiceController@download_reference')->name('retail_invoice.reference')->middleware('auth'); 
Route::get('download_retail_delivery/{id}', 'Retail\POS\InvoiceController@download_delivery')->name('retail_invoice.delivery')->middleware('auth'); 
Route::post('save_delivery','Retail\POS\InvoiceController@save_delivery')->name('retail_save.delivery');

Route::resource('retail_serial_invoice', 'Retail\POS\InvoiceSerialController')->middleware('auth');
 Route::get('retail_serial_findInvPrice', 'Retail\POS\InvoiceSerialController@findPrice')->middleware('auth'); 
 Route::get('retail_serial_invModal', 'Retail\POS\InvoiceSerialController@discountModal')->middleware('auth');
 Route::get('retail_serial_approve_purchase/{id}', 'Retail\POS\InvoiceSerialController@approve')->name('retail_serial_invoice.approve')->middleware('auth'); 
 Route::get('retail_serial_cancel/{id}', 'Retail\POS\InvoiceSerialController@cancel')->name('retail_serial_invoice.cancel')->middleware('auth'); 
 Route::get('retail_serial_receive/{id}', 'Retail\POS\InvoiceSerialController@receive')->name('retail_serial_invoice.receive')->middleware('auth'); 
 Route::get('retail_serial_make_payment/{id}', 'Retail\POS\InvoiceSerialController@make_payment')->name('retail_serial_pos_invoice.pay')->middleware('auth'); 
 Route::get('retail_serial_pos_invoice_pdfview',array('as'=>'retail_serial_pos_invoice_pdfview','uses'=>'Retail\POS\InvoiceSerialController@invoice_pdfview'))->middleware('auth');
 Route::get('retail_serial_pos_note_pdfview',array('as'=>'retail_serial_pos_note_pdfview','uses'=>'Retail\POS\InvoiceSerialController@note_pdfview'))->middleware('auth');
 Route::resource('retail_serial_invoice_payment', 'Retail\POS\InvoiceSerialPaymentController')->middleware('auth');

 Route::resource('retail_credit_note', 'Retail\POS\ReturnInvoiceController')->middleware('auth');
 Route::get('retail_findinvoice', 'Retail\POS\ReturnInvoiceController@findPrice')->middleware('auth'); 
 Route::get('retail_showInvoice', 'Retail\POS\ReturnInvoiceController@showInvoice')->middleware('auth'); 
 Route::get('retail_editshowInvoice', 'Retail\POS\ReturnInvoiceController@editshowInvoice')->middleware('auth'); 
 Route::get('retail_findinvQty', 'Retail\POS\ReturnInvoiceController@findQty')->middleware('auth'); 
Route::get('retail_approve_credit_note/{id}', 'Retail\POS\ReturnInvoiceController@approve')->name('retail_credit_note.approve')->middleware('auth'); 
Route::get('retail_cancel_credit_note/{id}', 'Retail\POS\ReturnInvoiceController@cancel')->name('retail_credit_note.cancel')->middleware('auth'); 
Route::get('retail_receive_credit_note/{id}', 'Retail\POS\ReturnInvoiceController@receive')->name('retail_credit_note.receive')->middleware('auth'); 
Route::get('retail_credit_note_payment/{id}', 'Retail\POS\ReturnInvoiceController@make_payment')->name('retail_credit_note.pay')->middleware('auth'); 
Route::get('retail_credit_note_pdfview',array('as'=>'retail_credit_note_pdfview','uses'=>'Retail\POS\ReturnInvoiceController@credit_note_pdfview'))->middleware('auth');
Route::resource('retail_credit_note_payment', 'Retail\POS\ReturnInvoicePaymentController')->middleware('auth');
 });
 
 
 Route::group(['prefix' => 'retail_purchases'], function () {
     
     
     
Route::resource('retail_supplier', 'Retail\shop\SupplierController')->middleware('auth');
Route::resource('retail_items', 'Retail\POS\ItemsController')->middleware('auth');
Route::post('retail_import','Retail\POS\ImportItemsController@import')->name('retail.import');
   Route::post('retail_sample','Retail\POS\ImportItemsController@sample')->name('retail.sample');
Route::get('addSupplier', 'Retail\POS\PurchaseController@addSupplier')->middleware('auth'); 
Route::get('addCategory', 'Retail\POS\ItemsController@addCategory')->middleware('auth');


Route::get('retail_findInvPrice', 'Retail\POS\PurchaseController@findPrice')->middleware('auth'); 
Route::get('retail_invModal', 'Retail\POS\PurchaseController@discountModal')->middleware('auth');
Route::get('retail_approve_purchase/{id}', 'Retail\POS\PurchaseController@approve')->name('retail_purchase.approve')->middleware('auth'); 
Route::get('retail_cancel/{id}', 'Retail\POS\PurchaseController@cancel')->name('retail_purchase.cancel')->middleware('auth'); 
Route::get('retail_receive/{id}', 'Retail\POS\PurchaseController@receive')->name('retail_purchase.receive')->middleware('auth'); 
Route::get('retail_make_payment/{id}', 'Retail\POS\PurchaseController@make_payment')->name('retail_purchase.pay')->middleware('auth'); 
Route::get('retail_purchase_pdfview',array('as'=>'retail_purchase_pdfview','uses'=>'Retail\POS\PurchaseController@inv_pdfview'))->middleware('auth');
Route::get('retail_order_payment/{id}', 'Retail\orders\OrdersController@order_payment')->name('retail_purchase_order.pay')->middleware('auth');
Route::resource('retail_purchase_payment', 'Retail\POS\PurchasePaymentController')->middleware('auth');
Route::any('retail_creditors_report', 'Retail\POS\PurchaseController@creditors_report')->middleware('auth');


Route::resource('retail_purchase', 'Retail\POS\PurchaseController')->middleware('auth');
Route::resource('retail_purchase_serial','Retail\POS\PurchaseSerialController')->middleware('auth');
Route::get('retail_approve_purchase_serial/{id}', 'Retail\POS\PurchaseSerialController@approve')->name('retail_purchase_serial.approve')->middleware('auth'); 
Route::get('retail_serial_cancel/{id}', 'Retail\POS\PurchaseSerialController@cancel')->name('retail_purchase_serial.cancel')->middleware('auth'); 
Route::get('retail_serial_receive/{id}', 'Retail\POS\PurchaseSerialController@receive')->name('retail_purchase_serial.receive')->middleware('auth'); 
Route::get('retail_serial_make_payment/{id}', 'Retail\POS\PurchaseSerialController@make_payment')->name('retail_purchase_serial.pay')->middleware('auth'); 
Route::get('retail_serial_purchase_pdfview',array('as'=>'retail_serial_purchase_pdfview','uses'=>'Retail\POS\PurchaseSerialController@inv_pdfview'))->middleware('auth');
Route::resource('retail_purchase_serial_payment', 'Retail\POS\PurchaseSerialPaymentController')->middleware('auth');
Route::get('retail_serialModal', 'Retail\POS\PurchaseSerialController@discountModal')->middleware('auth');
Route::get('purchase_list', 'Retail\POS\PurchaseController@purchase_list')->name('retail.purchase_list')->middleware('auth');
Route::post('save_batch', 'Retail\POS\PurchaseController@save_batch')->name('retail.batch')->middleware('auth');
Route::get('serial_list', 'Retail\POS\PurchaseSerialController@list')->name('retail.list')->middleware('auth');
Route::post('save_serial_reference', 'Retail\POS\PurchaseSerialController@save_reference')->name('retail.reference')->middleware('auth');
});



});

Route::resource('retail_location', 'Retail\LocationController')->middleware('auth');


//product
Route::group(['prefix' => 'product'], function () {
Route::get('manage/product','ProductController@index')->middleware('auth');
Route::post('product/save','ProductController@store')->middleware('auth');
Route::post('product/{id}/edit','ProductController@update')->middleware('auth');
Route::get('product/{id}/delete','ProductController@destroy')->middleware('auth');
});

//input order management
Route::group(['prefix' => 'order_management'], function () {
//Route::get('purchase/','PurchaseController@index')->middleware('auth');
Route::post('input/add','PurchaseController@store')->middleware('auth');
Route::get('get',"PurchaseController@create")->middleware('auth');
Route::post('ajax-posts/{id}/edit','PurchaseController@edit')->middleware('auth');
Route::get('order/{id}/{product}/{purchase}/delete','PurchaseController@destroy')->middleware('auth');
Route::post('order/{id}/update','PurchaseController@update')->middleware('auth');
Route::get('purchase/{id}/product','PurchaseController@show')->middleware('auth');
});

//output order managemnet
Route::group(['prefix' => 'output_order'], function () {
Route::post('sales/add','SalesController@store')->middleware('auth');
Route::get('get/sales',"SalesController@create")->middleware('auth');
Route::get('sales/{id}/{product}/{sale}/delete','SalesController@destroy')->middleware('auth');
Route::get('sales/{id}/product','SalesController@show')->middleware('auth');
});

// warehouse management
// Route::group(['prefix' => 'warehouse_management'], function () {
// Route::get('warehouse','WarehouseController@index')->middleware('auth');
// Route::post('warehouse/save','WarehouseController@store')->middleware('auth');
// Route::get('warehouse/{id}/show','WarehouseController@show')->middleware('auth');
// Route::resource('singlewarehouse','Single_warehouseController')->middleware('auth');
// Route::resource('warehouse_backend','warehouse\Warehouse_backendController')->middleware('auth');
// });

// make crops orders
Route::group(['prefix' => 'crop_order'], function () {
Route::resource('crops_order','Client_OrderController')->middleware('auth');
Route::resource('manipulation','Orders_Client_ManipulationsController')->middleware('auth');
});

//  logistic routes
//  logistic-truck routes
Route::group(['prefix' => 'logistic_truck'], function () {
Route::resource('truck', 'Truck\TruckController')->middleware('auth');
Route::get('disable/{id}', 'Truck\TruckController@save_disable')->name('truck.disable')->middleware('auth');
Route::get('connect_trailer', 'Truck\TruckController@connect')->name('truck.connect')->middleware('auth');
Route::get('connectModal', 'Truck\TruckController@discountModal')->middleware('auth');
Route::post('save_connect', 'Truck\TruckController@save_connect')->middleware('auth');
Route::get('disconnect/{id}', 'Truck\TruckController@save_disconnect')->name('truck.disconnect')->middleware('auth');
Route::get('connect_driver', 'Truck\TruckController@connect_driver')->name('truck.driver')->middleware('auth');
Route::post('save_driver', 'Truck\TruckController@save_driver')->middleware('auth');
Route::any('truck_report', 'Truck\TruckController@truck_report')->middleware('auth');
Route::any('truck_summary', 'Truck\TruckController@truck_summary')->middleware('auth');
Route::get('remove_driver/{id}', 'Truck\TruckController@remove_driver')->name('truck.remove')->middleware('auth');
Route::get('truck_sticker/{id}', 'Truck\TruckController@sticker')->name('truck.sticker')->middleware('auth');
Route::get('truck_insurance/{id}', 'Truck\TruckController@insurance')->name('truck.insurance')->middleware('auth');
Route::get('truck_permit/{id}', 'Truck\TruckController@permit')->name('truck.permit')->middleware('auth');
Route::get('truck_comesa/{id}', 'Truck\TruckController@comesa')->name('truck.comesa')->middleware('auth');
Route::get('truck_carbon/{id}', 'Truck\TruckController@carbon')->name('truck.carbon')->middleware('auth');
Route::post('insurance_import','Truck\ImportInsuranceController@import')->name('insurance.import');
Route::post('insurance_sample','Truck\ImportInsuranceController@sample')->name('insurance.sample');
Route::any('truck_fuel_report/{id}', 'Truck\TruckController@fuel')->name('truck.fuel')->middleware('auth');
Route::any('truck_route/{id}', 'Truck\TruckController@route')->name('truck.route')->middleware('auth');
Route::resource('sticker', 'Truck\StickerController')->middleware('auth');
Route::resource('road_permit', 'Truck\RoadPermitController')->middleware('auth');
Route::resource('comesa', 'Truck\ComesaController')->middleware('auth');
Route::resource('carbon', 'Truck\CarbonController')->middleware('auth');
Route::resource('truckinsurance', 'Truck\TruckInsuranceController')->middleware('auth');
Route::post('sticker_import','Truck\ImportStickerController@import')->name('sticker.import');
Route::post('sticker_sample','Truck\ImportStickerController@sample')->name('sticker.sample');
Route::post('road_permit_import','Truck\ImportRoadPermitController@import')->name('road_permit.import');
Route::post('road_permit_sample','Truck\ImportRoadPermitController@sample')->name('road_permit.sample');
Route::post('comesa_import','Truck\ImportComesaController@import')->name('comesa.import');
Route::post('comesa_sample','Truck\ImportComesaController@sample')->name('comesa.sample');
Route::post('carbon_import','Truck\ImportCarbonController@import')->name('carbon.import');
Route::post('carbon_sample','Truck\ImportCarbonController@sample')->name('carbon.sample');
Route::get('sdownload',array('as'=>'sdownload','uses'=>'Truck\StickerControllerr@sdownload'))->middleware('auth');
Route::get('tdownload',array('as'=>'tdownload','uses'=>'ruck\TruckInsuranceController@tdownload'))->middleware('auth');
});

//  logistic-driver routes
Route::group(['prefix' => 'logistic_driver'], function () {
Route::resource('driver', 'Driver\DriverController')->middleware('auth');
Route::get('driver_licence/{id}', 'Driver\DriverController@licence')->name('driver.licence')->middleware('auth');
Route::get('driver_performance/{id}', 'Driver\DriverController@performance')->name('driver.performance')->middleware('auth');
Route::resource('licence', 'Driver\LicenceController')->middleware('auth');
Route::resource('performance', 'Driver\PerformanceController')->middleware('auth');
Route::get('ldownload',array('as'=>'ldownload','uses'=>'Driver\LicenceController@ldownload'))->middleware('auth');
Route::get('pdownload',array('as'=>'pdownload','uses'=>'Driver\PerformanceController@pdownload'))->middleware('auth');
Route::any('driver_fuel_report/{id}', 'Driver\DriverController@fuel')->name('driver.fuel')->middleware('auth');
Route::any('driver_route/{id}', 'Driver\DriverController@route')->name('driver.route')->middleware('auth');
});
// Manufacturing routes
// Route::group(['prefix' => 'manufacturing'], function () {
// Route::resource('manufacturing_location', 'Manufacturing\LocationController')->middleware('auth');
// Route::resource('manufacturing_inventory', 'Manufacturing\InventoryController')->middleware('auth');
// Route::resource('bill_of_material', 'Manufacturing\BillOfMaterialController')->middleware('auth');
// Route::resource('work_order', 'Manufacturing\WorkOrderController')->middleware('auth');
// });


// Manufacturing routes

// Manufacturing routes
// Route::group(['middleware' => ['authorization:manage-manufacturing']], function(){

    Route::group(['prefix' => 'manufacturing'], function () {
    
      Route::resource('good_movement', 'Manufacturing\GoodMovementController')->middleware('auth');

     Route::resource('manufacturing_purchase', 'Manufacturing\PurchaseInventoryController')->middleware('auth');
     Route::resource('product_items', 'Manufacturing\ItemsController')->middleware('auth');

    Route::resource('manufacturing_location', 'Manufacturing\LocationController')->middleware('auth');
    Route::resource('manufacturing_inventory', 'Manufacturing\InventoryController')->middleware('auth');
    Route::resource('bill_of_material', 'Manufacturing\BillOfMaterialController')->middleware('auth');
     Route::get('bill_of_material_inv_pdfview',array('as'=>'bill_of_material_inv_pdfview','uses'=>'Manufacturing\BillOfMaterialController@inv_pdfview'))->middleware('auth');
    Route::resource('work_order', 'Manufacturing\WorkOrderController')->middleware('auth');
    Route::get('workModal', 'Manufacturing\WorkOrderController@discountModal'); 
    Route::resource('screp', 'Manufacturing\ScrepController')->middleware('auth');

    Route::get('findbillProduct', 'Manufacturing\WorkOrderController@findbillProduct')->middleware('auth'); 
    Route::get('work_order_approve/{id}', 'Manufacturing\WorkOrderController@approve')->name('work_order.approve')->middleware('auth'); 
    Route::get('work_order_release/{id}', 'Manufacturing\WorkOrderController@release')->name('work_order.release')->middleware('auth');
    Route::put('work_order_produce/{id}/produce', 'Manufacturing\WorkOrderController@produce')->name('work_order.produce')->middleware('auth');
    Route::get('work_order_finish/{id}', 'Manufacturing\WorkOrderController@finish')->name('work_order.finish')->middleware('auth');
    
    Route::get('manufacturing_approve/{id}', 'Manufacturing\PurchaseInventoryController@approve')->name('manufacturing_inventory.approve')->middleware('auth'); 
Route::get('manufacturing_cancel/{id}', 'Manufacturing\PurchaseInventoryController@cancel')->name('manufacturing_inventory.cancel')->middleware('auth'); 
Route::get('manufacturing_receive/{id}', 'Manufacturing\PurchaseInventoryController@receive')->name('manufacturing_inventory.receive')->middleware('auth'); 
Route::get('manufacturing_make_payment/{id}', 'Manufacturing\PurchaseInventoryController@make_payment')->name('manufacturing_inventory.pay')->middleware('auth'); 
Route::get('manufacturing_inv_pdfview',array('as'=>'manufacturing_inv_pdfview','uses'=>'Manufacturing\PurchaseInventoryController@inv_pdfview'))->middleware('auth');

    Route::any('packing_model/{$id}', 'Manufacturing\BillOfMaterialController@packing_model')->name('packing_model')->middleware('auth');
    

    // Route::resource('manufacturing_location', 'Manufacturing\LocationController')->middleware('auth');
    // Route::resource('manufacturing_inventory', 'Manufacturing\InventoryController')->middleware('auth');
    // Route::resource('bill_of_material', 'Manufacturing\BillOfMaterialController')->middleware('auth');
    // Route::resource('work_order', 'Manufacturing\WorkOrderController')->middleware('auth');
});




// inventory routes
Route::group(['prefix' => 'inventory'], function () {
Route::resource('location', 'Inventory\LocationController')->middleware('auth');
Route::resource('inventory', 'Inventory\InventoryController')->middleware('auth');
Route::resource('fieldstaff', 'Inventory\FieldStaffController')->middleware('auth');
Route::resource('requisition', 'Inventory\RequisitionController')->middleware('auth');
Route::resource('purchase_inventory', 'Inventory\PurchaseInventoryController')->middleware('auth');
Route::get('findInvPrice', 'Inventory\PurchaseInventoryController@findPrice')->middleware('auth'); 
Route::get('invModal', 'Inventory\PurchaseInventoryController@discountModal')->middleware('auth');
Route::get('approve/{id}', 'Inventory\PurchaseInventoryController@approve')->name('inventory.approve')->middleware('auth'); 
Route::get('cancel/{id}', 'Inventory\PurchaseInventoryController@cancel')->name('inventory.cancel')->middleware('auth'); 
Route::get('receive/{id}', 'Inventory\PurchaseInventoryController@receive')->name('inventory.receive')->middleware('auth'); 
Route::get('make_payment/{id}', 'Inventory\PurchaseInventoryController@make_payment')->name('inventory.pay')->middleware('auth'); 
Route::get('inv_pdfview',array('as'=>'inv_pdfview','uses'=>'Inventory\PurchaseInventoryController@inv_pdfview'))->middleware('auth');
Route::get('order_payment/{id}', 'orders\OrdersController@order_payment')->name('order.pay')->middleware('auth');
Route::get('inventory_list', 'Inventory\PurchaseInventoryController@inventory_list')->name('inventory.list')->middleware('auth');
Route::post('save_inv_reference', 'Inventory\PurchaseInventoryController@save_reference')->name('reference_inv.save')->middleware('auth');
Route::resource('inventory_payment', 'Inventory\InventoryPaymentController')->middleware('auth');
Route::resource('order_payment', 'orders\OrderPaymentController')->middleware('auth');
Route::resource('maintainance', 'Inventory\MaintainanceController')->middleware('auth');
Route::post('save_mechanical_report', 'Inventory\MaintainanceController@save_report')->name('maintainance.report')->middleware('auth');
Route::get('change_m_status/{id}', 'Inventory\MaintainanceController@approve')->name('maintainance.approve')->middleware('auth'); 
Route::resource('service', 'Inventory\ServiceController')->middleware('auth');
Route::resource('service_type', 'Inventory\ServiceTypeController')->middleware('auth');
Route::get('change_s_status/{id}', 'Inventory\ServiceController@approve')->name('service.approve')->middleware('auth');
Route::resource('good_issue', 'Inventory\GoodIssueController')->middleware('auth');
Route::get('findIssueService', 'Inventory\GoodIssueController@findService')->middleware('auth');
Route::get('issue_approve/{id}', 'Inventory\GoodIssueController@approve')->name('issue.approve')->middleware('auth'); 
Route::resource('good_return', 'Inventory\GoodReturnController')->middleware('auth');
Route::get('return_approve/{id}', 'Inventory\GoodReturnController@approve')->name('return.approve')->middleware('auth');
Route::resource('good_movement', 'Inventory\GoodMovementController')->middleware('auth');
Route::get('good_movement_approve/{id}', 'Inventory\GoodMovementController@approve')->name('good_movement.approve')->middleware('auth'); 

Route::get('movement_approve/{id}', 'Inventory\GoodReturnController@approve')->name('movement.approve')->middleware('auth'); 
Route::resource('good_reallocation', 'Inventory\GoodReallocationController')->middleware('auth');
Route::get('reallocation_approve/{id}', 'Inventory\GoodReallocationController@approve')->name('reallocation.approve')->middleware('auth'); 
Route::resource('good_disposal', 'Inventory\GoodDisposalController')->middleware('auth');
Route::get('disposal_approve/{id}', 'Inventory\GoodDisposalController@approve')->name('disposal.approve')->middleware('auth'); 
Route::get('findReturnService', 'Inventory\GoodReturnController@findService')->middleware('auth');
});

// cotton routes
Route::group(['prefix' => 'cotton_production'], function () {
Route::resource('costants', 'Cotton\CostantsController')->middleware('auth');
Route::resource('production', 'Cotton\ProductionController')->middleware('auth');
});

Route::group(['prefix' => 'cotton_invoice'], function () {
Route::resource('cotton_sales', 'Cotton\InvoiceController')->middleware('auth');
Route::resource('seed_list', 'Cotton\SeedListController')->middleware('auth');
Route::resource('seed_sales', 'Cotton\SeedInvoiceController')->middleware('auth');
});

Route::group(['prefix' => 'report'], function () {
Route::any('stock_report', 'Cotton\CollectionCenterController@stock_report')->middleware('auth');
Route::any('invoice_report', 'Cotton\ReportController@invoice_report')->middleware('auth');
Route::any('center_report', 'Cotton\CollectionCenterController@center_report')->middleware('auth');
Route::any('cotton_movement_report', 'Cotton\CollectionCenterController@cotton_movement_report')->middleware('auth');
Route::any('levy_report', 'Cotton\ReportController@levy_report')->middleware('auth');
//Route::any('debtors_report', 'Cotton\ReportController@debtors_report')->middleware('auth');
Route::any('general_report', 'Cotton\ReportController@general_report')->middleware('auth');
Route::any('general_report2', 'Cotton\ReportController@general_report2')->middleware('auth');
});


// Route::group(['prefix' => 'cotton_collection'], function () {
// Route::get('production_pdfview',array('as'=>'production_pdfview','uses'=>'Cotton\ProductionController@inv_pdfview'))->middleware('auth');
// Route::resource('operator', 'Cotton\OperatorController')->middleware('auth');
// Route::resource('collection_center', 'Cotton\CollectionCenterController')->middleware('auth');
// Route::resource('district', 'Cotton\DistrictController')->middleware('auth');
// Route::get('findCenterDistrict', 'Cotton\CollectionCenterController@findRegion')->middleware('auth');
// Route::get('findCenterRegion', 'Cotton\CollectionCenterController@findDistrict')->middleware('auth');
// Route::get('centerModal', 'Cotton\CollectionCenterController@discountModal')->middleware('auth');
// Route::get('addOperator', 'Cotton\CollectionCenterController@addOperator')->middleware('auth');
// Route::get('addLicence', 'Cotton\CollectionCenterController@addLicence')->middleware('auth');
// Route::resource('top_up_operator', 'Cotton\TopUpOperatorController')->middleware('auth');
// Route::get('complete_operator', 'Cotton\TopUpOperatorController@complete_operator')->middleware('auth');
// Route::get('complete_center', 'Cotton\TopUpCenterController@complete_center')->middleware('auth');
// Route::get('top_up_operator_approve/{id}', 'Cotton\TopUpOperatorController@approve')->name('operator.approve')->middleware('auth');
// Route::get('findOperator', 'Cotton\TopUpOperatorController@findOperator')->middleware('auth');
// Route::get('findCenter', 'Cotton\TopUpCenterController@findCenter')->middleware('auth');
// Route::get('findCenterName', 'Cotton\TopUpCenterController@findCenterName')->middleware('auth');
// Route::resource('top_up_center', 'Cotton\TopUpCenterController')->middleware('auth');
// Route::get('top_up_center_approve/{id}', 'Cotton\TopUpCenterController@approve')->name('center.approve')->middleware('auth');
// Route::resource('cotton_list', 'Cotton\CottonController')->middleware('auth');
// Route::resource('levy_list', 'Cotton\LevyController')->middleware('auth');
// Route::resource('purchase_cotton', 'Cotton\PurchaseCottonController')->middleware('auth');
// Route::get('findStock', 'Cotton\PurchaseCottonController@findStock')->middleware('auth'); 
// Route::get('findCottonPrice', 'Cotton\PurchaseCottonController@findPrice')->middleware('auth'); 
// Route::get('cotton_approve/{id}', 'Cotton\PurchaseCottonController@approve')->name('cotton.approve')->middleware('auth'); 
// Route::get('cotton_cancel/{id}', 'Cotton\PurchaseCottonController@cancel')->name('cotton.cancel')->middleware('auth'); 
// Route::get('cotton_receive/{id}', 'Cotton\PurchaseCottonController@receive')->name('cotton.receive')->middleware('auth'); ; 
// Route::get('cotton_pdfview',array('as'=>'cotton_pdfview','uses'=>'Cotton\PurchaseCottonController@inv_pdfview'))->middleware('auth');
// Route::resource('cotton_movement', 'Cotton\GoodMovementController')->middleware('auth');
// Route::get('cotton_movement_approve/{id}', 'Cotton\GoodMovementController@approve')->name('movement.approve')->middleware('auth'); 
// Route::get('cotton_check_balance', 'Cotton\GoodMovementController@chekBalance')->name('movement.chekBalance')->middleware('auth'); 
// Route::get('findQuantity', 'Cotton\GoodMovementController@findQuantity')->middleware('auth'); 
// Route::get('findPurchase', 'Cotton\GoodMovementController@findPurchase')->middleware('auth'); 
// Route::get('itemsModal', 'Cotton\GoodMovementController@discountModal')->middleware('auth');
// Route::get('reverseCenterModal', 'Cotton\TopUpCenterController@discountModal')->middleware('auth');
// Route::post('newreverseCenter', 'Cotton\TopUpCenterController@newdiscount')->middleware('auth');
// Route::get('center_complete/{id}', 'Cotton\TopUpCenterController@complete')->name('center.complete')->middleware('auth'); 
// Route::get('reverse_top_up_center', 'Cotton\TopUpCenterController@reverse_top_center')->middleware('auth'); 
// Route::get('reverseOperatorModal', 'Cotton\TopUpOperatorController@discountModal')->middleware('auth');
// Route::post('newreverseOperator', 'Cotton\TopUpOperatorController@newdiscount')->middleware('auth');
// Route::get('operator_complete/{id}', 'Cotton\TopUpOperatorController@complete')->name('operator.complete')->middleware('auth'); 
// Route::get('reverse_top_up_operator', 'Cotton\TopUpOperatorController@reverse_top_operator')->middleware('auth'); 


// Route::resource('general_report_table', 'Cotton\ReportController')->middleware('auth');
// Route::resource('cotton_client', 'Cotton\CottonClientController')->middleware('auth');

// Route::get('findSalesPrice', 'Cotton\InvoiceController@findPrice')->middleware('auth'); 
// Route::get('cotton_payment/{id}', 'Cotton\InvoiceController@make_payment')->name('invoice.pay')->middleware('auth'); 
// Route::get('sales_pdfview',array('as'=>'sales_pdfview','uses'=>'Cotton\InvoiceController@sales_pdfview'))->middleware('auth');
// Route::resource('cotton_sales_payment', 'Cotton\InvoicePaymentController')->middleware('auth');

// Route::get('findSeedPrice', 'Cotton\SeedInvoiceController@findPrice')->middleware('auth'); 
// Route::get('seed_payment/{id}', 'Cotton\SeedInvoiceController@make_payment')->name('seed.pay')->middleware('auth'); 
// Route::get('seed_pdfview',array('as'=>'seed_pdfview','uses'=>'Cotton\SeedInvoiceController@seed_pdfview'))->middleware('auth');
// Route::resource('seed_sales_payment', 'Cotton\SeedPaymentController')->middleware('auth');
// Route::resource('assign_driver', 'Cotton\AssignDriverController')->middleware('auth');
// Route::get('assign_driver_approve/{id}', 'Cotton\AssignDriverController@approve')->name('assign_driver.approve')->middleware('auth'); 
// Route::post('newreverseDriver', 'Cotton\AssignDriverController@newdiscount')->middleware('auth');
// Route::get('reverse_assign_driver', 'Cotton\AssignDriverController@reverse_assign_driver')->middleware('auth'); 
// Route::resource('assign_center', 'Cotton\AssignCenterController')->middleware('auth');
// Route::get('assign_center_approve/{id}', 'Cotton\AssignCenterController@approve')->name('assign_center.approve')->middleware('auth'); 
// Route::post('newreverseAssignCenter', 'Cotton\AssignCenterController@newdiscount')->middleware('auth');
// Route::get('reverse_assign_center', 'Cotton\AssignCenterController@reverse_assign_center')->middleware('auth'); 
// });

//tracking
Route::group(['prefix' => 'tracking'], function () {
Route::get('collection', 'Activity\OrderMovementController@collection')->name('order.collection')->middleware('auth');
Route::get('loading', 'Activity\OrderMovementController@loading')->name('order.loading')->middleware('auth');
Route::get('offloading', 'Activity\OrderMovementController@offloading')->name('order.offloading')->middleware('auth');
Route::get('delivering', 'Activity\OrderMovementController@delivering')->name('order.delivering')->middleware('auth');
Route::get('wb', 'Activity\OrderMovementController@wb')->name('order.wb')->middleware('auth');
Route::post('save_wb', 'Activity\OrderMovementController@save_wb')->name('save.wb')->middleware('auth');
Route::resource('order_movement', 'Activity\OrderMovementController')->middleware('auth');
Route::get('findTruck', 'Activity\OrderMovementController@findTruck')->middleware('auth');  
Route::get('findDriver', 'Activity\OrderMovementController@findDriver')->middleware('auth');  
Route::resource('activity', 'Activity\ActivityController')->middleware('auth');
Route::get('order_report', 'Activity\OrderMovementController@report')->name('order.report')->middleware('auth');
Route::get('findReport', 'Activity\OrderMovementController@findReport')->middleware('auth');
Route::get('findExp', 'Activity\OrderMovementController@findPrice')->middleware('auth');  
Route::get('truck_mileage', 'Activity\OrderMovementController@return')->name('order.return')->middleware('auth');
});


Route::group(['prefix' => 'fuel'], function () {
Route::get('findFromRegion', 'RouteController@findFromRegion')->middleware('auth');  
Route::get('findToRegion', 'RouteController@findToRegion')->middleware('auth'); 
});

//fuel
Route::resource('fuel', 'Fuel\FuelController')->middleware('auth');
Route::get('return_fuel', 'Fuel\FuelController@return_fuel')->name('fuel.return')->middleware('auth');
Route::any('fuel_report', 'Fuel\FuelController@fuel_report')->name('fuel.report')->middleware('auth');
Route::resource('refill_payment', 'Fuel\RefillPaymentController')->middleware('auth');
Route::get('refill_list', 'Fuel\FuelController@refill_list')->name('refill_list')->middleware('auth'); ;
Route::get('multiple_refill_payment', 'Fuel\RefillPaymentController@multiple_refill_payment')->name('multiple_refill_list')->middleware('auth');
Route::post('save_multiple_payment', 'Fuel\RefillPaymentController@save_multiple_payment')->name('save_multiple_refill')->middleware('auth');
Route::get('fuel_approve/{id}', 'Fuel\FuelController@approve')->name('fuel.approve')->middleware('auth');
Route::get('discountModal', 'Fuel\FuelController@discountModal')->middleware('auth');
Route::get('addRoute', 'Fuel\FuelController@route')->middleware('auth');


Route::resource('routes', 'RouteController')->middleware('auth');
Route::get('addLocation', 'RouteController@addlocation')->middleware('auth');
Route::get('findLocation', 'RouteController@findlocation')->middleware('auth');
Route::get('locationModal', 'RouteController@discountModal')->middleware('auth');
Route::get('routes_delete/{id}', 'RouteController@delete')->name('routes.delete')->middleware('auth');




//leave
Route::group(['prefix' => 'leave'], function () {
Route::resource('leave', 'Leave\LeaveController')->middleware('auth');
Route::post('addCategory', 'Leave\LeaveController@category')->middleware('auth');
Route::get('leave_approve/{id}', 'Leave\LeaveController@approve')->name('leave.approve')->middleware('auth');
Route::get('leave_reject/{id}', 'Leave\LeaveController@reject')->name('leave.reject')->middleware('auth');
});

//training
Route::group(['prefix' => 'training'], function () {
Route::resource('training', 'Training\TrainingController')->middleware('auth');
Route::get('training_start/{id}', 'Training\TrainingController@start')->name('training.start')->middleware('auth');
Route::get('training_approve/{id}', 'Training\TrainingController@approve')->name('training.approve')->middleware('auth');
Route::get('training_reject/{id}', 'Training\TrainingController@reject')->name('training.reject')->middleware('auth');
});

// tyre routes
Route::group(['prefix' => 'tyre'], function () {
Route::resource('tyre_brand', 'Tyre\TyreBrandController')->middleware('auth');
Route::get('tyre_list', 'Tyre\PurchaseTyreController@tyre_list')->name('tyre.list')->middleware('auth');
Route::resource('purchase_tyre', 'Tyre\PurchaseTyreController')->middleware('auth');
Route::get('findTyrePrice', 'Tyre\PurchaseTyreController@findPrice')->middleware('auth'); 
Route::get('tyre_approve/{id}', 'Tyre\PurchaseTyreController@approve')->name('purchase_tyre.approve')->middleware('auth'); 
Route::get('tyre_cancel/{id}', 'Tyre\PurchaseTyreController@cancel')->name('purchase_tyre.cancel')->middleware('auth'); 
Route::get('tyre_receive/{id}', 'Tyre\PurchaseTyreController@receive')->name('purchase_tyre.receive')->middleware('auth'); 
Route::get('make_tyre_payment/{id}', 'Tyre\PurchaseTyreController@make_payment')->name('purchase_tyre.pay')->middleware('auth'); 
Route::get('tyre_pdfview',array('as'=>'tyre_pdfview','uses'=>'Tyre\PurchaseTyreController@tyre_pdfview'))->middleware('auth');
Route::resource('tyre_payment', 'Tyre\TyrePaymentController')->middleware('auth');
Route::get('assign_truck', 'Tyre\PurchaseTyreController@assign_truck')->name('purchase_tyre.assign')->middleware('auth');
Route::get('tyreModal', 'Tyre\PurchaseTyreController@discountModal')->middleware('auth');
Route::post('save_reference', 'Tyre\PurchaseTyreController@save_reference')->name('reference_tyre.save')->middleware('auth');
Route::post('save_truck', 'Tyre\PurchaseTyreController@save_truck')->name('purchase_tyre.save')->middleware('auth');
Route::resource('tyre_reallocation', 'Tyre\TyreReallocationController')->middleware('auth');
Route::get('tyre_reallocation_approve/{id}', 'Tyre\TyreReallocationController@approve')->name('tyre_reallocation.approve')->middleware('auth'); 
Route::resource('tyre_disposal', 'Tyre\TyreDisposalController')->middleware('auth');
Route::get('tyre_disposal_approve/{id}', 'Tyre\TyreDisposalController@approve')->name('tyre_disposal.approve')->middleware('auth'); 
Route::resource('tyre_return', 'Tyre\TyreReturnController')->middleware('auth');
Route::get('findTyreDetails', 'Tyre\TyreReturnController@findPrice')->middleware('auth'); 
Route::get('tyre_return_approve/{id}', 'Tyre\TyreReturnController@approve')->name('tyre_return.approve')->middleware('auth'); 
Route::get('addSupp', 'Tyre\PurchaseTyreController@addSupp')->middleware('auth');

});
//pacel
Route::group(['prefix' => 'pacel'], function () {
Route::resource('pacel_list', 'Pacel\PacelListController')->middleware('auth');
Route::resource('client', 'ClientController')->middleware('auth');
Route::resource('pacel_quotation', 'Pacel\PacelController')->middleware('auth');

Route::get('pacel_disable/{id}', 'Pacel\PacelController@disable')->name('pacel.disable')->middleware('auth'); 
Route::get('pacel_invoice', 'Pacel\PacelController@invoice')->name('pacel.invoice')->middleware('auth');
Route::get('invoice_details/{id}', 'Pacel\PacelController@details')->name('invoice.details')->middleware('auth'); 
Route::get('invoice_pdfview',array('as'=>'invoice_pdfview','uses'=>'Pacel\PacelController@invoice_pdfview'))->middleware('auth');
Route::get('findPacelPrice', 'Pacel\PacelController@findPrice')->middleware('auth'); 
Route::get('pacel_approve/{id}', 'Pacel\PacelController@approve')->name('pacel.approve')->middleware('auth'); 
Route::get('pacel_cancel/{id}', 'Pacel\PacelController@cancel')->name('pacel.cancel')->middleware('auth');  
Route::get('make_pacel_payment/{id}', 'Pacel\PacelController@make_payment')->name('pacel.pay')->middleware('auth'); 
Route::get('pacel_pdfview',array('as'=>'pacel_pdfview','uses'=>'Pacel\PacelController@pacel_pdfview'))->middleware('auth');
Route::resource('pacel_payment', 'Pacel\PacelPaymentController')->middleware('auth');
Route::get('pacelModal', 'Pacel\PacelController@discountModal')->middleware('auth');
Route::post('newdiscount', 'Pacel\PacelController@newdiscount')->middleware('auth');
Route::get('addSupplier', 'Pacel\PacelController@addSupplier')->middleware('auth');
//Route::get('addRoute', 'Pacel\PacelController@addRoute')->middleware('auth');
Route::resource('mileage_payment', 'MileagePaymentController')->middleware('auth');
Route::get('mileage', 'MileagePaymentController@mileage')->name('mileage')->middleware('auth'); ;
Route::get('mileageModal', 'MileagePaymentController@discountModal')->middleware('auth');
Route::get('mileage_approve/{id}', 'MileagePaymentController@approve')->name('mileage.approve')->middleware('auth');
});


Route::resource('permit_payment', 'Permit\PermitPaymentController')->middleware('auth');
Route::get('permit', 'Permit\PermitPaymentController@permit')->name('permit')->middleware('auth'); ;
Route::get('permitModal', 'Permit\PermitPaymentController@discountModal')->middleware('auth');
Route::get('permit_approve/{id}', 'Permit\PermitPaymentController@approve')->name('permit.approve')->middleware('auth');

//courier

Route::group(['prefix' => 'courier'], function () {
Route::resource('courier_list', 'Courier\CourierListController')->middleware('auth');
Route::resource('courier_client', 'Courier\CourierClientController')->middleware('auth');
Route::resource('zones', 'ZoneController')->middleware('auth');
Route::resource('tariff', 'TariffController')->middleware('auth');
Route::post('tariff_import','TariffController@import')->name('tariff.import');
Route::post('tariff_sample','TariffController@sample')->name('tariff.sample');
Route::resource('courier_pickup', 'Courier\CourierPickupController')->middleware('auth');
Route::get('courier_pickup_approve/{id}', 'Courier\CourierPickupController@approve')->name('courier_pickup.approve')->middleware('auth'); 
Route::resource('courier_quotation', 'Courier\CourierController')->middleware('auth');
Route::get('courier_settings', 'Courier\CourierController@settings')->name('courier.settings')->middleware('auth'); 
Route::post('courier_save_settings', 'Courier\CourierController@add_settings')->name('courier.save_settings');

Route::post('assignCourier', 'Courier\CourierController@assign')->name('courier.assign');
Route::post('addwbn', 'Courier\CourierController@save_wbn')->name('courier.save_wbn');
Route::post('assign_wbn', 'Courier\CourierController@assign_wbn')->name('courier.assign_wbn');
Route::get('add_trip/{id}', 'Courier\CourierController@add_trip')->name('courier.add_trip')->middleware('auth'); 
Route::get('close_trip/{id}', 'Courier\CourierController@close_trip')->name('courier.close_trip')->middleware('auth'); 
Route::delete('delete_parent/{id}', 'Courier\CourierController@delete_parent')->name('courier_quotation.delete_parent')->middleware('auth'); 
Route::resource('courier', 'Courier\NewCourierController')->middleware('auth');
Route::get('addSales', 'Courier\NewCourierController@addSales');
Route::get('addPickup', 'Courier\NewCourierController@addPickup');
Route::get('addFreight', 'Courier\NewCourierController@addFreight');
Route::get('addCommission', 'Courier\NewCourierController@addCommission');
Route::post('addDelivery', 'Courier\NewCourierController@addDelivery')->name('add.delivery')->middleware('auth');
Route::post('addNewSales', 'Courier\NewCourierController@addNewSales')->name('add.sales')->middleware('auth');
Route::get('new_courier_report', 'Courier\NewCourierController@report')->middleware('auth');
Route::get('findNewCourierReport', 'Courier\NewCourierController@findReport')->middleware('auth');
Route::resource('storage_settings', 'Courier\StorageController')->middleware('auth');
Route::get('courier_invoice', 'Courier\CourierController@invoice')->name('courier.invoice')->middleware('auth');
Route::get('courier_invoice_details/{id}', 'Courier\CourierController@details')->name('courier.details')->middleware('auth'); 
Route::get('courier_edit_invoice/{id}', 'Courier\CourierController@edit_invoice')->name('courier_edit.invoice')->middleware('auth'); 
Route::post('courier_save_invoice', 'Courier\CourierController@save_invoice')->name('courier_save.invoice')->middleware('auth');
Route::get('courier_approve/{id}', 'Courier\CourierController@approve')->name('courier.approve')->middleware('auth');
Route::post('courier_reverse', 'Courier\CourierController@reverse')->name('courier.reverse')->middleware('auth');
Route::get('courier_receive/{id}', 'Courier\CourierController@receive')->name('courier.receive')->middleware('auth'); 
Route::post('save_courier_receive', 'Courier\CourierController@save_receive')->name('courier.save_receive')->middleware('auth');
Route::get('courier_start/{id}', 'Courier\CourierController@start')->name('courier.start')->middleware('auth'); 
Route::post('save_courier_start', 'Courier\CourierController@save_start')->name('courier.save_start')->middleware('auth');
Route::get('edit_formula/{id}', 'Courier\CourierController@edit_formula')->name('courier.formula')->middleware('auth'); 
Route::get('findCourierPrice', 'Courier\CourierController@findPrice')->middleware('auth'); 
Route::get('findTariff', 'Courier\CourierController@findTariff')->middleware('auth'); 
Route::get('findTariff2', 'Courier\CourierController@findTariff2')->middleware('auth'); 
Route::get('courier_approve/{id}', 'Courier\CourierController@approve')->name('courier.approve')->middleware('auth'); 
Route::get('courier_cancel/{id}', 'Courier\CourierController@cancel')->name('courier.cancel')->middleware('auth');  
Route::get('make_courier_payment/{id}', 'Courier\CourierController@make_payment')->name('courier.pay')->middleware('auth'); 
Route::get('courier_pdfview',array('as'=>'courier_pdfview','uses'=>'Courier\CourierController@courier_pdfview'))->middleware('auth');
Route::get('courier_invoice_pdfview',array('as'=>'courier_invoice_pdfview','uses'=>'Courier\CourierController@courier_invoice_pdfview'))->middleware('auth');
Route::resource('courier_payment', 'Courier\CourierPaymentController')->middleware('auth');
Route::get('courierModal', 'Courier\CourierController@discountModal')->middleware('auth');
Route::post('newCourierDiscount', 'Courier\CourierController@newdiscount')->middleware('auth');
Route::get('addCourierSupplier', 'Courier\CourierController@addSupplier')->middleware('auth');
Route::get('addCourierRoute', 'Courier\CourierController@addRoute')->middleware('auth');

Route::get('courier_collection', 'Courier\CourierMovementController@collection')->name('courier.collection')->middleware('auth');
Route::get('courier_loading', 'Courier\CourierMovementController@loading')->name('courier.loading')->middleware('auth');
Route::post('save_freight', 'Courier\CourierMovementController@save_freight')->name('save.freight')->middleware('auth');
Route::get('courier_offloading', 'Courier\CourierMovementController@offloading')->name('courier.offloading')->middleware('auth');
Route::get('courier_delivering', 'Courier\CourierMovementController@delivering')->name('courier.delivering')->middleware('auth');
Route::get('courier_delivered', 'Courier\CourierMovementController@delivered')->name('courier.delivered')->middleware('auth');
Route::get('courier_wb', 'Courier\CourierMovementController@wb')->name('wb.courier')->middleware('auth');
Route::post('save_courier_wb', 'Courier\CourierMovementController@save_wb')->name('courier.wb')->middleware('auth');
Route::get('freight_list', 'Courier\CourierMovementController@freight_list')->name('courier.freight')->middleware('auth');
Route::resource('courier_movement', 'Courier\CourierMovementController')->middleware('auth'); 
Route::resource('courier_activity', 'Courier\CourierActivityController')->middleware('auth');
Route::get('courier_report', 'Courier\CourierMovementController@report')->name('courier.report')->middleware('auth');
Route::any('cost_report', 'Courier\CourierMovementController@cost_report')->name('courier.cost_report')->middleware('auth');
Route::any('courier_tracking', 'Courier\CourierMovementController@courier_tracking')->name('courier.tracking')->middleware('auth');
Route::get('findCourierReport', 'Courier\CourierMovementController@findReport')->middleware('auth');

Route::get('payment_list', 'Courier\CourierController@payment_list')->name('courier.payment_list')->middleware('auth'); ;
Route::get('courier_cost_payment/{id}', 'Courier\CourierController@cost_payment')->name('courier_cost.pay')->middleware('auth'); 
Route::post('save_payment', 'Courier\CourierController@save_payment')->name('courier.save_payment')->middleware('auth');
Route::get('multiple_payment', 'Courier\CourierController@multiple_payment')->name('courier.multiple_payment_list')->middleware('auth');
Route::post('save_multiple_payment', 'Courier\CourierController@save_multiple_payment')->name('courier.save_multiple_payment')->middleware('auth');

Route::resource('courier_profoma_invoice', 'Courier\ProfomaInvoiceController')->middleware('auth');
 Route::get('courier_profoma_pdfview',array('as'=>'courier_profoma_pdfview','uses'=>'Courier\ProfomaInvoiceController@invoice_pdfview'))->middleware('auth');



});
//courier tracking
// Route::group(['prefix' => 'courier_tracking'], function () {



// });

//school management
Route::group(['prefix' => 'school'], function () {
Route::resource('student', 'School\StudentController')->middleware('auth');
Route::post('disable', 'School\StudentController@disable')->name('student.disable')->middleware('auth');
Route::get('findLevel', 'School\StudentController@findLevel')->middleware('auth');  
Route::any('invoice_general','School\StudentController@general')->name('student.general')->middleware('auth');
Route::any('fees_collection','School\StudentController@payment')->name('student.payment')->middleware('auth');
Route::get('autocomplete','School\StudentController@autocomplete')->name('student.db_payment')->middleware('auth');
Route::get('fees_collection/{id}/action','School\StudentController@action')->name('student.action')->middleware('auth');
Route::post('store_discount', 'School\StudentController@store_discount')->name('student.store_discount')->middleware('auth');
Route::post('store_payment','School\StudentController@store_payment')->name('student.store_payment')->middleware('auth');
Route::get('findStudent', 'School\StudentController@findStudent')->middleware('auth');
Route::get('findFeeAmount', 'School\StudentController@findAmount')->middleware('auth');
Route::get('findFeeDiscount', 'School\StudentController@findDiscount')->middleware('auth');
Route::post('generate_invoice','School\StudentController@generate')->name('student.generate')->middleware('auth');
Route::any('fees_collection_list','School\StudentController@list')->name('student.list')->middleware('auth');
Route::get('fees_collection_list/{student_payment_id}/fee_payment','School\StudentController@fee_payment')->name('student.fee_payment')->middleware('auth');
Route::get('invoice_general/{id}/invoice','School\StudentController@invoice')->name('student.invoice')->middleware('auth');
Route::resource('school', 'School\SchoolController')->middleware('auth');
Route::post('import-student','School\StudentImportController@import')->name('student.import');
Route::post('student-sample','School\StudentImportController@sample')->name('student.sample');
Route::post('student-payments-import','School\StudentController@import')->name('student_payments.import');
Route::post('student-payments-sample','School\StudentController@sample')->name('student_payments.sample');
Route::get('import_payments', 'School\StudentController@import_payments')->middleware('auth');
});

//GL SETUP

Route::group(['prefix' => 'gl_setup'], function () {
Route::resource('class_account', 'ClassAccountController')->middleware('auth');
Route::resource('group_account', 'GroupAccountController')->middleware('auth');
Route::resource('account_codes', 'AccountCodesController')->middleware('auth');
//Route::resource('system', 'SystemController')->middleware('auth');
Route::resource('chart_of_account', 'ChartOfAccountController')->middleware('auth');
Route::resource('expenses', 'ExpensesController')->middleware('auth');
Route::get('findSupplier', 'ExpensesController@findClient')->middleware('auth'); 
Route::get('expenses_approve/{id}', 'ExpensesController@approve')->name('expenses.approve')->middleware('auth');
Route::get('expenses_delete/{id}', 'ExpensesController@delete_list')->name('expenses.delete')->middleware('auth');
  Route::post('multiple_approve', 'ExpensesController@multiple_approve')->name('multiple_expenses.approve')->middleware('auth');
Route::post('import-expenses','ExpensesController@import')->name('expenses.import');
Route::post('expenses-sample','ExpensesController@sample')->name('expenses.sample');
Route::resource('deposit', 'DepositController')->middleware('auth');
Route::get('findClient', 'DepositController@findClient')->middleware('auth'); 
Route::get('deposit_approve/{id}', 'DepositController@approve')->name('deposit.approve')->middleware('auth');
Route::get('findInvoice', 'DepositController@findInvoice')->middleware('auth'); 
Route::resource('account', 'AccountController')->middleware('auth');
Route::resource('transfer', 'TransferController')->middleware('auth');
Route::resource('transfer2', 'TransferController')->middleware('auth');
Route::get('transfer_approve/{id}', 'TransferController@approve')->name('transfer.approve')->middleware('auth');
Route::get('transfer_approve2/{id}', 'TransferController@approve')->name('transfer2.approve')->middleware('auth');
});
//route for reports
Route::group(['prefix' => 'accounting'], function () {

    Route::any('trial_balance', 'AccountingController@trial_balance')->middleware('auth');
    Route::any('ledger', 'AccountingController@ledger')->middleware('auth');
    Route::any('journal', 'AccountingController@journal')->middleware('auth');
    Route::get('manual_entry', 'AccountingController@create_manual_entry')->middleware('auth');
    Route::post('manual_entry/store', 'AccountingController@store_manual_entry')->middleware('auth');
    Route::any('bank_statement', 'AccountingController@bank_statement')->middleware('auth');
    Route::any('bank_reconciliation', 'AccountingController@bank_reconciliation')->name('reconciliation.view')->middleware('auth');
    Route::any('reconciliation_report', 'AccountingController@reconciliation_report')->name('reconciliation.report')->middleware('auth');;
    Route::post('save_reconcile', 'AccountingController@save_reconcile')->name('reconcile.save')->middleware('auth');
});


//route for payroll
Route::group(['prefix' => 'payroll'], function () {

    Route::resource('salary_template', 'Payroll\SalaryTemplateController')->middleware('auth');
    Route::any('manage_salary','Payroll\ManageSalaryController@getDetails')->middleware('auth');
Route::get('addTemplate', 'Payroll\ManageSalaryController@addTemplate')->middleware('auth');
  Route::get('manage_salary_edit/{id}','Payroll\ManageSalaryController@edit')->name('employee.edit')->middleware('auth');;;;
  Route::delete('manage_salary_delete/{id}','Payroll\ManageSalaryController@destroy')->name('employee.destroy')->middleware('auth');;;;
    Route::get('employee_salary_list','Payroll\ManageSalaryController@salary_list')->name('employee.salary')->middleware('auth');;;
    Route::resource('make_payment', 'Payroll\MakePaymentsController')->middleware('auth');   
  Route::get('make_payment/{user_id}/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@getPayment')->name('payment')->middleware('auth'); 
Route::get('edit_make_payment/{user_id}/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@editPayment')->name('payment.edit')->middleware('auth'); 
  Route::post('save_payment','Payroll\MakePaymentsController@save_payment')->name('save_payment')->middleware('auth');;;;
  Route::post('edit_payment','Payroll\MakePaymentsController@edit_payment')->name('edit_payment')->middleware('auth');;;;
  Route::get('make_payment/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@viewPayment')->name('view.payment')->middleware('auth'); 
Route::resource('multiple_payment', 'Payroll\MultiplePaymentsController')->middleware('auth'); 
   Route::post('save_multiple_payment','Payroll\MultiplePaymentsController@save_payment')->name('multiple_save.payment')->middleware('auth');;;;
 Route::get('multiple_payment/{departments_id}/{payment_month}', 'Payroll\MultiplePaymentsController@viewPayment')->name('multiple_view.payment')->middleware('auth'); 
    Route::resource('advance_salary', 'Payroll\AdvanceController')->middleware('auth'); 
   Route::get('findAmount', 'Payroll\AdvanceController@findAmount')->middleware('auth'); 
      Route::get('findMonth', 'Payroll\AdvanceController@findMonth')->middleware('auth');   
  Route::get('advance_approve/{id}', 'Payroll\AdvanceController@approve')->name('advance.approve')->middleware('auth'); 
Route::get('advance_reject/{id}', 'Payroll\AdvanceController@reject')->name('advance.reject')->middleware('auth'); 
Route::resource('employee_loan', 'Payroll\EmployeeLoanController')->middleware('auth'); 
 Route::get('findLoan', 'Payroll\EmployeeLoanController@findLoan')->middleware('auth');  
  Route::get('employee_loan_approve/{id}', 'Payroll\EmployeeLoanController@approve')->name('employee_loan.approve')->middleware('auth'); 
Route::get('employee_loan_reject/{id}', 'Payroll\EmployeeLoanController@reject')->name('employee_loan.reject')->middleware('auth'); 
   Route::resource('overtime', 'Payroll\OvertimeController')->middleware('auth'); 
  Route::get('overtime_approve/{id}', 'Payroll\OvertimeController@approve')->name('overtime.approve')->middleware('auth'); 
Route::get('overtime_reject/{id}', 'Payroll\OvertimeController@reject')->name('overtime.reject')->middleware('auth'); 
   Route::get('findOvertime', 'Payroll\OvertimeController@findAmount')->middleware('auth'); 
 Route::any('nssf', 'Payroll\GetPaymentController@nssf')->middleware('auth'); 
 Route::any('tax', 'Payroll\GetPaymentController@tax')->middleware('auth'); 
 Route::any('nhif', 'Payroll\GetPaymentController@nhif')->middleware('auth'); 
 Route::any('wcf', 'Payroll\GetPaymentController@wcf')->middleware('auth'); 
Route::any('payroll_summary', 'Payroll\GetPaymentController@payroll_summary')->middleware('auth'); 
 Route::any('generate_payslip', 'Payroll\GetPaymentController@generate_payslip')->middleware('auth'); 
 Route::any('received_payslip/{id}', 'Payroll\GetPaymentController@received_payslip')->name('payslip.generate')->middleware('auth'); 
Route::get('payslip_pdfview',array('as'=>'payslip_pdfview','uses'=>'Payroll\GetPaymentController@payslip_pdfview'))->middleware('auth');

Route::post('save_salary_details',array('as'=>'save_salary_details','uses'=>'Payroll\ManageSalaryController@save_salary_details'))->middleware('auth');
    Route::get('employee_salary_list',array('as'=>'employee_salary_list','uses'=>'Payroll\ManageSalaryController@employee_salary_list'))->middleware('auth');
    Route::resource('get_payment2', 'Payroll\GetPayment2Controller')->middleware('auth');
    Route::resource('make_payment2', 'Payroll\MakePayments2Controller')->middleware('auth'); 
   //Route::post('make_payment/store{user_id}{departments_id}{payment_month}', 'Payroll\MakePaymentsController@store')->name('make_payment.store')->middleware('auth'); 
    
});

//route for store
Route::group(['prefix' => 'store'], function () {
Route::resource('manage_bar', 'Bar\ManageBarController');
 Route::any('pos_activity', 'Bar\POS\ReportController@summary'); 

Route::group(['prefix' => 'purchases'], function () {
    Route::resource('store_pos_supplier', 'POS\SupplierController')->middleware('auth');
    Route::resource('store_items', 'POS\ItemsController')->middleware('auth');
    Route::post('item_import','Bar\POS\ImportItemsController@import')->name('store_item.import');
    Route::post('item_sample','Bar\POS\ImportItemsController@sample')->name('store_item.sample');
    Route::resource('store_purchase', 'POS\PurchaseController')->middleware('auth');
    
    Route::get('findInvPrice', 'Bar\POS\PurchaseController@findPrice')->middleware('auth'); 
    Route::get('invModal', 'Bar\POS\PurchaseController@discountModal')->middleware('auth');
    Route::get('approve_purchase/{id}', 'Bar\POS\PurchaseController@approve')->name('store_purchase.approve')->middleware('auth'); 
    Route::get('cancel/{id}', 'Bar\POS\PurchaseController@cancel')->name('store_purchase.cancel')->middleware('auth'); 
    Route::get('receive/{id}', 'Bar\POS\PurchaseController@receive')->name('store_purchase.receive')->middleware('auth'); 
    Route::get('make_payment/{id}', 'Bar\POS\PurchaseController@make_payment')->name('store_purchase.pay')->middleware('auth'); 
    Route::get('store_purchase_pdfview',array('as'=>'store_purchase_pdfview','uses'=>'Bar\POS\PurchaseController@inv_pdfview'))->middleware('auth');
    Route::get('order_payment/{id}', 'orders\OrdersController@order_payment')->name('store_purchase_order.pay')->middleware('auth');
    Route::resource('store_purchase_payment', 'Bar\POS\PurchasePaymentController')->middleware('auth');
    //Route::any('creditors_report', 'Bar\POS\PurchaseController@creditors_report')->middleware('auth');
    Route::resource('store_pos_issue', 'Bar\POS\GoodIssueController')->middleware('auth');
    Route::get('findQuantity', 'Bar\POS\GoodIssueController@findQuantity'); 
    Route::get('issue_approve/{id}', 'Bar\POS\GoodIssueController@approve')->name('store_pos_issue.approve')->middleware('auth');
    Route::get('purchaseModal', 'Bar\POS\GoodIssueController@discountModal'); 
 

    Route::resource('store_debit_note', 'Bar\POS\ReturnPurchasesController')->middleware('auth');
      Route::get('findinvoice', 'Bar\POS\ReturnPurchasesController@findPrice')->middleware('auth'); 
      Route::get('showInvoice', 'Bar\POS\ReturnPurchasesController@showInvoice')->middleware('auth'); 
    Route::get('editshowInvoice', 'Bar\POS\ReturnPurchasesController@editshowInvoice')->middleware('auth'); 
      Route::get('findinvQty', 'Bar\POS\ReturnPurchasesController@findQty')->middleware('auth'); 
    Route::get('approve_debit_note/{id}', 'Bar\POS\ReturnPurchasesController@approve')->name('store_debit_note.approve')->middleware('auth'); 
    Route::get('cancel_debit_note/{id}', 'Bar\POS\ReturnPurchasesController@cancel')->name('store_debit_note.cancel')->middleware('auth'); 
    Route::get('receive_debit_note/{id}', 'Bar\POS\ReturnPurchasesController@receive')->name('store_debit_note.receive')->middleware('auth'); 
    Route::get('make_debit_note_payment/{id}', 'Bar\POS\ReturnPurchasesController@make_payment')->name('store_debit_note.pay')->middleware('auth'); 
    Route::resource('store_debit_note_payment', 'Bar\POS\ReturnPurchasesPaymentController')->middleware('auth');
    Route::get('store_debit_note_pdfview',array('as'=>'store_debit_note_pdfview','uses'=>'Bar\POS\ReturnPurchasesController@debit_note_pdfview'))->middleware('auth');
       
    });

    Route::group(['prefix' => 'sales'], function () {
    
      Route::resource('store_pos_client', 'POS\ClientController')->middleware('auth');  
      Route::any('debtors_report', 'POS\InvoiceController@debtors_report')->middleware('auth');

      Route::resource('store_invoice', 'POS\InvoiceController')->middleware('auth');  
      Route::get('findInvPrice', 'POS\InvoiceController@findPrice')->middleware('auth'); 
      Route::get('findInvQuantity', 'POS\InvoiceController@findQuantity'); 
      Route::get('invModal', 'POS\InvoiceController@discountModal')->middleware('auth');
      Route::get('approve_purchase/{id}', 'POS\InvoiceController@approve')->name('store_invoice.approve')->middleware('auth');  
      Route::get('cancel/{id}', 'POS\InvoiceController@cancel')->name('store_invoice.cancel')->middleware('auth'); 
      Route::get('receive/{id}', 'POS\InvoiceController@receive')->name('store_invoice.receive')->middleware('auth'); 
      Route::get('make_payment/{id}', 'POS\InvoiceController@make_payment')->name('store_invoice.pay')->middleware('auth'); 
    
      
      Route::get('store_invoice_pdfview',array('as'=>'store_invoice_pdfview','uses'=>'Bar\POS\InvoiceController@invoice_pdfview'))->middleware('auth');
      Route::get('order_payment/{id}', 'orders\OrdersController@order_payment')->name('store_purchase_order.pay')->middleware('auth');
      Route::resource('store_invoice_payment', 'POS\InvoicePaymentController')->middleware('auth');
    
      Route::resource('store_credit_note', 'POS\ReturnInvoiceController')->middleware('auth');
      Route::get('findinvoice', 'POS\ReturnInvoiceController@findPrice')->middleware('auth'); 
      Route::get('showInvoice', 'POS\ReturnInvoiceController@showInvoice')->middleware('auth'); 
    Route::get('editshowInvoice', 'POS\ReturnInvoiceController@editshowInvoice')->middleware('auth'); 
      Route::get('findinvQty', 'POS\ReturnInvoiceController@findQty')->middleware('auth'); 
    Route::get('approve_credit_note/{id}', 'POS\ReturnInvoiceController@approve')->name('store_credit_note.approve')->middleware('auth'); 
    Route::get('cancel_credit_note/{id}', 'POS\ReturnInvoiceController@cancel')->name('store_credit_note.cancel')->middleware('auth'); 
    Route::get('receive_credit_note/{id}', 'POS\ReturnInvoiceController@receive')->name('store_credit_note.receive')->middleware('auth'); 
    Route::get('make_credit_note_payment/{id}', 'POS\ReturnInvoiceController@make_payment')->name('store_credit_note.pay')->middleware('auth'); 
    Route::resource('store_credit_note_payment', 'POS\ReturnInvoicePaymentController')->middleware('auth');
    Route::get('credit_note_pdfview',array('as'=>'credit_note_pdfview','uses'=>'POS\ReturnInvoiceController@credit_note_pdfview'))->middleware('auth');
      });


  });




//route for restaurant
Route::group(['prefix' => 'restaurant'], function () {

Route::any('pos_activity', 'Restaurant\POS\ReportController@summary'); 

Route::resource('menu-items', 'Restaurant\POS\MenuItemController');
Route::get('menu-items/change/{id}', 'Restaurant\POS\MenuItemController@change_status')->name('menu-items.change')->middleware('auth');

Route::resource('orders', 'Restaurant\POS\OrderController');
Route::get('findPrice', 'Restaurant\POS\OrderController@findPrice'); 
Route::get('findQuantity', 'Restaurant\POS\OrderController@findQuantity'); 
Route::get('findUser', 'Restaurant\POS\OrderController@findUser');
Route::get('showType', 'Restaurant\POS\OrderController@showType');
Route::get('orders_cancel/{id}', 'Restaurant\POS\OrderController@cancel')->name('orders.cancel')->middleware('auth'); 
Route::get('orders_receive/{id}', 'Restaurant\POS\OrderController@receive')->name('orders.receive')->middleware('auth'); 
Route::get('orders_pdfview',array('as'=>'orders_pdfview','uses'=>'Restaurant\POS\OrderController@orders_pdfview'))->middleware('auth');
Route::get('orders_payment_pdfview',array('as'=>'orders_payment_pdfview','uses'=>'Restaurant\POS\OrderController@orders_payment_pdfview'))->middleware('auth');

Route::group(['prefix' => 'purchases'], function () {
    Route::resource('restaurant_pos_supplier', 'Restaurant\POS\SupplierController')->middleware('auth');
    Route::resource('restaurant_items', 'Restaurant\POS\ItemsController')->middleware('auth');
    Route::post('item_import','Restaurant\POS\ImportItemsController@import')->name('restaurant_item.import');
    Route::post('item_sample','Restaurant\POS\ImportItemsController@sample')->name('restaurant_item.sample');
    

Route::get('restaurant_purchase_requisition', 'Restaurant\POS\PurchaseController@purchase_requisition')->name('restaurant_purchase.requisition')->middleware('auth');
Route::get('restaurant_purchase_quotation', 'Restaurant\POS\PurchaseController@purchase_order')->name('restaurant_purchase.order')->middleware('auth');
Route::resource('restaurant_purchase', 'Restaurant\POS\PurchaseController')->middleware('auth');
Route::get('restaurant_purchase_first_approval/{id}', 'Restaurant\POS\PurchaseController@first_approval')->name('restaurant_purchase.first_approval')->middleware('auth'); 
Route::get('restaurant_purchase_second_approval/{id}', 'Restaurant\POS\PurchaseController@second_approval')->name('restaurant_purchase.second_approval')->middleware('auth'); 
Route::get('restaurant_purchase_final_approval/{id}', 'Restaurant\POS\PurchaseController@final_approval')->name('restaurant_purchase.final_approval')->middleware('auth'); 
Route::get('restaurant_purchase_second_disapproval/{id}','Restaurant\POS\PurchaseController@second_disapproval')->name('restaurant_purchase.second_disapproval')->middleware('auth'); 
Route::get('restaurant_purchase_final_disapproval/{id}','Restaurant\POS\PurchaseController@final_disapproval')->name('restaurant_purchase.final_disapproval')->middleware('auth'); 
Route::post('restaurant_grn','Restaurant\POS\PurchaseController@grn')->name('restaurant_purchase.grn')->middleware('auth');
Route::get('restaurant_issue_supplier/{id}', 'Restaurant\POS\PurchaseController@issue')->name('restaurant_purchase.issue')->middleware('auth'); 
Route::post('restaurant_save_order', 'Restaurant\POS\PurchaseController@save_order')->name('restaurant_purchase.save_order')->middleware('auth');
Route::post('restaurant_save_supplier', 'Restaurant\POS\PurchaseController@save_supplier')->name('restaurant_purchase.save_supplier')->middleware('auth');
Route::get('restaurant_confirm_order/{id}', 'Restaurant\POS\PurchaseController@confirm_order')->name('restaurant_purchase.confirm_order')->middleware('auth'); 
Route::get('restaurant_order_pdfview',array('as'=>'restaurant_order_pdfview','uses'=>'Restaurant\POS\PurchaseController@order_pdfview'))->middleware('auth');
Route::get('restaurant_issue_pdfview',array('as'=>'restaurant_issue_pdfview','uses'=>'Restaurant\POS\PurchaseController@issue_pdfview'))->middleware('auth');
    
    Route::get('findInvPrice', 'Restaurant\POS\PurchaseController@findPrice')->middleware('auth'); 
    Route::get('invModal', 'Restaurant\POS\PurchaseController@discountModal')->middleware('auth');
    Route::get('approve_purchase/{id}', 'Restaurant\POS\PurchaseController@approve')->name('restaurant_purchase.approve')->middleware('auth'); 
    Route::get('cancel/{id}', 'Restaurant\POS\PurchaseController@cancel')->name('restaurant_purchase.cancel')->middleware('auth'); 
    Route::get('receive/{id}', 'Restaurant\POS\PurchaseController@receive')->name('restaurant_purchase.receive')->middleware('auth'); 
    Route::get('make_payment/{id}', 'Restaurant\POS\PurchaseController@make_payment')->name('restaurant_purchase.pay')->middleware('auth'); 
    Route::get('restaurant_purchase_pdfview',array('as'=>'restaurant_purchase_pdfview','uses'=>'Restaurant\POS\PurchaseController@inv_pdfview'))->middleware('auth');
    Route::get('order_payment/{id}', 'orders\OrdersController@order_payment')->name('restaurant_purchase_order.pay')->middleware('auth');
    Route::resource('restaurant_purchase_payment', 'Restaurant\POS\PurchasePaymentController')->middleware('auth');     
    Route::get('restaurant_purchase_payment_first_approval/{id}', 'Restaurant\POS\PurchasePaymentController@first_approval')->name('restaurant_purchase_payment.first_approval')->middleware('auth'); 
    Route::get('restaurant_purchase_payment_final_approval/{id}', 'Restaurant\POS\PurchasePaymentController@final_approval')->name('restaurant_purchase_payment.final_approval')->middleware('auth'); 
   Route::get('restaurant_purchase_payment_first_disapproval/{id}', 'Restaurant\POS\PurchasePaymentController@first_disapproval')->name('restaurant_purchase_payment.first_disapproval')->middleware('auth');
   Route::get('restaurant_purchase_payment_confirm/{id}', 'Restaurant\POS\PurchasePaymentController@confirm')->name('restaurant_purchase_payment.confirm')->middleware('auth');
   Route::get('restaurant_purchase_payment_pdfview',array('as'=>'restaurant_purchase_payment_pdfview','uses'=>'Restaurant\POS\PurchasePaymentController@inv_pdfview'))->middleware('auth');
    Route::any('creditors_report', 'Restaurant\POS\PurchaseController@creditors_report')->middleware('auth');
    Route::resource('restaurant_pos_issue', 'Restaurant\POS\GoodIssueController')->middleware('auth');
    Route::get('findQuantity', 'Restaurant\POS\GoodIssueController@findQuantity'); 
    Route::get('issue_approve/{id}', 'Restaurant\POS\GoodIssueController@approve')->name('restaurant_pos_issue.approve')->middleware('auth');
    Route::get('purchaseModal', 'Restaurant\POS\GoodIssueController@discountModal'); 
 

    Route::resource('restaurant_debit_note', 'Restaurant\POS\ReturnPurchasesController')->middleware('auth');
      Route::get('findinvoice', 'Restaurant\POS\ReturnPurchasesController@findPrice')->middleware('auth'); 
      Route::get('showInvoice', 'Restaurant\POS\ReturnPurchasesController@showInvoice')->middleware('auth'); 
    Route::get('editshowInvoice', 'Restaurant\POS\ReturnPurchasesController@editshowInvoice')->middleware('auth'); 
      Route::get('findinvQty', 'Restaurant\POS\ReturnPurchasesController@findQty')->middleware('auth'); 
    Route::get('approve_debit_note/{id}', 'Restaurant\POS\ReturnPurchasesController@approve')->name('restaurant_debit_note.approve')->middleware('auth'); 
    Route::get('cancel_debit_note/{id}', 'Restaurant\POS\ReturnPurchasesController@cancel')->name('restaurant_debit_note.cancel')->middleware('auth'); 
    Route::get('receive_debit_note/{id}', 'Restaurant\POS\ReturnPurchasesController@receive')->name('restaurant_debit_note.receive')->middleware('auth'); 
    Route::get('make_debit_note_payment/{id}', 'Restaurant\POS\ReturnPurchasesController@make_payment')->name('restaurant_debit_note.pay')->middleware('auth'); 
    Route::resource('restaurant_debit_note_payment', 'Restaurant\POS\ReturnPurchasesPaymentController')->middleware('auth');
    Route::get('restaurant_debit_note_pdfview',array('as'=>'restaurant_debit_note_pdfview','uses'=>'Restaurant\POS\ReturnPurchasesController@debit_note_pdfview'))->middleware('auth');
       
    });

    Route::group(['prefix' => 'sales'], function () {
    
      Route::resource('restaurant_pos_client', 'Restaurant\POS\ClientController')->middleware('auth');  
      Route::any('debtors_report', 'Restaurant\POS\InvoiceController@debtors_report')->middleware('auth');

      Route::resource('restaurant_invoice', 'Restaurant\POS\InvoiceController')->middleware('auth');  
      Route::get('findInvPrice', 'Restaurant\POS\InvoiceController@findPrice')->middleware('auth'); 
      Route::get('findInvQuantity', 'Restaurant\POS\InvoiceController@findQuantity'); 
      Route::get('invModal', 'Restaurant\POS\InvoiceController@discountModal')->middleware('auth');
      Route::get('approve_purchase/{id}', 'Restaurant\POS\InvoiceController@approve')->name('restaurant_invoice.approve')->middleware('auth');  
      Route::get('cancel/{id}', 'Restaurant\POS\InvoiceController@cancel')->name('restaurant_invoice.cancel')->middleware('auth'); 
      Route::get('receive/{id}', 'Restaurant\POS\InvoiceController@receive')->name('restaurant_invoice.receive')->middleware('auth'); 
      Route::get('make_payment/{id}', 'Restaurant\POS\InvoiceController@make_payment')->name('restaurant_invoice.pay')->middleware('auth'); 
    
      
      Route::get('restaurant_invoice_pdfview',array('as'=>'restaurant_invoice_pdfview','uses'=>'Restaurant\POS\InvoiceController@invoice_pdfview'))->middleware('auth');
      Route::get('order_payment/{id}', 'orders\OrdersController@order_payment')->name('restaurant_purchase_order.pay')->middleware('auth');
      Route::resource('restaurant_invoice_payment', 'Restaurant\POS\InvoicePaymentController')->middleware('auth');
    
      Route::resource('restaurant_credit_note', 'Restaurant\POS\ReturnInvoiceController')->middleware('auth');
      Route::get('findinvoice', 'Restaurant\POS\ReturnInvoiceController@findPrice')->middleware('auth'); 
      Route::get('showInvoice', 'Restaurant\POS\ReturnInvoiceController@showInvoice')->middleware('auth'); 
    Route::get('editshowInvoice', 'Restaurant\POS\ReturnInvoiceController@editshowInvoice')->middleware('auth'); 
      Route::get('findinvQty', 'Restaurant\POS\ReturnInvoiceController@findQty')->middleware('auth'); 
    Route::get('approve_credit_note/{id}', 'Restaurant\POS\ReturnInvoiceController@approve')->name('restaurant_credit_note.approve')->middleware('auth'); 
    Route::get('cancel_credit_note/{id}', 'Restaurant\POS\ReturnInvoiceController@cancel')->name('restaurant_credit_note.cancel')->middleware('auth'); 
    Route::get('receive_credit_note/{id}', 'Restaurant\POS\ReturnInvoiceController@receive')->name('restaurant_credit_note.receive')->middleware('auth'); 
    Route::get('make_credit_note_payment/{id}', 'Restaurant\POS\ReturnInvoiceController@make_payment')->name('restaurant_credit_note.pay')->middleware('auth'); 
    Route::resource('restaurant_credit_note_payment', 'Restaurant\POS\ReturnInvoicePaymentController')->middleware('auth');
    Route::get('restaurant_credit_note_pdfview',array('as'=>'restaurant_credit_note_pdfview','uses'=>'Restaurant\POS\ReturnInvoiceController@credit_note_pdfview'))->middleware('auth');
      });


  });




    Route::group(['prefix' => 'financial_report'], function () {
        Route::any('trial_balance', 'ReportController@trial_balance')->middleware('auth');
         Route::any('trial_balance_summary', 'ReportController@trial_balance_summary')->middleware('auth');
        Route::any('trial_balance/pdf', 'ReportController@trial_balance_pdf')->middleware('auth');
        Route::any('trial_balance/excel', 'ReportController@trial_balance_excel')->middleware('auth');
        Route::any('trial_balance/csv', 'ReportController@trial_balance_csv')->middleware('auth');
     Route::any('trial_balance_summary/pdf', 'ReportController@trial_balance_summary_pdf')->middleware('auth');
        Route::any('trial_balance_summary/excel', 'ReportController@trial_balance_summary_excel')->middleware('auth');
        Route::any('ledger', 'ReportController@ledger')->middleware('auth');
        Route::any('journal', 'ReportController@journal')->middleware('auth');
        Route::any('income_statement', 'ReportController@income_statement')->middleware('auth');
         Route::any('income_statement_summary', 'ReportController@income_statement_summary')->middleware('auth');
        Route::any('income_statement/pdf', 'ReportController@income_statement_pdf')->middleware('auth');
        Route::any('income_statement/excel', 'ReportController@income_statement_excel')->middleware('auth');
        Route::any('income_statement/csv', 'ReportController@income_statement_csv')->middleware('auth');
         Route::any('income_statement_summary/pdf', 'ReportController@income_statement_summary_pdf')->middleware('auth');
        Route::any('income_statement_summary/excel', 'ReportController@income_statement_summary_excel')->middleware('auth');
        Route::any('balance_sheet', 'ReportController@balance_sheet')->middleware('auth');
        Route::any('balance_sheet_summary', 'ReportController@balance_sheet_summary')->middleware('auth');
        Route::any('balance_sheet/pdf', 'ReportController@balance_sheet_pdf')->middleware('auth');
        Route::any('balance_sheet/excel', 'ReportController@balance_sheet_excel')->middleware('auth');
        Route::any('balance_sheet/csv', 'ReportController@balance_sheet_csv')->middleware('auth');
         Route::any('balance_sheet_summary/excel', 'ReportController@balance_sheet_summary_excel')->middleware('auth');
        Route::any('balance_sheet_summary/pdf', 'ReportController@balance_sheet_summary_pdf')->middleware('auth');
         Route::any('summary', 'ReportController@summary')->middleware('auth');
        Route::any('summary/pdf', 'ReportController@summary_pdf')->middleware('auth');
        Route::any('summary/excel', 'ReportController@summary')->middleware('auth');
        Route::any('summary/csv', 'ReportController@summary')->middleware('auth');
        Route::any('cash_flow', 'ReportController@cash_flow')->middleware('auth');
        Route::any('provisioning', 'ReportController@provisioning')->middleware('auth');
        Route::any('provisioning/pdf', 'ReportController@provisioning_pdf')->middleware('auth');
        Route::any('provisioning/excel', 'ReportController@provisioning_excel')->middleware('auth');
        Route::any('provisioning/csv', 'ReportController@provisioning_csv')->middleware('auth');
    });

//reports
    Route::group(['prefix' => 'reports'], function () {
       
Route::group(['prefix' => 'inventory_report'], function () {
Route::any('purchase_report', 'POS\ReportController@purchase_report')->middleware('auth');
Route::any('good_issue_report', 'POS\ReportController@good_issue_report')->middleware('auth');
Route::any('sales_report', 'POS\ReportController@sales_report')->middleware('auth');
Route::any('balance_report', 'POS\ReportController@balance_report')->middleware('auth');
Route::any('stock_report', 'POS\ReportController@stock_report')->middleware('auth');
Route::any('report_by_date', 'POS\ReportController@report_by_date')->middleware('auth');
Route::any('profit_report', 'POS\ReportController@profit_report')->middleware('auth');
});

Route::group(['prefix' => 'pharmacy_report'], function () {
Route::any('purchase_report', 'Pharmacy\POS\ReportController@purchase_report')->middleware('auth');
Route::any('sales_report', 'Pharmacy\POS\ReportController@sales_report')->middleware('auth');
Route::any('balance_report', 'Pharmacy\POS\ReportController@balance_report')->middleware('auth');

});


Route::group(['prefix' => 'pharmacy_serial_report'], function () {
Route::any('purchase_report', 'Pharmacy\POS\ReportSerialController@purchase_report')->name('serial.purchase')->middleware('auth');
Route::any('sales_report', 'Pharmacy\POS\ReportSerialController@sales_report')->name('serial.sales')->middleware('auth');
Route::any('balance_report', 'Pharmacy\POS\ReportSerialController@balance_report')->middleware('auth');
Route::get('warrantModal', 'Pharmacy\POS\ReportSerialController@discountModal')->middleware('auth');
Route::post('save_warrant', 'Pharmacy\POS\ReportSerialController@save_warrant')->name('save.warrant')->middleware('auth');
});


Route::group(['prefix' => 'retail_report'], function () {
Route::any('purchase_report', 'Retail\POS\ReportController@purchase_report')->middleware('auth');
Route::any('sales_report', 'Retail\POS\ReportController@sales_report')->middleware('auth');
Route::any('balance_report', 'Retail\POS\ReportController@balance_report')->middleware('auth');

});


Route::group(['prefix' => 'retail_serial_report'], function () {
Route::any('purchase_report', 'Retail\POS\ReportSerialController@purchase_report')->name('retail_serial.purchase')->middleware('auth');
Route::any('sales_report', 'Retail\POS\ReportSerialController@sales_report')->name('retail_serial.sales')->middleware('auth');
Route::any('balance_report', 'Retail\POS\ReportSerialController@balance_report')->middleware('auth');
Route::get('warrantModal', 'Retail\POS\ReportSerialController@discountModal')->middleware('auth');
Route::post('save_warrant', 'Retail\POS\ReportSerialController@save_warrant')->name('retail_save.warrant')->middleware('auth');
});


Route::group(['prefix' => 'store'], function () {
    Route::any('purchase_report', 'Bar\POS\ReportController@purchase_report')->middleware('auth');
    Route::any('sales_report', 'Bar\POS\ReportController@sales_report')->middleware('auth');
    Route::any('balance_report', 'Bar\POS\ReportController@balance_report')->middleware('auth');
    Route::any('crate_report', 'Bar\POS\ReportController@crate_report')->middleware('auth');
    Route::any('bottle_report', 'Bar\POS\ReportController@bottle_report')->middleware('auth');
    
    });


Route::group(['prefix' => 'school'], function () {
    Route::any('student_report', 'School\StudentController@student_report')->name('student_report')->middleware('auth');
     Route::get('student_report_excel/{name}/{year}', 'School\StudentController@student_report_excel')->name('student_report.excel')->middleware('auth'); 
   Route::any('class_report', 'School\StudentController@class_report')->name('class_report')->middleware('auth');
   Route::any('uncollected_fees', 'School\StudentController@uncollected_fees')->name('uncollected_fees')->middleware('auth');

    
    });



Route::group(['prefix' => 'project'], function () {
  Route::any('profit_report', 'Project\ProjectController@profit_report')->name('profit_report')->middleware('auth');
     Route::get('profit_report_excel/{name}/{start}/{end}', 'Project\ProjectController@profit_report_excel')->name('profit_report.excel')->middleware('auth');
});

    });

    Route::group(['prefix' => 'access_control'], function () {
Route::resource('permissions', 'PermissionController')->middleware('auth');
Route::resource('departments', 'DepartmentController')->middleware('auth');
Route::resource('designations', 'DesignationController')->middleware('auth');
Route::resource('roles', 'RoleController')->middleware('auth');

Route::resource('users', 'UsersController')->middleware('auth');
Route::get('users_all', 'UsersController@users_all')->name('users_all')->middleware('auth');

Route::get('affiliate_users_all', 'UsersController@affiliate_users_all')->name('affiliate_users_all')->middleware('auth');
Route::get('affiliate_users_show/{id}/show', 'UsersController@affiliate_users_show')->name('affiliate_users_show')->middleware('auth');

Route::get('findDepartment', 'UsersController@findDepartment')->middleware('auth');  
Route::resource('users_details', 'User\UserDetailsController')->middleware('auth');

Route::resource('clients', 'ClientController')->middleware('auth');

Route::resource('system', 'SystemController')->middleware('auth');

//user Details
Route::resource('user_details', 'UserDetailsController')->middleware('auth');
    });
