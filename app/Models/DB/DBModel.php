<?php
namespace App\Models\DB;

use App\Models\BaseModel;
use DateTimeInterface;

class DBModel extends BaseModel
{

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y');
    }
}
