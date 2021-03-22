<?php
namespace App\Models\DB;

use App\Models\BaseModel;

class DBModel extends BaseModel
{

    /**
     * Devuelve la fecha created_at formateada
     *
     * @param string $format
     * @return string
     */
    public function createdAtFormatted($format = 'd/m/Y H:i')
    {
        if ($this->created_at == null) {
            return null;
        }
        return $this->created_at->format($format);
    }

    /**
     * Devuelve la fecha created_at formateada
     *
     * @param string $format
     * @return string
     */
    public function updatedAtFormatted($format = 'd/m/Y H:i')
    {
        if ($this->updated_at == null) {
            return null;
        }
        return $this->updated_at->format($format);
    }
}
