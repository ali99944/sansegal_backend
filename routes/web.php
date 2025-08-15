<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/storage/*', function(Request $request) {
    $request->cor;
    return Response::download($request->fullUrl(), "", [
        'Access-Control-Allow-Origin' => '*'
    ]);
    // response::
});
