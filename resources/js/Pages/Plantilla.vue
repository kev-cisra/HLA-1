<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                            Lorem, ipsum dolor.
                    </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-2">
            <div class="tw-flex tw-gap-4 tw-mx-2">
                <div>
                    <jet-label class="tw-text-center">EMPRESA</jet-label>
                    <select class="InputSelect" v-model="params.Empresa" @change="SelectEmpresa">
                        <option value="SHIELDTEX">SHIELDTEX</option>
                        <option value="SERGES">SERGES</option>
                    </select>
                </div>
            </div>
            <div>
                <jet-button @click="openModal" class="BtnNuevo">NUEVA INFORMACIÓN</jet-button>
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
                    <tr class="fila" v-for="data in Objeto" :key="data.id">
                        <td class="tw-p-2">{{data.var}}</td>
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
                                <div class="iconoDetails" @click="view(data)" data-bs-toggle="modal" data-bs-target="#exampleModal" >
                                        <span tooltip="Historico Vacaciones" >
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
        </section>

         <!-- **************************************************** MODALES ****************************************************** -->
    <modal :show="showModal" @close="chageClose" :maxWidth="tam">
        <div class="ModalHeader">
            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Lorem ipsum dolor sit.</h3>
        </div>

        <div class="ModalForm">
<!--             <div class="FormSection">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>VARIABLE</jet-label>
                    <select class="InputSelect">
                        <option v-for="obj in Objeto" :key="obj.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                    </select>
                    <small v-if="errors.obj" class="validation-alert">{{errors.obj}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>VARIABLE</jet-label>
                    <jet-input type="text" ></jet-input>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Código</jet-label>
                    <select  class="InputSelect">
                        <option value="OPCION">OPCION</option>
                    </select>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>FECHA</jet-label>
                    <jet-input type="date"></jet-input>
                </div>
            </div>
            <div class="FormSection">
                <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                    <jet-label><span class="required">*</span>TEXTO</jet-label>
                    <textarea name="" id="" cols="2" @input="(val) => (form.variable = form.variable.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                </div>
            </div> -->
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
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
import Table from "@/Components/TableGreen";
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
            color: "tw-bg-green-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
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
    },

    methods: {
        reset() {
            this.form = {
            };
        },

       //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#Requisiciones").DataTable({
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
    },

    watch: {
    }
};
</script>
