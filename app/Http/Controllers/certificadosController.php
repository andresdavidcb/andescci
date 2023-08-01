<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Empresa;
use App\Models\Calendario;
use App\Models\Alumno;
use App\Models\Curso;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class certificadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //dd($id);
        $c = Inscripcion::where('codigo_unico','=',$id)->count();
        $qr = "1";
        $inscripcion = Inscripcion::select('id_insc','estado','alumnos.apellido_paterno as apellido1','alumnos.apellido_materno as apellido2','alumnos.nombre_alumno as nombrealumno',
        'empresas.nombre_empresa','codigo_unico','inscripcions.created_at','inscripcions.updated_at')
        ->join('alumnos', 'alumnos.id_alumno', '=', 'inscripcions.alumno_id_alumno')
        ->join('empresas', 'empresas.id_empresa', '=', 'inscripcions.empresa_id_empresa')
        ->where('codigo_unico','=',$id)->first();
        /*$inscripcion = Inscripcion::where('codigo_unico', $id)->first();
        $empresa = Empresa::find($inscripcion->empresa_id_empresa);
        $calendario = Calendario::find($inscripcion->calendario_id_cal);
        $curso = Curso::find($calendario->curso_id_curso);
        $alumno = Alumno::find($inscripcion->alumno_id_alumno);
        
        $today = Carbon::today();

        $nota_diagnostico = $inscripcion->nota_diagnostico;
        $nota_teorica = $inscripcion->nota_teorica;
        $nota_practica = $inscripcion->nota_practica;
        $nota_final = $inscripcion->nota_final;
        $codigo_actividad = $inscripcion->estado === 'Aprobado' ? $calendario->codigo_actividad : strtoupper($inscripcion->estado);
        $nombreCompleto = $alumno->nombre_completo;
        $horasFormat = $curso->horas_format;
        $notaDiagnostico = $empresa->notaPorcentaje ? $inscripcion->nota_en_porcentaje['nota_diagnostico'] : $inscripcion->nota_diagnostico;
        $notaTeorica = $empresa->notaPorcentaje ? $inscripcion->nota_en_porcentaje['nota_teorica'] : $inscripcion->nota_teorica;
        $notaPractica = $empresa->notaPorcentaje ? $inscripcion->nota_en_porcentaje['nota_practica'] : $inscripcion->nota_practica;
        $notaFinal = $empresa->notaPorcentaje ? $inscripcion->nota_en_porcentaje['nota_final'] : $inscripcion->nota_final;

        $vigencia = $curso->vigencia_curso.' años';*/

        //$sql=json_encode($inscripcion);
        
        return view('livewire.consulta-certificado-main',compact('id','inscripcion','c','qr'));
    }

   
}
