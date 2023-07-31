<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

use Carbon\Carbon;
use App\Models\Inscripcion;
use Illuminate\Database\Eloquent\Builder;

class InscriptionDatatable extends DataTableComponent
{
    protected $model = Inscripcion::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_insc');
    }

    public function columns(): array
    {

        return [
            Column::make("#", "id_insc")->sortable(),
            Column::make("estado", "estado")->sortable(),
            Column::make("Apellido1", "alumnos.apellido_paterno")->sortable()->searchable(),
            Column::make("Apellido2", "alumnos.apellido_materno")->sortable()->searchable(),
            Column::make("Nombre", "alumnos.nombre_alumno")->sortable()->searchable(),
            Column::make("Empresa", "empresas.nombre_empresa")->sortable()->searchable(),
            Column::make("Código unico", "codigo_unico")->searchable(),      
            Column::make("Fecha creación", "created_at"),
            Column::make("Fecha actualización", "updated_at")->sortable(),
            ButtonGroupColumn::make('Actions')
    ->attributes(function($row) {
        return [
            'class' => 'space-x-2',
        ];
    })
    ->buttons([
        LinkColumn::make('View') // make() has no effect in this case but needs to be set anyway
            ->title(fn($row) => 'View ' . $row->name)
            ->location(fn($row) => route('lista_certificados', $row))
            ->attributes(function($row) {
                return [
                    'class' => 'underline text-blue-500 hover:no-underline',
                ];
            }),
        LinkColumn::make('Edit')
            ->title(fn($row) => 'Edit ' . $row->name)
            ->location(fn($row) => route('lista_certificados', $row))
            ->attributes(function($row) {
                return [
                    'target' => '_blank',
                    'class' => 'underline text-blue-500 hover:no-underline',
                ];
            }),
    ]),
            
        ];
    }

    public function builder(): Builder
    {
        return Inscripcion::query()
            ->select('id_insc','estado','alumnos.apellido_paterno','alumnos.apellido_materno','alumnos.nombre_alumno',
            'empresas.nombre_empresa','codigo_unico','inscripcions.created_at','inscripcions.updated_at')
            ->join('alumnos', 'alumnos.id_alumno', '=', 'inscripcions.alumno_id_alumno')
            ->join('empresas', 'empresas.id_empresa', '=', 'inscripcions.empresa_id_empresa');
    }
}
