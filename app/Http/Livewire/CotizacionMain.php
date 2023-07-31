<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Curso;
use App\Models\Empresa;
use Livewire\Component;
use App\Models\Cotizacion;
use App\Models\Contribucion;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;
use App\Models\ContribucionCotizacion;
use Illuminate\Support\LazyCollection;


class CotizacionMain extends Component
{
    use WithPagination;

    public $showEditModal, $showDeleteModal, $showPDFModal = false;
    public $id_cotizacion, $valorTotal, $empresa_id_empresa;
    public $mode = 'cotizacion';
    public $perPage = '25';
    public $search = '';
    public $selected = [];
    public $data = [''];
    public $field = 'codigo_cotizacion';
    public Cotizacion $cotizacion;
    public Contribucion $contribucion;
    public $cotCont = [];
    public $curso_id_curso = [];
    public $cantidad_alumnos = [];
    public $valor_alumno = [];
    public $nota_aprobacion = [];
    public $modalidad = [];
    public $contriAnd = [];
    public $contriEmp = [];

    public function rules() {
        switch ($this->mode){
            case ('cotizacion'):
                return [
                    'empresa_id_empresa'=>'required',
                    'cantidad_alumnos.*'=>'required',
                    'valor_alumno.*'=>'required',
                    'nota_aprobacion.*'=>'required',
                    'curso_id_curso.*'=>'required',
                    'modalidad.*'=>'required',
                    'contriAnd.*' => 'nullable',
                    'contriEmp.*' => 'nullable',
                ];

            case ('contribucion'):
                return [
                    'contribucion.contribucion' => 'required',
                    'contribucion.empresa' => 'required',
                ];
        }
    }

    public function render()
    {
        return view('livewire.cotizacion-main', [
            'cotizacions' => Cotizacion::with('cursos')
                ->with('empresas')
                ->search($this->field, $this->search)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
            'contribucions' => Contribucion::all()->sortBy('empresa'),
            'empresas' => Empresa::all(),
            'curso' => Curso::all(),
        ]);

    }

    public function makeBlank($mode)
    {
        switch($mode){
            case ('cotizacion'):
                return Cotizacion::make();
                break;

            case ('contribucion'):
                return Contribucion::make();
                break;
        }
    }

    public function edit(Cotizacion $data)
    {
        $this->cotizacion = $data;
        $this->mode = 'cotizacion';
        $this->showEditModal = true;
    }

    public function editContribucion(Contribucion $data)
    {
        $this->contribucion = $data;
        $this->mode = 'contribucion';
        $this->showEditModal = true;
    }

    public function create($mode)
    {
        switch($mode){
            case ('cotizacion'):
                $this->cotizacion = Cotizacion::make();
                $this->contriAnd = [];
                $this->contriEmp = [];
                $this->data = [''];
                $this->cotCont = [];
                $this->curso_id_curso = [];
                $this->cantidad_alumnos = [];
                $this->valor_alumno = [];
                $this->nota_aprobacion = [];
                $this->modalidad = [];
                $this->contriAnd = [];
                $this->contriEmp = [];
                $this->id_cotizacion = '';
                $this->valorTotal = '';
                $this->empresa_id_empresa = '';
                $this->mode = 'cotizacion';
                $this->showEditModal = true;
                break;

            case ('contribucion'):
                $this->contribucion = Contribucion::make();
                $this->mode = 'contribucion';
                $this->showEditModal = true;
                break;
        }
    }

