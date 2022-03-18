require('./bootstrap');
require('./calendar');
// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import 'bootstrap';

const el = document.getElementById('app');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
    })
    .mixin({
        data(){
            return{
                URLactual: window.location,
                path: 'https://intranethlangeles.com/storage/app/public/',
                path2: 'https://intranethlangeles.com/storage',
                pathDev: '192.168.11.3/storage/app/public/',
                showModal: false,
                editMode: false,
                now: moment().format('Y-M-d H:mm:ss'),
                Today: moment().format('Y-M-d'),
                colours: ["#84CC16", "#65A30D", "#4D7C0F", "#22C55E", "#16A34A", "15803D",
                "#10B981", "#059669", "#047857", "#14B8A6","#0D9488","#0F766E","#06B6D4","#0891B2","#0E7490",
                "#0EA5E9","#0284C7","#0369A1","#3B82F6","#2563EB","#1D4ED8","#6366F1","#4F46E5","#4338CA",
                "#8B5CF6","#7C3AED","#6D28D9","#A855F7", "#9333EA","#7E22CE","#D946EF","#C026D3","#A21CAF",
                "#EC4899","#DB2777","#BE185D","#F43F5E","#E11D48","#BE123C"],
                español: {
                    processing: "Procesando...",
                    lengthMenu: "Mostrar _MENU_ registros",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    info: "Registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    search: "Buscar:",
                    infoThousands: ",",
                    loadingRecords: "Cargando...",
                    paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior",
                    },
                    aria: {
                    sortAscending:
                        ": Activar para ordenar la columna de manera ascendente",
                    sortDescending:
                        ": Activar para ordenar la columna de manera descendente",
                    },
                    buttons: {
                    copy: "Copiar",
                    colvis: "Visibilidad",
                    collection: "Colección",
                    colvisRestore: "Restaurar visibilidad",
                    copyKeys:
                        "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.",
                    copySuccess: {
                        1: "Copiada 1 fila al portapapeles",
                        _: "Copiadas %d fila al portapapeles",
                    },
                    copyTitle: "Copiar al portapapeles",
                    csv: "CSV",
                    excel: "Excel",
                    pageLength: {
                        "-1": "Mostrar todas las filas",
                        1: "Mostrar 1 fila",
                        _: "Mostrar %d filas",
                    },
                    pdf: "PDF",
                    print: "Imprimir",
                    },
                    autoFill: {
                    cancel: "Cancelar",
                    fill: "Rellene todas las celdas con <i>%d</i>",
                    fillHorizontal: "Rellenar celdas horizontalmente",
                    fillVertical: "Rellenar celdas verticalmentemente",
                    },
                    decimal: ",",
                    searchBuilder: {
                    add: "Añadir condición",
                    button: {
                        0: "Constructor de búsqueda",
                        _: "Constructor de búsqueda (%d)",
                    },
                    clearAll: "Borrar todo",
                    condition: "Condición",
                    conditions: {
                        date: {
                        after: "Despues",
                        before: "Antes",
                        between: "Entre",
                        empty: "Vacío",
                        equals: "Igual a",
                        not: "No",
                        notBetween: "No entre",
                        notEmpty: "No Vacio",
                        },
                        moment: {
                        after: "Despues",
                        before: "Antes",
                        between: "Entre",
                        empty: "Vacío",
                        equals: "Igual a",
                        not: "No",
                        notBetween: "No entre",
                        notEmpty: "No vacio",
                        },
                        number: {
                        between: "Entre",
                        empty: "Vacio",
                        equals: "Igual a",
                        gt: "Mayor a",
                        gte: "Mayor o igual a",
                        lt: "Menor que",
                        lte: "Menor o igual que",
                        not: "No",
                        notBetween: "No entre",
                        notEmpty: "No vacío",
                        },
                        string: {
                        contains: "Contiene",
                        empty: "Vacío",
                        endsWith: "Termina en",
                        equals: "Igual a",
                        not: "No",
                        notEmpty: "No Vacio",
                        startsWith: "Empieza con",
                        },
                    },
                    data: "Data",
                    deleteTitle: "Eliminar regla de filtrado",
                    leftTitle: "Criterios anulados",
                    logicAnd: "Y",
                    logicOr: "O",
                    rightTitle: "Criterios de sangría",
                    title: {
                        0: "Constructor de búsqueda",
                        _: "Constructor de búsqueda (%d)",
                    },
                    value: "Valor",
                    },
                    searchPanes: {
                    clearMessage: "Borrar todo",
                    collapse: {
                        0: "Paneles de búsqueda",
                        _: "Paneles de búsqueda (%d)",
                    },
                    count: "{total}",
                    countFiltered: "{shown} ({total})",
                    emptyPanes: "Sin paneles de búsqueda",
                    loadMessage: "Cargando paneles de búsqueda",
                    title: "Filtros Activos - %d",
                    },
                    select: {
                    1: "%d fila seleccionada",
                    _: "%d filas seleccionadas",
                    cells: {
                        1: "1 celda seleccionada",
                        _: "$d celdas seleccionadas",
                    },
                    columns: {
                        1: "1 columna seleccionada",
                        _: "%d columnas seleccionadas",
                    },
                    },
                    thousands: ".",
                },
            }
        },

        methods: {
        route,
        hasAnyPermission: function (permissions) {

            var allPermissions = this.$page.props.auth.can;
            var hasPermission = false;
            //console.log(allPermissions)
            permissions.forEach(function(item){
                if(allPermissions[item]) hasPermission = true;
            });

            return hasPermission;
        },

        openModal() {
            this.chageClose();
            this.reset();
            this.editMode = false;
        },

        chageClose() {
            this.showModal = !this.showModal;
        },

        alertSucces() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });

            Toast.fire({
                icon: "success",
                title: "Operación Exitosa!",
                // background: '#99F6E4',
            });
        },

        alertInfo(message){
            const Toast = Swal.mixin({
                toast: true,
                position: "top-center",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });

            Toast.fire({
                icon: "info",
                title: message,
            });
        },

        alertDelete() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });

            Toast.fire({
                icon: "success",
                title: "Registro Eliminado Correctamente",
                // background: '#99F6E4',
            });
        },

        alertWarning() {
            const Toast = Swal.mixin({
                toast: true,
                position: "center",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });

            Toast.fire({
                icon: "warning",
                title: "Formato Incorrecto",
                // background: '#FDBA74',
            });
        },

        alertError() {
            const Toast = Swal.mixin({
                toast: true,
                position: "center",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });

            Toast.fire({
                icon: "warning",
                title: "Ocurrio un problema",
                // background: '#FDBA74',
            });
        },

        clean(obj) {
            for (var propName in obj) {
                if (obj[propName] === null || obj[propName] === undefined) {
                delete obj[propName];
                }
            }
        },

    } })
    .use(InertiaPlugin)
    .mount(el);

InertiaProgress.init({ color: '#22D3EE' });
