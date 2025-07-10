<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BatchBController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;

use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\ContractTypeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\TestingResultController;
use App\Models\TestingResult;

use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CheckActionController;
use App\Http\Controllers\Admin\CheckLoginController;
use App\Http\Controllers\Admin\FarmController;
use App\Http\Controllers\Admin\InfIngredientController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PlantingAreaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TypeOfPusController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\OrderBatchController;

use App\Http\Controllers\Export\ExportExcelController;
use App\Http\Controllers\Export\ExportLatexController;
use App\Http\Controllers\Export\ExportRssController;
use App\Http\Controllers\Export\ExportSvrController;
use App\Http\Controllers\Import\PlantingAreaImportController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\Import\ImportLatexController;
use App\Http\Controllers\Import\ImportRssController;
use App\Http\Controllers\Import\ImportSvrController;
use App\Http\Controllers\Admin\ContractFileController;
use App\Http\Controllers\Import\ImportBatchIngControllor;
use App\Http\Controllers\Import\ImportIngredientControllor;

use App\Http\Controllers\Admin\DueDiliStateController;
use App\Http\Controllers\Admin\FactoryController;
use App\Http\Controllers\Admin\GeojsonController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Import\UpdatePlantingAreaImportController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

// Route::get('/create', [LoginController::class, 'createuser']);
Route::post('/select-redirect', [LoginController::class, 'selectRedirect'])->name('select.redirect');


