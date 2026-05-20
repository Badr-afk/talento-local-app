// public/js/registro.js

function mostrarCamposDinamicos() {
    // 1. Ocultamos todos los bloques primero
    document.getElementById('bloque_estudiante').style.display = 'none';
    document.getElementById('bloque_profesor').style.display = 'none';
    document.getElementById('bloque_empresa').style.display = 'none';

    // 2. Vemos qué opción ha elegido el usuario
    const rolSeleccionado = document.getElementById('rol').value;

    // 3. Mostramos solo el bloque correspondiente
    if (rolSeleccionado === 'estudiante') {
        document.getElementById('bloque_estudiante').style.display = 'block';
    } else if (rolSeleccionado === 'tutor_academico') {
        document.getElementById('bloque_profesor').style.display = 'block';
    } else if (rolSeleccionado === 'empresa') {
        document.getElementById('bloque_empresa').style.display = 'block';
    }
}