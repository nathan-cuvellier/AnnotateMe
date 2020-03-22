<?php

namespace Tests\Feature\Project;

use App\Expert;
use App\LimitAnnotation;
use App\Participation;
use App\Project;
use App\Category;
use App\Data;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AnnotateTest extends TestCase
{

    public function testAccessToAnnotatePageWithoutParticipate()
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

            $category = Category::create([
                'label_cat' => "test label",
                'id_prj' => $project->id_prj,
                'num_line' => 0,
            ]);

            $data = Data::create([
                'pathname_data' => $project->name_prj . "/test.jpg",
                'priority_data' => 1,
                'nbannotation_data' => 0,
                'id_prj' => $project->id_prj,
            ]);

            $this->withSession(['expert' => ['id' => $expert->id_exp, 'type' => $expert->type_exp]])
                ->get(route('project.annotate', ['id' => $project->id_prj]))
                ->assertStatus(403);
        } catch(Exception $e) {
            echo "\ntestAccessToAnnotatePageWithoutParticipate\n";
            echo $e->getMessage();
        } finally {
            $data->delete();
            $category->delete();
            $project->delete();
            $expert->delete();
        }
    }

    public function testAccessToAnnotatePageWithoutData()
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

            $category = Category::create([
                'label_cat' => "test label",
                'id_prj' => $project->id_prj,
                'num_line' => 0,
            ]);

            $this->withSession(['expert' => ['id' => $expert->id_exp, 'type' => $expert->type_exp]])
                ->get(route('project.annotate', ['id' => $project->id_prj]))
                ->assertSessionHas('error')
                ->assertRedirect(route('project.list'));
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $category->delete();
            $project->delete();
            $expert->delete();
        }
    }

    public function testAccessToAnnotatePageWithouCategory()
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

            $data = Data::create([
                'pathname_data' => $project->name_prj . "/test.jpg",
                'priority_data' => 1,
                'nbannotation_data' => 0,
                'id_prj' => $project->id_prj,
            ]);

            $this->withSession(['expert' => ['id' => $expert->id_exp, 'type' => $expert->type_exp]])
                ->get(route('project.annotate', ['id' => $project->id_prj]))
                ->assertSessionHas('error')
                ->assertRedirect(route('project.list'));
        } catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            $data->delete();
            $project->delete();
            $expert->delete();
        }
    }
    
    
}