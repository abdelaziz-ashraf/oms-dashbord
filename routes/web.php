<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', [LandingPageController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/section/{section}', [LandingPageController::class, 'showSection'])->name('admin.section');
    
    Route::put('/admin/announcement', [SectionController::class, 'updateAnnouncement'])->name('admin.announcement.update');
    Route::put('/admin/hero', [SectionController::class, 'updateHero'])->name('admin.hero.update');
    Route::put('/admin/problem', [SectionController::class, 'updateProblem'])->name('admin.problem.update');
    Route::put('/admin/features', [SectionController::class, 'updateFeatures'])->name('admin.features.update');
    Route::put('/admin/packages', [SectionController::class, 'updatePackages'])->name('admin.packages.update');
    Route::put('/admin/audience', [SectionController::class, 'updateTargetAudience'])->name('admin.audience.update');
    Route::put('/admin/social-proof', [SectionController::class, 'updateSocialProof'])->name('admin.social-proof.update');
    Route::put('/admin/why-us', [SectionController::class, 'updateWhyUs'])->name('admin.why-us.update');
    Route::put('/admin/how-it-works', [SectionController::class, 'updateHowItWorks'])->name('admin.how-it-works.update');
    Route::put('/admin/comparison', [SectionController::class, 'updateComparison'])->name('admin.comparison.update');
    Route::put('/admin/faq', [SectionController::class, 'updateFaq'])->name('admin.faq.update');
    Route::put('/admin/cta', [SectionController::class, 'updateCta'])->name('admin.cta.update');
    Route::put('/admin/contact', [SectionController::class, 'updateContact'])->name('admin.contact.update');
    Route::put('/admin/footer', [SectionController::class, 'updateFooter'])->name('admin.footer.update');

    Route::get('/admin/contact-messages', [ContactMessageController::class, 'index'])->name('admin.contact-messages.index');
    Route::get('/admin/contact-messages/export', [ContactMessageController::class, 'export'])->name('admin.contact-messages.export');
    Route::get('/admin/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('admin.contact-messages.show');
    Route::post('/admin/contact-messages/{contactMessage}/reply', [ContactMessageController::class, 'reply'])->name('admin.contact-messages.reply');
    Route::patch('/admin/contact-messages/{contactMessage}/status', [ContactMessageController::class, 'updateStatus'])->name('admin.contact-messages.status');
    Route::delete('/admin/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('admin.contact-messages.destroy');

    Route::get('/admin/portfolio/{module}', [PortfolioController::class, 'index'])->name('admin.portfolio.index');
    Route::put('/admin/portfolio/{module}/settings', [PortfolioController::class, 'updateSettings'])->name('admin.portfolio.settings');
    Route::post('/admin/portfolio/{module}', [PortfolioController::class, 'store'])->name('admin.portfolio.store');
    Route::put('/admin/portfolio/{module}/{id}', [PortfolioController::class, 'update'])->name('admin.portfolio.update');
    Route::delete('/admin/portfolio/{module}/{id}', [PortfolioController::class, 'destroy'])->name('admin.portfolio.destroy');
});

require __DIR__.'/auth.php';
