<div>
    <div class="space-y-3">
        <div class="mb-10 text-2xl text-center text-white">
            <span>{{ __('PARTICIPANTES') }}</span>
        </div>
        <div class="flex space-x-5 align-middle">
            <div class="inline-block">
                <x-button.link wire:click="create">
                    <img class="inline-block hover:animate-wiggle" src="{{ url('img/Create.svg') }}" width="40px">
                    <span class="inline-block">CREAR</span>
                </x-button.link>
            </div>

            <div class="inline-block mt-0.5" id="dropdownMasa">
                <a href="" wire:click.prevent="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                    <img class="inline-block hover:animate-wiggle" src="{{ url('img/Delete.svg') }}" width="35px">
                    <span class="inline-block">ELIMINAR SELECCIONADOS</span>
                </a>
            </div>
        </div>

        <div class="inline-block">
            <x-input.select wire:model="field" class="mr-4">
                <option value="nombre_alumno">Por Nombre del Participante</option>
                <option value="apellido_materno">Por Apellido Materno</option>
                <option value="apellido_paterno">Por Apellido Paterno</option>
                <option value="rut_alumno">Por RUT del Participantes</option>
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
        {{ $alumnos -> links() }}
        <x-table class="mt-5">
            <x-slot name="head">
                <x-table.heading colspan="2">CONTROLES</x-table.heading>
                <x-table.heading>RUT PARTICIPANTE</x-table.heading>
                <x-table.heading>NOMBRE PARTICIPANTE</x-table.heading>
                <x-table.heading>Nº LICENCIA</x-table.heading>
                <x-table.heading>TIPO LICENCIA</x-table.heading>
                <x-table.heading>VENCIMIENTO LICENCIA</x-table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($alumnos as $alumno)
                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $alumno->id_alumno }}">
                        <x-table.cell class="flex">
                            <div >
                                <x-input.checkbox class="mt-2 rounded-l rounded-r" wire:model="selected" value="{{ $alumno->id_alumno }}" />
                            </div>

                            <div class="ml-5">
                                <x-button.link wire:click="edit({{ $alumno->id_alumno }})">
                                    <img class="hover:animate-wiggle" src="{{ url('img/Edit.svg') }}" width="30px">
                                </x-button.link>
                            </div>

                        </x-table.cell>
                        <x-table.cell>{{ $alumno->rut_alumno }}</x-table.cell>
                        <x-table.cell>{{ $alumno->nombre_completo }}</x-table.cell>
                        <x-table.cell>{{ $alumno->no_licencia }}</x-table.cell>
                        <x-table.cell>{{ $alumno->tipo_licencia }}</x-table.cell>
                        <x-table.cell>
                            {{ $alumno->vencimiento_licencia }}
                        </x-table.cell>
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
        {{ $alumnos -> links() }}
    </div>

    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model="showDeleteModal">
            <x-slot name="title">Confirmación</x-slot>
            <x-slot name="content">
                ¿Desea Eliminar Dato Seleccionado? (esta acción es irreversible)
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$toggle('showDeleteModal')"><img class="hover:animate-wiggle" src="{{ url('img/Cancel.svg') }}" alt="" width="40px"></x-button.secondary>
                <x-button.primary type="submit"><img class="hover:animate-wiggle" src="{{ url('img/Delete.svg') }}" alt="" width="40px"></x-button.primary>
            </x-slot>
        </x-modal.confirmation>
    </form>

    <form wire:submit.prevent="save">
        <x-modal.dialog x-show="show" wire:model="showCreateModal" >
            <x-slot name="title"> Edición/Creación de Participantes </x-slot>

            <x-slot name="content">
                <x-input.group>
                    <x-button.primary wire:click.prevent="addAlumno">
                        <img src="{{ url('img/Add.svg') }}" width="40px">
                    </x-button.primary>
                </x-input.group>

                @foreach ($data as $index => $i)
                    <hr><hr>

                    <x-input.group>
                        <x-button.secondary wire:click.prevent="removeAlumno({{ $index }})"> <img src="{{ url('img/Cancel.svg') }}" alt="" width="40px"> </x-button.secondary>
                    </x-input.group>

                    <x-input.group :error="$errors->first('rut_alumno_array.{{ $index }}')">
                        <x-slot name="labels">
                            <x-input.label>
                                RUT del Participante:
                            </x-input.label>
                        </x-slot>

                        {{-- TODO: Hacer funcar el chequeo de RUT --}}
                        <x-input.text wire:model="rut_alumno_array.{{ $index }}" />
                    </x-input.group>

                    <x-input.group :error="$errors->first('nombre_alumno.{{ $index }}')">
                        <x-slot name="labels">
                            <x-input.label>
                                Nombre del Participante:
                            </x-input.label>
                        </x-slot>

                        <x-input.text wire:model="nombre_alumno.{{ $index }}" id="nombre_alumno"/>
                    </x-input.group>

                    <x-input.group :error="$errors->first('apellido_paterno.{{ $index }}')">
                        <x-slot name="labels">
                            <x-input.label>
                                Apellido Paterno del Participante:
                            </x-input.label>
                        </x-slot>

                        <x-input.text wire:model="apellido_paterno.{{ $index }}" id="apellido_paterno"/>
                    </x-input.group>

                    <x-input.group :error="$errors->first('apellido_materno.{{ $index }}')">
                        <x-slot name="labels">
                            <x-input.label>
                                Apellido Materno del Participante:
                            </x-input.label>
                        </x-slot>

                        <x-input.text wire:model="apellido_materno.{{ $index }}" id="apellido_materno"/>
                    </x-input.group>

                    <x-input.group :error="$errors->first('no_licencia.{{ $index }}')">
                        <x-slot name="labels">
                            <x-input.label>
                                Numero de Licencia:
                            </x-input.label>
                        </x-slot>

                        <x-input.text wire:model="no_licencia.{{ $index }}" id="no_licencia"/>
                    </x-input.group>

                    <x-input.group :error="$errors->first('tipo_licencia.{{ $index }}')">
                        <x-slot name="labels">
                            <x-input.label>
                                Tipo de Licencia:
                            </x-input.label>
                        </x-slot>

                        <x-input.text wire:model="tipo_licencia.{{ $index }}" id="tipo_licencia"/>
                    </x-input.group>

                    <x-input.group :error="$errors->first('vencimiento_licencia.{{ $index }}')">
                        <x-slot name="labels">
                            <x-input.label>
                                Vencimiento de Licencia:
                            </x-input.label>
                        </x-slot>

                        <x-input.date wire:model="vencimiento_licencia.{{ $index }}" id="vencimiento_licencia" />
                    </x-input.group>
                @endforeach

                    <x-input.group>
                        <x-button.primary wire:click.prevent="addAlumno">
                            <img src="{{ url('img/Add.svg') }}" width="40px">
                        </x-button.primary>
                    </x-input.group>
            </x-slot>
            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showCreateModal')"><img class="hover:animate-wiggle" src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img class="hover:animate-wiggle" src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>

    <form wire:submit.prevent="save">
        <x-modal.dialog x-show="show" wire:model="showEditModal" >
            <x-slot name="title"> Edición/Creación de Participantes </x-slot>

            <x-slot name="content">
                <x-input.group :error="$errors->first('rut_alumno')">
                    <x-slot name="labels">
                        <x-input.label>
                            RUT del Alumno:
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="rut_alumno" id="RUT" onblur="checkRut(this)"/>
                </x-input.group>

                <x-input.group :error="$errors->first('alumno.nombre_alumno')">
                    <x-slot name="labels">
                        <x-input.label>
                            Nombre del Participante:
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="alumno.nombre_alumno" id="nombre_alumno"/>
                </x-input.group>

                <x-input.group :error="$errors->first('alumno.apellido_paterno')">
                    <x-slot name="labels">
                        <x-input.label>
                            Apellido Paterno del Participante:
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="alumno.apellido_paterno" id="apellido_paterno"/>
                </x-input.group>

                <x-input.group :error="$errors->first('alumno.apellido_materno')">
                    <x-slot name="labels">
                        <x-input.label>
                            Apellido Materno del Participante:
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="alumno.apellido_materno" id="apellido_materno"/>
                </x-input.group>

                <x-input.group :error="$errors->first('alumno.no_licencia')">
                    <x-slot name="labels">
                        <x-input.label>
                            Numero de Licencia:
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="alumno.no_licencia" id="no_licencia"/>
                </x-input.group>

                <x-input.group :error="$errors->first('alumno.tipo_licencia')">
                    <x-slot name="labels">
                        <x-input.label>
                            Tipo de Licencia:
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="alumno.tipo_licencia" id="tipo_licencia"/>
                </x-input.group>

                <x-input.group :error="$errors->first('alumno.vencimiento_licencia')">
                    <x-slot name="labels">
                        <x-input.label>
                            Vencimiento de Licencia:
                        </x-input.label>
                    </x-slot>

                    <x-input.date wire:model="alumno.vencimiento_licencia" id="vencimiento_licencia" wire:ignore/>
                </x-input.group>
            </x-slot>
            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showEditModal')"><img class="hover:animate-wiggle" src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img class="hover:animate-wiggle" src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
