<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->post('/register', [
            'name' => 'Sally Jones',
            'email' => 'sally+4589457894578444578@gmail.com',
            'password' => '348348348',
            'password_confirmation' => '348348348',
        ]);

        $response->assertRedirect('/schedule/today');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegisterNad()
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->post('/register', [
            'name' => 'Sally Jones',
            'email' => 'sally+45894578957844578@gmail.com',
            'password' => '348348348'
        ]);

        $response->assertDontSee('/schedule/today');
    }
}
