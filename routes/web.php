
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    Route::resource('products', ProductController::class);


    /*
    |--------------------------------------------------------------------------
    | Brands
    |--------------------------------------------------------------------------
    */

    Route::resource('brands', BrandController::class);


    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    Route::resource('categories', CategoryController::class);


    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */

    Route::resource('customers', CustomerController::class);


    /*
    |--------------------------------------------------------------------------
    | Inventory
    |--------------------------------------------------------------------------
    */

    // Inventory Dashboard
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');


    // Stock In
    Route::get('/inventory/stock-in', [InventoryController::class, 'stockIn'])
        ->name('inventory.stock-in');

    Route::post('/inventory/stock-in', [InventoryController::class, 'storeStockIn'])
        ->name('inventory.stock-in.store');


    // Stock Adjustment
    Route::get('/inventory/adjustment', [InventoryController::class, 'adjustment'])
        ->name('inventory.adjustment');

    Route::post('/inventory/adjustment', [InventoryController::class, 'storeAdjustment'])
        ->name('inventory.adjustment.store');


    // Stock Movements
    Route::get('/inventory/movements', [InventoryController::class, 'movements'])
        ->name('inventory.movements');


    // Stock Out
    Route::get('/inventory/stock-out', [InventoryController::class, 'stockOut'])
        ->name('inventory.stock-out');

    Route::post('/inventory/stock-out', [InventoryController::class, 'storeStockOut'])
        ->name('inventory.stock-out.store');


    /*
    |--------------------------------------------------------------------------
    | Sales / POS
    |--------------------------------------------------------------------------
    */

    // POS
    Route::get('/sales/pos', [SaleController::class, 'index'])
        ->name('sales.pos');


    // Sales Index
    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index');


    // Store Sale
    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store');


    // Sales History
    Route::get('/sales/history', [SaleController::class, 'history'])
        ->name('sales.history');


    // Sale Details
    Route::get('/sales/{sale}', [SaleController::class, 'show'])
        ->name('sales.show');


    // Receipt
    Route::get('/sales/{sale}/receipt', [SaleController::class, 'receipt'])
        ->name('sales.receipt');


    // Delete Sale
    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])
        ->name('sales.destroy');


    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    // Reports Dashboard
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');


    // Export Reports to CSV
    Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])
        ->name('reports.export.csv');

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
