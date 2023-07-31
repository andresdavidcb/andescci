<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    public function getRutAlumnoFormatAttribute($value)
    {
        $largo = strlen($value);

        $dv = substr($value, -1, 1);
        $cuerpo = '';

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

    public function getNombreCompletoAttribute()
    {
        return $this->apellido_paterno . ' ' . $this->apellido_materno . ', ' . $this->nombre_alumno;
    }

    public function getDateForHumansAttribute()
    {
        return $this->vencimiento_licencia->format('M, d Y');
    }

    public function inscripcions()
    {
        return $this->hasMany('App\Models\Inscripcion');
    }

    protected $primaryKey = 'id_alumno';
}
