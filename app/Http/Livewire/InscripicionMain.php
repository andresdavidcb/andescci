<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Empresa;
use Livewire\Component;
use App\Models\Calendario;
use App\Models\Inscripcion;
use Livewire\WithPagination;
use App\Exports\InscripcionExport;
use Maatwebsite\Excel\Facades\Excel;

class InscripicionMain extends Component
{
    use WithPagination;

    public $showEditModal = false;
    public $showDeleteModal = false;
    public $perPage = '25';
    public $search = '';
    public $field = 'codigo_unico';
    public $selected = [];
    public $sortField = 'valido_hasta';
    public $sortDirection = 'asc';
    public Inscripcion $inscripcion;
    public $participante;
    public $data, $fechaFinFormateado, $nota_diagnostico, $nota_teorica, $nota_practica, $nota_final, $valido_hasta;
    public $empresa_id_empresa, $calendario_id_cal, $alumno_id_alumno;
    public $modo = 'edit';

    public $rules = [
        'inscripcion.estado' => 'required',
        'nota_diagnostico' => 'nullable',
        'nota_teorica' => 'required',
        'nota_practica' => 'nullable',
        'alumno_id_alumno' => 'nullable',
        'empresa_id_empresa' => 'nullable',
        'calendario_id_cal' => 'nullable',
        'valido_hasta' => 'required',
    ];

    public function render()
    {
        return view('livewire.inscripicion-main', [
            'inscripcions' => Inscripcion::search($this->field, $this->search)->with('calendarios')->with('alumnos')->with('empresas')->orderBy('created_at', 'desc')->paginate($this->perPage),
            'calendarios' => Calendario::with('cursos')->get(),
            'alumnos' => Alumno::all(),
            'empresas' => Empresa::all(),
        ]);
    }

    public function makeBlank()
    {
        return Inscripcion::make();
    }

    public function edit(Inscripcion $data)
    {
        $this->inscripcion = $data;
        $this->participante = Alumno::find($data->alumno_id_alumno)->first();
        $this->nota_diagnostico = $this->inscripcion->nota_diagnostico;
        $this->nota_teorica = $this->inscripcion->nota_teorica;
        $this->nota_practica = $this->inscripcion->nota_practica;
        $this->modo = 'edit';
        $this->showEditModal = true;
    }

    public function create()
    {
        $this->inscripcion = $this->makeBlank();
        $this->modo = 'create';
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        if($this->modo === 'create') {
            $calendario_id = explode(' | ', $this->calendario_id_cal);
            $empresa_id = explode(' | ', $this->empresa_id_empresa);
            $alumno_id = explode(' | ', $this->alumno_id_alumno);

            $this->inscripcion->codigo_unico = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"),0, 1).substr(str_shuffle("aBcEeFgHiJkLmNoPqRstUvWxYz0123456789"),0, 10);

            $calendario  = Calendario::find($calendario_id[0]);
            $curso = Curso::find($calendario->curso_id_curso);

            $fechaFin = explode('-', $calendario->fecha_fin);
            $this->fechaFinFormateado = Carbon::today()->setDate($fechaFin[0], $fechaFin[1], $fechaFin[2]);

            $this->inscripcion->calendario_id_cal = $calendario_id[0];
            $this->inscripcion->empresa_id_empresa = $empresa_id[0];
            $this->inscripcion->alumno_id_alumno = $alumno_id[0];
        }

        $this->inscripcion->valido_hasta = $this->valido_hasta;
        $this->inscripcion->nota_diagnostico = $this->nota_diagnostico;
        $this->inscripcion->nota_teorica = $this->nota_teorica;
        $this->inscripcion->nota_practica = $this->nota_practica;
        if($this->inscripcion->nota_practica===null)
            $this->inscripcion->nota_final = $this->inscripcion->nota_teorica;
        elseif($this->inscripcion->nota_teorica===null)    
            $this->inscripcion->nota_final = $this->inscripcion->nota_practica;
        else
            $this->inscripcion->nota_final = ($this->inscripcion->nota_teorica + $this->inscripcion->nota_practica) / 2;

        $this->inscripcion->save();

        $this->showEditModal = false;
    }

    public function confirmDelete(Inscripcion $data)
    {
        $this->inscripcion = $data;
        $this->showDeleteModal = true;
    }

    public function deleteSelected()
    {
        $inscripcions = Inscripcion::whereKey($this->selected);

        $inscripcions->delete();

        $this->showDeleteModal = false;
    }

    public function createExcel()
    {
        $today = Carbon::today()->toDateString();
        return Excel::download(new InscripcionExport, 'Cursos Realizados Hasta '.$today.'.xlsx');
    }
}
