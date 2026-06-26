<?php

use App\Http\Controllers\Api\KnowledgeApiController;
use App\Http\Controllers\Api\DocumentApiController;
use Illuminate\Support\Facades\Route;

Route::get('/knowledge-active', [KnowledgeApiController::class, 'active']);
Route::get('/documents-processed', [DocumentApiController::class, 'processed']);