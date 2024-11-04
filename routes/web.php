<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HonorariumController;
use App\Http\Controllers\SentItemsController;
use App\Http\Controllers\ForAcknowledgementController;
use App\Http\Controllers\OpenAcknowledgementController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\SendEmailController;
use App\Models\Honorarium;
use App\Http\Controllers\OnHoldController;
use App\Http\Controllers\ProfileController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\CashierQueueController;
use App\Http\Controllers\FacultyDashboardController;
use App\Http\Controllers\FacultyTrackingController;
use App\Http\Controllers\ThesisNewEntriesController;

//START NO AUTHENTICATED ACCESS
Route::middleware(['guest', '419'])->group(function () {

    Route::get('/', [UserController::class, 'index'])->name("login")->name("login");
    Route::post('/login', [UserController::class, 'login'])->name("login.user");
    Route::get('/registration', [UserController::class, 'registration'])->name("registration");
    Route::post('/register', [UserController::class, 'register'])->name('form.register');
});
//END NO AUTHENTICATED ACCESS


//START AUTHENTICATED ACCESS

Route::middleware(['auth_check', '419'])->group(function () {

    Route::post('/test', [UserController::class, 'test'])->name('test');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    // Route::put('/profile/update', [ProfileController::class, 'profile_update'])->name('profile.update');
    Route::match(['post', 'put'], 'profile/update', [ProfileController::class, 'profile_update'])->name('profile.update');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::middleware(['faculty'])->group(function () {
        Route::get('/admin_dashboard', [AdminController::class, 'admin_dashboard'])->name("admin_dashboard");
    });

    Route::get('/admin_email', [AdminController::class, 'admin_email'])->name("admin_email");
    Route::get('/admin_open_email', [AdminController::class, 'admin_open_email'])->name("admin_open_email");

    Route::post('/send_email', [SendEmailController::class, 'send_email'])->name("send_email");
    Route::get('/getEmails', [SendEmailController::class, 'getEmails'])->name("getEmails");
    Route::get('/getadmin_email', [AdminController::class, 'getadmin_email'])->name("getadmin_email");
    Route::post('/updateEmailStatus', [SendEmailController::class, 'updateStatus'])->name('updateEmailStatus');
    Route::post('/deleteEmails', [SendEmailController::class, 'deleteEmails'])->name('deleteEmails');

    // Route::get('/sent_items', [AdminController::class, 'admin_open_email'])->name("admin_open_email");
    Route::get('/sent_items', [SentItemsController::class, 'sent_items'])->name("sent_items");
    Route::get('/open_sent_items', [SentItemsController::class, 'open_sent_items'])->name("open_sent_items");
    Route::post('/send_reply', [SentItemsController::class, 'send_reply'])->name("send_reply");
    Route::get('/getEmailsSent', [SentItemsController::class, 'getEmails'])->name("getEmailsSent");

    //START SUPERADMIN ACCESS

    // Route::middleware(['Superadmin'])->group(function () {

        Route::get('/getUser', [UserController::class, 'getUser'])->name('getUser');

        Route::get('/admin_faculty', [AdminController::class, 'admin_faculty'])->name("admin_faculty");
        Route::get('/admin_view_faculty', [AdminController::class, 'admin_view_faculty'])->name("admin_view_faculty");
        Route::get('/admin_faculty/list', [UserController::class, 'list'])->name("admin_faculty.list");

        Route::get('/user_management', [UserManagementController::class, 'user_management'])->name("user_management");
        Route::get('/user_management/list', [UserManagementController::class, 'list'])->name("user_management.list");
        Route::post('/user_management/store', [UserManagementController::class, 'store'])->name("user_management.store");

        Route::get('/admin_honorarium', [AdminController::class, 'admin_honorarium'])->name("admin_honorarium");
        Route::get('/admin_honorarium/list', [HonorariumController::class, 'list'])->name("admin_honorarium.list");
        Route::post('/admin_honorarium/store', [HonorariumController::class, 'store'])->name("admin_honorarium.store");
        Route::post('/admin/honorarium/update/{id}', [HonorariumController::class, 'update'])->name('admin_honorarium.update');
        Route::get('/admin/honorarium/getHonorarium', [HonorariumController::class, 'getHonorarium'])->name('getHonorarium');

        Route::get('/admin_new_entries', [AdminController::class, 'admin_new_entries'])->name("admin_new_entries");
        Route::get('/Getadmin_new_entries', [AdminController::class, 'Getadmin_new_entries'])->name("Getadmin_new_entries");
        Route::get('/admin_new_entries/list', [AdminController::class, 'list'])->name("admin_new_entries.list");
        Route::post('/admin_new_entries/generate_tracking_number', [AdminController::class, 'generate_trackingNum'])->name("admin_new_entries.generate_trackingNum");
        Route::post('/form/submit', [AdminController::class, 'submitForm'])->name('form.submit');
        Route::post('/submit/onHold', [AdminController::class, 'submitOnHold'])->name('submit.onHold');
        Route::post('insertFormData', [SendEmailController::class, 'reply_send'])->name('insertFormData');
        Route::post('/admin_new_entries/destroy', [AdminController::class, 'destroy'])->name('admin_new_entries.destroy');

        Route::get('/admin_on_queue', [AdminController::class, 'admin_on_queue'])->name('admin_on_queue');
        Route::get('/open_on_queue', [QueueController::class, 'OpenOnQueue'])->name('open_on_queue');
        Route::get('/admin_on_queue/list', [QueueController::class, 'list'])->name('admin_on_queue.list');
        Route::get('/admin_on_queue/open_list', [QueueController::class, 'open_list'])->name('admin_on_queue.open_list');

        Route::get('/admin_on_hold', [AdminController::class, 'admin_on_hold'])->name('admin_on_hold');
        Route::get('/main_on_hold', [OnHoldController::class, 'mainOnHold'])->name('main_on_hold');
        Route::get('/main_on_hold_list', [OnHoldController::class, 'list'])->name('main_on_hold.list');



        Route::post('/admin_on_queue/proceed_to_budget-office', [QueueController::class, 'proceedToBudgetOffice'])->name('admin_on_queue.proceedToBudgetOffice');
        Route::post('/admin_on_queue/proceed', [QueueController::class, 'proceed'])->name('admin_on_queue.proceed');
        Route::post('/admin_on_queue/on_hold_batch', [QueueController::class, 'on_hold_batch'])->name('admin_on_queue.on_hold_batch');
        Route::post('/admin_on_queue/proceed_to_cashier', [QueueController::class, 'proceedToCashier'])->name('admin_on_queue.proceedToCashier');
        Route::match(['post', 'put'], 'admin_on_queue/update', [QueueController::class, 'update'])->name('admin_on_queue.update');
        Route::match(['post', 'put'], 'admin_on_queue/change_to_onhold', [QueueController::class, 'change_to_onhold'])->name('admin_on_queue.change_to_onhold');

        Route::get('/cashier_in_queue', [CashierQueueController::class, 'cashier_in_queue'])->name('cashier_in_queue');
        Route::get('/cashier_in_queue/list', [CashierQueueController::class, 'list'])->name('cashier_in_queue.list');

        Route::get('/cashier_open_queue', [CashierQueueController::class, 'cashier_open_queue'])->name('cashier_open_queue');
        Route::get('/cashier_open_queue/open_list', [CashierQueueController::class, 'open_list'])->name('cashier_open_queue.open_list');
        Route::post('/cashier_open_queue/store', [CashierQueueController::class, 'store'])->name('cashier_open_queue.store');
        Route::post('/check-proceed-cashier', [CashierQueueController::class, 'checkIfProceedToCashier'])->name('check.proceed.cashier');


        Route::get('/for_acknowledgement', [ForAcknowledgementController::class, 'for_acknowledgement'])->name('for_acknowledgement');
        Route::get('/for_acknowledgement/list', [ForAcknowledgementController::class, 'list'])->name("for_acknowledgement.list");

        Route::get('/open_acknowledgement', [OpenAcknowledgementController::class, 'open_acknowledgement'])->name('open_acknowledgement');
        Route::get('/open_acknowledgement/list', [OpenAcknowledgementController::class, 'list'])->name('open_acknowledgement.list');
        Route::get('/open_acknowledgement/list', [OpenAcknowledgementController::class, 'list'])->name('open_acknowledgement.list');
        Route::post('/open_acknowledgement/acknowledge', [OpenAcknowledgementController::class, 'acknowledge'])->name('open_acknowledgement.acknowledge');


        Route::get('/transactions/on-hold', [OnHoldController::class, 'getOnHoldTransactions'])->name('on_hold_status');
        Route::post('/save/onHold', [OnHoldController::class, 'saveOnHold'])->name('saveOnHold');
        Route::post('/save/UpdateToProceed', [OnHoldController::class, 'UpdateToProceed'])->name('UpdateToProceed');
        Route::post('/update-complied-on', [OnHoldController::class, 'updateCompliedOn'])->name('update.complied.on');
        Route::post('/proceed_on_hold', [OnHoldController::class, 'proceed_on_hold'])->name('proceed_on_hold');


        Route::get('/history', [HistoryController::class, 'history'])->name('history');
        Route::get('/open_history', [HistoryController::class, 'open_history'])->name('open_history');
        Route::get('/open_history/list', [HistoryController::class, 'OpenHistoryList'])->name('OpenHistoryList');
        Route::get('/history/list', [HistoryController::class, 'list'])->name('history.list');

        Route::get('/faculty/bugs', [FacultyTrackingController::class, 'AdminList'])->name('faculty.bugs');
        Route::get('/faculty/budget-office', [FacultyTrackingController::class, 'BudgetList'])->name('faculty.budget-office');
        Route::get('/faculty/dean_office', [FacultyTrackingController::class, 'DeanList'])->name('faculty.dean_office');
        Route::get('/faculty/dean_office/accounting', [FacultyTrackingController::class, 'DeanListTwo'])->name('faculty.dean_office_two');
        Route::get('/faculty/accounting', [FacultyTrackingController::class, 'AccountList'])->name('faculty.accounting');
        Route::get('/faculty/cashier', [FacultyTrackingController::class, 'CashierList'])->name('faculty.cashier');
        Route::get('/faculty/honorarium_released', [FacultyTrackingController::class, 'honorarium_released'])->name('faculty.honorarium_released');

        Route::get('/faculty_dashboard', [FacultyDashboardController::class, 'faculty_dashboard'])->name('faculty_dashboard');
        Route::get('/faculty_tracking', [FacultyTrackingController::class, 'faculty_tracking'])->name('faculty_tracking');

        // New Route as of Nov 4
        Route::get('/thesis/new-entries', [ThesisNewEntriesController::class, 'thesisNewEntries'])->name('thesis.newEntries');
    // });

    //END SUPERADMIN ACCESS

});

//END AUTHENTICATED ACCESS

