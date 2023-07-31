<?php

namespace App\Http\Livewire;

use Carbon\carbon;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Empresa;
use Livewire\Component;
use App\Models\Calendario;
use App\Models\Inscripcion;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Buscador extends Component
{
    public $field = 'codigo_actividad';
    public $search = '';
    public $nombreCompleto, $horasFormat, $notaDiagnostico, $notaTeorica, $notaPractica, $notaFinal, $data, $estado, $vigencia, $rut_empresa, $empresas, $next_month, $next_two_months, $today, $codigo_actividad;
    public $showUnicoModal, $showActividadModal ,$showRutModal = false;
    public Inscripcion $inscripcion;
    public Alumno $alumno;
    public Empresa $empresa;
    public Curso $curso;
    public Calendario $calendario;

    public $rules = [
        'alumno.rut_alumno' => 'required',
        'alumno.nombre_alumno' => 'required',
        'alumno.apellido_materno' => 'required',
        'alumno.apellido_paterno' => 'required',
        'alumno.no_licencia' => 'nullable',
        'alumno.tipo_licencia' => 'nullable',
        'alumno.vencimiento_licencia' => 'nullable',
        'calendario.curso_id_curso' => 'required',
        'calendario.fecha_inicio' => 'required|date',
        'calendario.fecha_fin' => 'required|date',
        'calendario.profesor_a_cargo' => 'required',
        'calendario.rut_profesor' => 'required',
        'calendario.codigo_actividad' => 'required',
        'calendario.estado_curso' => 'required',
        'calendario.estado_inscripcion' => 'required',
        'calendario.dias_pago' => 'required',
        'calendario.estado_pago' => 'required',
        'calendario.fecha_limite' => 'date|nullable',
        'curso.codigo_curso' => 'required|string',
        'curso.nombre_curso' => 'required',
        'curso.horas' => 'required',
        'curso.vigencia_curso' => 'required',
        'curso.sence' => 'required',
        'curso.manejo_maquinaria' => 'required',
        'empresa.rut_empresa' => 'required',
        'empresa.nombre_empresa' => 'required',
        'empresa.notaPorcentaje' => 'required',
        'empresa.empresa_particular' => 'required',
        'inscripcion.estado' => 'required',
        'inscripcion.nota_diagnostico' => 'required',
        'inscripcion.nota_teorica' => 'required',
        'inscripcion.nota_practica' => 'required',
        'inscripcion.nota_final' => 'required',
        'inscripcion.valido_hasta' => 'required|date',
        'inscripcion.codigo_unico' => 'nullable',
        'inscripcion.alumno_rut_alumno' => 'required',
        'inscripcion.empresa_rut_empresa' => 'required',
        'inscripcion.calendario_id_cal' => 'required',
        'codigo_actividad',
        'nombreCompleto',
        'horasFormat',
    ];

    public function render()
    {
        return view('livewire.buscador');
    }

    public function selectOption()
    {
        switch ($this->field) {
            case 'codigo_actividad':
                $this -> CodigoActividadModal($this->search);
                break;

            case 'codigo_unico':
                $this -> CodigoUnicoModal($this->search);
                break;

            case 'rut_alumno':
                $replace = ['.', '-'];
                $this -> RutModal(str_replace($replace, '', $this->search));
                break;
        }
    }

    public function EmpresaValidation()
    {
        switch (Auth::user()->is_empresa) {
            case '1':
                if ((
                        Auth::user()->name === $this->empresa->rut_empresa &&
                        $this->empresa->id_empresa === $this->inscripcion->empresa_id_empresa
                    ) || (
                        $this->empresa->nombre_empresa === 'Particular' &&
                        $this->alumno->rut_alumno === Auth::user()->name
                    )
                ){
                    $this->resetErrorBag();
                    return true;
                } else {
                    $errors = $this->getErrorBag();
                    $errors->add('search', 'Usted no se encuentra autorizado para realizar esta busqueda');
                    return false;
                }
                break;

            case '0':
                return true;
                break;

            default:
                return false;
                break;
        }
    }

    public function CodigoActividadModal($search)
    {
        $this->calendario = Calendario::where('codigo_actividad', $search)->firstOrFail();
        $this->inscripcion = Inscripcion::where('calendario_id_cal', $this->calendario->id_cal)->firstOrFail();
        $this->data = Inscripcion::where('calendario_id_cal', $this->calendario->id_cal)->get();
        $this->alumno = Alumno::where('rut_alumno', Auth::user()->name)->orWhere('id_alumno', $this->inscripcion->alumno_id_alumno)->firstOrFail();
        $this->curso = Curso::find($this->calendario -> curso_id_curso);
        $this->empresa = Empresa::find($this->calendario->empresa_id_empresa);
        $this->today = Carbon::today();
        $this->next_month = $this->today->addMonth();
        $this->next_two_months = $this->today->addMonth(2);

        $this->empresa->nombre_empresa ==='Particular' ? $this->empresa->rut_empresa = 'Particular' : '';

        $this->showActividadModal = $this->EmpresaValidation(); //$this->EmpresaValidation retorna TRUE o FALSE dependiendo si es correcta la validacion
    }
    
    public function clear($data){
        foreach ($data as $key => $value) {
            unset($this->$key);
        }
    }

    public function CodigoUnicoModal($search)
    {
        $this->inscripcion = Inscripcion::where('codigo_unico', $search)->first();
        $this->empresa = Empresa::find($this->inscripcion->empresa_id_empresa);
        $this->calendario = Calendario::find($this->inscripcion->calendario_id_cal);
        $this->curso = Curso::find($this->calendario->curso_id_curso);
        $this->alumno = Alumno::find($this->inscripcion->alumno_id_alumno);
        
        $this->today = Carbon::today();

        $this->nota_diagnostico = $this->inscripcion->nota_diagnostico;
        $this->nota_teorica = $this->inscripcion->nota_teorica;
        $this->nota_practica = $this->inscripcion->nota_practica;
        $this->nota_final = $this->inscripcion->nota_final;
        $this->codigo_actividad = $this->inscripcion->estado === 'Aprobado' ? $this->calendario->codigo_actividad : strtoupper($this->inscripcion->estado);
        $this->nombreCompleto = $this->alumno->nombre_completo;
        $this->horasFormat = $this->curso->horas_format;
        $this->notaDiagnostico = $this->empresa->notaPorcentaje ? $this->inscripcion->nota_en_porcentaje['nota_diagnostico'] : $this->inscripcion->nota_diagnostico;
        $this->notaTeorica = $this->empresa->notaPorcentaje ? $this->inscripcion->nota_en_porcentaje['nota_teorica'] : $this->inscripcion->nota_teorica;
        $this->notaPractica = $this->empresa->notaPorcentaje ? $this->inscripcion->nota_en_porcentaje['nota_practica'] : $this->inscripcion->nota_practica;
        $this->notaFinal = $this->empresa->notaPorcentaje ? $this->inscripcion->nota_en_porcentaje['nota_final'] : $this->inscripcion->nota_final;

        $this->vigencia = $this->curso->vigencia_curso.' años';

        $this->showUnicoModal = $this->EmpresaValidation(); //$this->EmpresaValidation retorna TRUE o FALSE dependiendo si es correcta la validacion
    }

    public function RutModal($search)
    {
        $this->alumno = Alumno::where('rut_alumno', $search)->orderBy('created_at', 'desc')->firstOrFail();
        $this->nombreCompleto = $this->alumno->nombre_completo;

        switch(Auth::user()->is_empresa){
            case '1':
                $this->empresa = Empresa::where('rut_empresa', Auth::user()->name)->firstOrFail();
                $this->empresas = Empresa::where('rut_empresa', Auth::user()->name)->get();
                $this->inscripcion = Inscripcion::where('alumno_id_alumno', $this->alumno->id_alumno)->where('empresa_id_empresa', $this->empresa->id_empresa)->firstOrFail();
                $this->data = Inscripcion::where('alumno_id_alumno', $this->alumno->id_alumno)->where('empresa_id_empresa', $this->empresa->id_empresa)->get();
                $this->showRutModal = $this->EmpresaValidation(); //$this->EmpresaValidation retorna TRUE o FALSE dependiendo si es correcta la validacion
                break;

            case '0':
                $this->inscripcion = Inscripcion::where('alumno_id_alumno', $this->alumno->id_alumno)->first();
                $this->empresas = Empresa::where('id_empresa', $this->inscripcion->empresa_id_empresa)->get();
                $this->data = Inscripcion::where('alumno_id_alumno', $this->alumno->id_alumno)->get();
                
                //dd($this->empresas);
                $this->showRutModal = true;
                break;
        }

        
    }

    public function genCertificadoUnico() // para certificados en buscador por codigo unico
    {
        $this->inscripcion = Inscripcion::with('alumnos')
            -> with ('calendarios', 'calendarios.cursos')
            -> with ('empresas')
            -> where('codigo_unico', $this->search)
            -> first();
        $this->alumno = Alumno::where('id_alumno', $this->inscripcion->alumno_id_alumno)->first();
        $this->calendario = Calendario::where('id_cal', $this->inscripcion->calendario_id_cal)->first();
        $this->curso = Curso::where('id_curso', $this->calendario->curso_id_curso)->first();

        return response()->streamDownload(function () {
            $inscripcion = $this->inscripcion;
            $alumno = $this->alumno;
            $empresa = $this->empresa;
            $calendario = $this->calendario;
            $curso = $this->curso;

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf/pdfDocCertificado', compact('inscripcion', 'curso', 'alumno', 'empresa', 'calendario'));
            $pdf->setPaper('letter');
            echo $pdf->stream();
        }, $this->alumno->nombre_alumno.' '.$this->alumno->apellido_paterno.' '.$this->alumno->apellido_materno.' - '.$this->curso->nombre_curso.'.pdf');
    }

    public function genCertificadoActividad($id) //para certificados en buscador por codigo de actividad
    {
        $this->inscripcion = Inscripcion::findOrFail($id);
        $this->alumno = Alumno::find($this->inscripcion->alumno_id_alumno);
        $this->empresa = Empresa::find($this->inscripcion->empresa_id_empresa);
        $this->calendario = Calendario::find($this->inscripcion->calendario_id_cal);
        $this->curso = Curso::find($this->calendario->curso_id_curso);

        return response()->streamDownload(function () {
            $inscripcion = $this->inscripcion;
            $alumno = $this->alumno;
            $empresa = $this->empresa;
            $calendario = $this->calendario;
            $curso = $this->curso;

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf/pdfDocCertificado', compact('inscripcion', 'curso', 'alumno', 'empresa', 'calendario'));
            $pdf->setPaper('letter');
            echo $pdf->stream();
        }, $this->alumno->nombre_alumno.' '.$this->alumno->apellido_paterno.' '.$this->alumno->apellido_materno.' - '.$this->curso->nombre_curso.'.pdf');
    }

    public function genInforme()
    {
        $inscripcion = Inscripcion::with('empresas')
            -> with(['calendarios', 'calendarios.cursos'])
            -> where('alumno_rut_alumno', $this->search)
            -> first();

        $alumno = Alumno::where('rut_alumno', $this->search)-> first();

        $inscripciones = Inscripcion::with('alumnos')
            -> with('empresas')
            -> with(['calendarios', 'calendarios.cursos'])
            -> where('alumno_rut_alumno', $this->search)
            -> get();

        $pdf = PDF::loadView('pdf/pdfDocInforme', compact('inscripcion', 'inscripciones', 'alumno'));

        return $pdf->stream();
    }
}
