<?php

namespace Tests\Feature\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{

    /**
     * testExpertAccess
     *
     * @return void
     */
    public function testUserNotConnectedAccess()
    {
        $this->get(route('project.create'))
            ->assertRedirect(route('auth.login'));
    }

    /**
     * testExpertAccess
     *
     * @return void
     */
    public function testExpertAccess()
    {
        $this->withSession(['expert' => [
            "id" => 25,
            "email" => "expert@expert.fr",
            "type" => "expert",
            "firstname" => "expert",
            "name" => "expert",
        ]])->get(route('project.create'))
            ->assertStatus(403);
    }
}
