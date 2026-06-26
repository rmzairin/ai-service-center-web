<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\Api\KnowledgeApiController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

use App\Services\AnalyticsService;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================
// USER ROUTES (guard: web)
// ============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/history', [ChatController::class, 'history'])->name('chat.history');

    Route::get('/chat/new', function () {
        $chatService = app(\App\Services\ChatService::class);
        $userId = Auth::id();

        $activeSession = \App\Models\M_ChatSession::where('user_id', $userId)
            ->where('status', 'active')
            ->first();

        if ($activeSession) {
            $chatService->closeSession($activeSession->id);
        }

        $chatService->createSession($userId, 'web');
        return redirect()->route('chat.index');
    })->name('chat.new');
    Route::get('/chat/{sessionId}', [ChatController::class, 'detail'])->name('chat.detail');

    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/check/{sessionId}', [FeedbackController::class, 'check'])->name('feedback.check');

});


// ============================
// ADMIN ROUTES (guard: admin)
// ============================
Route::prefix('admin')->name('admin.')->group(function () {

    // Login (tidak perlu middleware admin, karena belum login)
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    // Routes yang butuh login admin
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', function () {
            $analytics = app(AnalyticsService::class);
            return view('admin.dashboard', [
                'summary'      => $analytics->getSummary(),
                'chatPerDay'   => $analytics->getChatPerDay(7),
                'ratings'      => $analytics->getRatingDistribution(),
                'chatBySource' => $analytics->getChatBySource(),
                'recentFeedbacks' => $analytics->getRecentFeedbacks(5),
            ]);
        })->name('dashboard');

        // Kategori
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Knowledge
        Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');
        Route::get('/knowledge/create', [KnowledgeController::class, 'create'])->name('knowledge.create');
        Route::post('/knowledge', [KnowledgeController::class, 'store'])->name('knowledge.store');
        Route::get('/knowledge/{id}', [KnowledgeController::class, 'show'])->name('knowledge.show');
        Route::get('/knowledge/{id}/edit', [KnowledgeController::class, 'edit'])->name('knowledge.edit');
        Route::put('/knowledge/{id}', [KnowledgeController::class, 'update'])->name('knowledge.update');
        Route::delete('/knowledge/{id}', [KnowledgeController::class, 'destroy'])->name('knowledge.destroy');
        Route::patch('/knowledge/{id}/toggle', [KnowledgeController::class, 'toggleStatus'])->name('knowledge.toggle');


        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/upload', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
        Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        });

        Route::get('/feedback', function () {
            $feedbackService = app(\App\Services\FeedbackService::class);
            return view('admin.feedback.index', [
                'feedbacks' => $feedbackService->getAll(),
                'stats'     => $feedbackService->getStats(),
            ]);
        })->name('feedback.index');

});


require __DIR__.'/auth.php';