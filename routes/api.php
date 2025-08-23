<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\AppModelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqCategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication API Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::apiResource('promotions', PromotionController::class);

Route::apiResource('products', ProductController::class);
// Route::apiResource('variants', ProductVariantController::class)->except(['index', 'show']);
Route::apiResource('models', AppModelController::class);

// Routes to manage the many-to-many relationship between products and models
Route::post('products/{product}/models/{appModel}', [ProductController::class, 'attachModel']);
Route::delete('products/{product}/models/{appModel}', [ProductController::class, 'detachModel']);

// This route uses route model binding to automatically fetch the product by its ID.
Route::get('/products/{product}/related', [ProductController::class, 'relatedProducts']);

Route::apiResource('variants', ProductVariantController::class)->only(['store', 'update', 'destroy']);
Route::apiResource('testimonials', TestimonialController::class);


// Route::prefix('seo')->name('seo.')->group(function () {
//     Route::get('/', [SeoController::class, 'index'])->name('api.seo.show');
//     Route::get('/{key}', [SeoController::class, 'getSeoByKey'])->name('api.seo.show');
// });

// --- SEO Management Routes ---
// For public site
Route::get('/seo/by-key/{key}', [SeoController::class, 'showByKey']);

// For Control Panel
Route::apiResource('seos', SeoController::class)->only(['index', 'show', 'update']);

Route::prefix('cart')->name('api.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index'); // Get cart contents
    Route::post('/', [CartController::class, 'store'])->name('store'); // Add item
    Route::put('/items/{cartItemId}', [CartController::class, 'update'])->name('update'); // Update quantity
    Route::delete('/items/{cartItemId}', [CartController::class, 'destroy'])->name('destroy'); // Remove item
    Route::post('/clear', [CartController::class, 'clear'])->name('clear'); // Clear entire cart
});

Route::apiResource('contact-messages', ContactMessageController::class);

// Routes for managing FAQ Categories (for admin) and fetching all for frontend
Route::apiResource('faq-categories', FaqCategoryController::class);

// Routes for managing individual FAQs (for admin)
Route::apiResource('faqs', FaqController::class);


// Public-facing route for tracking an order
Route::post('/track-order', [OrderController::class, 'track']);

// Resourceful routes for the control panel (no update functionality needed)
Route::apiResource('orders', OrderController::class)->except(['update']);


/*
|--------------------------------------------------------------------------
| Dashboard API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->group(function () {
    Route::get('/kpis', [DashboardController::class, 'kpis']);
    Route::get('/recent-orders', [DashboardController::class, 'recentOrders']);
    Route::get('/top-products', [DashboardController::class, 'topProducts']);
    Route::get('/sales-over-time', [DashboardController::class, 'salesOverTime']);
});


Route::prefix('statistics')->group(function () {
    Route::get('/kpis', [StatisticsController::class, 'kpis']);
    Route::get('/top-products', [StatisticsController::class, 'topProducts']);
    Route::get('/sales-by-city', [StatisticsController::class, 'salesByCity']);
    // We can reuse the sales-over-time route from the DashboardController
});

/*
|--------------------------------------------------------------------------
| Settings API Routes
|--------------------------------------------------------------------------
*/
Route::get('/settings', [SettingsController::class, 'index']);
Route::post('/settings', [SettingsController::class, 'store']);


// Public route to fetch a policy by its slug
Route::get('/policies/by-slug/{slug}', [PolicyController::class, 'showBySlug']);

// Control Panel routes (no create/delete, only index/show/update)
Route::apiResource('policies', PolicyController::class)->except(['store', 'destroy']);


Route::apiResource('promo-codes', PromoCodeController::class);
Route::post('/promo-codes/redeem-code', [PromoCodeController::class, 'getByCode']);
