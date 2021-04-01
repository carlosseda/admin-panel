<?php

namespace App\Models\DB;

use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Faq extends DBModel
{

    use LaravelVueDatatableTrait;

    protected $table = 't_faqs';

    protected $dataTableColumns = [

        'id' => [
            'searchable' => false,
        ],
        'title' => [
            'searchable' => true,
        ],
        'description' => [
            'searchable' => true,
        ]
    ];

}
