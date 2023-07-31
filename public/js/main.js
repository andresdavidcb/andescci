// Verificador de RUT
function checkRut(rut) {
    // Despejar Puntos y guion
    var valor = rut.value.replace(/[\.-]/g,'');
    document.getElementById("RUT").value = valor;

    // Aislar Cuerpo y DÃ­gito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();

    // Si no cumple con el mÃ­nimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}

    // Calcular DÃ­gito Verificador
    suma = 0;
    multiplo = 2;

    // Para cada dÃ­gito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {

        // Obtener su Producto con el MÃºltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);

        // Sumar al Contador General
        suma = suma + index;

        // Consolidar MÃºltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
    }

    // Calcular DÃ­gito Verificador en base al MÃ³dulo 11
    dvEsperado = 11 - (suma % 11);

    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;

    // Validar que el Cuerpo coincide con su DÃ­gito Verificador
    if(dvEsperado != dv) {
        rut.setCustomValidity("RUT InvÃ¡lido");
        document.getElementById("RUT").classList.add('border-red-500');
        document.getElementById("RUT").classList.add('bg-red-500');
        document.getElementById("RUT").classList.add('text-white');

        return false;
    }

    // Si sale bien, eliminar errores (decretar que es vÃ¡lido)
    rut.setCustomValidity('');
    document.getElementById("RUT").classList.remove('border-red-500');
    document.getElementById("RUT").classList.remove('bg-red-500');
    document.getElementById("RUT").classList.remove('text-white');
}
