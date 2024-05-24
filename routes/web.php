<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tyn', function () {
    return "Hello Christian";
});

Route::redirect('/youtube', '/tyn');

Route::fallback(function () {
    return "404";
});

Route::view('/hello', 'hello', ['name' => 'Christian']);

Route::get('/hello-again', function () {
    return view('hello', ['name' => 'Christian']);
});

Route::get('/hello-world', function () {
    return view('hello.world', ['name' => 'Christian']);
});

Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
})->name('product.detail');

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, Item $itemId";
})->name('product.item.detail');

Route::get('/categories/{id}', function ($categoryId) {
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id?}', function ($userId = '404') {
    return "User $userId";
})->name('user.detail');

Route::get('/conflict/tyn', function () {
    return "Conflict Christian";
});

Route::get('/conflict/{name}', function ($name) {
    return "Conflict $name";
});

Route::get('/produk/{id}', function ($id) {
    $link = route('product.detail', [
        'id' => $id
    ]);
    return "Link : " . $link;
});

Route::get('produk-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', [
        'id' => $id
    ]);
});

Route::prefix('/controller/hello')->controller(HelloController::class)->group(function () {
    Route::get('/request', 'request');
    Route::get('/{name}', 'hello');
});


Route::prefix('/input/hello')->controller(InputController::class)->group(function () {
    Route::get('', 'hello');
    Route::post('', 'hello');
    Route::post('/first', 'helloFirstName');
    Route::post('/input', 'helloInput');
    Route::post('/array', 'helloArray');
});
Route::post('/input/type', [InputController::class, 'inputType']);
Route::prefix('/input/filter')->controller(InputController::class)->group(function () {
    Route::post('/only', 'filterOnly');
    Route::post('/except', 'filterExcept');
    Route::post('/merge', 'filterMerge');
});

Route::post('/file/upload', [FileController::class, 'upload'])
    ->withoutMiddleware(VerifyCsrfToken::class);

Route::prefix('/response')->controller(ResponseController::class)->group(function () {
    Route::get('/hello', 'response');
    Route::get('/header', 'header');
});
Route::prefix('/response/type')->controller(ResponseController::class)->group(function () {
    Route::get('/view', 'responseView');
    Route::get('/json', 'responseJson');
    Route::get('/file', 'responseFile');
    Route::get('/download', 'responseDownload');
});

Route::prefix('/cookie')->controller(CookieController::class)->group(function () {
    Route::get('/set', 'createCookie');
    Route::get('/get', 'getCookie');
    Route::get('/clear', 'clearCookie');  
});

Route::prefix('/redirect')->controller(RedirectController::class)->group(function () {
    Route::get('/from', 'redirectFrom');
    Route::get('/to', 'redirectTo');
    Route::get('/name', 'redirectName');
    Route::get('/name/{name}', 'redirectHello')
        ->name('redirect-hello');
    Route::get('/action', 'redirectAction');
    Route::get('/away', 'redirectAway');
});
Route::get('/redirect/named', function () {
    // return route('redirect-hello', ['name' => "Christian"]);
    // return url()->route('redirect-hello', ['name' => "Christian"]);
    return URL::route('redirect-hello', ['name' => "Christian"]);
});

Route::prefix('/middleware')->middleware(['tyn'])->group(function () {
    Route::get('/api', function () {
        return "OK";
    });
    
    Route::get('/group', function () {
        return "GROUP";
    });
});

Route::prefix('/form')->controller(FormController::class)->group(function () {
    Route::get('', 'form');
    Route::post('', 'submitForm');
});

Route::prefix('/url')->group(function () {
    Route::get('/action', function () {
        // return action([FormController::class, 'form'], []);
        // return url()->action([FormController::class, 'form'], []);
        return URL::action([FormController::class, 'form'], []);
    });
    Route::get('/current', function () {
        return URL::full();
    });
});

Route::prefix('/session')->controller(SessionController::class)->group(function () {
    Route::get('/create', 'createSession');
    Route::get('/get', 'getSession');
});

Route::get('/error/sample', function () {
    throw new Exception("Sample Error");
});
Route::get('/error/manual', function () {
    report(throw new Exception("Sample Error"));
    return "OK";
});
Route::get('/error/validation', function () {
    throw new ValidationException("Sample Error");
});

Route::get('/abort/400', function () {
    abort(400, "Ups Validation Exception");
});
Route::get('/abort/401', function () {
    abort(401);
});
Route::get('/abort/500', function () {
    abort(500);
});