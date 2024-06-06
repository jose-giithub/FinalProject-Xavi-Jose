window.addEventListener("DOMContentLoaded", function () {
    //si se hace click en boton editar Vehiculo
    console.log("Entro el el DOMContentLoaded");
    $("#editarVehiculo, #editarHostiralMaitenance").on("click", function () {
        mostrarFormularioEdicion();
    });

    //si hacen click en el boton de editar historial de mantenimiento
    $(".botonEditarVehiculo").on("click", function () {
        var maintenanceId = $(this).data("id"); // Capturar el ID desde el data attribute
        $("#editForm" + maintenanceId).toggle(); // Alternar la visibilidad del formulario correspondiente
    });
    $("#tipo_combustible").data("value");

    //Evento click para el vehículo y el combustible
    $(".divIconosVehiculo, .divIcons").click(function () {
        const vehicleType = $(this).data("value"); // Usa .data() para obtener el valor del data-attribute
        const isVehicle = $(this).hasClass("divIconosVehiculo");
        if (isVehicle) {
            $("#tipo_vehiculo").val(vehicleType); // Asigna valor al campo oculto de tipo de vehículo
        } else {
            //   $("#tipo_combustible").val(vehicleType); // Asigna valor al campo oculto de tipo de combustible
        }
        resetColors(); //pone cualquier icono que no este en negro a negro
        // Cambia el color del ícono seleccionado a rojo
        $(this).find("i").css("color", "red");
        // Actualiza la visibilidad y pone el icono seleccionado en rojo

        toggleVisibility(vehicleType);
        //  añadirSelectMarca($("#tipo_vehiculo").val()); //función que crear el formulario
        // actualizarTipoConbustible( $("#tipo_combustible").val());
    });

    //Cargo al select las option
    $(".divIconosVehiculo").click(function () {
        añadirSelectMarca($("#tipo_vehiculo").val()); //función que crear el formulario
    });

    // Manejo de cambio para el input del año de fabricación
    $("#inputAnoFabricacion").change(function () {
        const yearValue = $(this).val();
        console.log("Año de fabricación seleccionado: " + yearValue);
    });

    //Si presionan el botn de editar de hisorial de mantenimiento
    document.querySelectorAll(".btn-primary").forEach((button) => {
        button.addEventListener("click", function () {
            const maintenanceId = this.getAttribute("data-id");
            const form = document.getElementById("editForm" + maintenanceId);
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        });
    });

    // ************************ Carrusel de imágenes
    document.querySelectorAll(".delete-btn").forEach((button) => {
        button.addEventListener("click", (event) => {
            event.stopPropagation(); // Prevent carousel from navigating
        });
    });

    // ******************Calcular el tiempo restante para proxima ITV revision ect**************************
    // Calcular tiempo restante de la próxima ITV
    const fechaITVAttr = document
        .getElementById("divProximaItv")
        .getAttribute("data-fecha-itv");
    const hoy = new Date();
    if (fechaITVAttr) {
        const fechaITV = new Date(fechaITVAttr);
        let diferencia = fechaITV - hoy; // Diferencia en milisegundos
        const diasRestantes = Math.floor(diferencia / (1000 * 60 * 60 * 24));

        anyadirTiempoRestante(diasRestantes);
    } else {
        anyadirTiempoRestante(null);
    }
    // Calcular tiempo restante de la próxima revisión
    const fechaRevisionAttr = document
        .getElementById("divProximaRevision")
        .getAttribute("data-fecha-revision");

    if (fechaRevisionAttr) {
        const fechaRevision = new Date(fechaRevisionAttr);
        let diferenciaRevision = fechaRevision - hoy; // Diferencia en milisegundos
        let diasRestantesRevision = Math.floor(
            diferenciaRevision / (1000 * 60 * 60 * 24)
        );
        //    console.log(diasRestantesRevision, "dias restantes revision");
        anyadirTiempoRestanteRevision(diasRestantesRevision);
    } else {
        anyadirTiempoRestanteRevision(null);
    }

    // Cargar el JSON con marcas y modelos
    $.getJSON("/modelosCoche.json", function (data) {
        console.log("JSON cargado");
        window.modelsData = data;
    });


   
    //******** */ notificaciones. capturo el boton con clas  notification-container
    // $(".notification-container").click(function () {
    //     toggleNotifications();
    // }
    // );

}); //final DOMContentLoaded

/**
 * Funcion que muestra o oculta las notificaciones
 */
function toggleNotifications() {
    var notifications = document.getElementById('notifications');
    if (notifications.style.display === 'none' || notifications.style.display === '') {
        notifications.style.display = 'block';
    } else {
        notifications.style.display = 'none';
    }
}
/**
 * Función que dependiendo del tipo de vehículo añade las option ajustándose al tipo de vehículo
 * @param {*} selectedType
 */
