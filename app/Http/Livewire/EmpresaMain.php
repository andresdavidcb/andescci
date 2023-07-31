<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Livewire\Component;
use Livewire\WithPagination;

class EmpresaMain extends Component
{
    use WithPagination;

    public $showEditModal = false;
    public $showDeleteModal = false;
    public $perPage = '25';
    public $search = '';
    public $selected = [];
    public $field = 'nombre_empresa';
    public $sortField = 'nombre_empresa';
    public $sortDirection = 'asc';
    public $rut_empresa;
    public Empresa $empresa;

    public $rules = [
        'rut_empresa' => 'required',
        'empresa.nombre_empresa' => 'required',
        'empresa.nombre_contacto' => 'required',
        'empresa.email_contacto' => 'required|email',
        'empresa.tel_contacto' => 'required',
        'empresa.notaPorcentaje' => 'required',
    ];

    public function render()
    {
        return view('livewire.empresa-main', [
            'empresas' => Empresa::search($this->field, $this->search)->orderBy('created_at', 'desc')->paginate($this->perPage),
        ]);
    }

    public function makeBlank()
    {
        return Empresa::make();
    }

    public function edit(empresa $data)
    {
        $this->empresa = $data;
        $this->showEditModal = true;
    }

    public function create()
    {
        $this->empresa = $this->makeBlank();
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->empresa->rut_empresa = $this->rut_empresa;

        $this->empresa->save();

        $this->showEditModal = false;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function confirmDelete(Empresa $data)
    {
        $this->empresa = $data;
        $this->showDeleteModal = true;
    }

    public function deleteSelected()
    {
        $empresas = Empresa::whereKey($this->selected);

        $empresas->delete();

        $this->showDeleteModal = false;
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }
}
