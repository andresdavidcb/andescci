<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Calendario;
//use App\Models\Programa;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';


    public function getVigenciaCursoFormatAttribute()
    {
        return $this->vigencia_curso . ' año(s)';
    }
    public function getHorasFormatAttribute()
    {
        return $this->horas . ' hrs.';
    }

    public function getSenceBoolAttribute()
    {
        return [
            '1' => 'Sí',
            '0' => 'No',
        ][$this->sence] ?? '';
    }

    public function getMaquinariaBoolAttribute()
    {
        return [
            '1' => 'Sí',
            '0' => 'No',
            ][$this->manejo_maquinaria] ?? '';
    }

    /**
     * Relaciones con otras tablas
     */
    public function calendarios()
    {
        return $this->hasMany(Calendario::class);
    }

    public function cotizacions()
    {
        return $this->hasMany(Cotizacion::class);
    }

    public function programas()
    {
        return $this->hasOne(Programa::class);
    }

    protected $primaryKey = 'id_curso';
}
