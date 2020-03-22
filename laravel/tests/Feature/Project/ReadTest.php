<?php

namespace Tests\Feature\Project;

use App\Expert;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReadTest extends TestCase
{
    /**
     * If the user is not in the project (not in participation table),
     * he is redirected to the home page (project.list)
     * With a message in session 'error'
     * @return void
     */
    public function testAccessToReadPageWithoutParticipate()
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
    
            $project = Project::create([
                'name_prj' => 'phpunit',
                'desc_prj' => null,
                'id_mode' => 1,
                'id_int' => 1,
                'id_exp' => $expert->id_exp,
                'limit_prj' => 1,
                'waiting_time_prj' => 1,
            ]);
    
            $this->withSession(['expert' => ['id' => $expert->id_exp, 'type' => $expert->type_exp]])
                ->get(route('project.read', ['id' => $project->id_prj]))
                ->assertSessionHas('error')
                ->assertRedirect(route('project.list'));
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $project->delete();
            $expert->delete();
        }
    }

}
