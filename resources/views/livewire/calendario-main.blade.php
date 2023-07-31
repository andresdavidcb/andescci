<div>
    <div class="space-y-3">
        <div class="mb-10 text-2xl text-center text-white">
            <span>{{ __('CALENDARIO') }}</span>
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
        </div>

        <div class="inline-block">
            <x-input.select wire:model="field" class="mr-4">
                <option value="fecha_inicio">Por Fecha de Inicio</option>
                <option value="codigo_actividad">Por Codigo de Actividad</option>
            </x-input.select>
        </div>
        <div class="inline-block w-1/2">
            <x-input.text wire:model="search" placeholder="Buscar..." />
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
        {{ $calendarios -> links() }}
        <x-table class="mt-5">
            <x-slot name="head">
                <x-table.heading colspan="2">CONTROLES</x-table.heading>
                <x-table.heading>CODIGO ACTIVIDAD</x-table.heading>
                <x-table.heading>CODIGO CURSO</x-table.heading>
                <x-table.heading>NOMBRE CURSO</x-table.heading>
                <x-table.heading>FECHA INICIO</x-table.heading>
                <x-table.heading>FECHA FIN</x-table.heading>
                <x-table.heading>RELATOR</x-table.heading>
                <x-table.heading>RUT RELATOR</x-table.heading>
                <x-table.heading>DIAS PAGO</x-table.heading>
                <x-table.heading>FECHA LIMITE</x-table.heading>
                <x-table.heading>ESTADO PAGO</x-table.heading>
                <x-table.heading>ESTADO CURSO</x-table.heading>
                <x-table.heading>ESTADO INSCRIPCION</x-table.heading>
                <x-table.heading>CODIGO ORDEN DE COMPRA</x-table.heading>
                <x-table.heading>ORDEN DE COMPRA</x-table.heading>
                <x-table.heading>FECHA ORDEN DE COMPRA</x-table.heading>
                <x-table.heading>CODIGO FACTURA</x-table.heading>
                <x-table.heading>FACTURA</x-table.heading>
                <x-table.heading>FECHA FACTURA</x-table.heading>
                <x-table.heading>NOMBRE EMPRESA</x-table.heading>
                <x-table.heading>RUT EMPRESA</x-table.heading>
                <x-table.heading>NOMBRE CONTACTO</x-table.heading>
                <x-table.heading>EMAIL CONTACTO</x-table.heading>
                <x-table.heading>TELÉFONO CONTACTO</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($calendarios as $calendario)
                    @php
                        $empresa = App\Models\Empresa::find($calendario->empresa_id_empresa);
                        $curso = App\Models\Curso::where('id_curso', $calendario->curso_id_curso)->first();
                    @endphp
                    <x-table.row wire:loading.class.delay="opacity-50">
                        <x-table.cell class="flex">
                            <div >
                                <x-input.checkbox class="mt-2 rounded-l rounded-r" wire:model="selected" value="{{ $calendario->id_cal }}" />
                            </div>

                            <x-button.link class="ml-5" wire:click="edit({{ $calendario->id_cal }}, 'edit')">
                                <img src="{{ url('img/Edit.svg') }}" width="30px">
                            </x-button.link>
                        </x-table.cell>
                        <x-table.cell>{{ $calendario->codigo_actividad }}</x-table.cell>
                        <x-table.cell nowrap>{{ $curso->codigo_curso }}</x-table.cell>
                        <x-table.cell nowrap>{{ $curso->nombre_curso }}</x-table.cell>
                        <x-table.cell nowrap>{{ $calendario->fecha_inicio }}</x-table.cell>
                        <x-table.cell nowrap>{{ $calendario->fecha_fin }}</x-table.cell>
                        <x-table.cell nowrap>{{ $calendario->profesor_a_cargo }}</x-table.cell>
                        <x-table.cell>{{ $calendario->rut_profesor }}</x-table.cell>
                        <x-table.cell>{{ $calendario->estado_pago == "Por Pagar" ? $calendario->dias_pago : 'Pagado'}}</x-table.cell>
                        <x-table.cell nowrap>{{ $calendario->estado_pago == "Por Pagar" ? $calendario->fecha_limite : 'Pagado' }}</x-table.cell>
                        <x-table.cell>{{ $calendario->estado_pago }}</x-table.cell>
                        <x-table.cell>{{ $calendario->estado_curso }}</x-table.cell>
                        <x-table.cell>{{ $calendario->estado_inscripcion }}</x-table.cell>
                        <x-table.cell nowrap>
                            <div class="flex">
                                <img src="{{ url('img/Alert.svg') }}" class="{{ $calendario->codigo_orden ? 'hidden' : '' }}" width="15%">
                                <span>{{ $calendario->codigo_orden ? $calendario->codigo_orden : __('No Presenta Orden de Compra') }}</span>
                            </div>
                        </x-table.cell>
                        <x-table.cell nowrap>
                            @if ($calendario->path_orden)
                                <x-button.link wire:click.prevent="download({{ $calendario->id_cal }}, 'ordenes')">
                                    <img src="{{ url('img/PDF.svg') }}" width="30px">
                                </x-button.link>

                                <x-button.link wire:click="edit({{ $calendario->id_cal }}, 'orden')">
                                    <img src="{{ url('img/Edit.svg') }}" width="30px">
                                </x-button.link>
                            @else
                                <x-button.link wire:click="edit({{ $calendario->id_cal }}, 'orden')">
                                    <img src="{{ url('img/Add.svg') }}" width="30px">
                                </x-button.link>
                            @endif
                        </x-table.cell>

                        <x-table.cell nowrap>
                            <div class="flex">
                                <img src="{{ url('img/Alert.svg') }}" class="{{ $calendario->codigo_orden ? 'hidden' : '' }}" width="15%">
                                <span>{{ $calendario->fecha_orden ? $calendario->fecha_orden : 'No Presenta Orden de Compra' }}</span>
                            </div>
                        </x-table.cell>

                        <x-table.cell nowrap>
                            <div class="flex">
                                <img src="{{ url('img/Alert.svg') }}" class="{{ $calendario->codigo_orden ? 'hidden' : '' }}" width="15%">
                                <span>{{ $calendario->codigo_factura ? $calendario->codigo_factura : 'No Presenta Factura'}}</span>
                            </div>
                        </x-table.cell>

                        <x-table.cell nowrap>
                            @if ($calendario->path_factura)
                                <x-button.link wire:click.prevent="download({{ $calendario->id_cal }}, 'facturas')">
                                    <img src="{{ url('img/PDF.svg') }}" width="30px">
                                </x-button.link>

                                <x-button.link wire:click="edit({{ $calendario->id_cal }}, 'factura')">
                                    <img src="{{ url('img/Edit.svg') }}" width="30px">
                                </x-button.link>
                            @else
                                <x-button.link wire:click="edit({{ $calendario->id_cal }}, 'factura')">
                                    <img src="{{ url('img/Add.svg') }}" width="30px">
                                </x-button.link>
                            @endif
                        </x-table.cell>
                        <x-table.cell nowrap class="flex">
                            <img src="{{ url('img/Alert.svg') }}" class="{{ $calendario->codigo_orden ? 'hidden' : '' }}" width="15%">
                            <span>{{ $calendario->fecha_factura ? $calendario->fecha_factura : 'No Presenta Factura' }}</span>
                        </x-table.cell>
                        <x-table.cell nowrap>{{ $empresa->nombre_empresa ?? '' }}</x-table.cell>
                        <x-table.cell nowrap>{{ $empresa->rut_empresa ?? '' }}</x-table.cell>
                        <x-table.cell nowrap>{{ $empresa->nombre_contacto ?? '' }}</x-table.cell>
                        <x-table.cell nowrap>{{ $empresa->email_contacto ?? '' }}</x-table.cell>
                        <x-table.cell nowrap>{{ $empresa->tel_contacto ?? '' }}</x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="25" class="text-xl text-center text-gray-400">
                            No Hay Campos que Mostrar...
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
        {{ $calendarios -> links() }}
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

    <form wire:submit.prevent="save('data')">
        <x-modal.dialog x-show="show" wire:model="showEditModal" >
            <x-slot name="title"> Edición/Creación de Calendarios </x-slot>
            <x-slot name="content">
                <x-input.group :error="$errors->first('calendario.codigo_actividad')">
                    <x-slot name="labels">
                        <x-input.label>
                            Codigo de Actividad:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="calendario.codigo_actividad" id="codigo_actividad" leadingAddOn="{{ url('img/Input.svg') }}" autofocus/>
                </x-input.group>

                <x-input.group :error="$errors->first('calendario.curso_id_curso')">
                    <x-slot name="labels">
                        <x-input.label>
                            Curso:
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="curso_id_curso" list="curso_id_curso" />

                    <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="curso_id_curso">
                        @forelse ($cursos as $curso)
                            <option value="{{ $curso->id_curso . ' | ' . $curso->codigo_curso . ' | ' . $curso->nombre_curso . ' | ' . $curso->horas . 'hrs. | ' . $curso->vigencia_curso . ' años' }}" />
                        @empty
                            <option value="">No Hay Datos Para Mostrar...</option>
                        @endforelse
                    </datalist>
                </x-input.group>

                <x-input.group :error="$errors->first('calendario.empresa_id_empresa')">
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

                <x-input.group :error="$errors->first('calendario.fecha_inicio')">
                    <x-slot name="labels">
                        <x-input.label>
                            Fecha de Inicio:
                        </x-input.label>
                    </x-slot>
                    <x-input.date wire:model="calendario.fecha_inicio" id="fecha_inicio"/>
                </x-input.group>

                <x-input.group :error="$errors->first('calendario.fecha_fin')">
                    <x-slot name="labels">
                        <x-input.label>
                            Fecha Fin:
                        </x-input.label>
                    </x-slot>
                    <x-input.date wire:model="calendario.fecha_fin" id="fecha_fin"/>
                </x-input.group>

                <x-input.group :error="$errors->first('calendario.profesor_a_cargo')">
                    <x-slot name="labels">
                        <x-input.label>
                            Relator:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="calendario.profesor_a_cargo" id="profesor_a_cargo"/>
                </x-input.group>

                <x-input.group for="RUT" :error="$errors->first('calendario.rut_profesor')">
                    <x-slot name="labels">
                        <x-input.label>
                            Rut del Relator:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="rut_profesor" id="RUT" onblur="checkRut(this)"/>
                </x-input.group>

                <x-input.group :error="$errors->first('calendario.estado_pago')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('Estado del Pago de la Actividad:') }}
                        </x-input.label>
                    </x-slot>

                    <div>
                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="calendario.estado_pago" class="mt-2 border-white shadow-md " name="calendario.estado_pago" id="estado_pago1" value="Pagado"/>
                            <x-input.label for="estado_pago1">
                                {{ __('Pagado') }}
                            </x-input.label>
                        </div>

                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="calendario.estado_pago" class="mt-2 border-white shadow-md" name="calendario.estado_pago" id="estado_pago0"  value="Por Pagar"/>
                            <x-input.label for="estado_pago0">
                                {{ __('Por Pagar') }}
                            </x-input.label>
                        </div>
                    </div>
                </x-input.group>

                <x-input.group :error="$errors->first('calendario.estado_curso')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('Estado de la Actividad:') }}
                        </x-input.label>
                    </x-slot>

                    <div>
                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="calendario.estado_curso" class="mt-2 border-white shadow-md " name="calendario.estado_curso" id="estado_curso1" value="En Curso"/>
                            <x-input.label for="estado_curso1">
                                {{ __('En Ejecucion') }}
                            </x-input.label>
                        </div>

                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="calendario.estado_curso" class="mt-2 border-white shadow-md" name="calendario.estado_curso" id="estado_curso0"  value="Cerrado"/>
                            <x-input.label for="estado_curso0">
                                {{ __('Cerrado') }}
                            </x-input.label>
                        </div>
                    </div>
                </x-input.group>

                <x-input.group :error="$errors->first('calendario.estado_inscripcion')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('Estado Inscripcion:') }}
                        </x-input.label>
                    </x-slot>

                    <div>
                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="calendario.estado_inscripcion" class="mt-2 border-white shadow-md " name="calendario.estado_inscripcion" id="estado_inscripcion1" value="Abierta"/>
                            <x-input.label for="estado_inscripcion1">
                                {{ __('Abierta') }}
                            </x-input.label>
                        </div>

                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="calendario.estado_inscripcion" class="mt-2 border-white shadow-md" name="calendario.estado_inscripcion" id="estado_inscripcion0"  value="Cerrada"/>
                            <x-input.label for="estado_inscripcion0">
                                {{ __('Cerrada') }}
                            </x-input.label>
                        </div>
                    </div>
                </x-input.group>

                @if($createMode)
                    <x-input.group>
                        <x-button.primary wire:click.prevent="addInscripcion">
                            <img src="{{ url('img/Add.svg') }}" width="40px">
                        </x-button.primary>
                    </x-input.group>

                    @foreach ($data as $index => $d)
                        <hr><hr>

                        <x-input.group>
                            <x-button.secondary wire:click.prevent="removeInscripcion({{ $index }})"> <img src="{{ url('img/Cancel.svg') }}" alt="" width="40px"> </x-button.secondary>
                        </x-input.group>

                        <x-input.group>
                            <x-slot name="labels">
                                Alumno:
                            </x-slot>

                            <x-input.text wire:model="alumno_id_alumno.{{ $index }}" list="alumno_id_alumno" />

                            <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="alumno_id_alumno">
                                @forelse ($alumnos as $alumno)
                                    <option value="{{ $alumno->id_alumno . ' | ' . $alumno->rut_alumno . ' | ' . $alumno->nombre_completo }}" />
                                @empty
                                    <option value="">No Hay Datos Para Mostrar...</option>
                                @endforelse
                            </datalist>
                        </x-input.group>

                        <x-input.group>
                            <x-button.primary wire:click.prevent="addInscripcion">
                                <img src="{{ url('img/Add.svg') }}" width="40px">
                            </x-button.primary>
                        </x-input.group>
                    @endforeach
                @endif

            </x-slot>
            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showEditModal')"><img src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>

    <form wire:submit.prevent="save('orden')">
        <x-modal.dialog x-show="show" wire:model="showOrdenModal" >
            <x-slot name="title"> Agregar Archivo Orden De Compra </x-slot>
            <x-slot name="content">
                <x-input.group :error="$errors->first('calendario.codigo_orden')">
                    <x-slot name="labels">
                        <x-input.label>
                            Codigo de Orden de Compra:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="calendario.codigo_orden" id="codigo_orden"/>
                </x-input.group>

                <x-input.group :error="$errors->first('orden')">
                    <x-slot name="labels">
                        <x-input.label>
                            Archivo Orden de Compra
                        </x-input.label>
                    </x-slot>
                    <x-input.file-upload wire:model="orden" id="orden" filename="{{ $orden ? $orden->getClientOriginalName() : '' }}"/>
                </x-input.group>

                <x-input.group :error="$errors->first('fecha_orden')">
                    <x-slot name="labels">
                        <x-input.label>
                            Fecha Orden de Compra
                        </x-input.label>
                    </x-slot>
                    <x-input.date wire:model="calendario.fecha_orden" id="fecha_orden" />
                </x-input.group>
            </x-slot>
            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showOrdenModal')"><img src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>

    <form wire:submit.prevent="save('factura')">
        <x-modal.dialog x-show="show" wire:model="showFacturaModal" >
            <x-slot name="title"> Agregar Archivo Factura </x-slot>
            <x-slot name="content">
                <x-input.group :error="$errors->first('calendario.codigo_factura')">
                    <x-slot name="labels">
                        <x-input.label>
                            Codigo de Factura:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="calendario.codigo_factura" id="codigo_factura"/>
                </x-input.group>

                <x-input.group :error="$errors->first('factura')">
                    <x-slot name="labels">
                        <x-input.label>
                            Archivo Factura
                        </x-input.label>
                    </x-slot>
                    <x-input.file-upload wire:model="factura" id="factura" filename="{{ $factura ? $factura->getClientOriginalName() : '' }}"/>
                </x-input.group>

                <x-input.group :error="$errors->first('fecha_factura')">
                    <x-slot name="labels">
                        <x-input.label>
                            Fecha Factura
                        </x-input.label>
                    </x-slot>
                    <x-input.date wire:model="calendario.fecha_factura" id="fecha_factura" />
                </x-input.group>
            </x-slot>
            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showFacturaModal')"><img src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
