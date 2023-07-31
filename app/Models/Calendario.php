<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cal';

    public function getEstadoCertificadoAttribute()
    {
        $today = Carbon::today();

        if($this->fecha_limite < $today && $this->estado_pago === 'Por Pagar') {
            return [
                'error'  => 'Certificado Invalido: Por Favor Contactar Área de Contabilidad',
                'estado' => false,
            ];
        } else {
            return [
                'error'  => '',
                'estado' => true,
            ];
        }
    }

    public function getRutProfesorAttribute($value)
    {
        $largo = strlen($value);

        switch($largo) {
            case (8):
                $dv = substr($value, 7, 1);
                $centenas = substr($value, 4, 3);
                $miles = substr($value, 1, 3);
                $millon = substr($value, 0, 1);

                return $millon .'.'. $miles .'.'. $centenas .'-'. $dv;

            case (9):
                $dv = substr($value, 8, 1);
                $centenas = substr($value, 5, 3);
                $miles = substr($value, 2, 3);
                $millon = substr($value, 0, 2);

                return $millon .'.'. $miles .'.'. $centenas .'-'. $dv;
        }
    }

    /**
     * Relaciones con otras tablas
     */
    public function cursos()
    {
        return $this->belongsTo('App\Models\Curso');
    }

    public function empresas()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function inscripcions()
    {
        return $this->hasMany('App\Models\Inscripcion');
    }
}