function añadirSelectMarca(selectedType) {
    //  console.log("entro en añadirSelectMarca");

    //capturo el select donde añadir dentro las option
    let selectMarca = $("#selectMarca");
    let selectConbustible = $("#selectCombustible");
    //limpio el select
    selectConbustible.empty();

    //si es coche
    if (selectedType === "Coche") {
        //añado option para coche
        selectMarca.append(`
                        <option id="textoInicioOption" value="">Marca de tu coche</option>
                        <option value="Alfa Romeo">Alfa Romeo</option>
                        <option value="Audi">Audi</option>
                        <option value="BMW">BMW</option>
                        <option value="Chevrolet">Chevrolet</option>
                        <option value="Citroen">Citroën</option>
                        <option value="CUPRA">CUPRA</option>
                        <option value="Dacia">Dacia</option>
                        <option value="Fiat">Fiat</option>
                        <option value="Ford">Ford</option>
                        <option value="Hyundai">Hyundai</option>
                        <option value="Jeep">Jeep</option>
                        <option value="Kia">Kia</option>
                        <option value="Land Rover">Land Rover</option>
                        <option value="Lexus">Lexus</option>
                        <option value="MG">MG</option>
                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                        <option value="Mitsubishi">Mitsubishi</option>
                        <option value="Nissan">Nissan</option>
                        <option value="Opel">Opel</option>
                        <option value="Peugeot">Peugeot</option>
                        <option value="Porsche">Porsche</option>
                        <option value="Renault">Renault</option>
                        <option value="Seat">Seat</option>
                        <option value="Skoda">Škoda</option>
                        <option value="Smart">Smart</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Volvo">Volvo</option>
                        <option value="Volkswagen">Volkswagen</option>`);
        // Añadir evento para cambiar los modelos según la marca seleccionada
        selectMarca.change(function () {
            let selectedMarca = $(this).val();
            let selectModelo = $("#selectModelo");

            // Limpiar el select de modelos
            selectModelo.empty();

            if (selectedMarca && window.modelsData[selectedMarca]) {
                let modelos = window.modelsData[selectedMarca];
                modelos.forEach(function (modelo) {
                    selectModelo.append(
                        `<option value="${modelo}">${modelo}</option>`
                    );
                });
            }
        });

        // añado option para combustible coche
        selectConbustible.append(`
                        <option value="">Tipo de combustible</option>
                        <option value="Gasolina">Gasolina</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Electrico">Eléctrico</option>
                        <option value="Hibrido">Hibrido</option>
                        `);
        //si es moto
    } else if (selectedType === "Moto") {
        //añado option para moto
        selectMarca.append(`
                        <option id="textoInicioOption" value="">Marca de tu moto</option>
                        <option value="Aprilia">Aprilia</option>
                        <option value="BMW">BMW</option>
                        <option value="Ducati">Ducati</option>
                        <option value="Harley-Davidson">Harley-Davidson</option>
                        <option value="Honda">Honda</option>
                        <option value="Kawasaki">Kawasaki</option>
                        <option value="KTM">KTM</option>
                        <option value="Moto Guzzi">Moto Guzzi</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Triumph">Triumph</option>
                        <option value="Yamaha">Yamaha</option>`);

        // añado option para combustible moto
        selectConbustible.append(`
                        <option value="">Tipo de combustible</option>
                        <option value="Gasolina">Gasolina</option>
                        <option value="Electrico">Eléctrica</option>
                        `);
    }
}

/**
 * Función que calcula cuantos días , meses y años faltan para el simiente evento como revisión de la ITV y lo muestra en el DOM
 * @param {*} diasRestantes
 */
