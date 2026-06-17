<?php

use App\Http\Controllers\Api\KnowledgeApiController;
use Illuminate\Support\Facades\Route;

Route::get('/knowledge-active', [KnowledgeApiController::class, 'active']);