<?php

namespace App\FormFields;

class TextAreaFormField extends FormField {
    public $columns;
    public $rows;

    public function __construct($db_name, $readable_name, $type, $required, $columns, $rows) {
        $this->db_name = $db_name;
        $this->readable_name = $readable_name;
        $this->type = $type;
        $this->required = $required;
        $this->columns = $columns;
        $this->rows = $rows;
    }
}