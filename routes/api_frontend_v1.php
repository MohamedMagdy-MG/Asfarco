<?php

use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function(){
    Route::get('nationalities','AuthController@getAllNationalities');
    Route::post('login','AuthController@Login');
    Route::post('socialLogin','AuthController@SocialLogin');
    Route::post('register','AuthController@Register');
    Route::post('sendVerificationCode','AuthController@SendVerificationCode');
    Route::post('activeAccount','AuthController@ActiveAccount');
    Route::post('forgetPassword','AuthController@ForgetPassword');
    Route::post('resetPassword','AuthController@ResetAccount');
});

Route::prefix('uploads')->group(function(){
    Route::post('image','UploadsController@SaveImage');
    Route::post('images','UploadsController@SaveImages');

});

Route::prefix('profile')->group(function(){
    Route::get('/','ProfileController@Profile');
    Route::prefix('reservation')->group(function(){
        Route::get('/pending','ProfileController@GetPendingReservations');
        Route::get('/ongoing','ProfileController@GetOngoingReservations');
        Route::get('/completed','ProfileController@GetCompletedReservations');
        Route::get('/cancelled','ProfileController@GetCancelledReservations');
        Route::post('/','ProfileController@ReservationDetails');
    });
    Route::put('/','ProfileController@UpdateProfile');  
    Route::put('/firebaseToken','ProfileController@UpdateFirebaseToken');  
    Route::put('/language','ProfileController@UpdateLanguage');  
    Route::put('/location','ProfileController@UpdateLocation');  
    Route::get('/cities','ProfileController@getAllCities');
    Route::put('/password','ProfileController@UpdatePassword');  
    Route::put('/resetPassword','ProfileController@UpdatePasswordWithOutCurrentPassword');  
    
    Route::prefix('payment')->group(function(){
        Route::post('/','ProfileController@AddPayment');  
        Route::put('/','ProfileController@UpdatePayment');  
        Route::delete('/','ProfileController@DeletePayment');  
    });

    Route::prefix('address')->group(function(){
        Route::post('/','ProfileController@AddAddress');  
        Route::put('/','ProfileController@UpdateAddress');  
        Route::delete('/','ProfileController@DeleteAddress');  
    });
});

Route::prefix('home')->group(function(){
    Route::get('/categories','HomeController@getAllCategories');
    Route::get('/cars','HomeController@getAllHomePageCars');
    
});

Route::prefix('reservation')->group(function(){
    Route::get('/address','ReservationController@Address');
    Route::get('/payment','ReservationController@Payments');
    Route::post('/features','ReservationController@Features');
    Route::post('/','ReservationController@Reserve');
    Route::post('/cancel','ReservationController@Cancel');
    Route::post('/car','ReservationController@CheckCarReservation');
    Route::post('/fatora','ReservationController@Fatora');
    
});

Route::prefix('cars')->group(function(){
    Route::get('/','HomeController@getAllCars');

    Route::prefix('filter')->group(function(){
        Route::get('/categories','HomeController@getAllCategoriesWithID');
        Route::get('/fueltypes','HomeController@getAllFuelTypes');
        Route::get('/brands','HomeController@getAllBrands');
        Route::get('/models','HomeController@getAllModels');
        Route::get('/modelyears','HomeController@getAllModelYears');
        Route::get('/transmissions','HomeController@getAllTransmissions');
        Route::get('/features','HomeController@getAllFeatures');
        Route::get('/colors','HomeController@getAllColors');
    });
    Route::get('/details/cars','HomeController@getAllCarDetailsPageCars');
    
});

Route::prefix('aboutus')->group(function(){
    Route::get('/cars','HomeController@getAllAboutUsPageCars');
    
});

Route::prefix('savedcars')->group(function(){
    Route::get('/cars','HomeController@getAllSavedCarsPageCars');
    Route::get('/','ProfileController@GetFavourites');
    Route::post('/','ProfileController@Favourite');
    
});


Route::post('logout','ProfileController@Logout');


Route::get('guest','AuthController@NotFound')->name('guest');

Route::fallback('AuthController@NotFound');
