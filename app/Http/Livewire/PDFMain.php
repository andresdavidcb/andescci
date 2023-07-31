<?php

namespace App\Http\Livewire;

use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Empresa;
use Livewire\Component;
use App\Models\Calendario;
use App\Models\Inscripcion;
use Barryvdh\DomPDF\Facade as PDF;
class PDFMain extends Component
{
    public function render()
    {
        return view('livewire.p-d-f-main');
    }
}
