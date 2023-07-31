<?php

namespace App\Http\Livewire;

use App\Models\Curso;
use Livewire\Component;
use Livewire\WithPagination;

class CursoMain extends Component
{
    use WithPagination;

    public $showEditModal = false;
    public $showDeleteModal = false;
    public $perPage = '25';
    public $search = '';
    public $selected = [];
    public $field = 'nombre_curso';
    public Curso $curso;

    public $rules = [
        'curso.codigo_curso' => 'required|string',
        'curso.nombre_curso' => 'required',
        'curso.horas' => 'required',
        'curso.vigencia_curso' => 'required',
        'curso.sence' => 'required',
        'curso.manejo_maquinaria' => 'required',
    ];

    public function render()
    {
        return view('livewire.curso-main', [
            'cursos' => Curso::search($this->field, $this->search)->orderBy('created_at', 'desc')->paginate($this->perPage),
        ]);
    }

    public function makeBlank()
    {
        return Curso::make();
    }

    public function edit(Curso $data)
    {
        $this->curso = $data;
        $this->showEditModal = true;
    }

    public function create()
    {
        $this->curso = $this->makeBlank();
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->curso->save();

        $this->showEditModal = false;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function confirmDelete(Curso $data)
    {
        $this->curso = $data;
        $this->showDeleteModal = true;
    }

    public function deleteSelected()
    {
        $cursos = Curso::whereKey($this->selected);

        $cursos->delete();

        $this->showDeleteModal = false;
    }
}
