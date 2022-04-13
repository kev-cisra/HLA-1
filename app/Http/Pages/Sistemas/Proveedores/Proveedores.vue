<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>PROVEEDORES SISTEMAS
                    </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-2">
            <div class="tw-flex tw-gap-4 tw-mx-2">
                <div>
                    <jet-label class="tw-text-center">NOMBRE PROVEEDOR</jet-label>
                    <jet-input type="text" v-model="form.Nombre"></jet-input>
                    <small v-if="errors.Nombre" class="validation-alert">{{errors.Nombre}}</small>
                </div>
                <div class="ModalFooter">
                    <jet-button type="button" @click="save(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
                    <jet-button type="button" @click="update(form)" v-show="editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualizar</jet-button>
                </div>
            </div>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->
        <section class="tw-mx-2">
            <Table id="datos">
                <template v-slot:TableHeader>
                    <th class="columna">NOMBRE</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in Proveedores" :key="data.id">
                        <td>{{data.Nombre}}</td>
                        <td>
                            <div class="FlexCenter">
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
import JetInput from "@/Components/Input";
import JetLabel from '@/Jetstream/Label';
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";

//Moment Js
import moment from 'moment';
import 'moment/locale/es';

export default {
    data() {
        return {
            now: moment().format("YYYY-MM-DD"),
            tam: "4xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                Nombre: '',
            },
            params: {
            },
        };
    },

    mounted() {
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        Table,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetLabel,
        JetSelect,
    },

    props: {
        Session: Object,
        errors: Object,
        Proveedores: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                Nombre: '',
            };
        },

       //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#tabla").DataTable({
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

        save(data){
            this.$inertia.post("/Sistemas/Proveedores", data, {
                onSuccess: () => {
                    this.reset(),
                    this.alertSucces();
                },
            });
        },

        edit: function (data) {
            this.editMode = true;
            this.form = Object.assign({}, data);
        },

        update(data) {
            data.IdUser = this.Session.id,
            data._method = "PUT";
            this.$inertia.post("/Sistemas/Proveedores/" + data.id, data, {
                onSuccess: () => {
                    this.editMode = false;
                    this.reset(),
                    this.alertSucces();
                },
            });
        },

        deleteRow: function (data) {
            data._method = "DELETE";
            this.$inertia.post("/Sistemas/Proveedores/" + data.id, data, {
                onSuccess: () => {
                    Swal.fire(
                        'Eliminado!',
                        'El registro fue eliminado con éxito',
                        'success'
                    )
                },
            });
        },
    },

    watch: {
    }
};
</script>
