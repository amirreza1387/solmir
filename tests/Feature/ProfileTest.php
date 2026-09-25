<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_view_or_update_profile(): void
    {
        $response = $this->get('/dashboard/profile');
        $response->assertRedirect('/login');

        $response = $this->patch('/dashboard/profile', [
            'name' => 'تست کاربر',
            'email' => 'test@example.com',
            'phone' => '09120000000',
        ]);
        $response->assertRedirect('/login');

        $response = $this->put('/dashboard/profile/password', [
            'current_password' => 'password',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_profile_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/profile');
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Dashboard/Profile')
            ->has('user.name')
            ->has('user.email')
            ->has('user.phone')
        );
    }

    public function test_user_can_update_own_profile_information(): void
    {
        $user = User::factory()->create([
            'name' => 'نام قدیمی',
            'email' => 'old@example.com',
            'phone' => '09121111111',
        ]);

        $response = $this->actingAs($user)->patch('/dashboard/profile', [
            'name' => 'نام جدید',
            'email' => 'new@example.com',
            'phone' => '09122222222',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertSame('نام جدید', $user->name);
        $this->assertSame('new@example.com', $user->email);
        $this->assertSame('09122222222', $user->phone);
    }

    public function test_user_can_keep_own_existing_email_and_phone(): void
    {
        $user = User::factory()->create([
            'email' => 'keepme@example.com',
            'phone' => '09123333333',
        ]);

        $response = $this->actingAs($user)->patch('/dashboard/profile', [
            'name' => 'نام بروزشده',
            'email' => 'keepme@example.com',
            'phone' => '09123333333',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('profile.edit'));
    }

    public function test_phone_number_is_normalized_with_persian_digits_and_prefix(): void
    {
        $user = User::factory()->create([
            'phone' => '09120000000',
        ]);

        $response = $this->actingAs($user)->patch('/dashboard/profile', [
            'name' => 'کاربر با شماره فارسی',
            'email' => $user->email,
            'phone' => '+۹۸۹۱۲۳۴۵۶۷۸۹',
        ]);

        $response->assertSessionHasNoErrors();
        $user->refresh();
        $this->assertSame('09123456789', $user->phone);
    }

    public function test_duplicate_email_from_another_user_is_rejected(): void
    {
        $otherUser = User::factory()->create(['email' => 'existing@example.com']);
        $currentUser = User::factory()->create(['email' => 'current@example.com']);

        $response = $this->actingAs($currentUser)->patch('/dashboard/profile', [
            'name' => $currentUser->name,
            'email' => 'existing@example.com',
            'phone' => $currentUser->phone,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_duplicate_phone_from_another_user_is_rejected(): void
    {
        $otherUser = User::factory()->create(['phone' => '09129999999']);
        $currentUser = User::factory()->create(['phone' => '09128888888']);

        $response = $this->actingAs($currentUser)->patch('/dashboard/profile', [
            'name' => $currentUser->name,
            'email' => $currentUser->email,
            'phone' => '09129999999',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_password_change_fails_with_wrong_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('CorrectPassword123!'),
        ]);

        $response = $this->actingAs($user)->put('/dashboard/profile/password', [
            'current_password' => 'WrongPassword123!',
            'password' => 'NewPassword999!',
            'password_confirmation' => 'NewPassword999!',
        ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('CorrectPassword123!', $user->fresh()->password));
    }

    public function test_password_change_succeeds_with_correct_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('OldPassword123!'),
        ]);

        $response = $this->actingAs($user)->put('/dashboard/profile/password', [
            'current_password' => 'OldPassword123!',
            'password' => 'BrandNewPassword123!',
            'password_confirmation' => 'BrandNewPassword123!',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('profile.edit'));
        $this->assertTrue(Hash::check('BrandNewPassword123!', $user->fresh()->password));
    }
}
