<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>INSUMOS
                    </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-2">
            <div>
                <jet-button @click="openModal" class="BtnNuevo">NUEVA INFORMACIÓN</jet-button>
            </div>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->
        <section class="tw-mx-8">
            <Table id="Insumos">
                <template v-slot:TableHeader>
                    <th class="columna">CLAVE</th>
                    <th class="columna">INSUMO</th>
                    <th class="columna">LINEA</th>
                    <th class="columna">UNIDAD</th>
                    <th class="columna">CANTIDAD</th>
                    <th class="columna">DEPARTAMENTO</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in Insumos" :key="data.id">
                        <td class="tw-p-2">{{data.Clave}}</td>
                        <td class="tw-p-2">{{data.Nombre}}</td>
                        <td class="tw-p-2">{{data.Linea}}</td>
                        <td class="tw-p-2">{{data.Unidad}}</td>
                        <td class="tw-p-2">{{data.Cantidad}}</td>
                        <td class="tw-p-2">{{data.departamento.Nombre}}</td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                <div class="iconoEdit" @click="edit(data)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="delte(data)">
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
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>REGISTRA NUEVO INSUMO</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>CLAVE</jet-label>
                        <jet-input type="text" v-model="form.Clave"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>INSUMO</jet-label>
                        <jet-input type="text" v-model="form.Nombre"></jet-input>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                        <jet-label><span class="required">*</span>LINEA</jet-label>
                        <select  class="InputSelect" v-model="form.Linea">
                            <option value="LIMPIEZA">LIMPIEZA</option>
                            <option value="INSUMO">INSUMO</option>
                        </select>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                            <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                            <jet-input type="text" v-model="form.Cantidad"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                        <jet-label><span class="required">*</span>UNIDAD</jet-label>
                        <jet-input type="text" v-model="form.Unidad"></jet-input>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                        <select class="InputSelect" v-model="form.Departamento_id">
                            <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualizar</jet-button>
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
import Table from "@/Components/TableTeal";
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
            color: "tw-bg-teal-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                Clave: '',
                Nombre: '',
                Linea: '',
                Unidad: '',
                Cantidad: '',
                Departamento_id: '',
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
        Departamentos: Object,
        Insumos: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                Clave: '',
                Nombre: '',
                Linea: '',
                Unidad: '',
                Cantidad: '',
                Departamento_id: '',
            };
        },

       //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#Insumos").DataTable({
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
            this.$inertia.post("/Compras/Insumos", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },

        edit: function (data) {
            console.log(data);
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.chageClose();
        },

        update(data) {
            data.metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Compras/Insumos/" + data.id, data, {
                onSuccess: () => {
                this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },
    },

    watch: {
    }
};
</script>
