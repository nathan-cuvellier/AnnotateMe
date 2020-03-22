<?php

namespace Tests\Feature\Account;

use App\Expert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use PDOException;
use Tests\TestCase;

class UpdateTest extends TestCase
{

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                       Expert                  ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     *
     *
     * @return void
     */
    public function testExpertUpdateHisAccountNoConnected()
    {
        try {
            $expert = Expert::create([
                'name_exp' => 'name',
                'firstname_exp' => 'firstname',
                'bd_date_exp' => '2000/01/01',
                'sex_exp' => 'name',
                'address_exp' => '9 rue de l\'arc en ciel',
                'pc_exp' => '74000',
                'mail_exp' => 'expert@annotate.com',
                'tel_exp' => '0601020304',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'expert',
            ]);

            $this->get(route('account.update', ['id' => $expert->id_exp]))
                ->assertRedirect(route('auth.login'));
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $expert->delete();
        }
    }

    /**
     *
     *
     * @return void
     */
    public function testExpertUpdateAccountDoesntExist()
    {
        try {
            $expert = Expert::create([
                'name_exp' => 'name',
                'firstname_exp' => 'firstname',
                'bd_date_exp' => '2000/01/01',
                'sex_exp' => 'name',
                'address_exp' => '9 rue de l\'arc en ciel',
                'pc_exp' => '74000',
                'mail_exp' => 'expert@annotate.com',
                'tel_exp' => '0601020304',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'expert',
            ]);

            $this->withSession(['expert' => ['id' => $expert->id_exp, 'type' => $expert->type_exp]])
                ->get(route('account.update', ['id' => -1]))
                ->assertForbidden();
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $expert->delete();
        }
    }


    public function testExpertUpdateAccountOfAnOtherExpert()
    {
        try {
            $expert = Expert::create([
                'name_exp' => 'name',
                'firstname_exp' => 'firstname',
                'bd_date_exp' => '2000/01/01',
                'sex_exp' => 'name',
                'address_exp' => '9 rue de l\'arc en ciel',
                'pc_exp' => '74000',
                'mail_exp' => 'expert@annotate.com',
                'tel_exp' => '0601020304',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'expert',
            ]);
            $expert1 = Expert::create([
                'name_exp' => 'name',
                'firstname_exp' => 'firstname',
                'bd_date_exp' => '2000/01/01',
                'sex_exp' => 'name',
                'address_exp' => '9 rue de l\'arc en ciel',
                'pc_exp' => '74000',
                'mail_exp' => 'expert1@annotate.com',
                'tel_exp' => '0601020305',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'expert',
            ]);

            $this->withSession(['expert' => ['id' => $expert->id_exp, 'type' => $expert->type_exp]])
                ->get(route('account.update', ['id' => $expert1->id_exp]))
                ->assertStatus(403);
        }  catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $expert->delete();
            $expert1->delete();
        }
    }

    public function testExpertUpdateAccountOfAnAdmin()
    {
        try {
            $expert = Expert::create([
                'name_exp' => 'name',
                'firstname_exp' => 'firstname',
                'bd_date_exp' => '2000/01/01',
                'sex_exp' => 'name',
                'address_exp' => '9 rue de l\'arc en ciel',
                'pc_exp' => '74000',
                'mail_exp' => 'expert@annotate.com',
                'tel_exp' => '0601020304',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'expert',
            ]);

            $admin = Expert::create([
                'name_exp' => 'name',
                'firstname_exp' => 'firstname',
                'bd_date_exp' => '2000/01/01',
                'sex_exp' => 'name',
                'address_exp' => '9 rue de l\'arc en ciel',
                'pc_exp' => '74000',
                'mail_exp' => 'admin@annotate.com',
                'tel_exp' => '0601020305',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'admin',
            ]);

            $this->withSession(['expert' => ['id' => $expert->id_exp, 'type' => $expert->type_exp]])
                ->get(route('account.update', ['id' => $admin->id_exp]))
                ->assertStatus(403);
        }  catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $expert->delete();
            $admin->delete();
        }
    }

    public function testExpertUpdateAccountOfAnSuperAdmin()
    {
        try {
            $expert = Expert::create([
                'name_exp' => 'name',
                'firstname_exp' => 'firstname',
                'bd_date_exp' => '2000/01/01',
                'sex_exp' => 'name',
                'address_exp' => '9 rue de l\'arc en ciel',
                'pc_exp' => '74000',
                'mail_exp' => 'expert@annotate.com',
                'tel_exp' => '0601020304',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'expert',
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

            $this->withSession(['expert' => ['id' => $expert->id_exp, 'type' => $expert->type_exp]])
                ->get(route('account.update', ['id' => $superadmin->id_exp]))
                ->assertStatus(403);
        }  catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $expert->delete();
            $superadmin->delete();
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                        Admin                  ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /**
     *
     *
     * @return void
     */
    public function testAdminUpdateAccountDoesntExist()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'admin']])
            ->get(route('account.update', ['id' => 9999]))
            ->assertSessionHas('warning')
            ->assertRedirect(route('account.list'));
    }

    public function testAdminUpdateAccountOfAnOtherAdmin()
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
                'tel_exp' => '0601020305',
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
                'tel_exp' => '0601020306',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'admin',
            ]);

            $this->withSession(['expert' => ['id' => $admin->id_exp, 'type' => $admin->type_exp]])
                ->get(route('account.update', ['id' => $admin1->id_exp]))
                ->assertSessionHas('warning')
                ->assertRedirect(route('account.list'));
        }  catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $admin->delete();
            $admin1->delete();
        }
    }


}
