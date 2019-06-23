<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_a_name()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_a_email()
    {
        $this->json('POST', 'api/auth/register')
          ->assertJsonValidationErrors(['email']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_a_valid_email()
    {
        $this->json('POST', 'api/auth/register', [
        'email' => 'nope'
      ])->assertJsonValidationErrors(['email']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_a_unique_email()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register', [
        'email' => $user->email
      ])->assertJsonValidationErrors(['email']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_registered()
    {
        $test = $this->json('POST', '/api/auth/register', [
        'email' => 'testing@email.com',
        'name' => 'Testing',
        'password' => 'testing',
        'password_confirmation' => 'testing'
      ]);


        $this->assertDatabaseHas('users', [
        'email' => 'testing@email.com',
        'name' => 'Testing',
      ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_returns_a_user_on_registration()
    {
        $this->json('POST', 'api/auth/register', [
        'email' => $email = 'testing@email.com',
        'name' => 'Testing',
        'password' => 'testing',
        'password_confirmation' => 'testing'
      ])->assertJsonFragment([
        'email' => $email
      ]);
    }
}
