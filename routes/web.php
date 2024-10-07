<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    return redirect()->route('login');
}); 

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Users
Route::resource('users', 'UserController');

Route::get('logout','UserController@logout');


//Usuarios
Route::get('/users.index', function(){
    return view(view:'users.index');
});


//Productos
Route::get('/products.index', function(){
    return view(view:'products.index');
});
Route::resource('products', ProductController::class);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/data', [ProductController::class, 'data'])->name('products.data');


//Roles
Route::resource('roles', 'RoleController');

Route::get('/roles.index', function(){
    return view(view:'roles.index');
});
 
Route::get('/roles.create', function(){
    return view(view:'roles.create');
});


//Categorias
Route::get('/categorias.index', function(){
    return view(view:'categorias.index');
});