<?php

namespace Tests\Feature\Account;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{

    /**
     * The user of type "expert" isn't allowed to create a new account
     * 
     * Test with a fake user of type expert
     * 
     * @return void
     */
    public function testExpertAccess()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.create'))
            ->assertForbidden();
    }


}
