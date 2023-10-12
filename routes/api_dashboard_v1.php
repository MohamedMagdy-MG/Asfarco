<?php

use Illuminate\Support\Facades\Route;




Route::prefix('auth')->group(function(){
    Route::post('login','AuthController@Login');
    Route::post('sendVerificationCode','AuthController@SendVerificationCode');
    Route::post('activeAccount','AuthController@ActiveAccount');
    Route::post('forgetPassword','AuthController@ForgetPassword');
    Route::post('resetPassword','AuthController@ResetAccount');
});


   
Route::prefix('analysis')->group(function(){
    Route::get('/cards','AnalysisController@Cards');
});


Route::prefix('uploads')->group(function(){
    Route::post('image','UploadsController@SaveImage');
    Route::post('images','UploadsController@SaveImages');

});

Route::prefix('profile')->group(function(){
    Route::get('/','ProfileController@Profile');
    Route::put('/update','ProfileController@UpdateProfile');  
    Route::put('/updateFirebaseToken','ProfileController@UpdateFirebaseToken');  

    
});

Route::prefix('user')->group(function(){
    Route::get('/getAllPendingUsers','UserController@getAllPendingUsers');
    Route::get('/getAllDeactiveUsers','UserController@getAllDeactiveUsers');
    Route::get('/getAllUnVerificationsUsers','UserController@getAllUnVerificationsUsers');
    Route::get('/getAllActiveUsers','UserController@getAllActiveUsers');
    Route::post('/document','UserController@ViewDocument');  
    Route::put('/document','UserController@VerifyDocument');  
    Route::put('/active','UserController@Active');    
});


Route::prefix('car')->group(function(){
    Route::get('/categories','CarController@getAllCategories');
    Route::get('/fuelTypes','CarController@getAllFuelTypes');
    Route::get('/brands','CarController@getAllBrands');
    Route::get('/models','CarController@getAllModels');
    Route::get('/modelYears','CarController@getAllModelYears');
    Route::get('/transmissions','CarController@getAllTransmissions');
    Route::get('/branches','CarController@getAllBranches');
    Route::get('/features','CarController@getAllFeatures');
    Route::get('/colors','CarController@getAllColors');
    Route::get('/','CarController@getAllCars');
    Route::post('/show','CarController@Show');
    Route::post('/','CarController@Add');  
    Route::put('/','CarController@Update');  
    Route::delete('/','CarController@Delete');  
    Route::put('/active','CarController@Active');    
});

Route::prefix('branchEmployee')->group(function(){
    Route::get('/','BranchEmployeeController@getAllBranchEmployees');
    Route::get('/branches','BranchEmployeeController@getAllBranches');
    Route::post('/','BranchEmployeeController@Add');  
    Route::delete('/','BranchEmployeeController@Delete');  
    Route::put('/active','BranchEmployeeController@Active');    
});

Route::prefix('branchManager')->group(function(){
    Route::get('/','BranchManagerController@getAllBranchManagers');
    Route::get('/branches','BranchManagerController@getAllBranches');
    Route::post('/','BranchManagerController@Add');  
    Route::delete('/','BranchManagerController@Delete');  
    Route::put('/active','BranchManagerController@Active');    
});


Route::prefix('manager')->group(function(){
    Route::get('/','ManagerController@getAllManagers');
    Route::post('/','ManagerController@Add');  
    Route::delete('/','ManagerController@Delete');  
    Route::put('/active','ManagerController@Active');    
});

Route::prefix('admin')->group(function(){
    Route::get('/','AdminController@getAllAdmins');
    Route::post('/','AdminController@Add');  
});

Route::prefix('branch')->group(function(){
    Route::get('/cities','BranchController@getAllCities');
    Route::get('/','BranchController@getAllBranches');
    Route::post('/','BranchController@Add');  
    Route::delete('/','BranchController@Delete');  
    Route::put('/','BranchController@Update');  
    Route::put('/active','BranchController@Active');    
});

Route::prefix('feature')->group(function(){
    Route::get('/','FeatureController@getAllFeaturees');
    Route::post('/','FeatureController@Add');  
    Route::delete('/','FeatureController@Delete');  
    Route::put('/','FeatureController@Update');  
});

Route::prefix('carBrand')->group(function(){
    Route::get('/','CarBrandController@getAllCarBrands');
    Route::post('/','CarBrandController@Add');  
    Route::delete('/','CarBrandController@Delete');  
    Route::put('/','CarBrandController@Update');  
});

Route::prefix('carCategory')->group(function(){
    Route::get('/','CarCategoryController@getAllCarCategories');
    Route::post('/','CarCategoryController@Add');  
    Route::delete('/','CarCategoryController@Delete');  
    Route::put('/','CarCategoryController@Update');  
});

Route::prefix('carColor')->group(function(){
    Route::get('/','CarColorController@getAllCarColors');
    Route::post('/','CarColorController@Add');  
    Route::delete('/','CarColorController@Delete');  
    Route::put('/','CarColorController@Update');  
});

Route::prefix('carModel')->group(function(){
    Route::get('/','CarModelController@getAllCarModels');
    Route::get('/brands','CarModelController@getAllCarBrands');
    Route::post('/','CarModelController@Add');  
    Route::delete('/','CarModelController@Delete');  
    Route::put('/','CarModelController@Update');  
});

Route::prefix('fuelType')->group(function(){
    Route::get('/','FuelTypeController@getAllFuelTypes');
    Route::post('/','FuelTypeController@Add');  
    Route::delete('/','FuelTypeController@Delete');  
    Route::put('/','FuelTypeController@Update');  
});

Route::prefix('modelYear')->group(function(){
    Route::get('/','ModelYearController@getAllModelYears');
    Route::post('/','ModelYearController@Add');  
    Route::delete('/','ModelYearController@Delete');  
    Route::put('/','ModelYearController@Update');  
});

Route::prefix('transmission')->group(function(){
    Route::get('/','TransmissionController@getAllTransmissions');
    Route::post('/','TransmissionController@Add');  
    Route::delete('/','TransmissionController@Delete');  
    Route::put('/','TransmissionController@Update');  
});





Route::post('logout','ProfileController@Logout');

Route::get('guest','AuthController@NotFound')->name('guest');

Route::fallback('AuthController@NotFound');
