<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                            VALES DE SALIDA.
                    </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-2 md:tw-mx-10">
            <div class="tw-flex tw-gap-4 tw-mx-2">
            </div>
            <div>
                <jet-button @click="openModal" class="BtnNuevo">NUEVA VALE</jet-button>
            </div>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->
        <section class="tw-mx-2 md:tw-mx-10">
            <Table id="TablaVales">
                <template v-slot:TableHeader>
                    <th class="columna">Folio</th>
                    <th class="columna">Fecha Salida</th>
                    <th class="columna">Proveedor</th>
                    <th class="columna">EstatusVale</th>
                    <th class="columna">Fecha Entrega</th>
                    <th class="columna">NumReq</th>
                    <th class="columna">Observaciones</th>
                    <th class="columna">Acciones</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in ValesSalida" :key="data.id">
                        <td>{{data.Folio}}</td>
                        <td>{{data.Fecha}}</td>
                        <td>{{data.NombreProveedor}}</td>
                        <td>{{data.EstatusVale}}</td>
                        <td>{{data.Salida}}</td>
                        <td>{{data.requisicion.NumReq}}</td>
                        <td>{{data.requisicion.Observaciones}}</td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                <div class="iconoEdit" @click="edit(data)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="remove(data)">
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

        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>VALES DE SALIDA</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>NÚM REQ</jet-label>
                        <jet-input type="text" min="0" v-model="form.NumReq"></jet-input>
                        <small v-if="errors.NumReq" class="validation-alert">{{errors.NumReq}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>FOLIO</jet-label>
                        <jet-input type="text" min="0" v-model="form.Folio"></jet-input>
                        <small v-if="errors.Folio" class="validation-alert">{{errors.Folio}}</small>
                    </div>

                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>FECHA SALIDA</jet-label>
                        <jet-input type="date" v-model="form.Fecha"></jet-input>
                        <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>PROVEEDOR</jet-label>
                        <select id="Jefe" v-model="form.NombreProveedor"  class="InputSelect">
                            <option v-for="select in Proveedores" :key="select.id" :value="select.Nombre" >{{ select.Nombre }}</option>
                        </select>
                        <small v-if="errors.NombreProveedor" class="validation-alert">{{errors.NombreProveedor}}</small>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>FECHA RECIBIDO</jet-label>
                        <jet-input type="date" v-model="form.Salida"></jet-input>
                    </div>

                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>ESTATUS</jet-label>
                        <select class="InputSelect" v-model="form.EstatusVale">
                            <option value="ENTREGADO">ENTREGADO</option>
                            <option value="RECIBIDO">RECIBIDO</option>
                            <option value="GARANTIA">GARANTIA</option>
                        </select>
                        <small v-if="errors.EstatusVale" class="validation-alert">{{errors.EstatusVale}}</small>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" v-show="editMode">Actualizar</jet-button>
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
import Table from "@/Components/TableCyan";
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
            tam: "xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                NumReq: '',
                Folio: '',
                Fecha: '',
                NombreProveedor: '',
                Salida: '',
                EstatusVale: '',
            },
            params: {
            },
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
        ValesSalida: Object,
        Proveedores: Object,
    },

    methods: {
        reset() {
            this.form = {
                NumReq: '',
                Folio: '',
                Fecha: '',
                NombreProveedor: '',
                Salida: '',
                EstatusVale: '',
            };
        },

       //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#TablaVales").DataTable({
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
            this.$inertia.post("/Almacen/ValesSalida", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },

        edit: function (data) {
            this.form = Object.assign({}, data);
            this.form.NumReq = data.requisicion.NumReq;
            this.editMode = true;
            this.chageClose();
        },

        update(data) {
            data.metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Almacen/ValesSalida/" + data.id, data, {
                onSuccess: () => {
                    this.editMode = false;
                    this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },

        remove(data){
            data._method = "DELETE";
            this.$inertia.post("/Almacen/ValesSalida/" + data.id, data, {
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

    watch: {
    }
};
</script>
