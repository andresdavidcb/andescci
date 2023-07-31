<div>
    <div class="space-y-3">
        <div class="mb-10 text-2xl text-center text-white">
            <span>{{ __('EMPRESAS') }}</span>
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
                    <option value="nombre_empresa">Por Nombre de la Empresa</option>
                    <option value="rut_empresa">Por RUT de la Empresa</option>
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
        {{ $empresas -> links() }}
        <x-table class="mt-5">
            <x-slot name="head">
                <x-table.heading colspan="2">CONTROLES</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('rut_empresa')" :direction="$sortField === 'rut_empresa' ? $sortDirection : null">RUT empresa</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('nombre_empresa')" :direction="$sortField === 'nombre_empresa' ? $sortDirection : null">NOMBRE EMPRESA</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('nombre_contacto')" :direction="$sortField === 'nombre_contacto' ? $sortDirection : null">NOMBRE CONTACTO</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('email_contacto')" :direction="$sortField === 'email_contacto' ? $sortDirection : null">EMAIL CONTACTO</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tel_contacto')" :direction="$sortField === 'tel_contacto' ? $sortDirection : null">TELEFONO CONTACTO</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('notaPorcentaje')" :direction="$sortField === 'notaPorcentaje' ? $sortDirection : null">¿Pide Porcentaje?</x-table.heading>

            </x-slot>
            <x-slot name="body">
                @forelse($empresas as $empresa)
                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $empresa->id_empresa }}">
                        <x-table.cell class="flex">
                            <div >
                                <x-input.checkbox class="mt-2 rounded-l rounded-r" wire:model="selected" value="{{ $empresa->id_empresa }}" />
                            </div>

                            <div class="ml-5">
                                <x-button.link wire:click="edit({{ $empresa->id_empresa }})">
                                    <img src="{{ url('img/Edit.svg') }}" width="30px">
                                </x-button.link>
                            </div>

                        </x-table.cell>
                        <x-table.cell nowrap>{{ $empresa->rut_empresa }}</x-table.cell>
                        <x-table.cell>{{ $empresa->nombre_empresa }}</x-table.cell>
                        <x-table.cell>{{ $empresa->nombre_contacto }}</x-table.cell>
                        <x-table.cell>{{ $empresa->email_contacto }}</x-table.cell>
                        <x-table.cell>{{ $empresa->tel_contacto }}</x-table.cell>
                        <x-table.cell>{{ $empresa->nota_porcentaje_bool }}</x-table.cell>
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
        {{ $empresas -> links() }}
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
            <x-slot name="title"> Edición/Creación de Empresas </x-slot>
            <x-slot name="content">
                <x-input.group label="Rut de la Empresa:" :error="$errors->first('rut_empresa')">
                    <x-slot name="labels">
                        <x-input.label for="RUT" >
                            RUT Empresa:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="rut_empresa" id="RUT" onblur="checkRut(this)" />
                </x-input.group>
                <x-input.group for="nombre_empresa" label="Nombre de la Empresa:" :error="$errors->first('empresa.nombre_empresa')">
                    <x-slot name="labels">
                        <x-input.label>
                            Nombre Empresa:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="empresa.nombre_empresa" id="nombre_empresa"/>
                </x-input.group>
                <x-input.group for="nombre_contacto" label="Nombre del Contacto:" :error="$errors->first('empresa.nombre_contacto')">
                    <x-slot name="labels">
                        <x-input.label>
                            Nombre Contacto:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="empresa.nombre_contacto" id="nombre_contacto"/>
                </x-input.group>

                <x-input.group for="email_contacto" label="¿Pide Porcentaje?"  :error="$errors->first('empresa.email_contacto')">
                    <x-slot name="labels">
                        <x-input.label>
                            E-Mail Contacto:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="empresa.email_contacto" id="email_contacto"/>
                </x-input.group>

                <x-input.group :error="$errors->first('empresa.tel_contacto')">
                    <x-slot name="labels">
                        <x-input.label>
                            Teléfono Contacto:
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="empresa.tel_contacto" id="tel_contacto"/>
                </x-input.group>

                <x-input.group :error="$errors->first('empresa.notaPorcentaje')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('¿La Empresa Pide Resultados con Porcentaje?:') }}
                        </x-input.label>
                    </x-slot>

                    <div>
                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="empresa.notaPorcentaje" class="mt-2 border-white shadow-md " name="empresa.notaPorcentaje" id="notaPorcentaje1" value="1"/>
                            <x-input.label for="notaPorcentaje1">
                                {{ __('Sí') }}
                            </x-input.label>
                        </div>

                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="empresa.notaPorcentaje" class="mt-2 border-white shadow-md" name="empresa.notaPorcentaje" id="notaPorcentaje0"  value="0"/>
                            <x-input.label for="notaPorcentaje0">
                                {{ __('No') }}
                            </x-input.label>
                        </div>
                    </div>
                </x-input.group>

            </x-slot>
            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showEditModal')"><img src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
