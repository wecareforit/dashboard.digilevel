<?php

declare(strict_types=1);

use App\Filament\Tenant\Resources\Posts\Pages\CreatePost;
use App\Filament\Tenant\Resources\Posts\Pages\EditPost;
use App\Filament\Tenant\Resources\Posts\Pages\ListPosts;
use App\Filament\Tenant\Resources\Users\Pages\CreateUser;
use App\Filament\Tenant\Resources\Users\Pages\EditUser;
use App\Filament\Tenant\Resources\Users\Pages\ListUsers;
use App\Models\Post;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Pages\Dashboard;
use Livewire\Livewire;

test('only the owner can access the admin panel', function () {
    $owner = User::first();
    $randomUser = User::factory()->create();

    // Guests are redirected to login
    $this->get(Dashboard::getUrl())
        ->assertRedirect(route('tenant.login'));

    $this->actingAs($owner)
        ->get(Dashboard::getUrl())
        ->assertSuccessful();

    // Non-owners get 403 forbidden
    $this->actingAs($randomUser)
        ->get(Dashboard::getUrl())
        ->assertForbidden();
});

// Posts
test('posts are listed correctly in the admin panel', function () {
    $owner = User::first();

    $owner->posts()->create(['title' => 'foo', 'body' => 'foo post']);

    // Tenant seeder creates 3 posts, we created 1, so there's a total of 4 posts
    expect($owner->posts()->count())->toBe(4);

    Livewire::test(ListPosts::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords($owner->posts) // All posts are listed
        ->assertCountTableRecords(4);
});

test('posts can be created through admin panel', function () {
    $owner = User::first();

    Livewire::test(CreatePost::class)
        ->assertOk()
        ->fillForm([
            'title' => $title = 'new post',
            'body' => $body = 'post created through the admin panel',
            'user_id' => $owner->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    // Post got created
    expect($owner->posts()->where(['title' => $title, 'body' => $body]))->not()->toBeNull();
});

test('posts can be edited through admin panel', function () {
    $owner = User::first();

    $post = Post::create([
        'title' => 'foo',
        'body' => 'foo text',
        'user_id' => $owner->id,
    ]);

    Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])
        ->fillForm([
            'title' => 'bar',
            'body' => 'bar text',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $post->refresh();

    expect($post->title)->toBe('bar')
        ->and($post->body)->toBe('bar text');
});

test('posts can be deleted through admin panel', function () {
    $owner = User::first();

    $post = Post::create([
        'title' => 'foo',
        'body' => 'foo text',
        'user_id' => $owner->id,
    ]);

    Livewire::test(ListPosts::class)
        ->assertActionVisible(TestAction::make('delete')->table($post))
        ->callAction(TestAction::make('delete')->table($post))
        ->assertSuccessful();

    expect(Post::find($post->id))->toBeNull();
});

// Users
test('users are listed correctly in the admin panel', function () {
    User::factory()->create(['email' => 'user1@example.test']);
    User::factory()->create(['email' => 'user2@example.test']);

    Livewire::test(ListUsers::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords(User::all())
        ->assertCountTableRecords(3); // 1 owner user + 2 created users
});

test('users can be created through admin panel', function () {
    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'testing',
            'email' => 'foo@bar.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(User::where(['name' => 'testing', 'email' => 'foo@bar.test'])->first())->not()->toBeNull();
});

test('users can be edited through admin panel', function () {
    $user = User::factory()->create([
        'name' => 'foo',
        'email' => 'foo@email.test',
    ]);

    Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
        ->fillForm([
            'name' => 'bar',
            'email' => 'bar@email.test',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $user->refresh();

    expect($user->name)->toBe('bar')
        ->and($user->email)->toBe('bar@email.test');
});

test('only non-owner users can be deleted through admin panel', function () {
    $owner = User::first();
    $user = User::factory()->create(['email' => 'foo@email.test']);

    Livewire::test(ListUsers::class)
        ->assertActionVisible(TestAction::make('delete')->table($user))
        ->callAction(TestAction::make('delete')->table($user))
        ->assertHasNoFormErrors()
        // Owner delete action is hidden
        ->assertActionHidden(TestAction::make('delete')->table($owner))
        // Deleting the owner using bulk deletes can be attempted
        // But it doesn't work (an exception is thrown and caught by Filament, user will get the "Failed to delete" notification)
        ->assertActionVisible(TestAction::make('delete')->table($owner)->bulk())
        ->callAction(TestAction::make('delete')->table($owner)->bulk());

    // Non-owner was deleted, owner was not
    expect(User::find($user->id))->toBeNull();
    expect(User::find($owner->id))->not()->toBeNull();
});

test('admin panel resources are properly scoped to tenant', function () {
    $tenant2 = $this->createTenant(['email' => 'tenant2@example.test']);

    // Create a post as tenant1 (current tenant)
    $owner = User::first();
    $post1 = $owner->posts()->create([
        'title' => 'Foo post',
        'body' => 'Post that belongs to tenant1',
    ]);

    // Switch to tenant2, the post from tenant1 shouldn't show up
    tenancy()->initialize($tenant2);

    // tenant2 shouldn't see tenant1's posts
    Livewire::test(ListPosts::class)
        ->assertSuccessful()
        ->assertCanNotSeeTableRecords([$post1])
        ->assertCountTableRecords(3); // Just the 3 seeded posts
});
