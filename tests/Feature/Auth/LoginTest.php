<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_an_email()
    {
        $this->json('POST', 'api/auth/login')
        ->assertJsonValidationErrors(['email']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_a_password()
    {
        $this->json('POST', 'api/auth/login')
        ->assertJsonValidationErrors(['password']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_returns_a_validation_error_if_credentials_dont_match()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'nope'
        ])->assertJsonValidationErrors(['email']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_returns_a_validation_error_if_credentials_dont_matchs()
    {
        $user = factory(User::class)->create([
          'password' => 'cats'
        ]);

        $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'cats'
        ])->assertJsonFragment([
          'email' => $user->email
        ]);
    }
}
