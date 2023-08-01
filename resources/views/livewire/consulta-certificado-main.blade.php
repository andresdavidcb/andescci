<x-guest-layout>
    <h1 class ='font-bold text-2xl text-center'>DATOS PERSONALES</h1>  
    <div class="mb-10 text-xl items-center margin-auto w-3/4 mx-6 px-12">
    
          
    <table>
        <tbody>
            <tr><td class="dark">Número inscripción:</td><td>{{$inscripcion->id_insc}}</td></tr> 
            <tr><td class="dark">Nombre completo:</td><td>{{$inscripcion->apellido1}} {{$inscripcion->apellido2}} {{$inscripcion->nombrealumno}}</td></tr> 
        </tbody>
    </table>   
    </div>
</x-guest-layout>