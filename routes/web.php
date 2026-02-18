<?php

use App\Http\Controllers\ContactInvitationController;
use App\Livewire\Front\Pages\Contact;
use App\Livewire\Front\Pages\Event;
use App\Livewire\Front\Pages\Events;
use App\Livewire\Front\Pages\Home;
use App\Livewire\Front\Pages\Legal;
use App\Livewire\Front\Pages\Member;
use App\Livewire\Front\Pages\Members;
use App\Livewire\Front\Pages\Policy;
use App\Livewire\Front\Pages\Post;
use App\Livewire\Front\Pages\Posts;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::livewire('/', Home::class)
    ->name('home');

Route::get('/inscription/{invitation}', ContactInvitationController::class)
    ->middleware('signed')
    ->name('contact.invitation.accept');

Route::livewire('actualites', Posts::class)
    ->name('posts.index');
Route::livewire('actualites/{post:slug}', Post::class)
    ->name('post.show');

Route::livewire('evenements', Events::class)
    ->name('events.index');
Route::livewire('evenements/{event:slug}', Event::class)
    ->name('event.show');

Route::livewire('annuaire', Members::class)
    ->name('members.index');
Route::livewire('annuaire/membre/{member:ulid}', Member::class)
    ->name('member.show');

Route::livewire('contact', Contact::class)
    ->name('contact');

Route::livewire('mentions-legales', Legal::class)
    ->name('legal');

Route::livewire('politique-de-confidentialite', Policy::class)
    ->name('policy');

Route::get('/scheduler-edit', function () {
    Artisan::call('schedule:run');
});
