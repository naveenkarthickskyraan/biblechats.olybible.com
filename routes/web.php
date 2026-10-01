<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/web-site', [App\Http\Controllers\WebController::class, 'web'])->name('web');

Route::any('webs-site', [App\Http\Controllers\WebController::class, 'website2'])->name('website2');

Route::any('/signup1', [App\Http\Controllers\WebController::class, 'signup1'])->name('signup1');

Route::post('/gets-chat',[App\Http\Controllers\WebController::class, 'get_chats']);

Route::post('/insert-chats',[App\Http\Controllers\WebController::class, 'insert_chats']);


Route::get('/forget-session', function (Request $request) {
    $status = "Offline Now";
    $incoming_id = Session::get('unique_id');

    if ($incoming_id) {
        DB::table('users')->where('unique_id', $incoming_id)->update(['status' => $status]);
    }

    Session::forget('unique_id');
    Session::flush();

    // Redirect back to previous page, or fallback if not available
    return redirect()->to(url()->previous() ?? route('website2'));
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users-list',[App\Http\Controllers\HomeController::class, 'users']);

Route::post('/users-search',[App\Http\Controllers\HomeController::class, 'search']);

Route::get('/chats',[App\Http\Controllers\HomeController::class, 'chats']);

Route::post('/get-chat',[App\Http\Controllers\HomeController::class, 'get_chats']);

Route::post('/insert-chat',[App\Http\Controllers\HomeController::class, 'insert_chats']);

Route::any('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('admin.logout');