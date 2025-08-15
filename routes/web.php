<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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


Route::get('/foo', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');

    if (!file_exists($link)) {
        symlink($target, $link);
    }

    return 'Link created';
});
