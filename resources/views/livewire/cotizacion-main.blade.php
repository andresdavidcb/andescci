<div>
    <div class="space-y-3">
        <div class="mb-10 text-2xl text-center text-white">
            <span>{{ __('COTIZACIONES') }}</span>
        </div>
        <div class="flex space-x-5 align-middle">
            <div class="inline-block">
                <x-button.link wire:click="create('cotizacion')">
                    <img class="inline-block" src="{{ url('img/Create.svg') }}" width="40px">
                    <span class="inline-block">CREAR COTIZACIÓN</span>
                </x-button.link>
            </div>

            <div class="inline-block">
                <x-button.link wire:click="create('contribucion')">
                    <img class="inline-block" src="{{ url('img/Create.svg') }}" width="40px">
                    <span class="inline-block">CREAR CONTRIBUCIÓN</span>
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
                    <option value="nombre_contacto">Por Nombre de Contacto</option>
                    <option value="email_contacto">Por E-Mail de Contacto</option>
                    <option value="codigo_cotizacion">Por Codigo de Cotizacion</option>
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
        {{ $cotizacions -> links()  }}
        <x-table class="mt-5">
            <x-slot name="head">
                <x-table.heading colspan="2">CONTROLES</x-table.heading>
                <x-table.heading nowrap>Codigo Cotización</x-table.heading>
                <x-table.heading nowrap>Nombre Contacto</x-table.heading>
                <x-table.heading nowrap>E-Mail Contacto</x-table.heading>
                <x-table.heading nowrap>Teléfono Contacto</x-table.heading>
                <x-table.heading nowrap>Fecha de Cotización</x-table.heading>
                <x-table.heading>Empresa</x-table.heading>
                <x-table.heading nowrap>RUT Empresa</x-table.heading>
                <x-table.heading nowrap>Contribuciones AndesCCI</x-table.heading>
                <x-table.heading nowrap>Contribuciones Empresa</x-table.heading>
                <x-table.heading>Actividades</x-table.heading>
                <x-table.heading>Participantes</x-table.heading>
                <x-table.heading nowrap>Valor por Participante</x-table.heading>
                <x-table.heading nowrap>Valor Actividad</x-table.heading>
                <x-table.heading nowrap>Valor Total</x-table.heading>

            </x-slot>
            <x-slot name="body">
                @forelse($cotizacions as $cotizacion)
                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $cotizacion->codigo_cotizacion }}">
                        <x-table.cell class="flex">
                            <div >
                                <x-input.checkbox class="mt-2 rounded-l rounded-r" wire:model="selected" value="{{ $cotizacion->id_cotizacion }}" />
                            </div>

                            <div class="ml-2">
                                <x-button.link wire:click="edit({{ $cotizacion->id_cotizacion }})">
                                    <img src="{{ url('img/Edit.svg') }}" width="40px">
                                </x-button.link>
                            </div>

                            <div class="ml-2">
                                <x-button.link wire:click.prevent="getPDF({{ $cotizacion->id_cotizacion }})">
                                    <img src="{{ url('img/PDF.svg') }}" width="40px">
                                </x-button.link>
                            </div>

                        </x-table.cell>
                        <x-table.cell nowrap>{{ $cotizacion->codigo_cotizacion }}</x-table.cell>
                        <x-table.cell nowrap>{{ $cotizacion->empresas->nombre_contacto }}</x-table.cell>
                        <x-table.cell nowrap>{{ $cotizacion->empresas->email_contacto  }}</x-table.cell>
                        <x-table.cell nowrap>{{ $cotizacion->empresas->tel_contacto  }}</x-table.cell>
                        <x-table.cell nowrap>{{ $cotizacion->fecha_cotizacion  }}</x-table.cell>
                        <x-table.cell nowrap>{{ $cotizacion->empresas->nombre_empresa  }}</x-table.cell>
                        <x-table.cell nowrap>{{ $cotizacion->empresas->rut_empresa  }}</x-table.cell>
                        <x-table.cell nowrap>
                            @foreach($cotizacion->contribucions as $c)
                                @if ($c->empresa === 'Andes')
                                    <li>{{ $c->contribucion }}</li>
                                @endif
                            @endforeach
                        </x-table.cell>
                        <x-table.cell nowrap>
                            @foreach($cotizacion->contribucions as $c)
                                @if ($c->empresa === 'Empresa')
                                    <li>{{ $c->contribucion }}</li>
                                @endif
                            @endforeach
                        </x-table.cell>
                        <x-table.cell nowrap>
                            @foreach($cotizacion->cursos as $c)
                                <li>{{ $c->nombre_curso  . '  | ' . $c->codigo_curso }}</li>
                            @endforeach
                        </x-table.cell>
                        <x-table.cell nowrap>
                            @foreach($cotizacion->cursos as $cursos)
                                <li>{{ $cursos->detalle_curso->cantidad_alumnos . ' alumnos' }}</li>
                            @endforeach
                        </x-table.cell>
                        <x-table.cell nowrap>
                            @foreach($cotizacion->cursos as $cursos)
                                <li>{{ '$'.$cursos->detalle_curso->valor_alumno.' CLP' }}</li>
                            @endforeach
                        </x-table.cell>
                        <x-table.cell nowrap>
                            @foreach($cotizacion->cursos as $cursos)
                                <li>{{ '$'.$cursos->detalle_curso->valor_actividad.' CLP' }}</li>
                            @endforeach
                        </x-table.cell>
                        <x-table.cell nowrap>
                            {{ '$'.$cotizacion->valor_total.' CLP' }}
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="14" class="text-xl text-center text-gray-400">
                            No Hay Campos que Mostrar...
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
    {{ $cotizacions -> links() }}
    </div>


    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model="showDeleteModal">
            <x-slot name="title">Confirmación</x-slot>
            <x-slot name="content">
                ¿Desea Eliminar Dato Seleccionado? (esta acción es irreversible)
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click.prevent="$toggle('showDeleteModal')"><img src="{{ url('img/Cancel.svg') }}" alt="" width="40px"></x-button.secondary>
                <x-button.primary type="submit"><img src="{{ url('img/Delete.svg') }}" alt="" width="40px"></x-button.primary>
            </x-slot>
        </x-modal.confirmation>
    </form>

    <form wire:submit.prevent="save">
        <x-modal.dialog x-show="show" wire:model="showEditModal" >
            @switch($mode)
                @case('cotizacion')
                    <x-slot name="title"> Edición/Creación de Cotizacion </x-slot>

                    <x-slot name="content">
                        <x-input.group :error="$errors->first('cotizacion.empresa_rut_empresa')">
                            <x-slot name="labels">
                                <x-input.label>
                                    Empresa:
                                </x-input.label>
                            </x-slot>

                            <x-input.text wire:model="empresa_id_empresa" list="empresa_id_empresa" />

                            <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="empresa_id_empresa">
                                @forelse ($empresas as $empresa)
                                    <option value="{{ $empresa->id_empresa . ' | ' . $empresa->rut_empresa . ' | ' .  $empresa->nombre_empresa }}" />
                                @empty
                                    <option value="">No Hay Datos Para Mostrar...</option>
                                @endforelse
                            </datalist>
                        </x-input.group>

                        <x-input.group>
                            <x-slot name="labels">Contribuciones Empresa</x-slot>

                            <div class="grid grid-cols-5">
                                @foreach ($contribucions as $index => $contribucion)
                                    @if ($contribucion->empresa === 'Empresa')
                                        <x-input.checkbox wire:model="contriEmp.{{ $index }}" name="contriEmp.{{ $index }}" value="{{ $contribucion->id_contribucion }}" checkId="{{ $contribucion->contribucion . '-' . $contribucion->empresa }}">
                                            {{ $contribucion->contribucion }}
                                        </x-input.checkbox>
                                    @endif
                                @endforeach
                            </div>
                        </x-input.group>

                        <x-input.group>
                            <x-slot name="labels">Contribuciones Andes</x-slot>

                            <div class="grid grid-cols-5">
                                @foreach ($contribucions as $index => $contribucion)
                                    @if ($contribucion->empresa === 'Andes')
                                        @php
                                            $contri[] = '';
                                        @endphp
                                        <x-input.checkbox wire:model="contriAnd.{{ $index }}" name="contriAnd.{{ $index }}" value="{{ $contribucion->id_contribucion }}" checkId="{{ $contribucion->contribucion . '-' . $contribucion->empresa }}">
                                            {{ $contribucion->contribucion }}
                                        </x-input.checkbox>
                                    @endif
                                @endforeach
                            </div>
                        </x-input.group>

                        <x-input.group>
                            <x-button.primary class="inline-block" wire:click.prevent="addCurso"> <img src="{{ url('img/Add.svg') }}" alt="" width="40px"> </x-button.primary>
                        </x-input.group>

                        @foreach ($data as $index=>$d)
                            <hr>
                            <hr>
                            <x-input.group>
                                <x-button.secondary wire:click.prevent="removeCurso({{ $index }})"> <img src="{{ url('img/Cancel.svg') }}" alt="" width="40px"> </x-button.secondary>
                            </x-input.group>

                            <x-input.group :error="$errors->first('curso_id_curso')">
                                <x-slot name="labels">
                                    <x-input.label>
                                        Curso:
                                    </x-input.label>
                                </x-slot>

                                <x-input.text wire:model="curso_id_curso.{{ $index }}" list="curso_id_curso" />

                                <datalist class="bg-white bg-opacity-25 rounded-3xl backdrop-blur" id="curso_id_curso">
                                    @forelse ($curso as $c)
                                        <option value="{{ $c->id_curso . ' | ' . $c->codigo_curso.' | '.$c->nombre_curso.' | '.$c->horas_format }}" />
                                    @empty
                                        <option value="">No Hay Datos Para Mostrar...</option>
                                    @endforelse
                                </datalist>
                            </x-input.group>

                            <x-input.group :error="$errors->first('cotizacion.cantidad_alumnos')">
                                <x-slot name="labels">
                                    <x-input.label>
                                        Cantidad Participantes:
                                    </x-input.label>
                                </x-slot>
                                <x-input.text wire:model="cantidad_alumnos.{{ $index }}" id="cantidad_alumnos"/>
                            </x-input.group>

                            <x-input.group :error="$errors->first('cotizacion.valor_alumno')">
                                <x-slot name="labels">
                                    <x-input.label>
                                        Valor por Participante:
                                    </x-input.label>
                                </x-slot>
                                <x-input.text wire:model="valor_alumno.{{ $index }}" id="valor_alumno"/>
                            </x-input.group>

                            <x-input.group :error="$errors->first('nota_aprobacion.{{ $index }}')">
                                <x-slot name="labels">
                                    <x-input.label>
                                        {{ __('Porcentaje de Aprobación:') }}
                                    </x-input.label>
                                </x-slot>

                                <div>
                                    <div class="flex space-x-5 align-middle">
                                        <x-input.radio wire:model="nota_aprobacion.{{ $index }}" class="mt-2 border-white shadow-md " name="nota_aprobacion.{{ $index }}" id="nota100" value="100"/>
                                        <x-input.label for="nota100">
                                            {{ __('100%') }}
                                        </x-input.label>
                                    </div>

                                    <div class="flex space-x-5 align-middle">
                                        <x-input.radio wire:model="nota_aprobacion.{{ $index }}" class="mt-2 border-white shadow-md" name="nota_aprobacion.{{ $index }}" id="nota85"  value="85"/>
                                        <x-input.label for="nota85">
                                            {{ __('85%') }}
                                        </x-input.label>
                                    </div>
                                </div>
                            </x-input.group>

                            <x-input.group :error="$errors->first('modalidad.{{ $index }}')">
                                <x-slot name="labels">
                                    <x-input.label>
                                        {{ __('Modalidad:') }}
                                    </x-input.label>
                                </x-slot>

                                <div>
                                    <div class="flex space-x-5 align-middle">
                                        <x-input.radio wire:model="modalidad.{{ $index }}" class="mt-2 border-white shadow-md " name="modalidad.{{ $index }}" id="modalidad-ol" value="On-Line"/>
                                        <x-input.label for="modalidad-ol">
                                            {{ __('On-Line') }}
                                        </x-input.label>
                                    </div>

                                    <div class="flex space-x-5 align-middle">
                                        <x-input.radio wire:model="modalidad.{{ $index }}" class="mt-2 border-white shadow-md" name="modalidad.{{ $index }}" id="modalidad-pl"  value="Presencial"/>
                                        <x-input.label for="modalidad-pl">
                                            {{ __('Presencial') }}
                                        </x-input.label>
                                    </div>
                                </div>
                            </x-input.group>
                            <hr>
                            <hr>
                        @endforeach

                        <x-input.group>
                            <x-button.primary wire:click.prevent="addCurso"> <img src="{{ url('img/Add.svg') }}" alt="" width="40px"> </x-button.primary>
                        </x-input.group>
                    </x-slot>
                    @break

                @case('contribucion')
                    <x-slot name="title"> Edición/Creación de Contribucion</x-slot>

                    <x-slot name="content">
                        <x-input.group :error="$errors->first('contribucion.contribucion')">
                            <x-slot name="labels">
                                <x-input.label>
                                    Contribucion:
                                </x-input.label>
                            </x-slot>
                            <x-input.text wire:model="contribucion.contribucion" id="contribucion"/>
                        </x-input.group>

                        <x-input.group :error="$errors->first('contribucion.empresa')">
                            <x-slot name="labels">
                                <x-input.label>
                                    Entidad:
                                </x-input.label>
                            </x-slot>

                            <div>
                                <div class="flex space-x-5 align-middle">
                                    <x-input.radio wire:model="contribucion.empresa" class="mt-2 border-white shadow-md " name="empresa" id="empresa-empresa" value="Empresa"/>
                                    <x-input.label for="empresa-empresa">
                                        {{ __('Empresa') }}
                                    </x-input.label>
                                </div>

                                <div class="flex space-x-5 align-middle">
                                    <x-input.radio wire:model="contribucion.empresa" class="mt-2 border-white shadow-md" name="empresa" id="empresa-andes"  value="Andes"/>
                                    <x-input.label for="empresa-andes">
                                        {{ __('Andes') }}
                                    </x-input.label>
                                </div>
                            </div>
                        </x-input.group>

                        <x-input.group>
                            <x-slot name="labels">
                                Contribuciones Existentes:
                            </x-slot>

                            <x-output.textarea>
                                @foreach ($contribucions as $contribucion)
                                    {{ $contribucion->contribucion  . ' ' . $contribucion->empresa . ' | ' }}
                                @endforeach
                            </x-output.textarea>
                        </x-input.group>
                    </x-slot>
                    @break
            @endswitch

            <x-slot name="footer">
                <x-button.link wire:click="$toggle('showEditModal')"><img src="{{  url('img/Cancel.svg')  }}" width="30px"></x-button.secondary>
                <x-button.primary type="submit"><img src="{{  url('img/Accept.svg')  }}" width="30px"></x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
