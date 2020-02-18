<?php

namespace Tests\Feature\Project;

use App\Expert;
use App\Project;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DeleteTest extends TestCase
{

    /**
     * testExpertAccess
     *
     * @return void
     */
    public function testUserNotConnectedAccess()
    {
        $this->post(route('project.delete', 25))
            ->assertRedirect(route('auth.login'));
    }

    /**
     * testExpertDeleteProject
     *
     * @return void
     */
    public function testExpertDeleteProject()
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
                'tel_exp' => '0601020395',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'expert',
            ]);

            $admin1 = Expert::create([
                'name_exp' => 'name',
                'firstname_exp' => 'firstname',
                'bd_date_exp' => '2000/01/01',
                'sex_exp' => 'name',
                'address_exp' => '9 rue de l\'arc en ciel',
                'pc_exp' => '74000',
                'mail_exp' => 'admin1@annotate.com',
                'tel_exp' => '0601020396',
                'city_exp' => 'Annecy',
                'pwd_exp' => Hash::make('123'),
                'type_exp' => 'admin',
            ]);

            $project = Project::create([
                'name_prj' => 'test',
                'desc_prj' => null,
                'id_mode' => 1,
                'id_int' => 1,
                'id_exp' => $admin->id_exp,
                'limit_prj' => 1,
                'waiting_time_prj' => 1,
            ]);

            $this->withSession(['expert' => ['id' => $admin1->id_exp, 'type' => $admin1->type_exp]])
            ->post(route('project.delete', $project->id_prj))
            ->assertStatus(403);
            
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $project->delete();
            $admin->delete();
            $admin1->delete();
        }
    }
}