function anyadirTiempoRestante(diasRestantes) {
    let diasTotales = diasRestantes;
    //guardo los años
    let años = Math.floor(diasTotales / 365);
    //guardo los meses
    let meses = Math.floor(diasTotales % 365) / 30;
    //redondeo meses a 1 digito
    meses = meses.toFixed(0);
    // meses = Math.round(meses * 10) / 10;
    //gaurdo los dias
    let dias = (diasTotales % 365) % 30;
    // console.log(dias + ' dias '+ meses + ' meses '+ años +  'años');
    const container = document.getElementById("divProximaItv");

    // Si es ITV
    if (diasRestantes === null) {
        // Si no hay fecha definida
        container.textContent = "Fecha no definida";
        container.classList.remove("green", "yellow");
        container.classList.add("red");
    } else if (isNaN(diasRestantes)) {
        // Si la fecha calculada es inválida
        container.textContent = "Fecha inválida";
        container.classList.remove("green", "yellow");
        container.classList.add("red");
    } else if (diasRestantes < 0) {
        container.textContent = "Tiempo  expirado";
        container.classList.remove("green", "yellow");
        container.classList.add("red");
    } else if (diasRestantes < 30) {
        container.textContent = `Faltan ${diasRestantes} días`;
        container.classList.remove("green");
        container.classList.add("yellow");
    } else if (diasRestantes == 30) {
        container.textContent = `Faltan  ${meses} meses`;
        container.classList.add("green");
    } else if (diasRestantes < 365) {
        container.textContent = `Faltan  ${meses} meses, y ${dias} días`;
        container.classList.add("green");
    } else {
        container.textContent = `Faltan ${años} años, ${meses} meses, y ${dias} días`;
        container.classList.add("green");
    }
}
function anyadirTiempoRestanteRevision(diasRestantes) {
    // console.log(diasRestantes);
    let diasTotales = diasRestantes;
    //guardo los años
    let años = Math.floor(diasTotales / 365);
    //guardo los meses
    let meses = Math.floor(diasTotales % 365) / 30;
    //redondeo meses a 1 digito
    meses = meses.toFixed(0);
    // meses = Math.round(meses * 10) / 10;
    //gaurdo los dias
    let dias = (diasTotales % 365) % 30;
    // console.log(dias + " dias " + meses + " meses " + años + "años");
    const container = document.getElementById("divProximaItv");
    const containerRevision = document.getElementById("divProximaRevision");
    if (diasRestantes === null) {
        // Si no hay fecha definida
        containerRevision.textContent = "Fecha no definida";
        containerRevision.classList.remove("green", "yellow");
        containerRevision.classList.add("red");
    } else if (isNaN(diasRestantes)) {
        // Si la fecha calculada es inválida
        containerRevision.textContent = "Fecha inválida";
        containerRevision.classList.remove("green", "yellow");
        containerRevision.classList.add("red");
    } else if (diasRestantes < 0) {
        containerRevision.textContent = "Tiempo  expirado";
        containerRevision.classList.remove("green", "yellow");
        containerRevision.classList.add("red");
    } else if (diasRestantes < 30) {
        containerRevision.textContent = `Faltan ${diasRestantes} días`;
        containerRevision.classList.remove("green");
        containerRevision.classList.add("yellow");
    } else if (diasRestantes < 365) {
        containerRevision.textContent = `Faltan  ${meses} meses, y ${dias} días`;
        containerRevision.classList.add("green");
    } else {
        containerRevision.textContent = `Faltan ${años} años, ${meses} meses, y ${dias} días`;
        containerRevision.classList.add("green");
    }
}

/**
 * Función que al hacer click en el boton editar vehículo muestra el formulario de edición vehículo usuario
 * oculta las características del vehículo
 */
function mostrarFormularioEdicion() {
    $(".sectionFormUsers").show();
    $("#seccionMostrarCaracteristicas").hide();
}
/**
 * Función que muestra o oculta los iconos de los vehículos y sus combustibles
 * @param {*} selectedType
 */
function toggleVisibility(selectedType) {
    // Mostrar o ocultar elementos basados en la selección
    if (selectedType === "Coche" || selectedType === "Moto") {
        if (selectedType === "Coche") {
            $("#divIconoMoto").hide(); //oculto el icon de moto
            $(".botonFormTopoVehiculo").show();
            $("#divAñoFabricacion").show();
            $("#tipoDeCombustible").show();
            $("#idCreateMarca").show();
            $("#idCreateModel").show();
            $("#idCreateKm").show();
            $("#idCreateCC").show();
            $("#idCreateCV").show();
            $("#idCreateCombustible").show();
            $("#divCreateITV").show();
            $("#divCreateRevision").show();
            $("#divCreateNomTaller").show();
            $("#divCreateResidenciaUser").show();
        } else if (selectedType === "Moto") {
            $("#divIconoCoche").hide(); //oculto el icono de coche
            $("#tipoDeCombustible").hide(); //mo se que are
            $(".botonFormTopoVehiculo").show();
            $("#divAñoFabricacion").show();
            $("#idCreateMarca").show();
            $("#idCreateModel").show();
            $("#idCreateKm").show();
            $("#idCreateCC").show();
            $("#idCreateCV").show();
            $("#divCreateITV").show();
            $("#divCreateRevision").show();
            $("#divCreateNomTaller").show();
            $("#idCreateCombustible").show();
            $("#divCreateResidenciaUser").show();
            $("#tipoDeMotos").show();
        }
    }
}

/**
 * Función que hace un reset los colores de los íconos y los pone en negro
 */
function resetColors() {
    // Hace un reset el color de todos los íconos a negro
    $("i").css("color", "#000000");
}

// Funcion para esconder o mostrar las notificaciones
document
    .getElementById("notificationButton")
    .addEventListener("click", function () {
        var notifications = document.getElementById("notifications");
        notifications.style.display =
            notifications.style.display === "block" ? "none" : "block";
    });

document
    .getElementById("closeNotifications")
    .addEventListener("click", function () {
        var notifications = document.getElementById("notifications");
        notifications.style.display = "none";
    });
