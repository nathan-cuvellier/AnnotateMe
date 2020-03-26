<?php

namespace Tests\Feature\Account;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    /**
     *
     * @return void
     */
    public function testAccessLoginConnected()
    {
        $this->withSession(['expert' => [
            "id" => 25,
            "email" => "expert@expert.fr",
            "type" => "expert",
            "firstname" => "expert",
            "name" => "expert",
        ]])
            ->get(route('auth.login'))
            ->assertRedirect(route('project.list'));
    }

}
