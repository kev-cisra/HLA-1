<template>
    <app-layout>
        <!-- ****************************************** TITULO ********************************************* -->
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fa-solid fa-desktop tw-ml-3 tw-mr-3"></i>Equipos Cómputo</h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-end tw-content-center tw-p-1 tw-my-8 tw-mx-4">
            <div>
                <jet-button @click="openModal" class="BtnNuevo">NUEVA INFORMACIÓN</jet-button>
            </div>
        </section>
        <!-- ****************************************** CONTENIDO ********************************************* -->
        <section class="tw-mx-4">
            <Table id="Hardware">
                <template v-slot:TableHeader>
                    <th class="columna">NOMBRE</th>
                    <th class="columna">MARCA</th>
                    <th class="columna">MODELO</th>
                    <th class="columna">NUM SERIE</th>
                    <th class="columna">COMENTARIOS</th>
                    <th class="columna">ESTATUS</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in EquiposComputo" :key="data.id">
                        <td class="tw-p-2">{{data.Nombre}}</td>
                        <td class="tw-p-2">{{data.Marca}}</td>
                        <td class="tw-p-2">{{data.Modelo}}</td>
                        <td class="tw-p-2">{{data.NumeroSerie}}</td>
                        <td class="tw-p-2">{{data.Comentarios}}</td>
                        <td class="tw-p-2">
                            <div class="FlexCenter">
                                    <div v-if="data.Estatus == 0">
                                        <span tooltip="Inactivo" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-pink-500 tw-rounded-full">Inactivo</span>
                                        </span>
                                    </div>
                                    <div v-if="data.Estatus == 1">
                                        <span tooltip="Activo" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-teal-500 tw-rounded-full">Activo</span>
                                        </span>
                                    </div>
                            </div>
                        </td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                <div class="iconoEdit" @click="edit(data)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="deleteRow(data)">
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
            </Table>
        </section>
        <!-- **************************************************** MODALES ****************************************************** -->
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Equipos Computo</h3>
            </div>

            <div class="ModalForm">
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>NOMBRE DISPOSITIVO</jet-label>
                        <jet-input type="text" v-model="form.Nombre" @input="(val) => (form.Nombre = form.Nombre.toUpperCase())"></jet-input>
                        <small v-if="errors.Nombre" class="validation-alert">{{errors.Nombre}}</small>
                    </div>
                </div>
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>MARCA</jet-label>
                        <jet-input type="text" v-model="form.Marca" @input="(val) => (form.Marca = form.Marca.toUpperCase())"></jet-input>
                        <small v-if="errors.Marca" class="validation-alert">{{errors.Marca}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>MODELO</jet-label>
                        <jet-input type="text" v-model="form.Modelo" @input="(val) => (form.Modelo = form.Modelo.toUpperCase())"></jet-input>
                        <small v-if="errors.Modelo" class="validation-alert">{{errors.Modelo}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>NUM SERIE</jet-label>
                        <jet-input type="text" v-model="form.NumeroSerie" @input="(val) => (form.NumeroSerie = form.NumeroSerie.toUpperCase())"></jet-input>
                        <small v-if="errors.NumeroSerie" class="validation-alert">{{errors.NumeroSerie}}</small>
                    </div>
                </div>
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label>COMENTARIOS</jet-label>
                        <textarea cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </modal>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableSky";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetLabel from '@/Jetstream/Label';
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
            tam: "2xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                Cantidad: '',
                Nombre: '',
                Marca: '',
                Modelo: '',
                NumeroSerie: '',
                Comentarios: '',
            },

        };
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        JetLabel,
        JetInput,
        JetSelect,
        JetButton,
        JetCancelButton,
        Table,
        Modal,
        Pagination,
    },

    props: {
        errors: Object,
        EquiposComputo: Object,
        Session: Object,
    },

    mounted(){
        this.tabla();
    },

    methods: {
       //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#Hardware").DataTable({
                    destroy: true,
                    stateSave: true,
                    language: this.español,
                    paging: true,
                    pageLength : 20,
                    scrollX: true,
                    scrollY:  '40vh',
                    order: [0, 'desc'],
                    columnDefs: [
                        { "width": "3%", "targets": [0] },
                    ],
                    "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        'colvis'
                    ]
                }).draw();
            });
        },

        reset() {
            this.form = {
                IdUser: this.Session.id,
                Cantidad: '',
                Nombre: '',
                Marca: '',
                Modelo: '',
                NumeroSerie: '',
                Comentarios: '',
            };
        },

        save(data){
            data.Estatus = 1;
            data.Cantidad = 1;
            this.$inertia.post("/Sistemas/EquiposComputo", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },

        edit: function (data) {
            data.Cantidad = 1;
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.chageClose();
        },

        update(data) {
            data.metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/EquiposComputo/" + data.id, data, {
                onSuccess: () => {
                this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },

        deleteRow(data){
            data._method = "DELETE";
            this.$inertia.post("/Sistemas/EquiposComputo/" + data.id, data, {
                onSuccess: () => {
                    Swal.fire(
                        'Eliminado!',
                        'El registro fue eliminado con éxito',
                        'success'
                    )
                },
            });
        }
    },
};
</script>
