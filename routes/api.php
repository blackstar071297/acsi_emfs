<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EmployeeMovementFormController;
use App\Http\Controllers\MovementRecordController;
use App\Http\Controllers\MailerController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("/employees/{id}",[EmployeeController::class,'show']);
Route::post("/employees",[EmployeeController::class,'index']);
Route::post("/positions",[EmployeeController::class,'getPositions']);
Route::post("/departments",[EmployeeController::class,'getDepartments']);
Route::post("/cost-center",[EmployeeController::class,'getCostCenter']);
Route::post("/supervisor",[EmployeeController::class,'getSuperior']);
Route::post("/manager",[EmployeeController::class,'getManager']);
Route::post("/supervisor/{id}",[EmployeeController::class,'getSupervisor']);
Route::post("/is-logged-in",[LoginController::class,'isLoggedIn'])->middleware('auth:employee');
Route::post('/login',[LoginController::class,'login']);
Route::post('/get-current-user',[LoginController::class,'getCurrentUser']);
Route::post('/logout',[LoginController::class,'logout'])->middleware('auth:employee');
Route::post('/fst/employee-movement-form',[EmployeeMovementFormController::class,'fstForm'])->middleware('auth:employee');

Route::post('/register',[RegisterController::class,'store']);
Route::post('generate-user',[EmployeeController::class,'generateUser']);
Route::post('test',[EmployeeController::class,'test']);
Route::post('/check-user',[LoginController::class,'checkUser']);
Route::post('/auto-login',[LoginController::class,'autoLogin']);
Route::post('/check-token',[LoginController::class,'checkToken']);

Route::post('/return-emf',[MovementRecordController::class,'returned'])->middleware('auth:employee');
Route::post('/cancel-emf',[MovementRecordController::class,'cancelled'])->middleware('auth:employee');

Route::post('/mailer',[MailerController::class,'composeEmail']);


Route::resource('/employee-movement-form',EmployeeMovementFormController::class)->middleware('auth:employee');

Route::resource('/movement-record',MovementRecordController::class)->middleware('auth:employee');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