Route::middleware(['login'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    // Route::get('/tx', [HomeController::class, 'index'])->name('tx');
    // Route::get('/api/contracts', [HomeController::class, 'fetchContracts']);
    // Route::get('/api/contracts/detail/{id}', [HomeController::class, 'getContractDetails']);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/account', [UserController::class, 'index'])->name('account');
    Route::post('/account', [UserController::class, 'store']);
    Route::get('/farm-vehicle-statistics', [ChartController::class, 'getFarmAndVehicleStatistics']);

    Route::put('/account/update', [UserController::class, 'update'])->name('account.update');


    Route::resources([
        'contract-types' => ContractTypeController::class,
        'customers' => CustomerController::class,
        'contracts' => ContractController::class,
        'testing' => TestingResultController::class,
        'certi' => CertificateController::class,

    ]);

    Route::get('show-untested/{id}', [TestingResultController::class, 'showun'])->name('showun');


    Route::get('/get-certificates/data', [CertificateController::class, 'getCertificatesData'])->name('certificates.data');
    Route::get('/contract-get-data', [ContractTypeController::class, 'getData'])->name('contract.types.data');
    Route::get('/customer-get-data', [CustomerController::class, 'getData']);
    Route::get('/contracts-get-data', [ContractController::class, 'getData']);
    Route::get('/testing-get-data', [TestingResultController::class, 'getData']);

    Route::get('/untested', [TestingResultController::class, 'indexUntested'])->name('untested');
    Route::get('/untested-get-data', [TestingResultController::class, 'getDataUntested']);

    Route::delete('/delete-order', [ContractController::class, 'delete_order'])->name('order.delete');

    Route::get('/farms', [FarmController::class, 'index'])->name('farms.index');
    Route::post('/save-farms', [FarmController::class, 'save'])->name('farms.save');
    Route::get('/farms/edit/{id}', [FarmController::class, 'edit'])->name('farms.edit');
    Route::post('/farms/update/{id}', [FarmController::class, 'update'])->name('farms.update');
    Route::get('farms/delete/{id}', [FarmController::class, 'destroy'])->name('farms.delete');
    Route::post('/farms/edit-multiple', [FarmController::class, 'editMultiple'])->name('farms.editMultiple');
    Route::post('/farms/delete-multiple', [FarmController::class, 'deleteMultiple'])->name('farms.deleteMultiple');
    Route::post('/toggle-farm-status', [FarmController::class, 'toggleStatus'])->name('farm.status');

    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::post('/save-units', [UnitController::class, 'save'])->name('units.save');
    Route::get('/units/edit/{id}', [UnitController::class, 'edit'])->name('units.edit');
    Route::post('/units/update/{id}', [UnitController::class, 'update'])->name('units.update');
    Route::get('units/delete/{id}', [UnitController::class, 'destroy'])->name('units.delete');
    Route::post('/units/edit-multiple', [UnitController::class, 'editMultiple'])->name('units.editMultiple');
    Route::post('/units/delete-multiple', [UnitController::class, 'deleteMultiple'])->name('units.deleteMultiple');
    Route::post('/toggle-unit-status', [UnitController::class, 'toggleStatus'])->name('unit.status');

    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/get-farms-by-unit/{unitId}', [VehicleController::class, 'getFarmsByUnit']);
    Route::post('/save-vehicles', [VehicleController::class, 'save'])->name('vehicles.save');
    Route::get('/vehicles/edit/{id}', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::post('/vehicles/update/{id}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::get('vehicles/delete/{id}', [VehicleController::class, 'destroy'])->name('vehicles.delete');
    Route::post('/vehicles/edit-multiple', [VehicleController::class, 'editMultiple'])->name('vehicles.editMultiple');
    Route::post('/vehicles/delete-multiple', [VehicleController::class, 'deleteMultiple'])->name('vehicles.deleteMultiple');
    Route::post('/toggle-vehicles-status', [VehicleController::class, 'toggleStatus'])->name('vehicles.status');
    Route::post('/vehicles/confirm-delete-multiple', [VehicleController::class, 'confirmDeleteMultiple'])->name('vehicles.confirm-delete-multiple');
    Route::post('/vehicles/update-status', [VehicleController::class, 'updateStatus']);

    // Route::get('/get-farms-by-unit', function (Request $request) {
    //     $unit = $request->query('unit');
    //     $farms = \App\Models\Farm::where('unit', $unit)->get(['id', 'farm_name']);
    //     return response()->json($farms);
    // });

    // Route::get('/api/get-farms-by-unit', function (Request $request) {
    //     $unit = $request->query('unit');
    //     $farms = \App\Models\Farm::where('unit', $unit)->where('status', 'Hoạt động')->get(['id', 'farm_name']);
    //     return response()->json($farms);
    // });


    Route::get('/typeofpus', [TypeOfPusController::class, 'index'])->name('typeofpus.index');
    Route::post('/save-typeofpus', [TypeOfPusController::class, 'save'])->name('typeofpus.save');
    Route::get('/typeofpus/edit/{id}', [TypeOfPusController::class, 'edit'])->name('typeofpus.edit');
    Route::post('/typeofpus/update/{id}', [TypeOfPusController::class, 'update'])->name('typeofpus.update');
    Route::get('typeofpus/delete/{id}', [TypeOfPusController::class, 'destroy'])->name('typeofpus.delete');
    Route::post('/typeofpus/edit-multiple', [TypeOfPusController::class, 'editMultiple'])->name('typeofpus.editMultiple');
    Route::post('/typeofpus/delete-multiple', [TypeOfPusController::class, 'deleteMultiple'])->name('typeofpus.deleteMultiple');
    Route::post('/toggle-typeofpus-status', [TypeOfPusController::class, 'toggleStatus'])->name('typeofpus.status');

    Route::get('/factorys', [FactoryController::class, 'index'])->name('factorys.index');
    Route::post('/save-factorys', [FactoryController::class, 'save'])->name('factorys.save');
    Route::get('/factorys/edit/{id}', [FactoryController::class, 'edit'])->name('factorys.edit');
    Route::post('/factorys/update/{id}', [FactoryController::class, 'update'])->name('factorys.update');
    Route::get('factorys/delete/{id}', [FactoryController::class, 'destroy'])->name('factorys.delete');
    Route::post('/factorys/edit-multiple', [FactoryController::class, 'editMultiple'])->name('factorys.editMultiple');
    Route::post('/factorys/delete-multiple', [FactoryController::class, 'deleteMultiple'])->name('factorys.deleteMultiple');
    Route::post('/toggle-factorys-status', [FactoryController::class, 'toggleStatus'])->name('factorys.status');

    Route::get('/plantingareas', [PlantingAreaController::class, 'index'])->name('plantingareas.index');
    Route::get('/add-plantingareas', [PlantingAreaController::class, 'add'])->name('add-plantingareas');
    Route::post('/save-plantingareas', [PlantingAreaController::class, 'save'])->name('save-plantingareas');
    Route::get('/edit-plantingareas/{id}', [PlantingAreaController::class, 'edit'])->name('edit-plantingareas');
    Route::post('/update-plantingareas/{id}', [PlantingAreaController::class, 'update'])->name('update-plantingareas');
    Route::get('/delete-plantingareas/{id}', [PlantingAreaController::class, 'destroy'])->name('delete-plantingareas');
    Route::post('/plantingareas/delete-multiple', [PlantingAreaController::class, 'deleteMultiple'])->name('plantingareas.deleteMultiple');
    Route::get('/get-farms-by-unit/{unitId}', [PlantingAreaController::class, 'getFarmsByUnit']);

    Route::get('/ingredients', [InfIngredientController::class, 'index'])->name('ingredients.index');
    Route::get('/add-ingredients', [InfIngredientController::class, 'add'])->name('add-ingredients');
    Route::post('/save-ingredients', [InfIngredientController::class, 'save'])->name('save-ingredients');
    Route::get('/edit-ingredients/{id}', [InfIngredientController::class, 'edit'])->name('edit-ingredients');
    Route::post('/update-ingredients/{id}', [InfIngredientController::class, 'update'])->name('update-ingredients');
    Route::get('/delete-ingredients/{id}', [InfIngredientController::class, 'destroy'])->name('delete-ingredients');
    Route::post('/ingredients/delete-multiple', [InfIngredientController::class, 'deleteMultiple'])->name('ingredients.deleteMultiple');
    Route::get('/get-vehicles', [InfIngredientController::class, 'getVehicles'])->name('get-vehicles');
    Route::get('/get-farms-by-unit', [InfIngredientController::class, 'getFarmsByUnit'])->name('get-farms-by-unit');
    Route::get('/get-chi-tieu', [InfIngredientController::class, 'getChiTieu'])->name('get.chi.tieu');
    Route::get('/select-chi-tieu', [InfIngredientController::class, 'selectChiTieu'])->name('select.chi.tieu');
    Route::get('/get-planting-areas-by-farm', [InfIngredientController::class, 'getPlantingAreasByFarm'])->name('get-planting-areas-by-farm');

    Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
    Route::get('/add-batches', [BatchController::class, 'add'])->name('add-batches');
    Route::post('/save-batches', [BatchController::class, 'save'])->name('save-batches');
    Route::get('/edit-batches/{id}', [BatchController::class, 'edit'])->name('edit-batches');
    Route::post('/update-batches/{id}', [BatchController::class, 'update'])->name('update-batches');
    Route::get('/delete-batches/{id}', [BatchController::class, 'destroy'])->name('delete-batches');
    Route::post('/batch/delete-multiple', [BatchController::class, 'deleteMultiple'])->name('batch.deleteMultiple');

    Route::get('/batchesB', [BatchBController::class, 'index_b'])->name('batchesB.index');
    Route::get('/add-batchesB', [BatchBController::class, 'add_b'])->name('add-batchesB');
    Route::post('/save-batchesB', [BatchBController::class, 'save_b'])->name('save-batchesB');
    Route::get('/edit-batchesB/{id}', [BatchBController::class, 'edit_b'])->name('edit-batchesB');
    Route::post('/update-batchesB/{id}', [BatchBController::class, 'update_b'])->name('update-batchesB');
    Route::get('/delete-batchesB/{id}', [BatchBController::class, 'destroy_b'])->name('delete-batchesB');
    Route::post('/batchB/delete-multiple', [BatchBController::class, 'deleteMultiple'])->name('batchB.deleteMultiple');

    Route::get('/qrCode', [BatchBController::class, 'index_qr'])->name('index_qr.index');
    Route::post('/generate-qr', [BatchBController::class, 'generateQrCodes'])->name('generate_qr');


    Route::get('/get-batch', [OrderBatchController::class, 'getBatch'])->name('get.batch');

    Route::get('/orderbatch', [OrderBatchController::class, 'index'])->name('orderbatchs.index');
    Route::get('/add-orderbatchs', [OrderBatchController::class, 'add'])->name('add-orderbatchs');
    Route::post('/save-orderbatchs', [OrderBatchController::class, 'save'])->name('save-orderbatchs');
    Route::get('/edit-orderbatchs/{id}', [OrderBatchController::class, 'edit'])->name('edit-orderbatchs');
    Route::post('/update-orderbatchs', [OrderBatchController::class, 'update'])->name('update-orderbatchs');
    Route::get('/delete-orderbatchs/{id}', [OrderBatchController::class, 'destroy'])->name('delete-orderbatchs');
    Route::post('/orderbatchs/delete-multiple', [OrderBatchController::class, 'deleteMultiple'])->name('orderbatchs.deleteMultiple');

    Route::get('/export-contracts', [ContractController::class, 'export'])->name('export.contracts');

    Route::get('/cont', [ContractController::class, 'index'])->name('cont');
    Route::post('/save-contract', [ContractController::class, 'storeContract'])->name('contstore');
    Route::post('/cont-update/{id}', [ContractController::class, 'updateContract']);
    Route::post('/contracts/delete-multiple', [ContractController::class, 'deleteMultiple'])->name('contracts.deleteMultiple');

    Route::post('/customers/delete-multiple', [CustomerController::class, 'deleteMultiple'])->name('customers.deleteMultiple');
    Route::post('/contracttype/delete-multiple', [ContractTypeController::class, 'deleteMultiple'])->name('contracttype.deleteMultiple');


    Route::get('/check-login', [CheckLoginController::class, 'index'])->name('checkLogin.index');
    Route::get('/check-action', [CheckActionController::class, 'index'])->name('checkAction.index');

    // Import Excel SVR, LATEX, RSS
    Route::get('/file', [TestingResultController::class, 'importFiles'])->name('import.files');
    Route::post('/import-rss', [ImportRssController::class, 'importRss'])->name('import-rss');
    Route::post('/import-svr', [ImportSvrController::class, 'importSvr'])->name('import-svr');
    Route::post('/import-latex', [ImportLatexController::class, 'importLatex'])->name('import-latex');

    Route::get('/import-ing', [InfIngredientController::class, 'index_ip'])->name('importIng.index');
    Route::post('/import-file', [InfIngredientController::class, 'import'])->name('importIng.import');
    Route::get('/download-sample', [InfIngredientController::class, 'downloadSample'])->name('download.sample');

    Route::get('/import-batchIng', [ImportBatchIngControllor::class, 'index'])->name('importBatchIng.index');
    Route::post('/storeBatchIng', [ImportBatchIngControllor::class, 'importExcel'])->name('storeBatchIng');




    // Xuất Excel
    Route::get('/export-excel', [ExportExcelController::class, 'exportExcel']);

    // Thêm khu vực trồng bằng excel
    Route::post('/upload-pdf', [PlantingAreaImportController::class, 'uploadPdf'])->name('upload.pdf');
    Route::get('/add-excel', [PlantingAreaImportController::class, 'add_excel'])->name('add-excel');
    Route::post('/import-plantingareas', [PlantingAreaImportController::class, 'importExcel'])->name('import-plantingareas');
    Route::post('/import-plantingareas/save-data', [PlantingAreaImportController::class, 'saveData'])->name('import-plantingareas.saveData');

    // Sửa khu vực trồng bằng excel
    Route::post('/upload-pdf-edit', [UpdatePlantingAreaImportController::class, 'uploadPdf'])->name('upload-edit.pdft');
    Route::get('/edit-excel', [UpdatePlantingAreaImportController::class, 'edit_excel'])->name('edit-excel');
    Route::post('/edit-import-plantingareas', [UpdatePlantingAreaImportController::class, 'importExcel'])->name('edit-import-plantingareas');
    Route::post('/edit-import-plantingareas/save-data', [UpdatePlantingAreaImportController::class, 'saveData'])->name('edit-import-plantingareas.saveData');

    // Báo cáo
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');

    // Thêm file vô hợp đồng
    Route::get('/contract-files', [ContractFileController::class, 'index'])->name('contract-files.index');
    Route::get('/contract-files/data', [ContractFileController::class, 'getData'])->name('contract-files.data');

    Route::get('/contract-files/edit/{id}', [ContractFileController::class, 'edit'])->name('edit.index');
    Route::put('/contract-files/edit/{id}', [ContractFileController::class, 'editFile'])->name('contract-files.edit');

    Route::get('/contract-files/create-file', [ContractFileController::class, 'create'])->name('create-file.index');
    Route::post('/contract-files/create-file', [ContractFileController::class, 'createFile'])->name('create-file.createfile');

    // Web tra cứu geojson
    Route::get('/batch-geojson', [GeojsonController::class, 'index'])->name('geojson.index');
    Route::get('/batch-geojson/download-geojson', [GeojsonController::class, 'downloadGeojson'])->name('download.geojson');


    // Cài đặt
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/webmap', [SettingController::class, 'updateWm'])->name('settings.wm');
    Route::post('/settings/token', [SettingController::class, 'updateToken'])->name('settings.token');
    Route::post('/settings/update-login', [SettingController::class, 'updateLogin'])->name('settings.updateLogin');
    Route::post('/settings/update-AM', [SettingController::class, 'updateAppMap'])->name('settings.updateWebmap');
    Route::post('/settings/update-runtime', [SettingController::class, 'updateruntime'])->name('settings.updateruntime');
    Route::post('/settings/all-save', [SettingController::class, 'saveAllSettings'])->name('settings.saveAllSettings');
    // Xuất file excel theo lọc (Quản lý khu vực trồng)
    Route::get('/export-ingredients', [InfIngredientController::class, 'exportExcel'])->name('ingredients.export');
});
Route::get('/api/map', [HomeController::class, 'map']);

Route::middleware(['role.khachhang', 'lang'])->group(function () {
    Route::get('/truy-xuat', [HomeController::class, 'index'])->name('tx');
    Route::get('/api/contracts', [HomeController::class, 'fetchContracts']);
    Route::get('/api/contracts/detail/{id}', [HomeController::class, 'getContractDetails']);
    Route::get('/dds-export/{code}', [HomeController::class, 'ddsExportExcel'])->name('dds.export');
    Route::get('/change-language/{lang}', function ($lang) {

        if (in_array($lang, ["en", "vi", "de", "zh"])) {
            Session::put('locale', $lang);
            Session::save();
        }
        return redirect()->back();
    })->name('change-language');
});
Route::middleware(['lang'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
});
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'handle_login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/user-login', [LoginController::class, 'indexUser'])->name('login');

// Route::get('/reset-password', [UserController::class, 'resetPass']);

// Route::post('/password/reset', [UserController::class, 'reset'])->name('password.update');


// Route::get('password/reset', [PasswordController::class, 'requestForm'])->name('password.request');
// Route::post('password/email', [PasswordController::class, 'sendResetLink'])->name('password.email');
// Route::get('password/reset/{token}', [PasswordController::class, 'resetForm'])->name('password.reset');
// Route::post('password/reset', [PasswordController::class, 'updatePassword'])->name('password.update');

Route::post('/check-email', [UserController::class, 'checkEmail']);
// Route::group(['middleware'], function () {
Route::group(['middleware' => ['isAdmin']], function () {
    Route::get('all-permissions', [PermissionController::class, 'all_permissions'])->name('all.permissions');
    Route::post('add-permissions', [PermissionController::class, 'store'])->name('store.permissions');
    Route::get('edit-permissions/{permission}', [PermissionController::class, 'show'])->name('show.permissions');
    Route::post('edit-permissions/{permission}', [PermissionController::class, 'update'])->name('edit.permissions');
    Route::delete('delete-permissions/{permission}', [PermissionController::class, 'delete'])->name('delete.permissions');

    Route::get('all-roles', [RoleController::class, 'all_roles'])->name('all.roles');
    Route::post('add-roles', [RoleController::class, 'store'])->name('store.roles');
    Route::get('edit-roles/{role}', [RoleController::class, 'show'])->name('show.roles');
    Route::post('edit-roles/{role}', [RoleController::class, 'update'])->name('edit.roles');
    Route::delete('delete-roles/{role}', [RoleController::class, 'delete'])->name('delete.roles');

    Route::get('give-permission/{role}', [RoleController::class, 'addPermissionToRole']);
    Route::post('give-permission/{role}', [RoleController::class, 'postPermissionToRole']);

    Route::get('all-users', [UserController::class, 'all_users'])->name('all.users');
    Route::post('add-users', [UserController::class, 'store'])->name('store.users');
    Route::get('edit-users/{users}', [UserController::class, 'show'])->name('show.users');
    Route::post('edit-users/{users}', [UserController::class, 'update'])->name('edit.users');
    Route::delete('delete-users/{users}', [UserController::class, 'delete'])->name('delete.users');
    Route::get('filter-selects', [UserController::class, 'all_users'])->name('filter.users');

    Route::middleware(['permission:Danh Sách Nông Trường'])->get('/farms', [FarmController::class, 'index'])->name('farms.index');
    Route::middleware(['permission:Thêm Nông Trường'])->post('/save-farms', [FarmController::class, 'save'])->name('farms.save');
    Route::middleware(['permission:Sửa Nông Trường'])->get('/farms/edit/{id}', [FarmController::class, 'edit'])->name('farms.edit');
    // Route::middleware(['permission:xoa Nông Trường'])->get('/farms/delete/{id}', [FarmController::class, 'destroy'])->name('farms.delete');
    Route::middleware(['permission:Xóa Nông Trường'])->post('/farms/delete-multiple', [FarmController::class, 'deleteMultiple'])->name('farms.deleteMultiple');

    // Route::middleware(['permission:Danh Sách Nhà Máy'])->get('/factorys', [FactoryController::class, 'index'])->name('factorys.index');
    // Route::middleware(['permission:Thêm Nhà Máy'])->post('/save-factorys', [FactoryController::class, 'save'])->name('factorys.save');
    // Route::middleware(['permission:Sửa Nhà Máy'])->get('/factorys/edit/{id}', [FactoryController::class, 'edit'])->name('factorys.edit');
    // Route::middleware(['permission:Xóa Nhà Máy'])->post('/factorys/delete-multiple', [FactoryController::class, 'deleteMultiple'])->name('factorys.deleteMultiple');

    Route::middleware(['permission:Danh Sách Xe'])->get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::middleware(['permission:Thêm Xe'])->post('/save-vehicles', [VehicleController::class, 'save'])->name('vehicles.save');
    Route::middleware(['permission:Sửa Xe'])->get('/vehicles/edit/{id}', [VehicleController::class, 'edit'])->name('vehicles.edit');
    // Route::middleware(['permission:Xóa Xe'])->get('/vehicles/delete/{id}', [VehicleController::class, 'destroy'])->name('vehicles.delete');
    Route::middleware(['permission:Xóa Xe'])->post('/vehicles/delete-multiple', [VehicleController::class, 'deleteMultiple'])->name('vehicles.deleteMultiple');

    Route::middleware(['permission:Danh Sách Nguyên Liệu'])->get('/ingredients', [InfIngredientController::class, 'index'])->name('ingredients.index');
    Route::middleware(['permission:Thêm Nguyên Liệu'])->get('/add-ingredients', [InfIngredientController::class, 'add'])->name('add-ingredients');
    // Route::middleware(['permission:Sửa Nguyên Liệu'])->get('/edit-ingredients/{id}', [InfIngredientController::class, 'edit'])->name('edit-ingredients');
    Route::middleware(['permission:Sửa Nguyên Liệu'])->post('/update-ingredients/{id}', [InfIngredientController::class, 'update'])->name('update-ingredients');
    // Route::middleware(['permission:Xóa Nguyên Liệu'])->get('/delete-ingredients/{id}', [InfIngredientController::class, 'destroy'])->name('delete-ingredients');
    Route::middleware(['permission:Xóa Nguyên Liệu'])->post('/ingredients/delete-multiple', [InfIngredientController::class, 'deleteMultiple'])->name('ingredients.deleteMultiple');

    Route::middleware(['permission:Danh Sách Khu Vực Trồng'])->get('/plantingareas', [PlantingAreaController::class, 'index'])->name('plantingareas.index');
    Route::middleware(['permission:Thêm Khu Vực Trồng'])->post('/add-plantingareas', [PlantingAreaController::class, 'save'])->name('add-plantingareas');
    // Route::middleware(['permission:Sửa Khu Vực Trồng'])->get('/edit-plantingareas/{id}', [PlantingAreaController::class, 'edit'])->name('edit-plantingareas');
    Route::middleware(['permission:Sửa Khu Vực Trồng'])->post('/update-plantingareas/{id}', [PlantingAreaController::class, 'update'])->name('update-plantingareas');
    // Route::middleware(['permission:Xóa Khu Vực Trồng'])->get('/delete-plantingareas/{id}', [PlantingAreaController::class, 'destroy'])->name('delete-plantingareas');
    Route::middleware(['permission:Xóa Khu Vực Trồng'])->post('/plantingareas/delete-multiple', [PlantingAreaController::class, 'deleteMultiple'])->name('deletedeleteMultiple');

    Route::middleware(['permission:Danh Sách Mã Lô'])->get('/batchesB', [BatchBController::class, 'index_b'])->name('batchesB.index');
    Route::middleware(['permission:Thêm Mã Lô'])->get('/add-batchesB', [BatchBController::class, 'add_b'])->name('add-batchesB');
    Route::middleware(['permission:Sửa Mã Lô'])->get('/edit-batchesB/{id}', [BatchBController::class, 'edit_b'])->name('edit-batchesB');
    // Route::middleware(['permission:Xóa Mã Lô'])->get('/delete-batchesB/{id}', [BatchBController::class, 'destroy_b'])->name('delete-batchesB');
    Route::middleware(['permission:Xóa Mã Lô'])->post('/batchB/delete-multiple', [BatchBController::class, 'deleteMultiple'])->name('batchB.deleteMultiple');

    Route::middleware(['permission:Danh Sách Kết Nối TTNL'])->get('/batches', [BatchController::class, 'index'])->name('batches.index');
    Route::middleware(['permission:Thêm Kết Nối TTNL'])->get('/add-batches', [BatchController::class, 'add'])->name('add-batches');
    // Route::middleware(['permission:Sửa Lô Hàng'])->get('/edit-batches/{id}', [BatchController::class, 'edit'])->name('edit-batches');
    Route::middleware(['permission:Sửa Kết Nối TTNL'])->post('/update-batches/{id}', [BatchController::class, 'update'])->name('update-batches');
    // Route::middleware(['permission:Xóa Kết Nối TTNL'])->get('/delete-batches/{id}', [BatchController::class, 'destroy'])->name('delete-batches');
    Route::middleware(['permission:Xóa Kết Nối TTNL'])->post('/batch/delete-multiple', [BatchController::class, 'deleteMultiple'])->name('batch.deleteMultiple');

    Route::middleware(['permission:Danh Sách Lệnh Xuất Hàng'])->get('/orderbatch', [OrderBatchController::class, 'index'])->name('orderbatchs.index');
    Route::middleware(['permission:Thêm Lệnh Xuất Hàng'])->get('/add-orderbatchs', [OrderBatchController::class, 'add'])->name('add-orderbatchs');
    Route::middleware(['permission:Sửa Lệnh Xuất Hàng'])->get('/edit-orderbatchs/{id}', [OrderBatchController::class, 'edit'])->name('edit-orderbatchs');
    // Route::middleware(['permission:Sửa Lệnh Xuất Hàng'])->post('/update-orderbatchs/{id}', [OrderBatchController::class, 'update'])->name('update-orderbatchs');
    // Route::middleware(['permission:Xóa Lệnh Xuất Hàng'])->get('/delete-orderbatchs/{id}', [OrderBatchController::class, 'destroy'])->name('delete-orderbatchs');
    Route::middleware(['permission:Xóa Lệnh Xuất Hàng'])->post('/orderbatchs/delete-multiple', [OrderBatchController::class, 'deleteMultiple'])->name('orderbatchs.deleteMultiple');

    // MDF qlcl
    Route::middleware(['permission:Danh Sách Quản Lý Chất Lượng'])->get('/untested', [TestingResultController::class, 'indexUntested'])->name('untested');
    Route::middleware(['permission:Danh Sách Quản Lý Chất Lượng'])->resource('testing', TestingResultController::class, [
        'only' => ['index'],
    ]);
    Route::middleware(['permission:Thêm Quản Lý Chất Lượng'])->resource('testing', TestingResultController::class, [
        'only' => ['create', 'store'],
    ]);
    Route::middleware(['permission:Sửa Quản Lý Chất Lượng'])->get('show-untested/{id}', [TestingResultController::class, 'showun'])->name('showun');
    Route::middleware(['permission:Xóa Quản Lý Chất Lượng'])->resource('testing', TestingResultController::class, [
        'only' => ['destroy'],
    ]);
    // MDW Loại hợp đồng
    Route::middleware(['permission:Danh Sách Loại Hợp Đồng'])->resource('contract-types', ContractTypeController::class, [
        'only' => ['index'],
    ]);
    Route::middleware(['permission:Thêm Loại Hợp Đồng'])->resource('contract-types', ContractTypeController::class, [
        'only' => ['create', 'store'],
    ]);
    Route::middleware(['permission:Sửa Loại Hợp Đồng'])->resource('contract-types', ContractTypeController::class, [
        'only' => ['edit', 'update'],
    ]);
    Route::middleware(['permission:Xóa Loại Hợp Đồng'])->resource('contract-types', ContractTypeController::class, [
        'only' => ['destroy'],
    ]);
    Route::middleware(['permission:Xóa Loại Hợp Đồng'])->post('/contracttype/delete-multiple', [ContractTypeController::class, 'deleteMultiple'])->name('contracttype.deleteMultiple');

    // Route::middleware(['permission:Xóa Loại Hợp Đồng'])->post('/contracttype/delete-multiple', [ContractTypeController::class, 'deleteMultiple'])->name('contracttype.delete-multiple');

    //Khách Hàng
    Route::middleware(['permission:Danh Sách Khách Hàng'])->resource('customers', CustomerController::class, [
        'only' => ['index'],
    ]);
    Route::middleware(['permission:Thêm Khách Hàng'])->resource('customers', CustomerController::class, [
        'only' => ['create', 'store'],
    ]);
    Route::middleware(['permission:Sửa Khách Hàng'])->resource('customers', CustomerController::class, [
        'only' => ['edit', 'update'],
    ]);
    // Route::middleware(['permission:Xóa Khách Hàng'])->resource('customers', CustomerController::class, [
    //     'only' => ['destroy'],
    // ]);
    Route::middleware(['permission:Xóa Khách Hàng'])->post('/customers/delete-multiple', [CustomerController::class, 'deleteMultiple'])->name('customers.deleteMultiple');

    //Chứng Chỉ
    Route::middleware(['permission:Danh Sách Chứng Chỉ'])->resource('certi', CertificateController::class, [
        'only' => ['index'],
    ]);
    Route::middleware(['permission:Thêm Chứng Chỉ'])->resource('certi', CertificateController::class, [
        'only' => ['create', 'store'],
    ]);
    Route::middleware(['permission:Sửa Chứng Chỉ'])->resource('certi', CertificateController::class, [
        'only' => ['edit', 'update'],
    ]);
    Route::middleware(['permission:Xóa Chứng Chỉ'])->resource('certi', CertificateController::class, [
        'only' => ['destroy'],
    ]);
    //Hop dong
    Route::middleware(['permission:Danh Sách Hợp Đồng'])->get('/cont', [ContractController::class, 'index'])->name('cont');

    Route::middleware(['permission:Thêm Hợp Đồng'])->resource('contracts', ContractController::class, [
        'only' => ['create'],
    ]);
    Route::middleware(['permission:Sửa Hợp Đồng'])->resource('contracts', ContractController::class, [
        'only' => ['edit'],
    ]);
    Route::middleware(['permission:Xóa Hợp Đồng'])->post('/contracts/delete-multiple', [ContractController::class, 'deleteMultiple'])->name('contracts.deleteMultiple');

    Route::get('/contract-dueDiligenceStatement', [DueDiliStateController::class, 'index'])->name('duedilistate.index');
    Route::get('/contract-dueDiligenceStatement/{id}', [DueDiliStateController::class, 'exportExcel'])->name('duedilistate.export');

    //midw tài khoản
    Route::middleware(['permission:Danh Sách Tài Khoản'])->get('/all-users', [UserController::class, 'all_users'])->name('all.users');
    Route::middleware(['permission:Thêm Tài Khoản'])->post('/add-users', [UserController::class, 'store'])->name('store.users');
    Route::middleware(['permission:Sửa Tài Khoản'])->get('/edit-users/{users}', [UserController::class, 'show'])->name('show.users');
    Route::middleware(['permission:Xóa Tài Khoản'])->delete('/delete-users/{users}', [UserController::class, 'delete'])->name('delete.users');
});

// Route::middleware(['isAdmin'])->get('/tx', [HomeController::class, 'index'])->name('tx');

Route::get('/password/forgot', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/forgot', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [LoginController::class, 'resetPassword'])->name('password.update');
Route::get('/forgot-password', [LoginController::class, 'forgotIndex'])->name('forgotIndex');

// Xuất excel dds trong danh sách hợp đồng
Route::get('/contract/dds/export/{code}', [ContractController::class, 'ddsExportExcel'])->name('export.dds.order');
Route::get('/contract/dds2/export/{code}', [ContractController::class, 'dds2ExportExcel'])->name('export.dds2.order');
Route::get('/contract/dds3/export/{code}', [ContractController::class, 'dds3ExportExcel'])->name('export.dds3.order');
Route::get('export/dds/order/{order_code}/batch/{batch_id}', [ContractController::class, 'getBatchDDS'])->name('export.dds.order.batch');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('permission:cache-reset');

    return "Cache cleared successfully!";
});