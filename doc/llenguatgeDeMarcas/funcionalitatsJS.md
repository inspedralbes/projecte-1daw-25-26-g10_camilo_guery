# Documentación Técnica de Componentes JavaScript

Este documento detalla el funcionamiento, la estructura y la implementación de dos scripts de JavaScript utilizados en el panel de administración.

---

## 1. Sistema de Navegación por Pestañas (`showWindow`)

### Descripción
Esta función gestiona la navegación interna dentro de la página de administración. Permite alternar la visibilidad de diferentes secciones o "ventanas" (vistas) sin necesidad de recargar la página.

### Código Fuente
```javascript
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
```

### Flujo de Ejecución
1. **Selección masiva**: Busca todos los elementos HTML que contienen la clase `.window-info`.
2. **Reinicio de estado**: Itera (`forEach`) sobre cada elemento encontrado para ocultarlo, eliminando la clase `active` y aplicando `display = 'none'`.
3. **Selección del objetivo**: Busca la ventana específica mediante el identificador único (`id`) recibido por parámetro.
4. **Activación**: Si el elemento existe, le añade la clase `active` y lo hace visible aplicando `display = 'block'`.

### Parámetros
*   **`id` (String)**: El identificador HTML (`id`) de la sección que se desea mostrar.

---

## 2. Generador de Gráfico de Barras Nativo (Canvas API)

### Descripción
Este script se encarga de dibujar un gráfico de barras interactivo de forma dinámica dentro de un elemento `<canvas>`. Utiliza datos inyectados directamente desde el servidor mediante PHP.

### Configuración de Variables Globales
El gráfico se dibuja de forma manual utilizando las siguientes constantes de posicionamiento y escala:
*   `altoMaximo (200)`: Altura máxima en píxeles que puede alcanzar una barra.
*   `valorMaximo (500)`: El valor numérico de los datos que representa el 100% de la altura.
*   `espacioEntre (80)`: Distancia en píxeles entre el inicio de cada barra.
*   `posicionIzquierda (40)`: Margen izquierdo (offset) donde inicia el eje vertical.
*   `posicionAbajo (300)`: Línea base (suelo) donde se apoyan las barras (eje horizontal).

### Funcionalidades y Bloques de Código

#### A. Inyección de Datos y Renderizado de Barras
El script recibe un array de objetos desde PHP (`dades`) e itera sobre ellos para dibujar cada columna:
*   **Cálculo de proporción**: `(dada.count / valorMaximo) * altoMaximo` define la altura proporcional de la barra según su valor.
*   **Dibujo de la barra**: Renderiza un rectángulo azul (`#2077B4`) de 30 píxeles de ancho.
*   **Etiquetas de datos**: 
    *   Muestra el valor numérico (`dada.count`) en la parte superior de cada barra en color azul oscuro.
    *   Muestra el identificador o fecha (`dada._id`) debajo del eje horizontal en color negro.

#### B. Renderizado de la Guía Vertical (Escala)
Utiliza un array estático (`valores = [100, 200, 300, 400, 500]`) para dibujar las referencias numéricas en el lateral izquierdo del gráfico, alineando los textos a la derecha.

#### C. Dibujo de los Ejes (X e Y)
Utiliza rutas nativas de Canvas (`beginPath`, `moveTo`, `lineTo`, `stroke`) para trazar dos líneas negras fijas de 1 píxel de grosor:
*   **Eje Vertical**: Va desde la altura Y=40 hasta la base del gráfico.
*   **Eje Horizontal**: Va desde el margen izquierdo hasta un ancho fijo de 1150 píxeles.

### Estructura de Datos Requerida (PHP)
Para que el gráfico funcione correctamente, la variable `$dades` de PHP debe convertirse a JSON y tener una estructura similar a la siguiente:
```json
[
  { "_id": "Enero", "count": 250 },
  { "_id": "Febrero", "count": 480 },
  { "_id": "Marzo", "count": 150 }
]
```
