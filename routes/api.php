<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Anime;
use App\Models\User;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/animes', function(){
    return Anime::whereNull('posted_at')
    ->orderBy('created_at', 'desc')
    ->take(24)
    ->get();
});
Route::get('/anime/{id}', function($id){
    return response()->json(Anime::where('id', '=', $id)
    ->first());
});
Route::get('/anime/{id}/tag', function($id){

    $anime = Anime::where('id', '=', $id)->firstorFail();

    $animetags = array();

    foreach($anime->tags as $tag){
        $record = $tag->name;
        $animetags[] = $record;
    };

    return Response::json($animetags);

});

Route::get('/users', function(){
    return User::orderBy('created_at', 'desc')->get();
});