<?php

namespace Tests\Feature\Account;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetTest extends TestCase
{
    /**
     * Test on reset form, when user enter an email
     *
     * @return void
     */
    public function testAccessResetBeingConnected()
    {
        $this->withSession(['expert' => [
            "id" => 25,
            "email" => "expert@expert.fr",
            "type" => "expert",
            "firstname" => "expert",
            "name" => "expert",
        ]])
            ->get(route('account.reset'))
            ->assertRedirect(route('project.list'));
    }

    /**
     * Test on reset form, when user enter a new password
     *
     * @return void
     */
    public function testAccessResetTokenBeingConnected()
    {
        $this->withSession(['expert' => [
            "id" => 25,
            "email" => "expert@expert.fr",
            "type" => "expert",
            "firstname" => "expert",
            "name" => "expert",
        ]])
            ->get(route('account.reset.token'))
            ->assertRedirect(route('project.list'));
    }
}
