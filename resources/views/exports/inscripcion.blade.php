<div>
    <table class="mt-5">
        <thead>
            <tr>
                <th>CODIGO UNICO</th>
                <th>CODIGO ACTIVIDAD</th>
                <th>NOMBRE ALUMNO</th>
                <th>RUT ALUMNO</th>
                <th>NOMBRE CURSO</th>
                <th>FECHA INICIO</th>
                <th>FECHA FIN</th>
                <th>NOMBRE EMPRESA</th>
                <th>ESTADO DE APROBACION</th>
                <th>NOTA DIAGNOSTICO</th>
                <th>NOTA TEORICA</th>
                <th>NOTA PRACTICA</th>
                <th>NOTA FINAL</th>
                <th>FECHA VENCIMIENTO</th>
                <th>VIGENCIA DEL CURSO</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscripcions as $inscripcion)
                @php
                    $calendario = App\Models\Calendario::find($inscripcion->calendario_id_cal);
                    $test = $calendario->curso_id_curso ?? '';
                    $curso = App\Models\Curso::find($test);
                    $alumno = App\Models\Alumno::find($inscripcion->alumno_id_alumno);
                    $empresa = App\Models\Empresa::find($inscripcion->empresa_id_empresa);
                @endphp
                <tr>
                    <x-table.cell>{{ $inscripcion->codigo_unico }}</x-table.cell>
                    <x-table.cell nowrap>{{ $calendario->codigo_actividad ?? '' }}</x-table.cell>
                    <x-table.cell nowrap>{{ $alumno->nombre_completo ?? '' }}</x-table.cell>
                    <x-table.cell nowrap>{{ $alumno->rut_alumno ?? '' }}</x-table.cell>
                    <x-table.cell nowrap>{{ $curso->nombre_curso ?? '' }}</x-table.cell>
                    <x-table.cell nowrap>{{ $calendario->fecha_inicio ?? '' }}</x-table.cell>
                    <x-table.cell nowrap>{{ $calendario->fecha_fin ?? '' }}</x-table.cell>
                    <x-table.cell nowrap>{{ $empresa->nombre_empresa ?? '' }}</x-table.cell>
                    <x-table.cell nowrap>{{ strtoupper($inscripcion->estado) }}</x-table.cell>
                    <x-table.cell>{{ $empresa->notaPorcentaje ?? '' ? $inscripcion->nota_en_porcentaje['nota_diagnostico'] : $inscripcion->nota_diagnostico }}</x-table.cell>
                    <x-table.cell>{{ $empresa->notaPorcentaje ?? '' ? $inscripcion->nota_en_porcentaje['nota_teorica'] : $inscripcion->nota_teorica }}</x-table.cell>
                    <x-table.cell>{{ $empresa->notaPorcentaje ?? '' ? $inscripcion->nota_en_porcentaje['nota_practica'] : $inscripcion->nota_practica }}</x-table.cell>
                    <x-table.cell>{{ $empresa->notaPorcentaje ?? '' ? $inscripcion->nota_en_porcentaje['nota_final'] : $inscripcion->nota_final }}</x-table.cell>
                    <x-table.cell nowrap>{{ $inscripcion->valido_hasta }}</x-table.cell>
                    <x-table.cell>{{ $inscripcion->estado === 'Aprobado' ? ($curso->vigencia_curso_format ?? '') : strtoupper($inscripcion->estado) }}</x-table.cell>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-xl text-center text-gray-400">
                        No Hay Campos que Mostrar...
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
