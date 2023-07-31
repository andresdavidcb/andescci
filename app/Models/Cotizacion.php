<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    public function cursos()
    {
        return $this
            ->belongsToMany(Curso::class)
            ->withPivot(
                'modalidad',
                'cantidad_alumnos',
                'valor_alumno',
                'valor_actividad',
                'nota_aprobacion',
                'curso_id_curso',
                'cotizacion_id_cotizacion'
                )
            ->as('detalle_curso');
    }

    public function empresas()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id_empresa');
    }

    public function contribucions()
    {
        return $this->belongsToMany(Contribucion::class);
    }

    protected $primaryKey = 'id_cotizacion';
}
