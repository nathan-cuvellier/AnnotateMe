<?php

namespace App\Http\Controllers\Account;

use App\Expert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListController extends Controller
{


    /**
     * ListController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function list()
    {
        $expertsDB = Expert::query()
            ->orderBy('type_exp', 'ASC')
            ->orderBy('name_exp')
            ->orderBy('firstname_exp')
            ->whereNotNull('mail_exp'); // email can be NULL in order to respect the RGPD

        // filter by type of expert
        if (isset($_GET['type']))
            $expertsDB->whereIn('type_exp', $_GET['type']);

        // filter by email of expert
        if (isset($_GET['mail_exp']) && trim($_GET['mail_exp']))
            $expertsDB->where('mail_exp', 'ILIKE', '%' . trim($_GET['mail_exp']) . '%');

        // filter by name of expert
        if (isset($_GET['name_exp']) && trim($_GET['name_exp']))
            $expertsDB->where('name_exp', 'ILIKE', '%' . trim($_GET['name_exp']) . '%');

        // filter by first name of expert
        if (isset($_GET['firstname_exp']) && trim($_GET['firstname_exp']))
            $expertsDB->where('firstname_exp', 'ILIKE', '%' . trim($_GET['firstname_exp']) . '%');

        $experts = [];
        // create an array with the expert accounts grouped by type of expert
        foreach ($expertsDB->get() as $expert) {
            $experts[$expert->type_exp][] = $expert;
        }

        return view('account.list', compact('experts'));
    }
}
