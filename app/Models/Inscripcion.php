<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscripcion extends Model
{
    use HasFactory;

    public function getEstadoCertificadoAttribute()
    {
        $today = Carbon::today();

        if($this->valido_hasta < $today) {
            return [
                'error'  => 'Certificado Invalido: Este Certificado Está Vencido',
                'estado' => false,
            ];
        } else {
            return [
                'error'  => '',
                'estado' => true,
            ];
        }
    }

    public function getNotaEnPorcentajeAttribute()
    {
        return [
            'nota_diagnostico' => round((($this->nota_diagnostico * 100) / 7), 2, PHP_ROUND_HALF_UP).'%',
            'nota_teorica' => round((($this->nota_teorica * 100) / 7), 2, PHP_ROUND_HALF_UP).'%',
            'nota_practica' => round((($this->nota_practica * 100) / 7), 2, PHP_ROUND_HALF_UP).'%',
            'nota_final' => round((($this->nota_final * 100) / 7), 2, PHP_ROUND_HALF_UP).'%',
        ];
    }

    public function getCodigoUnicoAttribute($value)
    {
        if($this->estado === 'Reprobado') {
            return 'REPROBADO';
        } else {
            return $this->estado === 'En Curso' ? 'En Curso' : $value;
        }
    }

    public function getValidoHastaAttribute($value)
    {
        if($this->estado === 'Reprobado') {
            return 'REPROBADO';
        } else {
            return $this->estado === 'En Curso' ? 'En Curso' : $value;
        }
    }

    public function calendarios()
    {
        return $this->belongsTo('App\Models\Calendario', 'calendario_id_cal');
    }

    public function empresas()
    {
        return $this->belongsTo('App\Models\Empresa', 'empresa_id_empresa');
    }

    public function alumnos()
    {
        return $this->belongsTo('App\Models\Alumno', 'alumno_id_alumno');
    }

    protected $primaryKey = 'id_insc';
}
