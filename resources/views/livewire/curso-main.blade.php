<div>
    <div class="space-y-3">
        <div class="mb-10 text-2xl text-center text-white">
            <span>{{ __('CURSOS') }}</span>
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
                <option value="nombre_curso">Por Nombre del Curso</option>
                <option value="codigo_curso">Por Codigo del Curso</option>
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
        {{ $cursos -> links() }}

        <x-table class="mt-5">
            <x-slot name="head">
                <x-table.heading colspan="2">CONTROLES</x-table.heading>
                <x-table.heading>CODIGO CURSO</x-table.heading>
                <x-table.heading>NOMBRE CURSO</x-table.heading>
                <x-table.heading>HORAS</x-table.heading>
                <x-table.heading>VIGENCIA</x-table.heading>
                <x-table.heading>¿SENCE?</x-table.heading>
                <x-table.heading>¿MANEJO?</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($cursos as $curso)
                    <x-table.row wire:loading.class.delay="opacity-50">
                        <x-table.cell class="flex">
                            <div >
                                <x-input.checkbox class="mt-2 rounded-l rounded-r" wire:model="selected" value="{{ $curso->id_curso }}" />
                            </div>

                            <x-button.link class="ml-5" wire:click="edit({{ $curso->id_curso  }})">
                                <img src="{{ url('img/Edit.svg') }}" width="30px">
                            </x-button.link>
                        </x-table.cell>

                        <x-table.cell>{{ $curso->codigo_curso }}</x-table.cell>
                        <x-table.cell>{{ $curso->nombre_curso }}</x-table.cell>
                        <x-table.cell>{{ $curso->horas_format }}</x-table.cell>
                        <x-table.cell>{{ $curso->vigencia_curso_format }}</x-table.cell>
                        <x-table.cell>{{ $curso->sence_bool }}</x-table.cell>
                        <x-table.cell>{{ $curso->maquinaria_bool }}</x-table.cell>
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

        {{ $cursos -> links() }}
    </div>


    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model="showDeleteModal">
            <x-slot name="title">Confirmación</x-slot>

            <x-slot name="content">
                ¿Desea Eliminar Dato Seleccionado? (esta acción es irreversible)
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$toggle('showDeleteModal')">
                    <img src="{{ url('img/Cancel.svg') }}" alt="" width="40px">
                </x-button.secondary>

                <x-button.primary type="submit">
                    <img src="{{ url('img/Delete.svg') }}" alt="" width="40px">
                </x-button.primary>
            </x-slot>
        </x-modal.confirmation>
    </form>

    <form wire:submit.prevent="save">

        <x-modal.dialog x-show="show" wire:model="showEditModal" >
            <x-slot name="title"> Edición/Creación de Cursos </x-slot>

            <x-slot name="content">
                <x-input.group for="codigo_curso" :error="$errors->first('curso.codigo_curso')">
                    <x-slot name="labels">
                        <x-input.label>
                            Codigo del curso
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="curso.codigo_curso" id="codigo_curso"/>
                </x-input.group>

                <x-input.group for="nombre_curso" :error="$errors->first('curso.nombre_curso')">
                    <x-slot name="labels">
                        <x-input.label>
                            Nombre del curso:
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="curso.nombre_curso" id="nombre_curso"/>
                </x-input.group>

                <x-input.group for="horas" :error="$errors->first('curso.horas')">
                    <x-slot name="labels">
                        <x-input.label>
                            Horas del curso
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="curso.horas" id="horas"/>
                </x-input.group>

                <x-input.group for="vigencia_curso" :error="$errors->first('curso.vigencia_curso')">
                    <x-slot name="labels">
                        <x-input.label>
                            Vigencia del curso
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="curso.vigencia_curso" id="vigencia_curso"/>
                </x-input.group>

                <x-input.group :error="$errors->first('curso.sence')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('¿Es un Curso SENCE?:') }}
                        </x-input.label>
                    </x-slot>

                    <div>
                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="curso.sence" class="mt-2 border-white shadow-md " name="curso.sence" id="sence1" value="1"/>
                            <x-input.label for="sence1">
                                {{ __('Sí') }}
                            </x-input.label>
                        </div>

                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="curso.sence" class="mt-2 border-white shadow-md" name="curso.sence" id="sence0"  value="0"/>
                            <x-input.label for="sence0">
                                {{ __('No') }}
                            </x-input.label>
                        </div>
                    </div>
                </x-input.group>

                <x-input.group :error="$errors->first('manejo_maquinaria')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('¿Es un Curso de Manejo de Vehiculos o Maquinaria?:') }}
                        </x-input.label>
                    </x-slot>

                    <div>
                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="curso.manejo_maquinaria" class="mt-2 border-white shadow-md " name="manejo_maquinaria" id="manejo_maquinaria1" value="1"/>
                            <x-input.label for="manejo_maquinaria1">
                                {{ __('Sí') }}
                            </x-input.label>
                        </div>

                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="curso.manejo_maquinaria" class="mt-2 border-white shadow-md" name="manejo_maquinaria" id="manejo_maquinaria0"  value="0"/>
                            <x-input.label for="manejo_maquinaria0">
                                {{ __('No') }}
                            </x-input.label>
                        </div>
                    </div>
                </x-input.group>
            </x-slot>


            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showEditModal')">
                    <img src="{{ url('img/Cancel.svg') }}" width="30px">
                </x-button.secondary>

                <x-button.primary type="submit">
                    <img src="{{ url('img/Accept.svg') }}" width="30px">
                </x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
