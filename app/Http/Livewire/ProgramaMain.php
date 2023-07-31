<?php

namespace App\Http\Livewire;

use App\Models\Programa;
use App\Models\Curso;
use Livewire\Component;

class ProgramaMain extends Component
{
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $perPage = '25';
    public $search = '';
    public $curso_id_curso, $objetivo_general, $programa_curso;
    public $field = 'alumno_rut_alumno';
    public $selected = [];
    public Programa $programa;

    public $rules = [
        'curso_id_curso' => 'required',
        'objetivo_general' => 'required',
        'programa_curso' => 'required',
        'programa.horas_teorica' => 'required',
        'programa.horas_practica' => 'required',
    ];

    public function sortBy($field)
    {
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        return view('livewire.programa-main', [
            'programas' => Programa::search($this->field, $this->search)->paginate($this->perPage),
            'cursos' => Curso::all(),
        ]);
    }

    public function makeBlank()
    {
        return Programa::make();
    }

    public function edit(Programa $data)
    {
        $this->programa = $data;
        $this->showEditModal = true;
    }

    public function create()
    {
        $this->programa = $this->makeBlank();
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $curso_array = explode(' | ', $this->curso_id_curso);
        $this->programa->curso_id_curso = $curso_array[0];
        $this->programa->programa = $this->programa_curso;
        $this->programa->objetivo_general = $this->objetivo_general;

        $this->programa->save();

        $this->showEditModal = false;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function confirmDelete(Programa $data)
    {
        $this->programa = $data;
        $this->showDeleteModal = true;
    }

    public function deleteSelected()
    {
        $programas = Programa::whereKey($this->selected);

        $programas->delete();

        $this->showDeleteModal = false;
    }
}
