<?php

use App\Models\Person;
use function Pest\Laravel\patch;

beforeEach(
    fn () => $this->person = tap(Person::factory()->create())->delete()
);

test('guests cannot restore person', function () {
    patch("people/{$this->person->id}/restore")
        ->assertStatus(302)
        ->assertRedirect('login');

    expect($this->person->fresh()->trashed())->toBeTrue();
});

test('users without permissions cannot restore person', function () {
    withPermissions(2)
        ->patch("people/{$this->person->id}/restore")
        ->assertStatus(403);

    expect($this->person->fresh()->trashed())->toBeTrue();
});

test('users with permissions can restore person', function () {
    withPermissions(3)
        ->patch("people/{$this->person->id}/restore")
        ->assertStatus(302)
        ->assertRedirect("people/{$this->person->id}");

    expect($this->person->fresh()->trashed())->toBeFalse();
});

test('person can be restored only when deleted', function () {
    $this->person->restore();

    withPermissions(3)
        ->patch("people/{$this->person->id}/restore")
        ->assertStatus(404);
});

test('person restoration is logged', function () {
    $this->person->restore();

    $log = latestLog();

    expect($log->log_name)->toBe('people');
    expect($log->description)->toBe('restored');
    expect($this->person->is($log->subject))->toBeTrue();

    expect($log->properties['attributes']['deleted_at'])->toBeNull();

    expect($log->properties)->toHaveCount(1);
    expect($log->properties['attributes'])->toHaveCount(1);
});
