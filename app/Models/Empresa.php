<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    public function getEmpresaParticularAttribute()
    {
        return [
            'Particular' => 'Particular',
        ][$this->nombre_empresa] ?? $this->rut_empresa;
    }

    public function getRutEmpresaFormatAttribute($value)
    {
        $largo = strlen($value);
        $dv = substr($value, -1, 1);

        switch($largo) {
            case (8):
                $centenas = substr($value, 4, 3);
                $miles = substr($value, 1, 3);
                $millon = substr($value, 0, 1);

                return $millon .'.'. $miles .'.'. $centenas .'-'. $dv;

            case (9):
                $centenas = substr($value, 5, 3);
                $miles = substr($value, 2, 3);
                $millon = substr($value, 0, 2);

                return $millon .'.'. $miles .'.'. $centenas .'-'. $dv;
        }
    }


    public function getNotaPorcentajeBoolAttribute()
    {
        return [
            '1' => 'Sí',
            '0' => 'No',
        ][$this->notaPorcentaje];
    }

    public function calendarios()
    {
        return $this->hasMany('App\Models\Calendario');
    }

    public function cotizacions()
    {
        return $this->hasMany('App\Models\Cotizacion');
    }

    protected $primaryKey = 'id_empresa';
}
