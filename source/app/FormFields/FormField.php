<?php

namespace App\FormFields;

class FormField {
    public $db_name;
    public $readable_name;
    public $type;
    public $required;

    public function __construct($db_name, $readable_name, $type, $required) {
        $this->db_name = $db_name;
        $this->readable_name = $readable_name;
        $this->type = $type;
        $this->required = $required;
    }
}