    public function save()
    {
        switch($this->mode){
            case ('cotizacion'):
                $this->validate();

                $id_empresa = explode(' | ', $this->empresa_id_empresa);
                $empresa = Empresa::find($id_empresa[0]);
                $fecha = Carbon::today();

                $cotizacionIdFecha = $fecha->year.$fecha->month.$fecha->day;
                $searchVowels = array("á", "é", "í", "ó", "ú","Á", "É", "Í", "Ó", "Ú",);
                $replace = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U",);
                $nombreEmpresa = str_replace($searchVowels, $replace, $empresa->nombre_empresa);

                $searchEE = array(
                    "LTDA",
                    "SPA",
                    "EIRL",
                    " S.A",
                    " S A",
                    "INGENIERIA",
                    "LIMITADA",
                    "CONSTRUCCION",
                    " Y ",
                    " E ",
                    "&",
                    ".",
                    "-",
                    " ",
                    "/",
                );


                $nombreEmpresa = array_filter(explode(',', str_replace($searchEE, ',', strtoupper($nombreEmpresa))));
                $siglas = '';

                switch (array_key_last($nombreEmpresa)) {
                    case (0):
                        $siglas = $nombreEmpresa[0];
                        break;
                    case (1):
                        $siglas = $nombreEmpresa[0] . $nombreEmpresa[1];
                        break;
                    default:
                        foreach($nombreEmpresa as $index => $i) {
                            $siglas = $siglas.substr($i, 0, 1);
                        }
                        break;
                }

                $cotizacionId= 'COT-'.$cotizacionIdFecha.'-'.$siglas;

                $cursos = LazyCollection::make( function (){
                    foreach($this->data as $index=>$i) {
                        $id_curso = explode(' | ', $this->curso_id_curso[$index]);

                        yield $curso = [
                            'curso_id_curso' => $id_curso[0],
                            'cantidad_alumnos' => $this->cantidad_alumnos[$index],
                            'valor_alumno' => $this->valor_alumno[$index],
                            'valor_actividad' => $this->valor_alumno[$index] * $this->cantidad_alumnos[$index],
                            'nota_aprobacion' => $this->nota_aprobacion[$index],
                            'cotizacion_id_cotizacion' => $this->cotizacion->id_cotizacion,
                            'modalidad' => $this->modalidad[$index],
                        ];
                        $id_curso = [];
                    }
                });


                $this->valorTotal = $cursos->sum('valor_actividad');
                $this->cotizacion->empresa_id_empresa = $id_empresa[0];
                $this->cotizacion->valor_total = $this->valorTotal;
                $this->cotizacion->codigo_cotizacion = $cotizacionId;
                $this->cotizacion->fecha_cotizacion = $fecha->year.'-'.$fecha->month.'-'.$fecha->day;

                $this->cotizacion->save();

                foreach($this->contriAnd as $c) {
                    $CC = new ContribucionCotizacion;

                    $CC->cotizacion_id_cotizacion = $this->cotizacion->id_cotizacion;
                    $CC->contribucion_id_contribucion = $c;

                    $CC->save();
                }

                foreach($this->contriEmp as $c) {
                    $CC = new ContribucionCotizacion;

                    $CC->cotizacion_id_cotizacion = $this->cotizacion->id_cotizacion;
                    $CC->contribucion_id_contribucion = $c;

                    $CC->save();
                }

                $cursos = collect($cursos);
                $this->cotizacion->cursos()->sync($cursos);

                $this->showEditModal = false;
                break;

            case ('contribucion'):
                $this->validate();
                $this->contribucion->save();
                $this->showEditModal = false;
                break;
        }
    }

    public function addCurso()
    {
        $this->data[] = '';
    }

    public function removeCurso($index)
    {
        unset($this->data[$index]);
        $this->data=array_values($this->data);
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function confirmDelete(Cotizacion $data)
    {
        $this->cotizacion = $data;
        $this->showDeleteModal = true;
    }

    public function deleteSelected()
    {
        $cotizacions = Cotizacion::whereKey($this->selected);

        $cotizacions->delete();

        $this->showDeleteModal = false;
    }

    public function getPDFModal($id)
    {
        $cotizacion = Cotizacion::find($id)
            ->cursos()
            ->with('empresas');
        $this->showPDFModal = true;
    }

    public function getPDF($id)
    {
        $cotizacion = Cotizacion::find($id);

        $this->id_cotizacion = $id;

        return response()->streamDownload(function () {
            $cotizacion = Cotizacion::find($this->id_cotizacion);

            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('pdf/pdfDocCotizacion', compact('cotizacion'));
            $pdf->setPaper('letter');
            echo $pdf->stream();
        }, $cotizacion->codigo_cotizacion . '.pdf');
    }
}
