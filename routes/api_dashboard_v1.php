<?php

use Illuminate\Support\Facades\Route;




Route::prefix('auth')->group(function(){
    Route::post('login','AuthController@Login');
    Route::post('sendVerificationCode','AuthController@SendVerificationCode');
    Route::post('activeAccount','AuthController@ActiveAccount');
    Route::post('forgetPassword','AuthController@ForgetPassword');
    Route::post('resetPassword','AuthController@ResetAccount');
});
Route::middleware('check.active.account')->group(function(){
    Route::prefix('analysis')->group(function(){
        Route::get('/cards','AnalysisController@Cards');
        Route::get('/charts','AnalysisController@Charts');
        Route::get('/branchCharts','AnalysisController@BranchCharts');
        Route::get('/latestOnGoing','AnalysisController@LatestOnGoing');
        Route::get('/latestCompleted','AnalysisController@LatestCompleted');

    });


    Route::prefix('uploads')->group(function(){
        Route::post('image','UploadsController@SaveImage');
        Route::post('images','UploadsController@SaveImages');

    });

    Route::prefix('profile')->group(function(){
        Route::get('/','ProfileController@Profile');
        Route::put('/update','ProfileController@UpdateProfile');  
        Route::put('/updateFirebaseToken','ProfileController@UpdateFirebaseToken');  
        Route::put('/updateLanguage ','ProfileController@updateLanguage');  

        
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

    Route::prefix('reservations')->group(function(){
        Route::get('/pending','ReservationController@getAllPendingReservation');
        Route::get('/ongoing','ReservationController@getAllOngoingReservation');
        Route::get('/completed','ReservationController@getAllCompletedReservation');
        Route::get('/cancelled','ReservationController@getAllCancelledReservation');
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

    Route::prefix('branchEmployee')->middleware('dashboard.admin.manager.branch_manager')->group(function(){
        Route::get('/','BranchEmployeeController@getAllBranchEmployees');
        Route::get('/branches','BranchEmployeeController@getAllBranches');
        Route::post('/','BranchEmployeeController@Add');  
        Route::delete('/','BranchEmployeeController@Delete');  
        Route::put('/active','BranchEmployeeController@Active');    
    });

    Route::prefix('branchManager')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','BranchManagerController@getAllBranchManagers');
        Route::get('/branches','BranchManagerController@getAllBranches');
        Route::post('/','BranchManagerController@Add');  
        Route::delete('/','BranchManagerController@Delete');  
        Route::put('/active','BranchManagerController@Active');    
    });

    Route::prefix('questions')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','QuestionController@getAllQuestions');
        Route::get('/data','QuestionController@getAllQuestionsWithData');
        Route::post('/','QuestionController@Add');  
        Route::post('/show','QuestionController@Show');  
        Route::delete('/','QuestionController@Delete');  
        Route::put('/','QuestionController@Edit');  
        Route::put('/arrange','QuestionController@Arrange');  
        
    });

    Route::prefix('homeAdsOne')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','HomeAdsOneController@ShowAds');
        Route::put('/','HomeAdsOneController@UpdateAds');    
    });

    Route::prefix('homeAdsTwo')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','HomeAdsTwoController@ShowAds');
        Route::put('/','HomeAdsTwoController@UpdateAds');    
    });

    Route::prefix('aboutAds')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','AboutAdsController@ShowAds');
        Route::put('/','AboutAdsController@UpdateAds');    
    });

    Route::prefix('fleetAds')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','FleetAdsController@ShowAds');
        Route::put('/','FleetAdsController@UpdateAds');    
    });

    Route::prefix('header')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','HeaderController@ShowHeader');
        Route::put('/','HeaderController@UpdateHeader');    
    });
    

    Route::prefix('manager')->middleware('dashboard.admin')->group(function(){
        Route::get('/','ManagerController@getAllManagers');
        Route::post('/','ManagerController@Add');  
        Route::delete('/','ManagerController@Delete');  
        Route::put('/active','ManagerController@Active');    
    });

    Route::prefix('admin')->middleware('dashboard.admin')->group(function(){
        Route::get('/','AdminController@getAllAdmins');
        Route::post('/','AdminController@Add');  
    });

    Route::prefix('branch')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/cities','BranchController@getAllCities');
        Route::get('/','BranchController@getAllBranches');
        Route::post('/','BranchController@Add');  
        Route::delete('/','BranchController@Delete');  
        Route::put('/','BranchController@Update');  
        Route::put('/active','BranchController@Active');    
    });

    Route::prefix('feature')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','FeatureController@getAllFeaturees');
        Route::post('/','FeatureController@Add');  
        Route::delete('/','FeatureController@Delete');  
        Route::put('/','FeatureController@Update');  
    });

    Route::prefix('carBrand')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','CarBrandController@getAllCarBrands');
        Route::post('/','CarBrandController@Add');  
        Route::delete('/','CarBrandController@Delete');  
        Route::put('/','CarBrandController@Update');  
    });

    Route::prefix('carCategory')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','CarCategoryController@getAllCarCategories');
        Route::post('/','CarCategoryController@Add');  
        Route::delete('/','CarCategoryController@Delete');  
        Route::put('/','CarCategoryController@Update');  
    });

    Route::prefix('carColor')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','CarColorController@getAllCarColors');
        Route::post('/','CarColorController@Add');  
        Route::delete('/','CarColorController@Delete');  
        Route::put('/','CarColorController@Update');  
    });

    Route::prefix('carModel')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','CarModelController@getAllCarModels');
        Route::get('/brands','CarModelController@getAllCarBrands');
        Route::post('/','CarModelController@Add');  
        Route::delete('/','CarModelController@Delete');  
        Route::put('/','CarModelController@Update');  
    });

    Route::prefix('fuelType')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','FuelTypeController@getAllFuelTypes');
        Route::post('/','FuelTypeController@Add');  
        Route::delete('/','FuelTypeController@Delete');  
        Route::put('/','FuelTypeController@Update');  
    });

    Route::prefix('modelYear')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','ModelYearController@getAllModelYears');
        Route::post('/','ModelYearController@Add');  
        Route::delete('/','ModelYearController@Delete');  
        Route::put('/','ModelYearController@Update');  
    });

    Route::prefix('transmission')->middleware('dashboard.admin.manager')->group(function(){
        Route::get('/','TransmissionController@getAllTransmissions');
        Route::post('/','TransmissionController@Add');  
        Route::delete('/','TransmissionController@Delete');  
        Route::put('/','TransmissionController@Update');  
    });


    Route::prefix('notifications')->group(function(){
        Route::get('/dashboard','ProfileController@getAllNotificationsCount');
        Route::get('/','ProfileController@getAllNotifications');
        Route::put('/','ProfileController@ReadAll');
        Route::delete('/','ProfileController@Delete');

    });





    Route::post('logout','ProfileController@Logout');

});

Route::get('guest','AuthController@NotFound')->name('guest');

Route::fallback('AuthController@NotFound');
