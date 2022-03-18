<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fas fa-user tw-ml-3 tw-mr-3"></i> REQUISICIONES SISTEMAS </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-8">
            <div class="tw-flex tw-gap-4 tw-mx-2">
            </div>
            <div>
                <jet-button @click="openModal" class="BtnNuevo">NUEVA REQUISICION</jet-button>
            </div>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->
        <section class="tw-mx-8">
            <Table id="Requisiciones">
                <template v-slot:TableHeader>
                    <th class="columna">FECHA</th>
                    <th class="columna">FOLIO</th>
                    <th class="columna">SOLICITANTE</th>
                    <th class="columna">DEPARTAMENTO</th>
                    <th class="columna">MATERIAL</th>
                    <th class="columna">ESTATUS</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in ReqSistemas" :key="data.id">
                        <td>{{data.Fecha}}</td>
                        <td>RSIS-0{{data.Folio}}</td>
                        <td>{{data.perfil.Nombre}} {{data.perfil.ApPat}} {{data.perfil.ApMat}} </td>
                        <td>{{data.departamento.Nombre}}</td>
                        <td>
                            <p v-for="art in data.articulos" :key="art.id">
                                -{{art.hardware.Cantidad }} {{art.hardware.Unidad }} {{art.hardware.Nombre }}
                            </p>
                        </td>
                        <td>
                            <div class="FlexCenter">
                                <div v-if="data.Estatus == 0">
                                    <span tooltip="Confirmar Solicitud" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blueGray-400 tw-rounded-full">SOLICITADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 1">
                                    <span tooltip="Solicitado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-emerald-500 tw-rounded-full">COTIZAR</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 2">
                                    <span tooltip="Cotizado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-500 tw-rounded-full">COTIZADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 3">
                                    <span tooltip="En Autorización" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-500 tw-rounded-full">AUTORIZACIÓN</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 4">
                                    <span tooltip="Autorizado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-500 tw-rounded-full">APROBADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 5">
                                    <span tooltip="Material Adquirido" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blue-500 tw-rounded-full">STOCK</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 10">
                                    <span tooltip="Cotizacion Rechazada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-rose-500 tw-rounded-full">RECHAZADA</span>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                <div class="iconoEdit" @click="Confirma(data)" v-if="data.Estatus == 0">
                                    <span tooltip="Enviar Solicitud a Compra" flow="left">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </div>
                                <div class="iconoDetails" @click="view(data)" >
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
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>NUEVA REQUISICIÓN</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>FECHA</jet-label>
                        <jet-input type="date" :min="Today" v-model="form.Fecha"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                        <select class="InputSelect" v-model="form.Departamento_id">
                            <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                        </select>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3">
                        <input type="button" @click="addRow()" value="Añadir Partida" class="BtnCancel">
                    </div>
                </div>
                <div class="FormSection" v-for="(form) in form.Partida" :key="form.id">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                        <jet-input type="number" min="1" v-model="form.Cantidad"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-3/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>UNIDAD</jet-label>
                        <select id="Unidad" v-model="form.Unidad" class="InputSelect">
                            <option value="PZ">PIEZAS</option>
                            <option value="MT">METROS</option>
                            <option value="CAJA">CAJA</option>
                        </select>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-6/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>MATERIAL</jet-label>
                        <select class="InputSelect" v-model="form.Hardware_id">
                            <option v-for="hard in Hardware" :key="hard.id" :value="hard.id" > {{ hard.Nombre }}</option>
                        </select>
                    </div>
                    <div class="tw-mt-6  md:tw-w-1/12 md:tw-mb-0">
                        <button type="button" class="btn btn-primary" @click="removeRow(index)">Quitar</button>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)">Guardar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </modal>
        <!-- --------------------- Modal para ver partidas -------------------------- -->
        <modal :show="showDetalle" @close="chageDetalle" maxWidth="xl">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>REQUISICIÓN RSIS-0{{form.Folio}}</h3>
            </div>

            <div class="ModalForm">
                <Table id="Articulos">
                    <template v-slot:TableHeader>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">EQUIPO</th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="data in ArticulosReq" :key="data.id">
                            <td class="tw-text-center">{{data.Cantidad}}</td>
                            <td class="tw-text-center">{{data.Unidad}}</td>
                            <td class="tw-text-center">{{data.hardware.Nombre}} </td>
                            <td>
                                <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                    <div class="iconoEdit" @click="edit(data)" v-if="form.Estatus == 0">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="IconAproved" v-else-if="form.Estatus == 1">
                                        <span tooltip="Aprovado" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>

            <div class="ModalFooter">
                <jet-CancelButton @click="chageDetalle">Cerrar</jet-CancelButton>
            </div>
        </modal>
        <!-- --------------------- Modal para editar partida -------------------------- -->
        <modal :show="showCreate" @close="chageCreate" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>NUEVA REQUISICIÓN</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>FECHA</jet-label>
                        <jet-input type="date" :min="Today" v-model="form.Fecha"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                        <select class="InputSelect" v-model="form.Departamento_id">
                            <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                        </select>
                    </div>
                </div>
                <div class="FormSection" v-for="(form) in form.Partida" :key="form.id">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                        <jet-input type="number" min="1" v-model="form.Cantidad"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-3/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>UNIDAD</jet-label>
                        <select id="Unidad" v-model="form.Unidad" class="InputSelect">
                            <option value="PZ">PIEZAS</option>
                            <option value="MT">METROS</option>
                            <option value="CAJA">CAJA</option>
                        </select>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-6/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>MATERIAL</jet-label>
                        <select class="InputSelect" v-model="form.Hardware_id">
                            <option v-for="hard in Hardware" :key="hard.id" :value="hard.id" > {{ hard.Nombre }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="update(form)">Actualizar</jet-button>
                <jet-CancelButton @click="chageCreate">Cerrar</jet-CancelButton>
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
            showCreate: false,
            showDetalle: false,
            form: {
                IdUser: this.Session.id,
                Fecha: '',
                Folio: '',
                Departamento_id: '',
                Estatus: '',
                Partida: [{
                    Cantidad: '',
                    Unidad: '',
                    Hardware_id: '',
                }],
                requisicion_sistemas_id: '',
            },
            ArticulosReq: [],
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
        ReqSistemas: Object,
        Hardware: Object,
    },

    methods: {
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

        reset() {
            this.form = {
                IdUser: this.Session.id,
                Fecha: '',
                Folio: '',
                Departamento_id: '',
                Estatus: '',
                Partida: [{
                    Cantidad: '',
                    Unidad: '',
                    Hardware_id: '',
                }],
                requisicion_sistemas_id: '',
            };
        },

        addRow: function () { //Agregar Campos dinamicamente
            //Funcion para añadir inputs dinamicos
            this.form.Partida.push({Part: ""});
        },

        removeRow: function (row) { //Quitar Campos dinamicamente
            //Quitar del arreglo los inputs dinamicos
            this.form.Partida.splice(row,1);
        },

        chageCreate(){
            this.showCreate = !this.showCreate;
        },

        save(data){ //Funcion de guardado de requisicion
            data.Estatus = 0;
            this.$inertia.post("/Sistemas/RequisicionSistemas", data, {
                onSuccess: () => {
                    if(this.$attrs.jetstream.flash.type == 'Warning'){
                        this.alertInfo(this.$attrs.jetstream.flash.message);
                    }else{
                        this.alertSucces();
                        this.reset();
                        this.chageClose();
                    }
                },
            });
        },

        Confirma(data){
            data.Metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/RequisicionSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        chageDetalle(){
            this.showDetalle  = !this.showDetalle;
        },

        view(data){
            this.chageDetalle();
            this.form.Folio = data.Folio;
            this.form.Fecha = data.Fecha;
            this.form.Departamento_id = data.Departamento_id;
            this.ArticulosReq = data.articulos;
            this.form.Estatus = data.Estatus;
        },

        edit(data){
            this.editMode = true;
            this.form.requisicion_sistemas_id = data.requisicion_sistemas_id;
            this.form.Partida[0].Cantidad = data.Cantidad;
            this.form.Partida[0].Unidad = data.Unidad;
            this.form.Partida[0].Hardware_id = data.hardware.id;
            this.chageDetalle();
            this.chageCreate();
        },

        update(data){
            data.Metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/RequisicionSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.editMode = false;
                    this.reset(),
                    this.chageCreate();
                    this.alertSucces();
                },
            });
        },
    },

    watch: {
    }
};
</script>
