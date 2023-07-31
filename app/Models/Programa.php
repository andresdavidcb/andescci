<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;

    public function getHorasTeoricaFormatAttribute()
    {
        return $this->horas_teorica . ' hrs.';
    }

    public function getHorasPracticaFormatAttribute()
    {
        return $this->horas_practica . ' hrs.';
    }

    public function cursos()
    {
        return $this->belongsTo('App\Models\Curso', 'curso_id_curso');
    }

    protected $primaryKey = 'id_programas';
}
