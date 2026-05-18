/* FUNCION PER CAMBIAR DE SECCION EN LA PAGINA DE ADMIN */

function showWindow(id) {

    const windows = document.querySelectorAll('.window-info');

    windows.forEach(element => {
        element.classList.remove('active');
        element.style.display = 'none';
    });

    const selectedWindow = document.getElementById(id);

    if (selectedWindow) {
        selectedWindow.classList.add('active');
        selectedWindow.style.display = 'block';
    }
}