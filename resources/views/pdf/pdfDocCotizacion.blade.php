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
        
        div {
            fontFamily: Montserrat-Thin, sans-serif;
            src: url("public/fonts/Montserrat-Thin.ttf");
        }

        #image {
            margin-top: -2.85em;
            margin-left: -2.85em;
        }

        #firma {
            margin-left: -10rem;
            bottom: 8cm;
            left: 11cm;
            z-index: -1;
        }

        #cot-wrapper {
            fontFamily: sans-serif;
        }

        .cot-wrapper {
            padding: 1vw;
            margin-top: 5em;
        }

        .dia-codigo {
            width: 100%;
            text-align: right;
        }

        .descripcion {
            text-align: justify;
            text-justify: inter-word;
        }

        .firma {
            position:fixed;
        }

        .firma-text {
            z-index: -1;
            margin-top: 7em;
            text-align: center;
        }

        .page_break {
            page-break-before: always;
        }

        .table {
            border: 1px solid black;
            border-radius: 25px;
            background-color: white;
            max-width: 200px;
        }
    </style>
</head>

<body>

    <img id="image" src="img/Informe.svg" alt="" width="113%" style="tabindex: -1; position:fixed;">

    <div class="cot-wrapper"  id="cot-wrapper" style="font-family:sans-serif;">
        <div class="dia-codigo">
            <div>
                <div class="dia">{{ $cotizacion->fecha_cotizacion }}</div>
                <div class="codigo">{{ $cotizacion->codigo_cotizacion }}</div>
            </div>
        </div>

        <div class="info-contacto">
				<span>Señor(a)</span><br>
            <span>{{ $cotizacion->empresas->nombre_contacto }}</span><br>
            <span>{{ $cotizacion->empresas->nombre_empresa }}</span><br>
            <span>Presente</span>
        </div>
        <br><br>
            <div class="costo">
                <div class="costo-title"><h3>Costos</h3></div>
                <div class="costo-table">
                    <table class="table">
                        <thead class="table-header">
                            <tr style="font-size:14px">
                                <th nowrap>Código</th>
                                <th nowrap>Actividad</th>
                                <th nowrap>Modo</th>
                                <th nowrap>Horas</th>
                                <th nowrap>% Aprob.</th>
                                <th nowrap>Part.</th>
                                <th nowrap>Costo P/Part.</th>
                                <th nowrap>Costo Actividad</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:12px">
                            @foreach ($cotizacion->cursos as $cursos)
                                <tr>
                                    <td nowrap>
                                        {{  $cursos->codigo_curso }}
                                    </td>
                                    <td>
                                        {{ $cursos->nombre_curso  }}
                                    </td>
                                    <td nowrap>
                                        {{ $cursos->detalle_curso->modalidad }}
                                    </td>
                                    <td nowrap>
                                        {{ $cursos->horas }} hrs.
                                    </td>
                                    <td>
                                        {{ $cursos->detalle_curso->nota_aprobacion . '%' }}
                                    </td>
                                    <td>
                                        {{ $cursos->detalle_curso->cantidad_alumnos }}
                                    </td>
                                    <td nowrap>
                                        {{ '$'.$cursos->detalle_curso->valor_alumno.' CLP' }}
                                    </td>
                                    <td nowrap>
                                        {{ '$'.$cursos->detalle_curso->valor_actividad.' CLP' }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5"></td>
                                <td><b>Total:</b></td>
                                <td>
                                    {{ '$'.$cotizacion->valor_total.' CLP' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <br><br>

            <div class="aportes">
                <div class="empresa">
                    <b>
								Empresa: 
							</b>

                    <span>
                        Para la correcta ejecución de la actividad solicitada, la empresa contribuirá con los recursos en la
                        cantidad y tiempo requerido, según el siguiente detalle:
                    </span>

                    <ul>
                        @foreach($cotizacion->contribucions as $c)
                            @if ($c->empresa === 'Empresa')
                                <li>{{ $c->contribucion }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <br>
                <div class="andes">
                    <b>
								Andes CCI Ltda.:
							</b>

                    <span>
                        Contribuirá con los siguientes recursos para la correcta ejecución de la actividad solicitada en la cantidad y tiempo requerido en la presente propuesta:
                    </span>

                    <ul>
                        @foreach($cotizacion->contribucions as $c)
                            @if ($c->empresa === 'Andes')
                                <li>{{ $c->contribucion }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="page_break"></div>
            <br><br><br><br>

            <div class="datos-andes">
                <div class="datos-title">
                    <b>Favor realizar Orden de Compra a:</b>
                </div>

                <div class="datos-list">
                    <ul>
                        <li>Nombre : Andes CCI Ltda.</li>
                        <li>RUT : 76.297.400-2</li>
                        <li>Dirección : Rancagua 420</li>
                        <li>Teléfono : +56-9 6347 0947</li>
                        <li>Contacto : Paula Parilo / pparilo@andescci.com</li>
                        <li>Giro : Capacitación</li>
                    </ul>
                </div>
            </div>

            <br>

            <div class="info-pago">
                <div class="pago-title">
                    <b>Información para el pago:</b>
                </div>

                <ul>
                    <li>Cuenta Vista : 12171303263</li>
                    <li>Banco : Banco Estado</li>
                    <li>Modalidad: Al Contado</li>
                </ul>
            </div>
            
            <div style="text-align:center;font-size:12px;width:300px; position: absolute; margin-left: 45%; bottom: 0;">
                <span id="rayita_firma" style="width:280px; margin-top: -.5rem"></span>
                <p style="margin-top:1.25cm; position: absolute; left:-5rem">
                    Oscar Alejandro García-Huidobro Riquelme<br/>
                    Gerente General<br/>
                    Andes Centro de Capacitación Integral<br/><br>
                </p>

                <div id="firma">
                    <img src="img/firma.png" style="width:50%;" />
                </div>
            </div>
            
            <div class="footer"></div>
        </div>
    </div>
</body>
</html>
