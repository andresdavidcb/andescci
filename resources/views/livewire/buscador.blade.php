<div>
    <div class="flex justify-center space-x-5 text-2xl text-white">
        {{ __('CERTIFICADOS') }}
    </div>

    <form wire:submit.prevent="selectOption" class="flex justify-center w-full mt-12 mb-12 align-middle">
        @csrf

        <div class="inline-block w-3/4 mt-2">
            <x-input.text wire:model="search" placeholder="Buscar..." />
            @if ($errors)
                <div class="mt-1 text-sm text-red-500">{{ $errors->first('search') }}</div>
            @endif
        </div>

        <x-button.primary type="submit" class="inline-block">
            <img class="hover:animate-wiggle" src="{{ url('img/Search.svg') }}" alt="Search" width="40px">
        </x-button.primary>
    </form>

    <div class="ml-40">
        <div class="flex space-x-5 align-middle">
            <x-input.radio wire:model="field" class="mt-2 border-white shadow-md " name="searchField" id="field1" value="codigo_actividad"/>
            <x-input.label for="field1">
                <b>Codigo Actividad:</b> <span>Muestra un listado de alumnos que participaron en un curso y permite la descarga de los certificados correspondientes</span>
            </x-input.label>
        </div>

        <div class="flex space-x-5 align-middle">
            <x-input.radio wire:model="field" class="mt-2 border-white shadow-md" name="searchField" id="field2" value="codigo_unico"/>
            <x-input.label for="field2">
                <b>Codigo Unico:</b> <span>Muestra la información del participante de un curso específico</span>
            </x-input.label>
        </div>

        <div class="flex space-x-5 align-middle">
            <x-input.radio wire:model="field" class="mt-2 border-white shadow-md" name="searchField" id="field3" value="rut_alumno"/>
            <x-input.label for="field3">
                <b>RUT Alumno:</b> <span>Muestra un listado de cursos que el participante ha asistido</span>
            </x-input.label>
        </div>
    </div>

    {{-- RESULTADO CODIGO ACTIVIDAD --}}
    @if ($empresa && $curso)
        <div>
            <x-modal.dialog x-show="show" wire:model="showActividadModal">
                <x-slot name="title"> Resultado </x-slot>

                <x-slot name="content">
                    <x-input.group>
                        <x-slot name="labels">
                            <x-input.label>
                                Nombre Empresa:
                            </x-input.label>
                        </x-slot>

                        <x-output.text wire:model="empresa.nombre_empresa"/>
                    </x-input.group>

                    <x-input.group>
                        <x-slot name="labels">
                            <x-input.label>
                                RUT Empresa:
                            </x-input.label>
                        </x-slot>

                        <x-output.text wire:model="empresa.rut_empresa"/>
                    </x-input.group>

                    <x-input.group>
                        <x-slot name="labels">
                            <x-input.label>
                                Nombre del Curso:
                            </x-input.label>
                        </x-slot>

                        <x-output.text wire:model="curso.nombre_curso"/>
                    </x-input.group>

                    <x-input.group>
                        <x-slot name="labels">
                            <x-input.label>
                                Codigo de Actividad:
                            </x-input.label>
                        </x-slot>

                        <x-output.text wire:model="calendario.codigo_actividad"/>
                    </x-input.group>

                    <x-table class="w-full mt-5">
                        <x-slot name="head">
                            @if ($calendario->estado_certificado['estado'] && $inscripcion->estado_certificado['estado'])
                                <x-table.heading colspan="2">DESCARGAR CERTIFICADO</x-table.heading>
                            @endif

                            <x-table.heading>NOMBRE ALUMNO</x-table.heading>
                            <x-table.heading>RUT ALUMNO</x-table.heading>
                            <x-table.heading>CODIGO UNICO</x-table.heading>
                            <x-table.heading>ESTADO</x-table.heading>
                            <x-table.heading>NOTA DIAGNOSTICO</x-table.heading>
                            <x-table.heading>NOTA TEORICA</x-table.heading>
                            <x-table.heading>NOTA PRACTICA</x-table.heading>
                            <x-table.heading>NOTA FINAL</x-table.heading>
                        </x-slot>

                        <x-slot name="body">
                            @if ($data)
                                @foreach($data as $i)
                                    @php
                                        $alumno = App\Models\Alumno::find($i->alumno_id_alumno)
                                    @endphp

                                    <x-table.row wire:loading.class.delay="opacity-50">
                                        @if ($calendario->estado_certificado['estado'] && $i->estado_certificado['estado'] && $i->estado === 'Aprobado')
                                            <x-table.cell class="flex">
                                                <x-button.primary wire:click="genCertificadoActividad({{ $i->id_insc }})">
                                                    <img class="hover:animate-wiggle" src="{{  url('img/PDF.svg')  }}" width="40px">
                                                </x-button.primary>
                                            </x-table.cell>
                                        @else
                                            <x-table.cell></x-table.cell>
                                        @endif

                                        <x-table.cell>{{ $alumno->apellido_paterno . ' ' . $alumno->apellido_materno . ', ' . $alumno->nombre_alumno }}</x-table.cell>
                                        <x-table.cell>{{ $alumno->rut_alumno }}</x-table.cell>

                                        @if ($calendario->estado_certificado['estado']  && $i->estado_certificado['estado'])
                                            <x-table.cell>{{ $i->estado === 'Aprobado' ? $i->codigo_unico : $i->estado }}</x-table.cell>
                                            <x-table.cell>{{ $i->estado }}</x-table.cell>
                                            <x-table.cell>{{ $empresa->notaPorcentaje ? $i->nota_en_porcentaje['nota_diagnostico'] : $i->nota_diagnostico }}</x-table.cell>
                                            <x-table.cell>{{ $empresa->notaPorcentaje ? $i->nota_en_porcentaje['nota_teorica'] : $i->nota_teorica }}</x-table.cell>
                                            <x-table.cell>{{ $empresa->notaPorcentaje ? $i->nota_en_porcentaje['nota_practica'] : $i->nota_practica }}</x-table.cell>
                                            <x-table.cell>{{ $empresa->notaPorcentaje ? $i->nota_en_porcentaje['nota_final'] : $i->nota_final }}</x-table.cell>

                                        @elseif (!$calendario->estado_certificado['estado'])
                                            <x-table.cell colspan="6"><h3 class="text-red-500">{{ $calendario->estado_certificado['error'] }}</h3></x-table.cell>

                                        @elseif (!$i->estado_certificado['estado'])
                                            <x-table.cell colspan="6"><h3 class="text-red-500">{{ $inscripcion->estado_certificado['error'] }}</h3></x-table.cell>
                                        @endif
                                    </x-table.row>
                                @endforeach
                            @endif
                        </x-slot>
                    </x-table>
                </x-slot>

                <x-slot name="footer">
                    <x-button.link wire:click.prevent="$toggle('showActividadModal')"><img class="hover:animate-wiggle" src="{{  url('img/Cancel.svg')  }}" width="40px"></x-button.secondary>
                </x-slot>
            </x-modal.dialog>
        </div>
    @endif

    {{-- RESULTADO CODIGO UNICO --}}
    @if ($inscripcion && $calendario && $curso)
        <div>
            <form wire:submit.prevent="genCertificadoUnico">
                <x-modal.dialog x-show="show" wire:model="showUnicoModal">
                    <x-slot name="title"> Resultado </x-slot>

                    <x-slot name="content">
                        <div>
                            @if ($calendario->estado_certificado['estado'] && $inscripcion->estado_certificado['estado'])
                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Codigo Unico:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="inscripcion.codigo_unico"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Codigo Actividad:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="codigo_actividad"/>
                                </x-input.group>
                            @else
                                <div class="w-full mb-5">
                                    <div class="grid h-20 grid-rows-3 text-red-500 border border-red-500 rounded-3xl w-100">
                                        <div></div>
                                        <span class="justify-self-center">
                                            {{ !$calendario->estado_certificado['estado'] ? $calendario->estado_certificado['error'] : $inscripcion->estado_certificado['error'] }}
                                        </span>
                                        <div></div>
                                    </div>
                                </div>
                            @endif

                            <x-input.group class="border-t-none">
                                <x-slot name="labels">
                                    <x-input.label>
                                        Rut del Participante:
                                    </x-input.label>
                                </x-slot>
                                <x-output.text wire:model="alumno.rut_alumno"/>
                            </x-input.group>

                            <x-input.group>
                                <x-slot name="labels">
                                    <x-input.label>
                                        Nombre del Participante:
                                    </x-input.label>
                                </x-slot>

                                <x-output.text wire:model="nombreCompleto"/>
                            </x-input.group>

                            <x-input.group>
                                <x-slot name="labels">
                                    <x-input.label>
                                        Nombre de la Empresa:
                                    </x-input.label>
                                </x-slot>

                                <x-output.text wire:model="empresa.nombre_empresa"/>
                            </x-input.group>

                            <x-input.group>
                                <x-slot name="labels">
                                    <x-input.label>
                                        RUT de la Empresa:
                                    </x-input.label>
                                </x-slot>

                                <x-output.text wire:model="empresa.rut_empresa" />
                            </x-input.group>

                            @if ($calendario->estado_certificado['estado'] && $inscripcion->estado_certificado['estado'])
                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Nombre del Curso:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="curso.nombre_curso"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Codigo del Curso:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="curso.codigo_curso"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Horas del Curso:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="horasFormat"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Inicio del Curso:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="calendario.fecha_inicio"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Fin del Curso:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="calendario.fecha_fin"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Estado de Aprobacion:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="inscripcion.estado"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Nota Diagnostico:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="notaDiagnostico"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Nota Teorica:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="notaTeorica"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Nota Practica:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="notaPractica"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Nota Final:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="notaFinal"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Vencimiento:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="inscripcion.valido_hasta"/>
                                </x-input.group>

                                <x-input.group>
                                    <x-slot name="labels">
                                        <x-input.label>
                                            Vigencia:
                                        </x-input.label>
                                    </x-slot>

                                    <x-output.text wire:model="curso.vigencia_curso" />
                                </x-input.group>
                            @endif
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-button.link wire:click.prevent="$toggle('showUnicoModal')"><img class="hover:animate-wiggle" src="{{  url('img/Cancel.svg')  }}" width="40px"></x-button.link>

                        @if ($calendario->estado_certificado['estado'] && $inscripcion->estado_certificado['estado'])
                            <x-button.primary type="submit"><img class="hover:animate-wiggle" src="{{  url('img/PDF.svg')  }}" width="40px"></x-button.primary>
                        @endif
                    </x-slot>
                </x-modal.dialog>
            </form>
        </div>
    @endif

    {{-- RESULTADO RUT ALUMNO --}}
    @if ($alumno)
        <div>
            <x-modal.dialog x-show="show" wire:model="showRutModal">
                <x-slot name="title"> Resultado </x-slot>

                <x-slot name="content">
                    <x-input.group>
                        <x-slot name="labels">
                            <x-input.label>
                                Rut del Alumno:
                            </x-input.label>
                        </x-slot>
                        <x-output.text wire:model="alumno.rut_alumno"/>
                    </x-input.group>

                    <x-input.group>
                        <x-slot name="labels">
                            <x-input.label>
                                Nombre del Alumno:
                            </x-input.label>
                        </x-slot>
                        <x-output.text wire:model="nombreCompleto"/>
                    </x-input.group>

                    <x-table class="w-full mt-5">
                        <x-slot name="head">
                            <x-table.heading colspan="2">DESCARGAR CERTIFICADO</x-table.heading>
                            <x-table.heading>CODIGO UNICO</x-table.heading>
                            <x-table.heading>CODIGO ACTIVIDAD</x-table.heading>
                            <x-table.heading>CODIGO CURSO</x-table.heading>
                            <x-table.heading>VENCIMIENTO</x-table.heading>
                            <x-table.heading>VIGENCIA</x-table.heading>
                            <x-table.heading>NOTA DIAGNOSTICO</x-table.heading>
                            <x-table.heading>NOTA TEORICA</x-table.heading>
                            <x-table.heading>NOTA PRACTICA</x-table.heading>
                            <x-table.heading>NOTA FINAL</x-table.heading>
                            <x-table.heading>ESTADO</x-table.heading>
                            <x-table.heading>NOMBRE CURSO</x-table.heading>
                            <x-table.heading>NOMBRE EMPRESA</x-table.heading>
                            <x-table.heading>RUT EMPRESA</x-table.heading>
                        </x-slot>

                        <x-slot name="body">
                            @if (isset($empresas))
                                    @foreach($data as $i)
                                        @php
                                            $empresa = App\Models\Empresa::find($i->empresa_id_empresa);
                                            $calendario = App\Models\Calendario::find($i->calendario_id_cal);
                                            $curso = App\Models\Curso::find($calendario->curso_id_curso);
                                        @endphp
        
                                        <x-table.row wire:loading.class.delay="opacity-50">
                                            @if($calendario->estado_certificado['estado'] && $i->estado_certificado['estado'])
                                                <x-table.cell class="flex">
                                                    <x-button.primary wire:click="genCertificadoActividad({{ $i->id_insc }})"><img class="hover:animate-wiggle" src="{{  url('img/PDF.svg')  }}" width="40px"></x-button.primary>
                                                </x-table.cell>
        
                                                <x-table.cell>{{ $i->codigo_unico }}</x-table.cell>
                                                <x-table.cell>{{ $i->estado }}</x-table.cell>
                                                <x-table.cell>{{ $calendario->codigo_actividad }}</x-table.cell>
                                                <x-table.cell>{{ $curso->codigo_curso }}</x-table.cell>
                                                <x-table.cell>{{ $i->valido_hasta }}</x-table.cell>
                                                <x-table.cell>{{ $curso->vigencia_curso }}</x-table.cell>
                                                <x-table.cell>{{ $empresa->notaPorcentaje ? $i->nota_en_porcentaje['nota_diagnostico'] : $i->nota_diagnostico }}</x-table.cell>
                                                <x-table.cell>{{ $empresa->notaPorcentaje ? $i->nota_en_porcentaje['nota_teorica'] : $i->nota_teorica }}</x-table.cell>
                                                <x-table.cell>{{ $empresa->notaPorcentaje ? $i->nota_en_porcentaje['nota_practica'] : $i->nota_practica }}</x-table.cell>
                                                <x-table.cell>{{ $empresa->notaPorcentaje ? $i->nota_en_porcentaje['nota_final'] : $i->nota_final }}</x-table.cell>
                                            @else
                                                <x-table.cell>
                                                    @if($calendario->estado_certificado['estado'] || $i->estado_certificado['estado'])
                                                        {{ __('CERTIFICADO INVALIDO') }}
                                                    @elseif ($i->estado !== 'Aprobado')
                                                        {{ strtoupper($i->estado) }}
                                                    @endif
                                                </x-table.cell>
        
                                                <x-table.cell colspan="8">{{ $calendario->estado_certificado['estado'] ? $calendario->estado_certificado['error'] : $inscripcion->estado_certificado['error'] ?? '' }}</x-table.cell>
                                            @endif
        
                                            <x-table.cell>{{ $curso->nombre_curso }}</x-table.cell>
                                            <x-table.cell>{{ $empresa->rut_empresa }}</x-table.cell>
                                            <x-table.cell>{{ $empresa->nombre_empresa }}</x-table.cell>
                                        </x-table.row>
                                    @endforeach
                            @endif
                        </x-slot>
                    </x-table>
                </x-slot>

                <x-slot name="footer" class="">
                    <x-button.link wire:click.prevent="$toggle('showRutModal')"><img class="hover:animate-wiggle" src="{{  url('img/Cancel.svg')  }}" width="40px"></x-button.secondary>
                </x-slot>
            </x-modal.dialog>
        </div>
    @endif
</div>





