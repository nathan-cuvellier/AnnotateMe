<?php

namespace Tests\Feature\Account;

use App\Expert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadTest extends TestCase
{

    /*
     * 1 => superadmin
     * 5|28 => admin
     * 25|27 => expert
     */

    /**
     * @return void
     */
    public function testExpertReadAccountWhoDoesntExist()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.read', ['id' => 9999]))
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testSuperAdminOrAdminReadAccountWhoDoesntExist()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'admin']])
            ->get(route('account.read', ['id' => 9999]))
            ->assertSessionHas('warning')
            ->assertRedirect(route('account.list'));
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                        Expert                ////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @return void
     */
    public function testExpertReadAccountOfAnOtherExpert()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.read', ['id' => 25]))
            ->assertStatus(403);
    }

    /**
     * @return void
     */
    public function testExpertReadAccountOfAdmin()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.read', ['id' => 5]))
            ->assertStatus(403);
    }

    /**
     * @return void
     */
    public function testExpertReadAccountOfSuperadmin()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.read', ['id' => 1]))
            ->assertStatus(403);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                        Admin                  ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @return void
     */
    public function testAdminReadAccountOfAnOtherAdmin()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'admin']])
            ->get(route('account.read', ['id' => 5]))
            ->assertStatus(403);
    }

    /**
     * @return void
     */
    public function testAdminReadAccountOfAnOtherSuperadmin()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'admin']])
            ->get(route('account.read', ['id' => 1]))
            ->assertStatus(403);
    }

}
