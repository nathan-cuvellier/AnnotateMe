<?php

namespace Tests\Feature\Account;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{

    public function testExpertAccess()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.create'))
            ->assertStatus(403);
    }


}
