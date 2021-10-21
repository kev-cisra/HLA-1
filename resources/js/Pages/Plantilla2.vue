<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header>
            <slot>Perfiles de Usuarios</slot>
        </Header>

        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-end">
                <div>
                    <jet-button @click="openModal" class="BtnNuevo">Nueva Información</jet-button>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
                <TableGreen id="perfiles">
                    <template v-slot:TableHeader>
                        <th class="columna">dato</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="dato in datos" :key="dato.id">
                            <td class="tw-p-2">{{ dato.var }}</td>
                            <td class="fila">
                                <div class="columnaIconos">
                                    <div class="iconoDetails" @click="show(dato)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <span tooltip="Detalles" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoEdit" @click="edit(dato)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoDelete" @click="deleteRow(dato)">
                                        <span tooltip="Eliminar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </TableGreen>
            </div>
        </div>

    </div>


    <modal :show="showModal" @close="chageClose" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Registro de Información</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>variable</jet-label>
                                <jet-input type="text" v-model="form.variable"></jet-input>
                                <small v-if="errors.variable" class="validation-alert">{{errors.variable}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>variable</jet-label>
                                <select id="Jefe" v-model="form.variable"  class="InputSelect">
                                    <option v-for="select in selects" :key="select.id" :value="select.id" >{{ select.variable2 }}</option>
                                </select>
                                <small v-if="errors.variable" class="validation-alert" >{{ errors.variable }}</small>
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
        <div class="modal-dialog">
            <div class="modal-content tw-bg-blueGray-50 tw-my-4">
                <div class="DetailsHeader">
                    <div class="tw-max-w-sm tw-mx-auto md:tw-w-full md:tw-mx-0">
                        <div class="tw-inline-flex tw-items-center tw-space-x-4">
                            <img class="tw-object-cover tw-w-10 tw-h-10 tw-rounded-full" src="https://picsum.photos/200/300"/>
                            <h1 class="titleDetails">Informacion Personal</h1>
                        </div>
                    </div>
                </div>
                <div class="DetailsBody">

                    <div class="SectionInfo">
                        <h2 class="SectionTitle md:tw-w-1/4">Datos Personales</h2>
                        <div class="tw-max-w-sm tw-mx-auto md:tw-w-3/4">
                            <div>
                                <label class="info">Nombre</label>
                                <div class="DataContainer">
                                    <input type="text" class="InfoData" v-model="form.Nombre" disabled/>
                                </div>
                            </div>
                            <div>
                                <label class="info">Apellido Paterno</label>
                                <div class="DataContainer">
                                    <input type="text" class="InfoData" v-model="form.ApPat" disabled/>
                                </div>
                            </div>
                            <div>
                                <label class="info">Apellido Materno</label>
                                <div class="DataContainer">
                                    <input type="text" class="InfoData" v-model="form.ApMat" disabled/>
                                </div>
                            </div>
                            <div>
                                <label class="info">Cumpleaños</label>
                                <div class="DataContainer">
                                    <input type="date" class="InfoData" v-model="form.Cumpleaños" disabled/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="SectionInfo">
                        <h2 class="SectionTitle md:tw-w-1/4">Datos de Pila</h2>
                        <div class="tw-max-w-sm tw-mx-auto md:tw-w-3/4">
                            <div>
                                <label class="info">CURP</label>
                                <div class="DataContainer">
                                    <input type="text" class="InfoData" v-model="form.Curp" disabled/>
                                </div>
                            </div>
                            <div>
                                <label class="info">RFC</label>
                                <div class="DataContainer">
                                    <input type="text" class="InfoData" v-model="form.Rfc" disabled/>
                                </div>
                            </div>
                            <div>
                                <label class="info">NSS</label>
                                <div class="DataContainer">
                                    <input type="text" class="InfoData" v-model="form.Nss" disabled/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="SectionInfo">
                        <h2 class="SectionTitle md:tw-w-1/4">Datos de Contacto</h2>
                        <div class="tw-max-w-sm tw-mx-auto md:tw-w-3/4">
                            <div>
                                <label class="info">Telefono</label>
                                <div class="DataContainer">
                                    <input type="text" class="InfoData" v-model="form.Telefono" disabled/>
                                </div>
                            </div>
                            <div>
                                <label class="info">Direccion</label>
                                <div class="DataContainer">
                                    <input type="text" class="InfoData" v-model="form.Direccion" disabled/>
                                </div>
                            </div>
                        </div>
                    </div>
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
import TableGreen from "@/Components/TableGreen";
import Table from "@/Components/Table";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';

export default {
    mounted() {
        this.tabla();
    },

    data() {
        return {
            tam: "4xl",
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
            },
        };
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        TableGreen,
        Table,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetSelect,
    },

    props: {
        Session: Object,
    },

    mounted() {
        this.tabla();
    },

    methods: {
    },
};
</script>
