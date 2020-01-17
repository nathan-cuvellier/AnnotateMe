<?php

namespace Tests\Feature\Account;

use App\Expert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                        Expert                ////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function testExpertAccess()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->post(route('account.delete', ['id' => 5]))
            ->assertSessionHas('warning')
            ->assertStatus(302);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                        Admin                ////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function testAdminRemoveAnOtherAdmin()
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

        $admin1 = Expert::create([
            'name_exp' => 'name',
            'firstname_exp' => 'firstname',
            'bd_date_exp' => '2000/01/01',
            'sex_exp' => 'name',
            'address_exp' => '9 rue de l\'arc en ciel',
            'pc_exp' => '74000',
            'mail_exp' => 'admin1@annotate.com',
            'tel_exp' => '0601020305',
            'city_exp' => 'Annecy',
            'pwd_exp' => Hash::make('123'),
            'type_exp' => 'admin',
        ]);

        $this->withSession(['expert' => ['id' => $admin->id_exp, 'type' => $admin->type_exp]])
            ->post(route('account.delete', ['id' => $admin1->id_exp]))
            ->assertSessionHas('warning')
            ->assertStatus(302);

        $admin->delete();
        $admin1->delete();
    }


    public function testAdminRemoveAnSuperAdmin()
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

        $this->withSession(['expert' => ['id' => $admin->id_exp, 'type' => $admin->type_exp]])
            ->post(route('account.delete', ['id' => $superadmin->id_exp]))
            ->assertSessionHas('warning')
            ->assertStatus(302);

        $admin->delete();
        $superadmin->delete();
    }

}
