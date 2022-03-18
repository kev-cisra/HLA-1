<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fas fa-user tw-ml-3 tw-mr-3"></i> COTIZACIONES SISTEMAS </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-8">
            <div class="tw-flex tw-gap-4 tw-mx-2">
            </div>
            <div>
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
                    <tr class="fila" v-for="data in RequisicionesSistemas" :key="data.id">
                        <td>{{data.Fecha}}</td>
                        <td>{{data.Folio}}</td>
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
                            <div class="tw-flex tw-justify-center tw-items-center" >
                                <div class="iconoPurple" @click="CotizarReq(data)" v-if="data.Estatus == 1">
                                    <span tooltip="Realizar Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                                <div class="iconoGreen" @click="ConfirmaMaterial(data)" v-if="data.Estatus == 1 || data.Estatus == 4">
                                    <span tooltip="Confirma Material" flow="left">
                                        <i class="fa-solid fa-box-open"></i>
                                    </span>
                                </div>
                                <div class="iconoTeal" @click="ConfirmaCotizacion(data)" v-else-if="data.Estatus == 2 || data.Estatus == 10">
                                    <span tooltip="Confirma Cotizacion" flow="left">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </span>
                                </div>
                                <div class="iconoCyan" @click="VisualizaCotizacion(data)" v-if="data.Estatus > 1">
                                    <span tooltip="Realizar Cotizacion" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
        </section>

        <!-- ***************************************** MODALES ****************************************************** -->
        <!-- --------------------- Modal Cotizacion -------------------------- -->
        <modal :show="showDetalle" @close="chageDetalle" maxWidth="3xl">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>REQUISICIÓN RSIS-0{{form.Folio}}</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>MONEDA</jet-label>
                        <select class="InputSelect" v-model="form.Moneda">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="form.Moneda == 'USD' || form.Moneda == 'EUR'">
                        <jet-label><span class="required">*</span>TIPO CAMBIO</jet-label>
                        <jet-input type="text"  v-model="form.TipoCambio"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>TIPO PAGO</jet-label>
                        <select class="InputSelect" v-model="form.TipoPago">
                            <option value="REM">REMISIÓN</option>
                            <option value="FAC">FACTURADO</option>
                        </select>
                    </div>
                </div>
                <Table id="Articulos">
                    <template v-slot:TableHeader>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">EQUIPO</th>
                        <th class="columna">PRECIO</th>
                        <th class="columna">MARCA EQUIPO</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="match in form.DatosCotizacion" :key="match">
                            <td class="tw-text-center">{{match.Cantidad}}</td>
                            <td class="tw-text-center">{{match.Unidad}}</td>
                            <td class="tw-text-center">{{match.Hardware_id}} </td>
                            <td>
                                <input type="number" min="1" class="InputDinamico" v-model="match.PrecioUnitario">
                            </td>
                            <td>
                                <input type="text" class="InputDinamico" v-model="match.Marca" @input="(val) => (form.Comentario = form.Comentario.toUpperCase())">
                            </td>
                        </tr>
                    </template>
                </Table>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>COMENTARIOS</jet-label>
                        <textarea name="" id="" cols="2" v-model="form.Comentario" @input="(val) => (form.Comentario = form.Comentario.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label>ARCHIVO</jet-label>
                        <div class='tw-flex tw-items-center tw-justify-center tw-w-full'>
                            <label class='tw-flex tw-flex-col tw-border-4 tw-border-dashed tw-w-full tw-h-24 hover:tw-bg-gray-100 hover:tw-border-indigo-300 tw-group'>
                                <div class='tw-flex tw-flex-col tw-items-center tw-justify-center tw-pt-4'>
                                    <svg class="tw-w-8 tw-h-8 tw-text-indigo-400 group-hover:tw-text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class='tw-lowercase tw-text-sm tw-text-gray-400 group-hover:tw-text-indigo-600 tw-mt-2 tw-tracking-wider' v-if="form.archivo == null">Seleccion un Archivo</p>
                                    <span class="tw-mt-2 tw-text-xxs tw-text-teal-500 tw-font-bold" v-if="form.archivo != null">{{  form.archivo.name }}</span>
                                </div>
                            <input type='file' class="tw-hidden" @input="form.archivo = $event.target.files[0]"/>
                            </label>
                        </div>
                        <div v-if="form.archivo != null">
                            <!-- <iframe :src="path + form.archivo" title="description" ></iframe> -->
                            <span class="tw-text-green-600">{{form.archivo}}</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="RealizaCotizacion(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
                <jet-button type="button" @click="EditaCotizacion(form)" v-show="editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualizar</jet-button>
                <jet-CancelButton @click="chageDetalle">Cerrar</jet-CancelButton>
            </div>
        </modal>

        <modal :show="showCotizacion" @close="chageCotizacion" maxWidth="3xl">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Cotización SIS-0{{RequisicionSistemas.Folio}}</h3>
            </div>

            <div class="ModalForm">
                <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Requisición --</p>
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna">SOLICITANTE</th>
                        <th class="columna">FOLIO</th>
                        <th class="columna">DEPARTAMENTO</th>
                        <th class="columna">COMENTARIOS</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" >
                            <td class="tw-text-center">{{RequisicionSistemas.Fecha}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.perfil.Nombre}} {{RequisicionSistemas.perfil.ApPat}} {{RequisicionSistemas.perfil.ApMat}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.Folio}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.departamento.Nombre}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.Comentarios}}</td>
                        </tr>
                    </template>
                </Table>
                <div v-for="data in RequisicionSistemas.cotizacion" :key="data.id">
                    <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Cotización --</p>
                    <div :class="{ 'tw-p-2 tw-border-4 tw-border-teal-700 tw-bg-teal-600': data.Aprobado == 1}">
                        <Table>
                            <template v-slot:TableHeader>
                                <th class="columna">TIPO PAGO</th>
                                <th class="columna">MONEDA</th>
                                <th class="columna">TIPO CAMBIO</th>
                                <th class="columna">APROVADO</th>
                                <th class="columna">COMENTARIOS</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" >
                                    <td class="tw-text-center">{{data.TipoPago}}</td>
                                    <td class="tw-text-center">{{data.Moneda}}</td>
                                    <td class="tw-text-center">{{data.TipoCambio}}</td>
                                    <td>
                                        <div class="FlexCenter">
                                            <div class="IconAproved"  v-if="data.Aprobado == 1">
                                                <span tooltip="APROBADO" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="IconDenied" v-else>
                                                <span tooltip="DENEGADO" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                                                </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="tw-text-center">{{data.Comentario}}</td>
                                </tr>
                            </template>
                        </Table>

                        <Table>
                            <template v-slot:TableHeader>
                                <th class="columna">MARCA</th>
                                <th class="columna">PRECIO</th>
                                <th class="columna">TOTAL</th>
                                <th class="columna">ACCIONES</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" v-for="pre in data.precios" :key="pre.id">
                                    <td class="tw-text-center">{{pre.Marca}}</td>
                                    <td class="tw-text-center">{{pre.Precio}}</td>
                                    <td class="tw-text-center">{{pre.Total}}</td>
                                    <td>
                                        <div class="FlexCenter">
                                            <div class="iconoEdit" @click="edit(data)" v-if="Estatus == 2 || Estatus == 10">
                                                <span tooltip="Editar" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="IconProcess" v-if="Estatus >= 3 && Estatus < 10">
                                                <span tooltip="En proceso ..." flow="left">
                                                    <i class="fa-solid fa-spinner"></i>
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

            <div class="ModalFooter">
                <jet-CancelButton @click="chageCotizacion">Cerrar</jet-CancelButton>
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
            showDetalle: false,
            showCotizacion: false,
            showEdit: false,
            Estatus: 0,
            form: {
                IdUser: this.Session.id,
                requisicion_sistemas_id: '',
                Cotizacion_id: '',
                Folio: '',
                Fecha: '',
                Departamento_id: '',
                Estatus: '',
                Moneda: '',
                TipoCambio: 1,
                TipoPago: '',
                Comentario: '',
                archivo: '',
                DatosCotizacion: [], //Arreglo vacio que contendra inputs dinamicos
            },
        };
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
        RequisicionesSistemas: Object, //Consulta inicial
        RequisicionSistemas: Object, //Requisicion con Cotizacion
    },

    mounted() {
        this.tabla();
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
                requisicion_sistemas_id: '',
                Cotizacion_id: '',
                Folio: '',
                Fecha: '',
                Departamento_id: '',
                Estatus: '',
                Moneda: '',
                TipoCambio: 1,
                TipoPago: '',
                Comentario: '',
                archivo: '',
                DatosCotizacion: [],
            };
        },

        chageDetalle(){
            this.showDetalle  = !this.showDetalle;
        },

        CotizarReq(data){
            this.reset();
            this.chageDetalle();
            this.form.requisicion_sistemas_id = data.id;
            this.form.Folio = data.Folio;
            this.form.Fecha = data.Fecha;
            this.form.Departamento_id = data.Departamento_id;
            this.ArticulosReq = data.articulos;
            this.form.Estatus = data.Estatus;
            // ----- Genracion de inputs dinamicos -----------
            this.form.DatosCotizacion = []; //Vacio arreglo de inputs
            data.articulos.forEach(Art => { //Generacion de inputs apartir del objeto a recorrer
                this.form.DatosCotizacion.push({ //Añado mas campos a visualizar
                    id: Art.id,
                    Cantidad: Art.Cantidad,
                    Unidad: Art.Unidad,
                    Hardware_id: Art.hardware.Nombre,
                    PrecioUnitario: null,
                    Marca: null,
                })
            })
        },

        RealizaCotizacion(data){
            this.$inertia.post("/Sistemas/CotizacionSistemas", data, {
                onSuccess: () => {
                    if(this.$attrs.jetstream.flash.type == 'Warning'){
                        this.alertInfo(this.$attrs.jetstream.flash.message);
                    }else{
                        this.alertSucces();
                        this.reset();
                        this.chageDetalle();
                    }
                },
            });
        },

        ConfirmaCotizacion(data){ //Envia la cotizacion para autorizacion
            data.Metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/CotizacionSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.reset();
                    this.alertSucces();
                },
            });
        },

        ConfirmaMaterial(data){ //Confirma que existe el material
            data.Metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/CotizacionSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.reset();
                    this.alertSucces();
                },
            });
        },

        chageCotizacion(){
            this.showCotizacion  = !this.showCotizacion;
        },

        VisualizaCotizacion(data){
                this.$inertia.get('/Sistemas/CotizacionSistemas', { Req: data.id }, { //envio de variables por url
                onSuccess: () => {
                    this.chageCotizacion();
                    this.Estatus = this.RequisicionSistemas.Estatus;
            }, preserveState: true })
        },

        edit(data){
            this.chageCotizacion();
            this.chageDetalle();
            this.editMode = true;
            this.form.Cotizacion_id = data.id;
            this.form.Moneda = data.Moneda;
            this.form.TipoPago = data.TipoPago;
            this.form.TipoCambio = data.TipoCambio;
            this.form.Comentario = data.Comentario;

            this.form.DatosCotizacion = []; //Vacio arreglo de inputs
            data.precios.forEach(Pre => { //Generacion de inputs apartir del objeto a recorrer
                this.form.DatosCotizacion.push({ //Añado mas campos a visualizar
                    Cot_id: Pre.id,
                    id: Pre.id,
                    Marca: Pre.Marca,
                    PrecioUnitario: Pre.Precio,
                    Cantidad: Pre.articulos.Cantidad,
                    Unidad: Pre.articulos.Unidad,
                    Hardware_id: Pre.articulos.hardware.Nombre,
                })
            })
        },

        EditaCotizacion(data){
            data.Metodo = 3;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/CotizacionSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.editMode = false;
                    this.chageDetalle();
                    this.reset();
                    this.alertSucces();
                },
            });
        },

    },

    computed:{
    },

    watch: {
    },
};
</script>
