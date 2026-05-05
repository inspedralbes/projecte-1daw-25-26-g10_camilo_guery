/* FUNCION PER CAMBIAR DE SECCION EN LA PAGINA DE ADMIN */

const varieties = ['incidencies', 'informeTecnics', 'informeDepartamental', 'informeAcceso'];

function showWindow(ventana) {
    varieties.forEach(v => {
        document.getElementById(v).classList.remove('active');
        document.getElementById(`btn-${v}`).classList.remove('active');
    });
    
    document.getElementById(ventana).classList.add('active');
    document.getElementById(`btn-${ventana}`).classList.add('active');
}
