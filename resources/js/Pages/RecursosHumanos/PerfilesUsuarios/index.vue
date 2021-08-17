<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                        Perfiles de Usuarios
                </h3>
            </slot>
        </Header>
        {{ fecha }}

        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-end">
                <div>
                    <jet-button @click="openModal" class="BtnNuevo">Nueva Información</jet-button>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
                <TableGreen id="perfiles">
                    <template v-slot:TableHeader>
                        <th class="columna">Núm. Empleado</th>
                        <th class="columna">Empresa</th>
                        <th class="columna">Nombre</th>
                        <th class="columna">Paterno</th>
                        <th class="columna">Materno</th>
                        <th class="columna">Curp</th>
                        <th class="columna">RFC</th>
                        <th class="columna">NSS</th>
                        <th class="columna">Direccion</th>
                        <th class="columna">Telefono</th>
                        <th class="columna">Fecha Ingreso</th>
                        <th class="columna">Antiguedad</th>
                        <th class="columna">Dias Vac.</th>
                        <th class="columna">Puesto</th>
                        <th class="columna">Departamento</th>
                        <th class="columna">Jefe</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in PerfilesUsuarios" :key="datos.id">
                            <td class="tw-p-2">{{ datos.IdEmp }}</td>
                            <td class="tw-p-2">{{ datos.Empresa }}</td>
                            <td class="tw-p-2">{{ datos.Nombre }}</td>
                            <td class="tw-p-2">{{ datos.ApPat }}</td>
                            <td class="tw-p-2">{{ datos.ApMat }}</td>
                            <td class="tw-p-2">{{ datos.Curp }}</td>
                            <td class="tw-p-2">{{ datos.Rfc }}</td>
                            <td class="tw-p-2">{{ datos.Nss }}</td>
                            <td class="tw-p-2">{{ datos.Direccion }}</td>
                            <td class="tw-p-2">{{ datos.Telefono }}</td>
                            <td class="tw-p-2">{{ datos.FecIng }}</td>
                            <td class="tw-p-2">{{ datos.Antiguedad }}</td>
                            <td class="tw-p-2">{{ datos.DiasVac }}</td>
                            <td class="tw-p-2">{{ datos.perfil_puesto.Nombre }}</td>
                            <td class="tw-p-2">{{ datos.perfil_departamento.Nombre }}</td>
                            <td class="tw-p-2">{{ datos.perfil_jefe.Nombre }}</td>
                            <td class="fila">
                                <div class="columnaIconos">
                                    <div class="iconoDetails" @click="show(datos)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <span tooltip="Detalles" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoEdit" @click="edit(datos)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoDelete" @click="deleteRow(datos)">
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
                                <jet-label><span class="required">*</span>Número Empleado</jet-label>
                                <jet-input type="text" v-model="form.IdEmp"></jet-input>
                                <small v-if="errors.IdEmp" class="validation-alert">{{errors.IdUser}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Empresa</jet-label>
                                <select id="Empresa" v-model="form.Empresa" class="InputSelect">
                                    <option value="HILATURAS">HILATURAS</option>
                                    <option value="SERGES">SERGES</option>
                                </select>
                                <small v-if="errors.Empresa" class="validation-alert">{{ errors.Empresa }}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Jefe</jet-label>
                                <select id="Jefe" v-model="form.jefes_areas_id"  class="InputSelect">
                                    <option v-for="jefe in Jefes" :key="jefe.id" :value="jefe.id" >{{ jefe.Nombre }}</option>
                                </select>
                                <small v-if="errors.jefes_areas_id" class="validation-alert" >{{ errors.jefes_areas_id }}</small>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Nombre</jet-label>
                                <jet-input type="text" v-model="form.Nombre" @input="(val) => (form.Nombre = form.Nombre.toUpperCase())"></jet-input>
                                <small v-if="errors.Nombre" class="validation-alert">{{errors.Nombre}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Apellido Paterno</jet-label>
                                <jet-input type="text" v-model="form.ApPat" @input="(val) => (form.ApPat = form.ApPat.toUpperCase())"></jet-input>
                                <small v-if="errors.ApPat" class="validation-alert">{{errors.ApPat}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Apellido Materno</jet-label>
                                <jet-input type="text" v-model="form.ApMat" @input="(val) => (form.ApMat = form.ApMat.toUpperCase())"></jet-input>
                                <small v-if="errors.ApMat" class="validation-alert">{{errors.ApMat}}</small>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>CURP</jet-label>
                                <jet-input type="text" v-model="form.Curp" @input="(val) => (form.Curp = form.Curp.toUpperCase())" @change="ValidaCurp($event)"></jet-input>
                                <small v-if="errors.Curp" class="validation-alert">{{errors.Curp}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Número de Seguro Social</jet-label>
                                <jet-input type="text" v-model="form.Nss" @input="(val) => (form.Nss = form.Nss.toUpperCase())" @change="ValidaNss($event)"></jet-input>
                                <small v-if="errors.Nss" class="validation-alert">{{errors.Nss}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>RFC</jet-label>
                                <jet-input type="text" v-model="form.Rfc" @input="(val) => (form.Rfc = form.Rfc.toUpperCase())" @change="ValidaRfc($event)"></jet-input>
                                <small v-if="errors.Rfc" class="validation-alert">{{errors.Rfc}}</small>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Direccion</jet-label>
                                <jet-input type="text" v-model="form.Direccion" @input="(val) => (form.Direccion = form.Direccion.toUpperCase())"></jet-input>
                                <small v-if="errors.Direccion" class="validation-alert">{{errors.Direccion}}</small>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Telefono</jet-label>
                                <jet-input type="text" v-model="form.Telefono" @input="(val) => (form.Telefono = form.Telefono.toUpperCase())" @change="ValidaCel($event)"></jet-input>
                                <small v-if="errors.Telefono" class="validation-alert">{{errors.Telefono}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha Cumpleaños</jet-label>
                                <jet-input type="date" v-model="form.Cumpleaños" @change="FechaMayor($event)"></jet-input>
                                <small v-if="errors.Cumpleaños" class="validation-alert">{{errors.Cumpleaños}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha Ingreso</jet-label>
                                <jet-input type="date" v-model="form.FecIng" @change="FechaMayor($event)"></jet-input>
                                <small v-if="errors.FecIng" class="validation-alert">{{errors.FecIng}}</small>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Puesto</jet-label>
                                <select id="Jefe" v-model="form.Puesto_id" class="InputSelect">
                                    <option v-for="puesto in Puestos" :key="puesto.id" :value="puesto.id" >
                                        {{ puesto.Nombre }}
                                    </option>
                                </select>
                                <small v-if="errors.Puesto_id" class="validation-alert">{{errors.Puesto_id}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Departamento</jet-label>
                                <select id="Jefe" v-model="form.Departamento_id" class="InputSelect">
                                    <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                </select>
                                <small v-if="errors.Departamento_id" class="validation-alert" >{{ errors.Departamento_id }}</small>
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
    data() {
        return {
            color: "tw-bg-green-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            now: moment().format("YYYY-MM-DD"),
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
                IdUser: this.Session.id,
                IdEmp: null,
                jefes_areas_id: null,
                Empresa: null,
                Nombre: null,
                ApPat: null,
                ApMat: null,
                Curp: null,
                Rfc: null,
                Nss: null,
                Direccion: null,
                Telefono: null,
                Cumpleaños: null,
                FecIng: null,
                Antiguedad: null,
                DiasVac: null,
                Puesto_id: null,
                Departamento_id: null,
            },
            rows: [
                {name: ""}
            ]
        };
    },

    mounted() {
        this.tabla();
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
        PerfilesUsuarios: Object,
        errors: Object,
        Jefes: Object,
        Puestos: Object,
        Departamentos: Object,
        fecha: Object
    },

    methods: {
        FechaMayor(event){
            var fecha1 = event.target.value;
            var fecha2 = moment(); //fecha de hoy
            var tiempo = fecha2.diff(fecha1, 'hours');
            if(tiempo < 0){
                console.log("fecha invalida");
                event.target.value = '';
            }
        },

        Renapo: function (curp) {
            var regex = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/;
            return regex.test(curp);
        },

        SeguroSocial: function (rfc) {
            var regex = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            return regex.test(rfc);
        },

        Rfc: function (nss) {
            var regex = /^(\d{2})(\d{2})(\d{2})\d{5}$/;
            return regex.test(nss);
        },

        Celular(cel){
           var regex = /^(\(\+?\d{2,3}\)[\*|\s|\-|\.]?(([\d][\*|\s|\-|\.]?){6})(([\d][\s|\-|\.]?){2})?|(\+?[\d][\s|\-|\.]?){8}(([\d][\s|\-|\.]?){2}(([\d][\s|\-|\.]?){2})?)?)$/;
            return regex.test(cel);
        },

        ValidaCurp(event) {
            if (!this.Renapo(event.target.value)){
                console.log("CURP NO VALIDO")
                this.alertWarning();
            }else{
                console.log("CURP CORRECTO")
            }
        },

        ValidaNss(event){
            if (!this.SeguroSocial(event.target.value)){
                console.log("NSS NO VALIDO")
                this.alertWarning();
            }else{
                console.log("nss CORRECTO")
            }
        },

        ValidaRfc(event){
            if (!this.Rfc(event.target.value)){
                console.log("rfc NO VALIDO")
                this.alertWarning();
            }else{
                console.log("rfc CORRECTO")
            }
        },

        ValidaCel(event){
            if (!this.Celular(event.target.value)){
                this.alertWarning();
            }else{
                console.log("Celular CORRECTO")
            }
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
                jefes_areas_id: null,
                Empresa: null,
                Nombre: null,
                ApPat: null,
                ApMat: null,
                Curp: null,
                Rfc: null,
                Nss: null,
                Direccion: null,
                Telefono: null,
                Cumpleaños: null,
                FecIng: null,
                Antiguedad: null,
                DiasVac: null,
                Puesto_id: null,
                Departamento_id: null,
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

        //consulta para generar datos de la tabla
        verTabla(event) {
        $("#perfiles").DataTable().destroy();
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

        save(data) {
            //Obtengo la fecha ingresada
            var fecha1 = data.FecIng;
            var fecha2 = moment(); //fecha de hoy

            //calculo de diferencia de años entre las 2 fechas
            data.Antiguedad = fecha2.diff(fecha1, 'years')

            if(data.Antiguedad > 0){ //si tiene años de antiguedad entra al proceso

                if(data.Antiguedad <= 5){
                    // menor a 5 años se agregan 2 dias por cada año cumplido
                switch(data.Antiguedad){
                    case 1: data.DiasVac = 6; break;
                    case 2: data.DiasVac = 8; break;
                    case 3: data.DiasVac = 10; break;
                    case 4: data.DiasVac = 12; break;
                    case 5: data.DiasVac = 14; break;
                }
                //proceso de agregar 2 dias por cada 5 años cumplidos de antiguedad
                }else if(data.Antiguedad <= 9){
                    data.DiasVac = 14;
                }else if(data.Antiguedad >= 10 && data.Antiguedad <= 14){
                    data.DiasVac = 16;
                }else if(data.Antiguedad >= 15 && data.Antiguedad <= 19){
                    data.DiasVac = 18;
                }else if(data.Antiguedad >= 20 && data.Antiguedad <= 24){
                    data.DiasVac = 20;
                }else if(data.Antiguedad >= 25 && data.Antiguedad <= 29){
                    data.DiasVac = 22;
                }else if(data.Antiguedad >= 30 && data.Antiguedad <= 24){
                    data.DiasVac = 24;
                }
            }else{
                data.DiasVac = 0;
            }

        this.$inertia.post("/RecursosHumanos/PerfilesUsuarios", data, {
            onSuccess: () => {
            this.reset(), this.chageClose(), this.alertSucces();
            },
        });
        },

        edit: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.chageClose();
        },

        update(data) {
        data._method = "PUT";
        this.$inertia.post("/RecursosHumanos/PerfilesUsuarios/" + data.id, data, {
            onSuccess: () => {
            this.reset(), this.chageClose(), this.alertSucces();
            },
        });
        },

        deleteRow: function (data) {
            Swal.fire({
                title: '¿Estas seguro de querer eliminar esta información',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'No, Cancelar!',
                }).then((result) => {
                if (result.isConfirmed) {

                    data._method = "DELETE";
                    this.$inertia.post("/RecursosHumanos/PerfilesUsuarios/" + data.id, data, {
                        onSuccess: () => {
                            Swal.fire(
                                'Eliminado!',
                                'El registro fue eliminado con éxito',
                                'success'
                            )
                        },
                    });
                }
                })
        },

        show: function (data) {
        this.form = Object.assign({}, data);
        },
    },

    watch: {
    }
};
</script>
