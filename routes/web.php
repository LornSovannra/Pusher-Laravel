<?php

use App\Events\ChatRoom;
use Illuminate\Support\Facades\Route;

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

Route::get('/chat-room', function () {
    return view('chat-room');
})->name('chat-room');

Route::post('/chat-room', function () {
    $message = request()->message;

    event(new ChatRoom($message));

    return redirect()->route('chat-room');
})->name('chat.send');
