<?php
namespace App\Http\Livewire;

// (づ｡◕‿‿◕｡)づ uwu jeje
 //No entiendo nada, pero igual apaño jeje
 //Comentario de relleno
 //R E L L E N O
 // M A N J A R
 //Q U I E R O
 //U N A
 //E M P A N A D A
 /* la legal tengo cualquier hambre uwu quiero una empanada y vino uwu*/

use App\Models\Alumno;
use Livewire\Component;
use Livewire\WithPagination;

class AlumnoMain extends Component
{
    use WithPagination;
    public $showEditModal = false;
    public $showCreateModal = false;
    public $showDeleteModal = false;
    public $mode = 'create';
    public $perPage = '25';
    public $search = '';
    public $field = 'nombre_alumno';
    public $selected = [];
    public $data = [''];
    public $rut_alumno;
    public Alumno $alumno;
    public $rut_alumno_array, $nombre_alumno, $apellido_paterno, $apellido_materno = [];
    public $no_licencia = [];
    public $tipo_licencia = [];
    public $vencimiento_licencia = [];
    public $estado = [''];

    public $rules = [
            'rut_alumno.*' => 'unique:alumnos,rut_alumno|required',
            'alumno.nombre_alumno.*' => 'required',
            'alumno.apellido_materno.*' => 'required',
            'alumno.apellido_paterno.*' => 'required',
            'alumno.no_licencia.*' => 'max:15|nullable',
            'alumno.tipo_licencia.*' => 'nullable',
            'alumno.vencimiento_licencia.*' => 'date|nullable',
        ];

    public function render()
    {
        return view('livewire.alumno-main', [
            'alumnos' => Alumno::search($this->field, $this->search)->orderBy('created_at', 'desc')->paginate($this->perPage),
        ]);

    }

    public function makeBlank()
    {
        return Alumno::make();
    }

    public function edit($id)
    {
        $this->alumno = Alumno::find($id);
        $this->rut_alumno = $this->alumno->rut_alumno;
        $this->data = [''];
        $this->mode = 'edit';
        $this->showEditModal = true;
    }

    public function create()
    {
        $this->alumno = $this->makeBlank();
        $this->data = [''];
        $this->mode = 'create';
        $this->showCreateModal = true;
    }

    public function addAlumno()
    {
        $this->data[] = '';
        $this->estado[] = '';
    }

    public function removeAlumno($index)
    {
        unset($this->data[$index]);
        unset($this->estado[$index]);
        $this->data=array_values($this->data);
        $this->estado=array_values($this->estado);
    }

    public function save()
    {
        switch($this->mode) {
            case('create'):
                /*$this->validate([
                    'rut_alumno_array.*' => 'unique:alumnos,rut_alumno|required',
                    'nombre_alumno.*' => 'required',
                    'apellido_materno.*' => 'required',
                    'apellido_paterno.*' => 'required',
                    'no_licencia.*' => 'max:15|nullable',
                    'tipo_licencia.*' => 'nullable',
                    'vencimiento_licencia.*' => 'date|nullable',
                ]);*/

                foreach($this->data as $index => $i) {
                    $this->alumno = new Alumno;

                    $this->alumno->rut_alumno = $this->rut_alumno_array[$index];
                    $this->alumno->nombre_alumno = $this->nombre_alumno[$index];
                    $this->alumno->apellido_paterno = $this->apellido_paterno[$index];
                    $this->alumno->apellido_materno = $this->apellido_materno[$index];
                    $this->alumno->no_licencia = $this->no_licencia[$index] ?? null;
                    $this->alumno->tipo_licencia = $this->tipo_licencia[$index] ?? null;
                    $this->alumno->vencimiento_licencia = $this->vencimiento_licencia[$index] ?? null;

                    $this->alumno->save();
                }
                $this->showCreateModal = false;
                break;

            case('edit'):
                $this->validate([
                    'rut_alumno' => 'unique:alumnos,rut_alumno|required',
                    'alumno.nombre_alumno' => 'required',
                    'alumno.apellido_materno' => 'required',
                    'alumno.apellido_paterno' => 'required',
                    'alumno.no_licencia' => 'max:15|nullable',
                    'alumno.tipo_licencia' => 'nullable',
                    'alumno.vencimiento_licencia' => 'date|nullable',
                ]);
                $this->alumno->rut_alumno = $this->rut_alumno;
                $this->alumno->save();
                $this->showEditModal = false;
                break;
        }
    }

    public function checkRut() // TODO: Hacerlo funcar para varios participantes
    {
        foreach($this->rut_alumno_array as $index => $in) {
            $this->rut_alumno_array[$index] = str_replace(['.', '-'], '', $this->rut_alumno_array[$index]);

            $length = strlen($this->rut_alumno_array[$index]);
            $dv = strtoupper(substr($this->rut_alumno_array[$index], -1, 1));
            $sum = 0;
            $mult = 2;

            for($i=2;$i<=$length;$i++) {
                $indice = $mult * intval(substr($this->rut_alumno_array[$index], -$i, 1));
                $sum += $indice;
                ($mult < 7) ? $mult++ : $mult=2;
            }

            $expectedDv = 11 - ($sum % 11);

            $dv = ($dv == 'K') ? 10 : $dv;
            $dv = ($dv == 0) ? 11 : $dv;

            $this->estado[$index] = ($expectedDv != $dv) ? false : true;
        }
    }

    public function confirmDelete(Alumno $data)
    {
        $this->alumno = $data;
        $this->showDeleteModal = true;
    }

    public function deleteSelected()
    {
        $alumnos = Alumno::whereKey($this->selected);

        $alumnos->delete();

        $this->showDeleteModal = false;
    }
}
