<?php

namespace Tests\Feature\Account;

use App\Expert;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReadTest extends TestCase
{

    /**
     * If the user of type "expert" try to access an account that doesn't exist
     * The WEB site return a 403 error in order to not revel the ids that exist
     * 
     * @return void
     */
    public function testExpertReadAccountWhoDoesntExist()
    {
        $this->withSession(['expert' => ['id' => 99, 'type' => 'expert']])
            ->get(route('account.read', ['id' => -1]))
            ->assertStatus(403);
    }

    /**
     * If the user of type "admin" or "superadmin" try to access an account that doesn't exist
     * the user (admin or superadmin) is redirect to the account list page with a warning message
     * If user has the error 403, that means, he manually changed the id directly in the URL
     * 
     * @return void
     */
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


    /**
     * If the user of type "expert" try to access an other account of the same grade
     * The WEB site return a 403 error in order to not revel the ids that exist
     * If user has the error 403, that means, he manually changed the id directly in the URL
     * 
     * @return void
     */
    public function testExpertReadAccountOfAnOtherExpert()
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
            ->get(route('account.read', ['id' => $expert1->id_exp]))
            ->assertStatus(403);
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $expert->delete();
            $expert1->delete();
        }  
        
    }

    /**
     * If the user of type "expert" try to access an account of type "admin"
     * The WEB site return a 403 error in order to not revel the ids that exist
     * If user has the error 403, that means, he manually changed the id directly in the URL
     * 
     * @return void
     */
    public function testExpertReadAccountOfAdmin()
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
                ->get(route('account.read', ['id' => $admin->id_exp]))
                ->assertStatus(403);
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $admin->delete();
        }  
        

    }

    /**
     * If the user of type "expert" try to access an account of type "superadmin"
     * The WEB site return a 403 error in order to not revel the ids that exist
     * If user has the error 403, that means, he manually changed the id directly in the URL
     * 
     * @return void
     */
    public function testExpertReadAccountOfSuperadmin()
    {
        try {
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
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $superadmin->delete();
        }  
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////                        Admin                  ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * If the user of type "admin" try to access an other account of the same grade
     * The WEB site return a 403 error
     * If user has the error 403, that means, he manually changed the id directly in the URL
     * 
     * @return void
     */
    public function testAdminReadAccountOfAnOtherAdmin()
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
    
            $this->withSession(['expert' => ['id' => 99, 'type' => 'admin']])
                ->get(route('account.read', ['id' => $admin->id_exp]))
                ->assertStatus(403);
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $admin->delete();
        }
    }

    /**
     * If the user of type "superadmin" try to access an other account of the same grade
     * The WEB site return a 403 error
     * If user has the error 403, that means, he manually changed the id directly in the URL
     * 
     * @return void
     */
    public function testAdminReadAccountOfAnOtherSuperadmin()
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
    
            $this->withSession(['expert' => ['id' => 99, 'type' => 'admin']])
                ->get(route('account.read', ['id' => $admin->id_exp]))
                ->assertStatus(403);
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $admin->delete();
        }
    }


}
