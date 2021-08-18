<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-calendar-check tw-ml-3 tw-mr-3"></i>
                    Captura de Incidencias
                </h3>
            </slot>
        </Header>

        <div class="tw-mt-8">
            <div class="tw-overflow-x-auto tw-mx-2">
                <Table id="perfiles">
                    <template v-slot:TableHeader>
                        <th class="columna">Num Control</th>
                        <th class="columna">Nombre</th>
                        <th class="columna">Apellido Paterno</th>
                        <th class="columna">Apellido Materno</th>
                        <th class="columna">Departamento</th>
                        <th class="columna">Puesto</th>
                        <th class="columna">Dias de Vacaciones</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="dato in PerfilesUsuarios" :key="dato.id">
                            <td class="tw-p-2">{{ dato.IdEmp }}</td>
                            <td class="tw-p-2">{{ dato.Nombre }}</td>
                            <td class="tw-p-2">{{ dato.ApPat }}</td>
                            <td class="tw-p-2">{{ dato.ApMat }}</td>
                            <td class="tw-p-2">{{ dato.perfil_puesto.Nombre }}</td>
                            <td class="tw-p-2">{{ dato.perfil_departamento.Nombre }}</td>
                            <td class="tw-p-2">{{ dato.DiasVac }} Dias</td>
                            <td class="fila">
                                <div class="columnaIconos">
                                    <div class="iconoEdit" @click="incidencias(dato)">
                                        <span tooltip="Captura de Incidencias" flow="left">
                                            <i class="fas fa-user-plus"></i>
                                        </span>
                                    </div>
                                    <div class="iconoDetails" @click="Historico(dato)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <span tooltip="Historico Incidencias" >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>
    </div>

    <modal :show="showModal" @close="chageClose" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Registro de Incidencias</h3>
                    </div>
                </div>

                <div class="overflow-hidden tw-flex-column tw-bg-blueGray-50 tw-my-4 tw-border-teal-500 tw-border-t-2 tw-border-b-2">
                    <div class="tw-flex tw-p-2 tw-gap-2">
                        <div class="tw-w-1/3 md:tw-w-1/3 lg:tw-w-1/3">
                            <label class="info">Nombre</label>
                            <div class="DataContainer">
                                <input type="text" class="InfoData" v-model="form.Nombre" disabled/>
                            </div>
                        </div>
                        <div class="tw-w-1/3 md:tw-w-1/3 lg:tw-w-1/3">
                            <label class="info">Apellido Paterno</label>
                            <div class="DataContainer">
                                <input type="text" class="InfoData" v-model="form.ApPat" disabled/>
                            </div>
                        </div>
                        <div class="tw-w-1/3 md:tw-w-1/3 lg:tw-w-1/3">
                            <label class="info">Apellido Materno</label>
                            <div class="DataContainer">
                                <input type="text" class="InfoData" v-model="form.ApMat" disabled/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha de la Incidencia</jet-label>
                                <jet-input type="date" v-model="form.Fecha"></jet-input>
                                <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Tipo Incidencia</jet-label>
                                <select class="InputSelect focus:outline-none focus:shadow-outline" v-model="form.Tipo">
                                    <option value="">-- SELECCIONA UNA TIPO --</option>
                                    <option value="CAMBIO DE TURNO">CAMBIO DE TURNO</option>
                                    <option value="PERMISO C/GOCE DE SUELDO">PERMISO S/GOCE DE SUELDO</option>
                                    <option value="PERMISO C/GOCE DE SUELDO">PERMISO C/GOCE DE SUELDO</option>
                                    <option value="INCAPACIDAD">INCAPACIDAD</option>
                                    <option value="OTROS">OTROS</option>
                                </select>
                                <small v-if="errors.Tipo" class="validation-alert">{{errors.Tipo}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Comentarios</jet-label>
                                <textarea name="" id="" cols="2" v-model="form.Comentarios"  @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                                <small v-if="errors.Comentarios" class="validation-alert">{{errors.Comentarios}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </form>
    </modal>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content tw-bg-blueGray-50 tw-my-4">
                <div class="DetailsHeader">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Historico Vacaciones</h3>
                    </div>
                </div>
                </div>

                <div class="DetailsBody" v-if="Incidencias.length > 0">
                    <Table id="incidencias">
                        <template v-slot:TableHeader>
                            <th class="columna">Num Control</th>
                            <th class="columna">Motivo</th>
                            <th class="columna">Fecha</th>
                            <th class="columna">Comentarios</th>
                        </template>

                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="dato in Incidencias" :key="dato.id">
                                <td class="tw-p-2">{{ dato.IdEmp }}</td>
                                <td class="tw-p-2">{{ dato.TipoMotivo }}</td>
                                <td class="tw-p-2">{{ dato.Fecha }}</td>
                                <td class="tw-p-2">{{ dato.Comentarios }}</td>
                            </tr>
                        </template>
                    </Table>
                </div>
                <div class="DetailsBody" v-else-if="Incidencias.length == ''">
                    <Alert>No se encontraron vacaciones capturadas con anterioridad</Alert>
                </div>
                <div class="tw-bg-coolGray-100 tw-p-4 tw-border-b-4 tw-border-cyan-500">
                </div>
            </div>
        </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableGreen";
import JetButton from "@/Components/Button";
import JetTextArea from "@/Components/Textarea";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
import Alert from "@/Components/Alert";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';

export default {
    mounted() {
        this.tabla();
        this.tablaDetalles();
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        Table,
        Alert,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetSelect,
        JetTextArea,
    },

    props: {
        Session: Object,
        PerfilesUsuarios: Object,
        errors: Object,
        Perfil: Object,
        Incidencias: Object,
    },

    data() {
        return {
            color: "tw-bg-green-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            now: moment().format("YYYY-MM-DD"),
            tam: "xl",
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
            showModal: false,
            form: {
                id: null,
                IdUser: this.Session.id,
                IdEmp: null,
                Fecha: null,
                Tipo: null,
                Comentarios:null,
            },
        };
    },

    methods: {
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

        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: null,
                Fecha: null,
                Tipo: null,
                Comentarios:null,
            };
        },

        openModal() {
            this.chageClose();
            this.reset();
            this.editMode = false;
        },

        chageClose() {
            this.showModal = !this.showModal;
        },

        //datatable
        tabla() {
        this.$nextTick(() => {
            $("#perfiles").DataTable({
            language: this.español,
            });
        });
        },

        tablaDetalles() {
        this.$nextTick(() => {
            $("#incidencias").DataTable({
            language: this.español,
            });
        });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            $('#perfiles').DataTable().clear();
            $('#perfiles').DataTable().destroy();
            this.$inertia.get(
                "/RecursosHumanos/PerfilesUsuarios",
                { busca: event.target.value },
                {
                onSuccess: () => {
                    this.tabla();
                },
                }
        );
        },

        //consulta para generar datos de la tabla de historico
        verTablaDetalles(event) {
            $('#incidencias').DataTable().clear();
            $('#incidencias').DataTable().destroy();
            this.$inertia.get(
                "/RecursosHumanos/Incidencias",
                { busca: event.target.value },
                {
                onSuccess: () => {
                    this.tabla();
                },
                }
        );
        },

        //asigno inforamcion a ventana modal
        incidencias: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = false;
            this.chageClose();
        },

        //guardo de los datos de la incidencia
        save(data) {
            console.log(data.id);
            data.IdUser = this.Session.id;
            this.$inertia.post("/RecursosHumanos/Incidencias", data, {
                onSuccess: () => {
                    this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },

        //Consulta de historico de incidencias por perfil
        Historico: function (data) {
            this.$inertia.get('/RecursosHumanos/Incidencias',{ busca: data.IdEmp }, {
                onSuccess: () => {
                }, preserveState: true
            });
        },
    },
};
</script>
