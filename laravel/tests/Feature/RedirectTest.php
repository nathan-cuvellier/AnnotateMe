<?php

namespace Tests\Feature;

use Tests\TestCase;

class RedirectTest extends TestCase
{
    /**
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/')
            ->assertRedirect('/login');
    }

    public function testRedirectIfNotConnectedTest()
    {
        $response = $this->get('/project')
            ->assertRedirect('/login');

    }

    /**
     * User connected try to access
     */
    public function testRedirectIfConnectedTest()
    {
        $this->withSession(['expert' => [
            "id" => 25,
            "email" => "expert@expert.fr",
            "type" => "expert",
            "firstname" => "expert",
            "name" => "expert",
        ]])
            ->get('/')
            ->assertRedirect(route('project.list'));
    }

    /**
     * Expert try to create an account
     */
    public function test_error_unauthorized()
    {
        $this->withSession(['expert' => ['type' => 'expert']])
            ->get('/register')
            ->assertStatus(403);
    }

}
