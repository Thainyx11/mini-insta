<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return redirect()->route('feed');
});

// Laravel Breeze Auth routes
require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('feed');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
    Route::patch('/profile/update-bio', [ProfileController::class, 'updateBio'])->name('profile.update.bio');

    // Publication routes
    Route::get('/publication/create', [PublicationController::class, 'create'])->name('publication.create');
    Route::post('/publication/store', [PublicationController::class, 'store'])->name('publication.store');
    Route::get('/publication/{id}', [PublicationController::class, 'show'])->name('publication.show');
    Route::delete('/publication/{id}', [PublicationController::class, 'destroy'])->name('publication.delete');

    // Follow routes
    Route::post('/follow/{id}', [FollowController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{id}', [FollowController::class, 'unfollow'])->name('unfollow');

    // Comment routes
    Route::post('/publication/{publicationId}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{commentId}', [CommentController::class, 'destroy'])->name('comment.destroy'); // Suppression d'un commentaire

    // Like routes
    Route::post('/publication/{publicationId}/like', [LikeController::class, 'likePublication'])->name('like.publication');
    Route::delete('/publication/{publicationId}/unlike', [LikeController::class, 'unlikePublication'])->name('unlike.publication');

    Route::post('/comment/{commentId}/like', [LikeController::class, 'likeComment'])->name('like.comment');
    Route::delete('/comment/{commentId}/unlike', [LikeController::class, 'unlikeComment'])->name('unlike.comment');

    Route::post('/story/{storyId}/like', [LikeController::class, 'likeStory'])->name('like.story');
    Route::delete('/story/{storyId}/unlike', [LikeController::class, 'unlikeStory'])->name('unlike.story');

    // Search routes
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Feed routes
    Route::get('/feed', [FeedController::class, 'index'])->name('feed');

    // Logout routes
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Notification routes
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

});
