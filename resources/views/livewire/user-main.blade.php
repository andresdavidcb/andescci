<div>
    <div class="space-y-3">
        <div class="mb-10 text-2xl text-center text-white">
            <span>{{ __('USUARIOS') }}</span>
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
    </div>
    <div class="mt-5 w-full">
        @if(Auth::user()->is_admin)
            <x-table class="mt-5 w-1/2">
                <x-slot name="head">
                    <x-table.heading colspan="2">{{ __('CONTROLES') }}</x-table.heading>
                    <x-table.heading>{{ __('USUARIO') }}</x-table.heading>
                    <x-table.heading>{{ __('EMAIL') }}</x-table.heading>
                    <x-table.heading>{{ __('ADMIN') }}</x-table.heading>
                    <x-table.heading>{{ __('EMPRESA') }}</x-table.heading>
                </x-slot>
                
                <x-slot name="body">
                    @forelse($users as $user)
                        @if(!$user->is_empresa)
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $user->id }}">
                                <x-table.cell class="flex">
                                    <div>
                                        <x-input.checkbox class="mt-2 rounded-l rounded-r" wire:model="selected" value="{{ $user->id }}" />
                                    </div>
        
                                    <div class="ml-5">
                                        <x-button.link wire:click="edit({{ $user->id }})">
                                            <img class="hover:animate-wiggle" src="{{ url('img/Edit.svg') }}" width="30px">
                                        </x-button.link>
                                    </div>
                                </x-table.cell>
                                <x-table.cell>{{ $user->name }}</x-table.cell>
                                <x-table.cell>{{ $user->email }}</x-table.cell>
                                <x-table.cell>{{ $user->is_admin === 1 ? __('Sí') : __('No') }}</x-table.cell>
                                <x-table.cell>{{ $user->is_empresa === 1 ? __('Sí') : __('No')}}</x-table.cell>
                            </x-table.row>
                        @endif
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6" class="text-xl text-center text-gray-400">
                                {{ __('No Hay Campos que Mostrar...') }}
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>
        @endif    
        <x-table class="mt-5 w-1/2">
            <x-slot name="head">
                <x-table.heading colspan="2">{{ __('CONTROLES') }}</x-table.heading>
                <x-table.heading>{{ __('USUARIO') }}</x-table.heading>
                <x-table.heading>{{ __('EMAIL') }}</x-table.heading>
                <x-table.heading>{{ __('ADMIN') }}</x-table.heading>
                <x-table.heading>{{ __('EMPRESA') }}</x-table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($users as $user)
                    @if($user->is_empresa)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $user->id }}">
                            <x-table.cell class="flex">
                                <div >
                                    <x-input.checkbox class="mt-2 rounded-l rounded-r" wire:model="selected" value="{{ $user->id }}" />
                                </div>
    
                                <div class="ml-5">
                                    <x-button.link wire:click="edit({{ $user->id }})">
                                        <img class="hover:animate-wiggle" src="{{ url('img/Edit.svg') }}" width="30px">
                                    </x-button.link>
                                </div>
    
                            </x-table.cell>
                            <x-table.cell>{{ $user->name }}</x-table.cell>
                            <x-table.cell>{{ $user->email }}</x-table.cell>
                            <x-table.cell>{{ $user->is_admin === 1 ? __('Sí') : __('No') }}</x-table.cell>
                            <x-table.cell>{{ $user->is_empresa === 1 ? __('Sí') : __('No')}}</x-table.cell>
                        </x-table.row>
                    @endif
                @empty
                    <x-table.row>
                        <x-table.cell colspan="6" class="text-xl text-center text-gray-400">
                            {{ __('No Hay Campos que Mostrar...') }}
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
    </div>

    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model="showDeleteModal">
            <x-slot name="title">{{ __('Confirmación') }}</x-slot>
            <x-slot name="content">
                {{ __('¿Desea Eliminar Dato Seleccionado? (esta acción es irreversible)') }}
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$toggle('showDeleteModal')"><img class="hover:animate-wiggle" src="{{ url('img/Cancel.svg') }}" alt="" width="40px"></x-button.secondary>
                <x-button.primary type="submit"><img class="hover:animate-wiggle" src="{{ url('img/Delete.svg') }}" alt="" width="40px"></x-button.primary>
            </x-slot>
        </x-modal.confirmation>
    </form>

    <form wire:submit.prevent="save">
        <x-modal.dialog x-show="show" wire:model="showEditModal" >
            <x-slot name="title"> {{ __('Edición/Creación de Usuarios') }} </x-slot>
            <x-slot name="content">
                <x-input.group :error="$errors->first('user.name')">
                    <x-slot name="labels">
                        <x-input.label for="name">
                            {{ __('Nombre de Usuario (Si es empresa usar rut sin puntos ni guion):') }}
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="user.name" id="name"/>
                </x-input.group>

                <x-input.group :error="$errors->first('user.email')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('E-Mail del Usuario (correo de contacto si es empresa):') }}
                        </x-input.label>
                    </x-slot>
                    <x-input.text wire:model="user.email" id="email"/>
                </x-input.group>

                <x-input.group :error="$errors->first('password')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('Contraseña:') }}
                        </x-input.label>
                    </x-slot>
                    <x-input.password wire:model="password" id="password"/>
                </x-input.group>

                <x-input.group :error="$errors->first('password_confirmation')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('Confirmación de Contraseña:') }}
                        </x-input.label>
                    </x-slot>
                    <x-input.password wire:model="password_confirmation" id="password_confirmation"/>
                </x-input.group>

                @if (Auth::user()->is_admin)
                    <x-input.group :error="$errors->first('user.is_admin')">
                        <x-slot name="labels">
                            <x-input.label>
                                {{ __('Es Admin?:') }}
                            </x-input.label>
                        </x-slot>

                        <div>
                            <div class="flex space-x-5 align-middle">
                                <x-input.radio wire:model="is_admin" class="mt-2 border-white shadow-md " name="is_admin" id="admin1" value="1"/>
                                <x-input.label for="admin1">
                                    {{ __('Sí') }}
                                </x-input.label>
                            </div>

                            <div class="flex space-x-5 align-middle">
                                <x-input.radio wire:model="is_admin" class="mt-2 border-white shadow-md" name="is_admin" id="admin2"  value="0" checked/>
                                <x-input.label for="admin2">
                                    {{ __('No') }}
                                </x-input.label>
                            </div>
                        </div>
                    </x-input.group>

                <x-input.group for="is_empresa" :error="$errors->first('user.is_empresa')">
                    <x-slot name="labels">
                        <x-input.label>
                            {{ __('Es Empresa?:') }}
                        </x-input.label>
                    </x-slot>

                    <div>
                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="is_empresa" class="mt-2 border-white shadow-md " name="is_empresa" id="empresa1" value="1"/>
                            <x-input.label for="empresa1">
                                {{ __('Sí') }}
                            </x-input.label>
                        </div>

                        <div class="flex space-x-5 align-middle">
                            <x-input.radio wire:model="is_empresa" class="mt-2 border-white shadow-md" name="is_empresa" id="empresa2"  value="0"/>
                            <x-input.label for="empresa2">
                                {{ __('No') }}
                            </x-input.label>
                        </div>
                    </div>
                </x-input.group>
                @endif
            </x-slot>
            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showEditModal')"><img class="hover:animate-wiggle" src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img class="hover:animate-wiggle" src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
