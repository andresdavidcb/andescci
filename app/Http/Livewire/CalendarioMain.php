<?php
namespace App\Http\Livewire;

use App\Models\Alumno;
use Carbon\Carbon;
use App\Models\Curso;
use App\Models\Empresa;
use Livewire\Component;
use App\Models\Calendario;
use App\Models\Inscripcion;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class CalendarioMain extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $showOrdenModal, $showFacturaModal, $showDeleteModal, $showEditModal, $createMode = false;
    public $factura, $orden, $fecha_fin, $codigo_unico, $rut_profesor, $curso_id_curso, $empresa_id_empresa;
    public $perPage = '25';
    public $search = '';
    public $field = 'fecha_inicio';
    public $selected = [];
    public $sortField = 'fecha_inicio';
    public $sortDirection = 'asc';
    public Calendario $calendario;
    public Curso $curso;
    public Inscripcion $inscripcion;
    public $data = [''];
    public $alumno_id_alumno = [];

    public $rules = [
        'curso_id_curso' => 'required',
        'empresa_id_empresa' =>'required',
        'calendario.fecha_inicio' => 'required|date',
        'calendario.fecha_fin' => 'required|date',
        'calendario.profesor_a_cargo' => 'nullable',
        'rut_profesor' => 'nullable',
        'calendario.codigo_actividad' => 'required',
        'calendario.estado_curso' => 'required',
        'calendario.fecha_orden' =>'nullable|date',
        'calendario.fecha_factura' =>'nullable|date',
        'calendario.codigo_orden' =>'nullable|unique:calendarios,codigo_orden',
        'calendario.codigo_factura' =>'nullable|unique:calendarios,codigo_factura',
        'orden' =>'nullable|file:pdf|unique:calendarios,path_orden',
        'factura' =>'nullable|file:pdf|unique:calendarios,path_factura',
        'calendario.estado_inscripcion' => 'required',
        'calendario.estado_pago' => 'required',
    ];

    public function render()
    {
        return view('livewire.calendario-main', [
            'calendarios' => Calendario::search($this->field, $this->search)->orderBy('created_at', 'desc')->paginate($this->perPage),
            'cursos' => Curso::all(),
            'empresas' => Empresa::all(),
            'alumnos' => Alumno::all(),
        ]);
    }

    public function makeBlank($field)
    {
        switch($field){
            case ('cal'):
                return Calendario::make();
                break;
            case ('insc'):
                return Inscripcion::make();
                break;
        }
    }

    public function download(Calendario $cal, $type)
    {
        switch ($type) {
            case 'ordenes':
                return response()->download(storage_path('app/'.$type.'/'.$cal->path_orden));
                break;
            case 'facturas':
                return response()->download(storage_path('app/'.$type.'/'.$cal->path_factura));
                break;
        }

    }

    public function edit(Calendario $data, $modo)
    {
        $this->calendario = $data;

        switch ($modo) {
            case 'edit':
                $this->createMode = false;
                $this->showEditModal = true;
                break;

            case 'orden':
                $this->showOrdenModal = true;
                break;

            case 'factura':
                $this->showFacturaModal = true;
                break;
        }
    }

    public function create()
    {
        $this->calendario = $this->makeBlank('cal');
        $this->inscripcion = $this->makeBlank('insc');
        $this->nota_diagnostico = $this->nota_teorica = $this->nota_practica = '';
        $this->createMode = true;
        $this->showEditModal = true;
    }

    public function save($modo)
    {
        switch ($modo) {
            case 'data':
                // Creacion de Registro Calendario
                $this->validate();
                $this->calendario->dias_pago = 60; //cambiar cuando sea necesario

                $fechaLimite = explode("-", $this->calendario->fecha_fin);
                $fechaFormateado = Carbon::today()->setDate($fechaLimite[0],$fechaLimite[1],$fechaLimite[2]);
                $this->calendario->fecha_limite = $fechaFormateado->addDays($this->calendario->dias_pago);

                $curso_array = explode(' | ', $this->curso_id_curso);
                $this->calendario->curso_id_curso = $curso_array[0];

                $empresa_array = explode(' | ', $this->empresa_id_empresa);
                $this->calendario->empresa_id_empresa = $empresa_array[0];

                $this->calendario->rut_profesor = $this->rut_profesor;

                $this->calendario->save();

                // Creacion de Registro Inscripcion
                if($this->createMode){
                    
                    $this->validate([
                        'alumno_id_alumno.*' => 'required',
                    ]);

                    $this->curso = Curso::find($this->calendario->curso_id_curso);

                    $fecha = explode('-', $this->calendario->fecha_fin);
                    $this->fecha_fin = Carbon::today();
                    $this->fecha_fin->set('year', $fecha[0], 'month', $fecha[1], 'day', $fecha[2]);

                    foreach($this->data as $index => $i){
                        $this->inscripcion = new Inscripcion;
                        $fecha_fin = $this->fecha_fin;
                        $vigencia_curso = $this->curso->vigencia_curso;
                        $alumno_array = explode(' | ', $this->alumno_id_alumno[$index]);

                        $this->inscripcion->alumno_id_alumno = $alumno_array[0];
                        $this->inscripcion->calendario_id_cal = $this->calendario->id_cal;
                        $this->inscripcion->empresa_id_empresa = $this->calendario->empresa_id_empresa;
                        $this->inscripcion->estado = "En Curso";
                        $this->inscripcion->valido_hasta = $fecha_fin->addYears($vigencia_curso);
                        $this->inscripcion->codigo_unico = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"),0, 1).substr(str_shuffle("aBcEeFgHiJkLmNoPqRstUvWxYz0123456789"),0, 10);

                        $this->inscripcion->save();
                    }
                }

                $this->showEditModal = false;
                break;

            case 'orden':
                $this->validate([
                    'orden' =>'nullable|file:pdf|unique:calendarios,path_orden',
                    'calendario.fecha_orden' =>'nullable|date',
                    'calendario.codigo_orden' =>'nullable|unique:calendarios,codigo_orden',
                ]);

                $this->orden->storePubliclyAs('ordenes', $this->orden->getClientOriginalName());
                $this->calendario->path_orden = $this->orden->getClientOriginalName();

                $this->calendario->save();
                $this->showOrdenModal = false;
                break;

            case 'factura':
                $this->validate([
                    'factura' =>'nullable|file:pdf|unique:calendarios,path_factura',
                    'calendario.fecha_factura' =>'nullable|date',
                    'calendario.codigo_factura' =>'nullable|unique:calendarios,codigo_factura',
                ]);

                $this->factura->storePubliclyAs('facturas', $this->factura->getClientOriginalName());
                $this->calendario->path_factura = $this->factura->getClientOriginalName();

                $this->calendario->save();
                $this->showFacturaModal = false;
                break;
        }
    }

    public function addInscripcion()
    {
        $this->data[] = '';
    }

    public function removeInscripcion($index)
    {
        unset($this->data[$index]);
        $this->data=array_values($this->data);
    }

    public function confirmDelete(Calendario $data)
    {
        $this->calendario = $data;
        $this->showDeleteModal = true;
    }

    public function deleteSelected()
    {
        $calendarios = Calendario::whereKey($this->selected);

        $calendarios->delete();

        $this->showDeleteModal = false;
    }
}
