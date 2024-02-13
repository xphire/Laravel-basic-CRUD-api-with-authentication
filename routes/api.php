<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RemoveXPowered;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::get("/getAllBooks", [BookController::class,"index"]);

// Route::get("/getBookById", function (Request $request) {

//     $id = $request->param

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Public Routes

Route::post("/register", [AuthController::class,"register"])->middleware(RemoveXPowered::class);

Route::get("/searchProduct/{name}", [BookController::class,"search"]);

Route::get("/getAllBooks", [BookController::class,"index"])->middleware(RemoveXPowered::class);

Route::get("/getBookById/{id}", [BookController::class,"show"]);

Route::post("/login", [AuthController::class,"login"]);

//Protected Routes

Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::patch("/updateBookById/{id}", [BookController::class,"update"]);

    Route::delete("/deleteBookById/{id}", [BookController::class,"destroy"]);

    Route::post("/addNewBook", [BookController::class,"store"]);

    Route::post("/logout", [AuthController::class,"logout"]);
    
})->middleware(RemoveXPowered::class);
