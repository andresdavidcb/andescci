<div>
    <div class="space-y-3">
        <div class="mb-10 text-2xl text-center text-white">
            <span>{{ __('PROGRAMAS') }}</span>
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

        {{--<div class="inline-block">
            <x-input.select wire:model="field" class="mr-4">
                <option value="objetivo_general">Por Objetivo General</option>
                <option value="id_programas">Por RUT de la programa</option>
            </x-input.select>
        </div>
        <div class="inline-block w-1/2">
            <x-input.text wire:model="search" placeholder="Buscar..." />
        </div>--}}
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
        {{ $programas -> links() }}
        <x-table class="mt-5">
            <x-slot name="head">
                <x-table.heading colspan="2">CONTROLES</x-table.heading>
                <x-table.heading>CODIGO CURSO</x-table.heading>
                <x-table.heading>NOMBRE CURSO</x-table.heading>
                <x-table.heading>HORAS TEORICAS</x-table.heading>
                <x-table.heading>HORAS PRACTICAS</x-table.heading>
                <x-table.heading>OBJETIVO GENERAL</x-table.heading>
                <x-table.heading>PROGRAMA</x-table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($programas as $programa)
                    @php $curso = App\Models\Curso::find($programa->curso_id_curso); @endphp

                    <x-table.row wire:loading.class.delay="opacity-50">
                        <x-table.cell class="flex">
                            <div >
                                <x-input.checkbox class="mt-2 rounded-l rounded-r" wire:model="selected" value="{{ $programa->id_programas }}" />
                            </div>

                            <x-button.link class="ml-5" wire:click="edit({{ $programa->id_programas }})">
                                <img src="{{ url('img/Edit.svg') }}" width="30px">
                            </x-button.link>
                        </x-table.cell>
                        <x-table.cell>{{ $curso->codigo_curso ?? '' }}</x-table.cell>
                        <x-table.cell nowrap>{{ $curso->nombre_curso ?? '' }}</x-table.cell>
                        <x-table.cell nowrap>{{ $programa->horas_teorica_format }}</x-table.cell>
                        <x-table.cell nowrap>{{ $programa->horas_practica_format }}</x-table.cell>
                        <x-table.cell nowrap>{{ $programa->objetivo_general }}</x-table.cell>
                        <x-table.cell nowrap><span class="overflow-y-auto">{!! nl2br(e($programa->programa)) !!}</span></x-table.cell>
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
        {{ $programas -> links() }}
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
            <x-slot name="title"> Edición/Creación de Programas </x-slot>
            <x-slot name="content">
                <x-input.group :error="$errors->first('programa.curso_id_curso')">
                    <x-slot name="labels">
                        <x-input.label>
                            Curso:
                        </x-input.label>
                    </x-slot>

                    <x-input.text wire:model="curso_id_curso" list="curso_id_curso" />

                    <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="curso_id_curso">
                        @forelse ($cursos as $curso)
                            <option value="{{ $curso->id_curso . ' | ' . $curso->codigo_curso . ' | ' . $curso->nombre_curso  . ' | ' . $curso->horas . 'hrs. | ' . $curso->vigencia_curso . ' año(s)' }}" />
                        @empty
                            <option value="">No Hay Datos Para Mostrar...</option>
                        @endforelse
                    </datalist>

                </x-input.group>

                <x-input.group :error="$errors->first('objetivo_general')">
                    <x-slot name="labels">
                        <x-input.label>
                            Objetivo General:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="objetivo_general" id="objetivo_general"/>
                </x-input.group>

                <x-input.group :error="$errors->first('programa_curso')">
                    <x-slot name="labels">
                        <x-input.label>
                            Programa:
                        </x-input.label>
                    </x-slot>
                    <x-input.textarea wire:model="programa_curso" id="programa"/>
                </x-input.group>

                <x-input.group :error="$errors->first('programa.horas_practica')">
                    <x-slot name="labels">
                        <x-input.label>
                            Horas Practicas:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="programa.horas_practica" id="horas_practica"/>
                </x-input.group>

                <x-input.group :error="$errors->first('programa.horas_teorica')">
                    <x-slot name="labels">
                        <x-input.label>
                            Horas Teoricas:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="programa.horas_teorica" id="horas_teorica"/>
                </x-input.group>
            </x-slot>
            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showEditModal')"><img src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
