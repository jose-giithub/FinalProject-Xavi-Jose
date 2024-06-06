window.addEventListener("DOMContentLoaded", function () {
    //si se hace click en boton editar Vehiculo
    console.log("Entro el el DOMContentLoaded");

    cargarEspecialidades();
    cargarCiudades();
    //actualizarHorario();
    // Evento change para cada selector de abierto o cerrado por dias
    //  $('#lunes, #martes').change(function() {
    //     console.log("Entro en el change");
    //     actualizarHorario();
    // });

    $("#lunes, #martes, #miercoles, #jueves, #viernes, #sabado, #domingo").change(function() {
        toggleHorarios(this.id);  // Muestra u oculta los selectores de horario dependiendo del estado abierto/cerrado
        actualizarHorario();  // Actualiza el campo 'horario' basado en los valores actuales de los selectores
    });
    

    // Manejar el evento submit del formulario
    $("form").submit(function () {
        actualizarHorario(); // Asegura que el campo 'horario' se actualice con los últimos valores antes de enviar el formulario
    });

    // Cargar el archivo JSON que contiene los horarios de apertura y cierre
    $.getJSON("/horariosOpertura.json", function (data) {
        console.log("JSON cargado", data); // Muestra en la consola que el JSON ha sido cargado
        var horarios = data.horarios; // Acceder a la parte 'horarios' del JSON
        // Llenar los selectores de horario para cada día
        cargarHorarios("Lunes", horarios);
        cargarHorarios("Martes", horarios);
        cargarHorarios("Miercoles", horarios);
        cargarHorarios("Jueves", horarios);
        cargarHorarios("Viernes", horarios);
        cargarHorarios("Sabado", horarios);
        cargarHorarios("Domingo", horarios);
        // Puedes agregar más días ajustando la función para cargarlos
        actualizarHorario(); // Actualiza el campo 'horario' inicialmente con los valores predeterminados
    });
}); //final del DOMContentLoaded

// Función para cargar los horarios en los selectores
function cargarHorarios(day, horarios) {
    var aperturaSelect = $('#horarios' + day + ' select[name="' + day.toLowerCase() + '_apertura"]'); // Selector de apertura
    //añado un nuevo campor para añadir cierre medio dia
    var cierreMediodiaSelect = $('#horarios' + day + ' select[name="' + day.toLowerCase() + '_cierre_mediodia"]');
     //añador nuevo campo para añadir opertura medio dia
    var aperturaMediodiaSelect = $('#horarios' + day + ' select[name="' + day.toLowerCase() + '_apertura_mediodia"]');
   
    var cierreSelect = $('#horarios' + day + ' select[name="' + day.toLowerCase() + '_cierre"]'); // Selector de cierre


    
    // Rellenar el selector de apertura con los horarios disponibles
    horarios.apertura.forEach(function(time) {
        aperturaSelect.append($('<option></option>').val(time).text(time)); // Crea y añade opciones al selector de apertura
    });
   // Rellenar el selector de cierre de mediodía
   horarios.cierre_mediodia.forEach(function(time) {
    cierreMediodiaSelect.append($('<option></option>').val(time).text(time));
});

// Rellenar el selector de apertura de mediodía
horarios.apertura_mediodia.forEach(function(time) {
    aperturaMediodiaSelect.append($('<option></option>').val(time).text(time));
});

    // Rellenar el selector de cierre con los horarios disponibles
    horarios.cierre.forEach(function(time) {
    cierreSelect.append($('<option></option>').val(time).text(time)); // Crea y añade opciones al selector de cierre
    });
}

/**
 * Función que captura los valores de los selectores de horario y los concatena en un solo campo y los añade al value del campo hoario para que lo suba a la BD
 */
function actualizarHorario() {
    var horario = "";
    var days = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];

    // Iterar sobre cada día
    days.forEach(function(day) {
        var dayLower = day.toLowerCase(); // Nombre del día en minúscula para usar en los nombres de los elementos
        horario += day + ": " + $("#" + dayLower).val(); // Estado del día (abierto/cerrado)
        if ($("#" + dayLower).val() === "abierto") {
            // Formato de horario: 'HH:MM a HH:MM y de HH:MM a HH:MM'
            horario += " " + $('select[name="' + dayLower + '_apertura"]').val() +
                       " a " + $('select[name="' + dayLower + '_cierre_mediodia"]').val() +
                       " y  " + $('select[name="' + dayLower + '_apertura_mediodia"]').val() +
                       " a " + $('select[name="' + dayLower + '_cierre"]').val();
        }
        horario += ". ";
    });

    // Elimina la última coma y espacio
    horario = horario.slice(0, -2);
    $("#horario").val(horario); // Actualiza el campo oculto
}

function toggleHorarios(dayId) {
    var selector = $("#" + dayId); // Selecciona el elemento de HTML basado en el ID pasado
    var valor = selector.val(); // Obtiene el valor actual del selector (abierto o cerrado)
    console.log("Valor: ", valor); // Muestra en la consola el estado actual
    var horariosDiv = $(
        "#horarios" + dayId.charAt(0).toUpperCase() + dayId.slice(1)
    ); // Construye el ID del div correspondiente
    console.log("horariosDiv: ", horariosDiv); // Muestra en la consola el div de horarios
    if (valor === "abierto") {
        horariosDiv.show(); // Muestra el div si el valor es 'abierto'
    } else {
        horariosDiv.hide(); // Oculta el div si el valor es 'cerrado'
    }
}
/**
 *
 * funcion para cargar los horarios en el select
 */
function cargarCiudades() {
    let selectCity = $("#city");
    selectCity.empty(); // Limpiar opciones previas
    selectCity.append('<option value="">Barcelona</option>');

    // Cargar el JSON y agregar las especialidades al select
    $.getJSON("/ciudadesEspanya.json", function (data) {
        // console.log("JSON cargado", data);
        $.each(data, function (key, city) {
            //agregar las especialidades al select
            selectCity.append(
                $("<option>", {
                    value: city,
                    text: city,
                })
            );
        });
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.error("Error al cargar el JSON:", textStatus, errorThrown);
    });
}

/**
 * Cargar las especialidades de los talleres en el select
 */
function cargarEspecialidades() {
    let selectEspecialidad = $("#especialidad");
    selectEspecialidad.empty(); // Limpiar opciones previas
    selectEspecialidad.append(
        '<option value="">Seleccionar Especialidad</option>'
    );

    // Cargar el JSON y agregar las especialidades al select
    $.getJSON("/especialidadTaller.json", function (data) {
        //  console.log("JSON cargado", data);
        $.each(data, function (key, especialidad) {
            //agregar las especialidades al select
            selectEspecialidad.append(
                $("<option>", {
                    value: especialidad,
                    text: especialidad,
                })
            );
        });
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.error("Error al cargar el JSON:", textStatus, errorThrown);
    });
}
