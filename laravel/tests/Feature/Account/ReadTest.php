<?php

namespace Tests\Feature\Account;

use App\Expert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReadTest extends TestCase
{

    /**
     * @return void
     */
    public function testExpertReadAccountWhoDoesntExist()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.read', ['id' => -1]))
            ->assertStatus(403);
    }

    public function testSuperAdminOrAdminReadAccountWhoDoesntExist()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'admin']])
            ->get(route('account.read', ['id' => -1]))
            ->assertSessionHas('warning')
            ->assertRedirect(route('account.list'));
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                        Expert                ////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function testExpertReadAccountOfAnOtherExpert()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.read', ['id' => 25]))
            ->assertStatus(403);
    }

    public function testExpertReadAccountOfAdmin()
    {
        $admin = Expert::create([
            'name_exp' => 'name',
            'firstname_exp' => 'firstname',
            'bd_date_exp' => '2000/01/01',
            'sex_exp' => 'name',
            'address_exp' => '9 rue de l\'arc en ciel',
            'pc_exp' => '74000',
            'mail_exp' => 'admin@annotate.com',
            'tel_exp' => '0601020304',
            'city_exp' => 'Annecy',
            'pwd_exp' => Hash::make('123'),
            'type_exp' => 'admin',
        ]);

        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.read', ['id' => $admin->id_exp]))
            ->assertStatus(403);

        $admin->delete();
    }

    public function testExpertReadAccountOfSuperadmin()
    {
        $superadmin = Expert::create([
            'name_exp' => 'name',
            'firstname_exp' => 'firstname',
            'bd_date_exp' => '2000/01/01',
            'sex_exp' => 'name',
            'address_exp' => '9 rue de l\'arc en ciel',
            'pc_exp' => '74000',
            'mail_exp' => 'superadmin@annotate.com',
            'tel_exp' => '0601020305',
            'city_exp' => 'Annecy',
            'pwd_exp' => Hash::make('123'),
            'type_exp' => 'superadmin',
        ]);

        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.read', ['id' => $superadmin->id_exp]))
            ->assertStatus(403);

        $superadmin->delete();
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                        Admin                  ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function testAdminReadAccountOfAnOtherAdmin()
    {
        $admin = Expert::create([
            'name_exp' => 'name',
            'firstname_exp' => 'firstname',
            'bd_date_exp' => '2000/01/01',
            'sex_exp' => 'name',
            'address_exp' => '9 rue de l\'arc en ciel',
            'pc_exp' => '74000',
            'mail_exp' => 'admin@annotate.com',
            'tel_exp' => '0601020304',
            'city_exp' => 'Annecy',
            'pwd_exp' => Hash::make('123'),
            'type_exp' => 'admin',
        ]);

        $this->withSession(['expert' => ['id' => 99, 'type' => 'admin']])
            ->get(route('account.read', ['id' => $admin->id_exp]))
            ->assertStatus(403);

        $admin->delete();
    }

    public function testAdminReadAccountOfAnOtherSuperadmin()
    {
        $admin = Expert::create([
            'name_exp' => 'name',
            'firstname_exp' => 'firstname',
            'bd_date_exp' => '2000/01/01',
            'sex_exp' => 'name',
            'address_exp' => '9 rue de l\'arc en ciel',
            'pc_exp' => '74000',
            'mail_exp' => 'admin@annotate.com',
            'tel_exp' => '0601020304',
            'city_exp' => 'Annecy',
            'pwd_exp' => Hash::make('123'),
            'type_exp' => 'admin',
        ]);

        $this->withSession(['expert' => ['id' => 99, 'type' => 'admin']])
            ->get(route('account.read', ['id' => $admin->id_exp]))
            ->assertStatus(403);

        $admin->delete();
    }


}
