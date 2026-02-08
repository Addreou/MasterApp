<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginTest extends TestCase{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $this->get(route('login'))
            ->assertStatus(200);
    }

    public function test_user_can_login_with_correct_credentials()
    {
        // Arrange
        $user = User::create([
            'first_name' => 'Testing',
            'last_name' => 'Test',
            'email' => 'testing.test@test.com',
            'username' => 'testing.test',
            'password' => bcrypt('password123'),
        ]);

        // Act
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Assert
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('app.dashboard'));
    }

    public function test_logged_in_user_cannot_view_login_screen()
    {
        // Arrange
        $user = User::create([
            'first_name' => 'Testing',
            'last_name' => 'Test',
            'email' => 'testing.test@test.com',
            'username' => 'testing.test',
            'password' => bcrypt('password123'),
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get(route('login'));

        // Assert
        $response->assertStatus(302);
        $response->assertRedirect(route('app.dashboard'));
    }

    public function test_user_can_logout()
    {
        // Arrange
        $user = User::create([
            'first_name' => 'Testing',
            'last_name' => 'Test',
            'email' => 'testing.test@test.com',
            'username' => 'testing.test',
            'password' => bcrypt('password123'),
        ]);

        // Act
        $response = $this->actingAs($user)
            ->post('/logout');

        // Assert
        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_login_requires_email_and_password()
    {
        // Act
        $response = $this->post(route('login'), [
            'email' => '',
            'password' => '',
        ]);

        // Assert
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Arrange
        $user = User::create([
            'first_name' => 'Testing',
            'last_name' => 'Test',
            'email' => 'testing.test@test.com',
            'username' => 'testing.test',
            'password' => bcrypt('password123'),
        ]);

        // Act
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        // Assert
        $response->assertSessionHasErrors('failed');
        $this->assertGuest();
    }

    public function test_login_attempts_are_rate_limited_after_too_many_failures()
    {
        // Arrange
        $user = User::create([
            'first_name' => 'Testing',
            'last_name' => 'Test',
            'email' => 'testing.test@test.com',
            'username' => 'testing.test',
            'password' => bcrypt('password123'),
        ]);

        RateLimiter::clear($user->email . '|127.0.0.1');

        // Act
        $maxAttempts = 6;
        foreach (range(1, $maxAttempts) as $attempt) {
            $response = $this->post(route('login'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        }
        $this->assertEquals(429, $response->status());
    }
}
