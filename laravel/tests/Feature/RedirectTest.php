<?php

namespace Tests\Feature;

use Tests\TestCase;

class RedirectTest extends TestCase
{

    public function testRedirectIfNotConnectedTest()
    {
        $response = $this->get(route('project.list'))
            ->assertRedirect(route('auth.login'));
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

}
