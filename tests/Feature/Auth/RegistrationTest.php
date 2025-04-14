<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
{
    $response = $this->post('/register', [
        'name' => 'Test User',
        'UserEmail' => 'test@example.com',  // Đảm bảo trường này khớp với tên cột trong DB
        'UserPhone' => '1234567890',  // Thêm trường UserPhone
        'UserAddress' => '123 Test Street',  // Thêm trường UserAddress
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
}

}
