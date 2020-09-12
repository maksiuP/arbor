<?php

use App\User;
use Illuminate\Auth\Events\Login;

test('authenticated users are redirected when trying to access form', function () {
    withPermissions(0)
        ->get('/login')
        ->assertStatus(302)
        ->assertRedirect('/people');

    assertAuthenticated();
});

test('authenticated users are redirected when trying to log in', function () {
    withPermissions(0)
        ->post('/login')
        ->assertStatus(302)
        ->assertRedirect('/people');

    assertAuthenticated();
});

it('requires email', function () {
    from('/login')
        ->post('/login', [
            'password' => 'password',
        ])
        ->assertSessionHasErrors('username')
        ->assertStatus(302)
        ->assertRedirect('/login');

    assertGuest();
});

it('requires password', function () {
    from('/login')
        ->post('/login', [
            'username' => 'gracjan',
        ])
        ->assertSessionHasErrors('password')
        ->assertStatus(302)
        ->assertRedirect('/login');

    assertGuest();
});

it('checks if user exists', function () {
    from('/login')
        ->post('/login', [
            'username' => 'gracjan',
            'password' => 'hasło',
        ])
        ->assertSessionHasErrors('username')
        ->assertStatus(302)
        ->assertRedirect('/login');

    assertGuest();
});

it('checks password', function () {
    $user = User::factory()->create([
        'username' => 'gracjan',
    ]);

    from('/login')
        ->post('/login', [
            'username' => 'gracjan',
            'password' => 'wrong',
        ])
        ->assertSessionHasErrors('username')
        ->assertStatus(302)
        ->assertRedirect('/login');

    assertGuest();
});

test('user can log in with correct credentials', function () {
    $user = User::factory()->create([
        'username' => 'gracjan',
        'password' => Hash::make($password = 'secret'),
    ]);

    Event::fake();

    post('/login', [
        'username' => 'gracjan',
        'password' => 'secret',
    ])->assertSessionHasNoErrors()
        ->assertStatus(302)
        ->assertRedirect('/people');

    assertAuthenticatedAs($user);

    Event::assertDispatched(fn (Login $event) => $event->user->is($user));
});
