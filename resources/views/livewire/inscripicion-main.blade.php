<div>
    <div class="space-y-3">
        <div class="mb-10 text-2xl text-center text-white">
            <span>{{ __('INSCRIPCIONES') }}</span>
        </div>

        <div class="flex space-x-5 align-middle">
            <div class="inline-block">
                <x-button.link wire:click="create">
                    <img class="inline-block" src="{{ url('img/Create.svg') }}" width="40px">
                    <span class="inline-block">CREAR</span>
                </x-button.link>
            </div>

            <div class="inline-block mt-0.5" id="dropdownMasa">
                <a href="" wire:click.prevent="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                    <img class="inline-block" src="{{ url('img/Delete.svg') }}" width="35px">
                    <span class="inline-block">ELIMINAR SELECCIONADOS</span>
                </a>
            </div>

            <div class="inline-block">
                <x-button.link wire:click="createExcel">
                    <img class="inline-block" src="{{ url('img/Excel.svg') }}" width="40px"alt="">
                    <span class="inline-block">EXPORTAR</span>
                </x-button.link>
            </div>
        </div>

        <div class="inline-block" style="border-radius: 25px">
            <x-input.select wire:model="field" class="mr-4" style="border-radius: 25px">
                <option value="codigo_unico">Por Codigo Unico</option>
                <option value="calendario_id_cal">Por Codigo de Actividad</option>
                <option value="alumno_id_alumno">Por Alumno</option>
                <option value="empresa_id_empresa">Por Empresa</option>
            </x-input.select>
        </div>

        <div class="inline-block w-1/2">
            @switch($field)
                @case('alumno_id_alumno')
                    <x-input.text wire:model="search" list="search_alumno" />

                    <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="search_alumno">
                        @forelse ($alumnos as $alumno)
                            <option value="{{ $alumno->id_alumno . ' | ' .$alumno->rut_alumno . ' | ' . $alumno->nombre_completo }}" />
                        @empty
                            <option value="">No Hay Datos Para Mostrar...</option>
                        @endforelse
                    </datalist>
                    @break

                @case('calendario_id_cal')
                    <x-input.text wire:model="search" list="search_calendario" />

                    <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="search_calendario">
                        @forelse ($calendarios as $calendario)
                            @php $curso = App\Models\Curso::find($calendario->curso_id_curso); @endphp
                            <option value="{{ $calendario->id_cal . ' | ' .$calendario->codigo_actividad . ' | ' . $curso->nombre_curso . ' | ' . $curso->horas . 'hrs.' }}" />
                        @empty
                            <option value="">No Hay Datos Para Mostrar...</option>
                        @endforelse
                    </datalist>
                    @break

                @case('empresa_id_empresa')
                    <x-input.text wire:model="search" list="search_empresa" />

                    <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="search_empresa">
                        @forelse ($empresas as $empresa)
                            <option value="{{ $empresa->id_empresa . ' | ' . $empresa->rut_empresa . ' | ' . $empresa->nombre_empresa}}"/>
                        @empty
                            <option value="">No Hay Datos Para Mostrar...</option>
                        @endforelse
                    </datalist>
                @break

                @default
                    <x-input.text wire:model="search" placeholder="Buscar..." />
                    @break
            @endswitch
        </div>
    </div>

    <div class="flex w-1/2 mt-5 mb-5 space-x-5 align-middle">
        <x-input.label class="inline-block">Resultados Por Pagina:</x-input.label>
        <x-input.select wire:model="perPage" class="inline-block">
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="500">500</option>
        </x-input.select>
    </div>

    <div class="mt-5">
        {{ $inscripcions -> links() }}

        <x-table class="mt-5">
            <x-slot name="head">
                <x-table.heading colspan="2">CONTROLES</x-table.heading>
                <x-table.heading>CODIGO UNICO</x-table.heading>
                <x-table.heading>CODIGO ACTIVIDAD</x-table.heading>
                <x-table.heading>NOMBRE ALUMNO</x-table.heading>
                <x-table.heading>RUT ALUMNO</x-table.heading>
                <x-table.heading>NOMBRE CURSO</x-table.heading>
                <x-table.heading>FECHA INICIO</x-table.heading>
                <x-table.heading>FECHA FIN</x-table.heading>
                <x-table.heading>NOMBRE EMPRESA</x-table.heading>
                <x-table.heading>ESTADO DE APROBACION</x-table.heading>
                <x-table.heading>NOTA DIAGNOSTICO</x-table.heading>
                <x-table.heading>NOTA TEORICA</x-table.heading>
                <x-table.heading>NOTA PRACTICA</x-table.heading>
                <x-table.heading>NOTA FINAL</x-table.heading>
                <x-table.heading>FECHA VENCIMIENTO</x-table.heading>
                <x-table.heading>VIGENCIA DEL CURSO</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($inscripcions as $inscripcion)
                    @php
                        $calendario = App\Models\Calendario::find($inscripcion->calendario_id_cal);
                        $curso = App\Models\Curso::find($calendario->curso_id_curso);
                    @endphp

                    <x-table.row wire:loading.class.delay="opacity-50">
                        <x-table.cell class="flex">
                            <div >
                                <x-input.checkbox class="mt-2 rounded-l rounded-r" wire:model="selected" value="{{ $inscripcion->id_insc }}" />
                            </div>

                            <x-button.link class="ml-5" wire:click="edit({{ $inscripcion->id_insc }})">
                                <img src="{{ url('img/Edit.svg') }}" width="30px">
                            </x-button.link>
                        </x-table.cell>

                        <x-table.cell>{{ $inscripcion->codigo_unico }}</x-table.cell>
                        <x-table.cell nowrap>{{ $calendario->codigo_actividad }}</x-table.cell>
                        <x-table.cell nowrap>{{ $inscripcion->alumnos->nombre_completo ?? '' }}</x-table.cell>
                        <x-table.cell nowrap>{{ $inscripcion->alumnos->rut_alumno ?? '' }}</x-table.cell>
                        <x-table.cell nowrap>{{ $curso->nombre_curso }}</x-table.cell>
                        <x-table.cell nowrap>{{ $inscripcion->calendarios->fecha_inicio }}</x-table.cell>
                        <x-table.cell nowrap>{{ $inscripcion->calendarios->fecha_fin }}</x-table.cell>
                        <x-table.cell nowrap>{{ $inscripcion->empresas->nombre_empresa ?? '' }}</x-table.cell>
                        <x-table.cell nowrap>{{ strtoupper($inscripcion->estado) }}</x-table.cell>
                        <x-table.cell>{{ $inscripcion->empresas->notaPorcentaje ?? '' ? $inscripcion->nota_en_porcentaje['nota_diagnostico'] : $inscripcion->nota_diagnostico }}</x-table.cell>
                        <x-table.cell>{{ $inscripcion->empresas->notaPorcentaje ?? '' ? $inscripcion->nota_en_porcentaje['nota_teorica'] : $inscripcion->nota_teorica }}</x-table.cell>
                        <x-table.cell>{{ $inscripcion->empresas->notaPorcentaje ?? '' ? $inscripcion->nota_en_porcentaje['nota_practica'] : $inscripcion->nota_practica }}</x-table.cell>
                        <x-table.cell>{{ $inscripcion->empresas->notaPorcentaje ?? '' ? $inscripcion->nota_en_porcentaje['nota_final'] : $inscripcion->nota_final }}</x-table.cell>
                        <x-table.cell nowrap>{{ $inscripcion->valido_hasta }}</x-table.cell>
                        <x-table.cell>{{ $inscripcion->estado === 'Aprobado' ? $curso->vigencia_curso_format : strtoupper($inscripcion->estado) }}</x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="6" class="text-xl text-center text-gray-400">
                            No Hay Campos que Mostrar...
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>

        {{ $inscripcions -> links() }}
    </div>

    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model="showDeleteModal">
            <x-slot name="title">Confirmación</x-slot>
            <x-slot name="content">
                ¿Desea Eliminar Dato Seleccionado? (esta acción es irreversible)
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$toggle('showDeleteModal')"><img src="{{ url('img/Cancel.svg') }}" alt="" width="40px"></x-button.secondary>
                <x-button.primary type="submit"><img src="{{ url('img/Delete.svg') }}" alt="" width="40px"></x-button.primary>
            </x-slot>
        </x-modal.confirmation>
    </form>

    <form wire:submit.prevent="save">
        <x-modal.dialog x-show="show" wire:model="showEditModal" >
            <x-slot name="title"> Edición/Creación de Inscripciones </x-slot>
            <x-slot name="content">
                @if($modo==='create')
                    <x-input.group :error="$errors->first('calendario_id_cal')">
                        <x-slot name="labels">
                            <x-input.label>
                                Actividad:
                            </x-input.label>
                        </x-slot>

                        <x-input.text wire:model="calendario_id_cal" list="calendario_id_cal" />

                        <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="calendario_id_cal">
                            @forelse ($calendarios as $calendario)
                                @php $curso = App\Models\Curso::find($calendario->curso_id_curso); @endphp
                                <option value="{{ $calendario->id_cal . ' | ' . $calendario->codigo_actividad . ' | ' . $curso->nombre_curso . ' | ' . $curso->horas_format }}" />
                            @empty
                                <option value="">No Hay Datos Para Mostrar...</option>
                            @endforelse
                        </datalist>
                    </x-input.group>

                    <x-input.group :error="$errors->first('empresa_id_empresa')">
                        <x-slot name="labels">
                            <x-input.label>
                                Empresa:
                            </x-input.label>
                        </x-slot>

                        <x-input.text wire:model="empresa_id_empresa" list="empresa_id_empresa" />

                        <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="empresa_id_empresa">
                            @forelse ($empresas as $empresa)
                                <option value="{{ $empresa->id_empresa . ' | ' . $empresa->rut_empresa . ' | ' . $empresa->nombre_empresa }}" />
                            @empty
                                <option value="">No Hay Datos Para Mostrar...</option>
                            @endforelse
                        </datalist>
                    </x-input.group>

                    <x-input.group :error="$errors->first('alumno_id_alumno')">
                        <x-slot name="labels">
                            <x-input.label>
                                Participante:
                            </x-input.label>
                        </x-slot>

                        <x-input.text wire:model="alumno_id_alumno" list="alumno_id_alumno" />

                        <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="alumno_id_alumno">
                            @forelse ($alumnos as $alumno)
                                <option value="{{ $alumno->id_alumno . ' | ' . $alumno->rut_alumno . ' | ' . $alumno->nombre_completo }}" />
                            @empty
                                <option value="">No Hay Datos Para Mostrar...</option>
                            @endforelse
                        </datalist>
                    </x-input.group>
                @endif

                <x-input.group :error="$errors->first('inscripcion.estado')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('Estado de Aprobación del Participante:') }}
                        </x-input.label>
                    </x-slot>

                    <div>
                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="inscripcion.estado" class="mt-2 border-white shadow-md " name="inscripcion.estado" id="estado1" value="Aprobado"/>
                            <x-input.label for="estado1">
                                {{ __('Aprobado') }}
                            </x-input.label>
                        </div>

                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="inscripcion.estado" class="mt-2 border-white shadow-md" name="inscripcion.estado" id="estado2"  value="Reprobado"/>
                            <x-input.label for="estado2">
                                {{ __('Reprobado') }}
                            </x-input.label>
                        </div>
                    </div>
                </x-input.group>

                <x-input.group :error="$errors->first('inscripcion.nota_diagnostico')">
                    <x-slot name="labels">
                        <x-input.label>
                            Nota Diagnostico:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="nota_diagnostico" id="nota_diagnostico"/>
                    <span class="ml-16 text-gray-400">{{ $nota_diagnostico == null ? '0%' : round((($nota_diagnostico * 100) / 7), 2, PHP_ROUND_HALF_UP).'%' }}</span>
                </x-input.group>

                <x-input.group :error="$errors->first('inscripcion.nota_teorica')">
                    <x-slot name="labels">
                        <x-input.label>
                            Nota Teorica:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="nota_teorica" id="nota_teorica"/>
                    <span class="ml-16 text-gray-400">{{ $nota_teorica == null ? '0%' : round((($nota_teorica * 100) / 7), 2, PHP_ROUND_HALF_UP).'%' }}</span>
                </x-input.group>

                <x-input.group :error="$errors->first('inscripcion.nota_practica')">
                    <x-slot name="labels">
                        <x-input.label>
                            Nota Practica:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="nota_practica" id="nota_practica"/>
                    <span class="ml-16 text-gray-400">{{ $nota_practica == null ? '0%' : round((($nota_practica * 100) / 7), 2, PHP_ROUND_HALF_UP).'%' }}</span>
                </x-input.group>
                
                <x-input.group :error="$errors->first('valido_hasta')">
                    <x-slot name="labels">
                        <x-input.label>
                            Fecha Vencimiento:
                        </x-input.label>
                    </x-slot>
                    <x-input.date wire:model="valido_hasta" id="valido_hasta"/>
                </x-input.group>
            </x-slot>

            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showEditModal')"><img src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
