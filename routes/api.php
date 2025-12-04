<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum']);

Route::name("auth.")->prefix("auth")->controller(AuthController::class)->group(function () {
    Route::post("sign-in", "signIn")->name("sign-in");
    Route::post("sign-up", "signUp")->name("sign-up");
    Route::post("sign-out", "signOut")->name("sign-out")->middleware(['auth:sanctum']);
});

Route::middleware(['auth:sanctum'])->controller(TasksController::class)->group(function () {
    Route::match(["get", "post"], "tasks", "index")->name("tasks");
    Route::patch("tasks/{task}/complete", "complete")->name("tasks");
    Route::delete("tasks/{task}", "delete")->name("tasks");
});
