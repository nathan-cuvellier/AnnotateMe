<?php

namespace Tests\Feature\Project;

use App\Expert;
use App\LimitAnnotation;
use App\Participation;
use App\Project;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AnnotateTest extends TestCase
{

    public function testExample()
    {
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
            'name_prj' => 'test',
            'desc_prj' => null,
            'id_mode' => 1,
            'id_int' => 1,
            'id_exp' => $expert->id_exp,
            'limit_prj' => 1,
            'waiting_time_prj' => 1,
        ]);

        $participation = Participation::create([
            'id_cptlvl' => '1',
            'id_exp' => $expert->id_exp,
            'id_prj' => $project->id_prj,
        ]);

        $limitAnnotation = LimitAnnotation::create([
            'id_exp' => $expert->id_exp,
            'id_prj' => $project->id_prj,
            'date_limit_annotation' => (new DateTime())->modify("+{$project->waiting_time_prj} hours")
        ]);

        $this->withSession(['expert' => ['id' => $expert->id_exp, 'type' => $expert->type_exp]])
            ->get(route('project.annotate', ['id' => $project->id_prj]))
            ->assertSessionHas('warning')
            ->assertRedirect(route('project.list'));

        $limitAnnotation->delete();
        $participation->delete();
        $project->delete();
        $expert->delete();

    }
}
