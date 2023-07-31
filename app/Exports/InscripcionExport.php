<?php

namespace App\Exports;

use App\Models\Inscripcion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InscripcionExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        ini_set('memory_limit', '-1');

        return view('exports.inscripcion', [
            'inscripcions' => Inscripcion::all(),
        ]);
    }
}
