<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Certificado de Compotencia Laboral">
        <meta name="author" content="Andes CCI">
        <style type="text/css" media="all">
            #firma {
                margin-left: -10rem;
                margin-top: -3rem;
                left: 11cm;
                z-index: -1000;
            }
            
            #barra {
                position: absolute;
                height: 800px;
                width: 70px;
                left: 9rem;
                top: 0;
                z-index: -1000;
            }

            #logo {
                height: 2.5cm;
                top: 4cm;
            }
            #qr {
                position: absolute;
                top: 22.2cm;
                right: 3cm;
            }

            td {
                font-size:10px;
            }

            .page_break {page-break-before: always}
        </style>
    </head>
    <body>
            <div id="qr">___________QR_______________
            {!! QrCode::size(300)->generate('https://techvblogs.com/blog/generate-qr-code-laravel-9') !!}</div>
        <div>
            <table style="width:950px;font-family:sans-serif;margin-top:5em;position: absolute;">
                <tr>
                    <td>
                        <img id="barra" src="img/BarraLateral_Derecha.jpg" style="position: absolute; left: 0" />
                    </td>
                    <td>
                        <table style="position:relative; left:0cm">
                            <tr>
                                <td style="font-size:13px;width:400px">
                                    <br>
                                    <span style="font-size:13px; display:inline-block;" class="text-nowrap">
                                        Rancagua Nº 420  <br>
                                        Copiapó - Chile  <br>
                                        Fono: 056-52-2253699  <br>
                                        E-Mail: contacto@andescci.com  <br>
                                        www.andescci.com  <br>
                                    </span>
                                </td>

                                <td>
                                    <img src="img/logo-main.jpg" style="width:50%;" /><br /><br />
                                </td>
                            </tr>

                            <tr>
                                <td style="font-size:25px" colspan="3"> <br> Andes Centro de Capacitación Integral Ltda. <br> <br> </td>
                            </tr>

                            <tr>
                                <td colspan="3">Certifica que:</td>
                            </tr>

                            <tr>
                                <td style="font-size:22px" colspan="3"><b>{{ $alumno->nombre_completo }}</b></td>
                            </tr>

                            <tr>
                                <td colspan="3">Rut: <b style="font-size:18px"> {{ $alumno->rut_alumno }} </b> <br><br> </td>
                            </tr>

                            @if($curso->manejo_maquinaria==1 && $alumno->no_licencia)
                                <tr>
                                    <td colspan="3">Licencia Tipo {{ $alumno->tipo_licencia }} Número {{ $alumno->no_licencia }} {{ $alumno->vencimiento_licencia != null ? 'con vencimiento el '.$alumno->vencimiento_licencia : '' }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td colspan="3"> Empresa: </td>
                            </tr>

                            <tr>
                                <td style="font-size:18px" colspan="3"> <b>{{ $empresa->nombre_empresa }}</b> </td>
                            </tr>

                            <tr>
                                <td colspan="3">Rut: <b style="font-size:18px"> {{ $empresa->rut_empresa }} </b> <br><br> </td>
                            </tr>

                            <tr>
                                <td colspan="3">Para Actividad de:</td>
                            </tr>

                            <tr class="col">
                                <td style="font-size:18px"><b>{{ $curso->nombre_curso }}</b> <br><br></td>
                            </tr>
                            @if ($curso->sence)
                                <tr>
                                    <td colspan="3">Con Código SENCE:</td>
                                </tr>

                                <tr class="col">
                                    <td style="font-size:18px"><b>{{ $curso->codigo_curso }}</b></td>
                                </tr>

                                <tr>
                                    <td colspan="3">Y Código de Acción:</td>
                                </tr>

                                <tr class="col">
                                    <td style="font-size:18px"><b>{{ $calendario->codigo_actividad }}</b></td>
                                </tr>
                            @endif

                            <tr>
                                <td colspan="3">Nota Teorica: <b style="font-size:18px"> {{ $empresa->notaPorcentaje ? $inscripcion->nota_en_porcentaje['nota_teorica'] : $inscripcion->nota_teorica }} </b></td>
                            </tr>

                            @if ($inscripcion->nota_practica != 0)
                                <tr>
                                    <td colspan="3">Nota Practica: <b style="font-size:18px"> {{ $empresa->notaPorcentaje ? $inscripcion->nota_en_porcentaje['nota_practica'] : $inscripcion->nota_practica }} </b></td>
                                </tr>
                            @endif

                            <tr>
                                <td colspan="3">Nota Final: <b style="font-size:18px"> {{ $empresa->notaPorcentaje ? $inscripcion->nota_en_porcentaje['nota_final'] : $inscripcion->nota_final }} </b></td>
                            </tr>

                            <tr>
                                <td colspan="3"> Horas: <b style="font-size:18px">{{ $curso->horas_format }}</b> </td>
                            </tr>

                            <tr>
                                <td colspan="3">Fecha de Certificación: <b style="font-size:18px">{{ $inscripcion->calendarios->fecha_fin }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="3">Vigencia: <b style="font-size:18px">{{ $curso->vigencia_curso }} año(s) a contar de la realización de la actividad <br><br></b></td>
                            </tr>
                            <tr>
                                <td colspan="1">
                                    <img src="img/logo_inn_jpg.jpg"  style="width:30%; position: absolute; bottom: 15em"/>
                                    @php
                                        $fecha = Carbon\Carbon::now()->format('M Y');
                                    @endphp
                                    <p style="font-size:12px;margin-left:1.8cm;margin-bottom:2em">Copiapó - {{ $fecha }}</p>
                                </td>
                                <td style="text-align:center;font-size:12px;width:300px; position: absolute;">
                                    <span id="rayita_firma" style="width:280px; margin-top: -.5rem"></span>
                                    <p style="margin-top:1.25cm; position: absolute; left:-5rem">
                                        Oscar Alejandro García-Huidobro Riquelme<br/>
                                        Gerente General<br/>
                                        Andes Centro de Capacitación Inegral<br/><br>
                                        <span style="font-size:1rem; font-weight:bold"> Código Verificación: {{ $inscripcion->codigo_unico }} </span>
                                    </p>

                                    <div id="firma">
                                        <img src="img/firma.png" style="width:50%;" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

    {{-- programas --}}
    @php
        $programa = App\Models\Programa::where('curso_id_curso', $curso->id_curso)->first() ?? false;
    @endphp

    @if($programa)
        <div class="page_break" style="width:700px;">
            <table style="font-family:sans-serif;">
                <tr>
                    <td>
                        <span style="margin-left:initial">
                            <h4>
                                Objetivos Generales
                            </h4>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span id="objetivo" style="margin-left: 2rem;font-size:10px">
                            {{ $programa->objetivo_general }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span style = "margin-left:initial">
                            <h4>Horas Practicas: {{ $programa->horas_practica_format }}</h4>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span style = "margin-left:initial">
                            <h4>Horas Teoricas: {{ $programa->horas_teorica_format }}</h4>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span style="margin-left:initial">
                            <h4>Contenido</h4>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <ul class="text-justify" style="margin-left:-1rem; list-style-type: circle; font-size:10px">
                            {!! nl2br(e($programa->programa)) !!}
                        </ul>
                    </td>
                </tr>

                @if($inscripcion->calendarios->profesor_a_cargo)
                    <tr>
                        <td>
                            <span style="margin-left:initial">
                                <h4>Profesor a Cargo</h4>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>

                            <ul class="text-justify" style="margin-left:-1rem; list-style-type: circle; font-size:10px">
                                {{ $inscripcion->calendarios->profesor_a_cargo }} <b>Con Cedula de identidad</b> {{ $inscripcion->calendarios->rut_profesor }}
                            </ul>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    @endif
    </body>
</html>
