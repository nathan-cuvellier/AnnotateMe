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

    /**
     * The user of type "expert" can delete only this account
     * 
     * Test with an user of type expert
     * 
     * @return void
     */
    public function testExpertAccess()
    {
        try {
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
            ->post(route('account.delete', ['id' => $admin->id_exp]))
            ->assertSessionHas('warning')
            ->assertStatus(302);
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $admin->delete();
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                        Admin                ////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * The user of type "admin" can delete only this account or expert account
     * 
     * Test with an user of type admin to delete an other account of type admin
     * 
     * @return void
     */
    public function testAdminRemoveAnOtherAdmin()
    {
        try {
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
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $admin->delete();
            $admin1->delete();
        }        
    }

    /**
     * The user of type "admin" can delete only this account or expert account
     * 
     * Test with an user of type admin to delete an other account of type superadmin
     * 
     * @return void
     */
    public function testAdminRemoveAnSuperAdmin()
    {
        try {
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
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $admin->delete();
            $superadmin->delete();
        }
    }

}
