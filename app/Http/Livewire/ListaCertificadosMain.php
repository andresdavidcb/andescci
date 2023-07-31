<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Inscripcion;

class ListaCertificadosMain extends Component
{
    public $inscripciones;
    public function render()
    {
        $inscripciones = Inscripcion::all();
        return view('livewire.lista-certificados-main');
    }

    public function showHTML($id)
    {
        //
    }

    public function reportPDF($id)
    {
        //
    }
    
}
