<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fas fa-user tw-ml-3 tw-mr-3"></i>AUTORIZA COTIZACIONES SISTEMAS </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-2">
            <div class="tw-flex tw-gap-4 tw-mx-2">
                <div>
                    <jet-label class="tw-text-center">AÑO</jet-label>
                    <select class="InputSelect" v-model="params.Year">
                        <option value="0"> TODOS --</option>
                        <option value="2021"> 2021 --</option>
                        <option value="2022"> 2022 -- </option>
                    </select>
                </div>

                <div>
                    <jet-label class="tw-text-center">MES</jet-label>
                    <select class="InputSelect" v-model="params.Month">
                        <option value="0">TODOS</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
                </div>

                <div>
                    <jet-label class="tw-text-center">ESTATUS</jet-label>
                    <select class="InputSelect" v-model="params.Status" @change="SelectEmpresa">
                        <option value="0">TODOS</option>
                        <option value="4">PENDIENTES</option>
                        <option value="5">APROBADAS</option>
                    </select>
                </div>

                <div class="tw-mt-4">
                    <jet-button @click="Filtros" class="BtnFiltros"><i class="fas fa-filter tw-mr-1"></i>Aplica Filtros</jet-button>
                </div>
            </div>
            <div>
                <jet-button @click="openReportes" class="BtnNuevo">COSTOS</jet-button>
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
                    <th class="columna">ARTICULOS</th>
                    <th class="columna">COMENTARIOS</th>
                    <th class="columna">COSTO</th>
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
                                -{{art.Cantidad }} {{art.Unidad }} {{art.Dispositivo }}
                            </p>
                        </td>
                        <td>{{data.Comentarios}}</td>
                        <td>${{data.CostoReq}}</td>
                        <td>
                            <div class="FlexCenter">
                                <div v-if="data.Estatus == 0">
                                    <span tooltip="Cotizacion Rechazada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-rose-500 tw-rounded-full">RECHAZADA</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 4">
                                    <span tooltip="Cotizado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-500 tw-rounded-full">AUTORIZA</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 5">
                                    <span tooltip="Autorizado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-500 tw-rounded-full">APROBADA</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 6">
                                    <span tooltip="Material Adquirido" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blue-500 tw-rounded-full">STOCK</span>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center" >
                                <div class="iconoCyan" @click="VisualizaCotizacion(data)" v-if="data.Estatus > 2 || data.Estatus == 0">
                                    <span tooltip="Revisar Cotizacion" flow="left">
                                        <i class="fa-solid fa-credit-card"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
        </section>

        <!-- ***************************************** MODALES ****************************************************** -->
        <!-- ------- Modal para autorizar Cotizacion -------- -->
        <modal :show="showCotizacion" @close="chageCotizacion" maxWidth="3xl">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>SOLICITUD S-{{RequisicionSistemas.Folio}}</h3>
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
                        <th class="columna">COSTO TOTAL</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" >
                            <td class="tw-text-center">{{RequisicionSistemas.Fecha}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.perfil.Nombre}} {{RequisicionSistemas.perfil.ApPat}} {{RequisicionSistemas.perfil.ApMat}}</td>
                            <td class="tw-text-center">S-{{RequisicionSistemas.Folio}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.departamento.Nombre}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.Comentarios}}</td>
                            <td class="tw-text-center">${{RequisicionSistemas.CostoReq}}</td>
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
                                <th class="columna">COMENTARIOS</th>
                                <th class="columna">COSTO EXTRA</th>
                                <th class="columna">PROVEEDOR</th>
                                <th class="columna">AUTORIZADA</th>
                                <th class="columna">ARCHIVO</th>
                                <th class="columna">ACCIONES</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" >
                                    <td class="tw-text-center">{{data.TipoPago}}</td>
                                    <td class="tw-text-center">{{data.Moneda}}</td>
                                    <td class="tw-text-center">{{data.TipoCambio}}</td>
                                    <td class="tw-text-center">{{data.Comentario}}</td>
                                    <td class="tw-text-center">${{data.CostoExtra}}</td>
                                    <td class="tw-text-center">{{data.proveedor.Nombre}}</td>
                                    <td>
                                        <div class="FlexCenter">
                                            <div class="IconAproved"  v-if="data.Aprobado == 1">
                                                <span tooltip="APROBADO" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="IconDenied" v-else>
                                                <span tooltip="DENEGADO" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                                                </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="FlexCenter">
                                            <div class="iconoEdit">
                                                <a target="_blank" :href="path + data.Archivo" style="color:black;">
                                                    <i class="far fa-file-image"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tw-flex tw-justify-center tw-items-center" >
                                            <div class="iconoCyan" @click="AutorizaCotizacion(data)" >
                                                <span tooltip="Autoriza Cotizacion" flow="left">
                                                    <i class="fa-solid fa-check"></i>
                                                </span>
                                            </div>
                                            <div class="iconoCyan" @click="RechazaCotizacion(data)" >
                                                <span tooltip="Autoriza Cotizacion" flow="left">
                                                    <i class="fa-solid fa-ban"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </Table>

                        <Table>
                            <template v-slot:TableHeader>
                                <th class="columna">CANTIDAD</th>
                                <th class="columna">UNIDAD</th>
                                <th class="columna">DISPOSITIVO</th>
                                <th class="columna">MARCA</th>
                                <th class="columna">PRECIO</th>
                                <th class="columna">TOTAL</th>
                                <th class="columna">ACCIONES</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" v-for="pre in data.precios" :key="pre.id">
                                    <td class="tw-text-center">{{pre.articulos.Cantidad}}</td>
                                    <td class="tw-text-center">{{pre.articulos.Unidad}}</td>
                                    <td class="tw-text-center">{{pre.articulos.Dispositivo}}</td>
                                    <td class="tw-text-center">{{pre.Marca}}</td>
                                    <td class="tw-text-center">${{pre.Precio}}</td>
                                    <td class="tw-text-center">${{pre.Total}}</td>
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
                <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Total de requisición --</p>
                <span class="tw-text-center tw-font-bold"> {{ TotalRequisicion }} </span>
            </div>

            <div class="ModalFooter">
                <jet-CancelButton @click="chageCotizacion">Cerrar</jet-CancelButton>
            </div>
        </modal>
        <!-- --- Modal de costos ---- -->
        <modal :show="showReporte" @close="chageReporte" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>COSTOS REQUISICIONES SISTEMAS</h3>
            </div>

            <div class="ModalForm">
                <Table id="datos">
                    <template v-slot:TableHeader>
                        <th class="columna">HILATURAS</th>
                        <th class="columna">HILESA</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr>
                            <td>
                                <span class="tw-tracking-wider tw-text-white tw-bg-blue-500 tw-px-4 tw-py-1 tw-text-sm tw-rounded tw-leading-loose tw-mx-2 tw-font-semibold" title="">
                                    <i class="fa-solid fa-money-bill"></i> Costo Anual Hilaturas ${{ Costos.CostoAnualHLA }}
                                </span>
                            </td>
                            <td>
                                <span class="tw-tracking-wider tw-text-white tw-bg-blue-500 tw-px-4 tw-py-1 tw-text-sm tw-rounded tw-leading-loose tw-mx-2 tw-font-semibold" title="">
                                    <i class="fa-solid fa-money-bill"></i> Costo Anual Hilesa ${{ Costos.CostoAnualHilesa }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="tw-tracking-wider tw-text-white tw-bg-blue-500 tw-px-4 tw-py-1 tw-text-sm tw-rounded tw-leading-loose tw-mx-2 tw-font-semibold" title="">
                                    <i class="fa-solid fa-money-bill"></i> Costo del Mes Hilaturas ${{ Costos.CostoMensualHLA }}
                                </span>
                            </td>
                            <td>
                                <span class="tw-tracking-wider tw-text-white tw-bg-blue-500 tw-px-4 tw-py-1 tw-text-sm tw-rounded tw-leading-loose tw-mx-2 tw-font-semibold" title="">
                                    <i class="fa-solid fa-money-bill"></i> Costo del Mes Hilesa ${{ Costos.CostoMensualHilesa }}
                                </span>
                            </td>
                        </tr>
                    </template>
                </Table>
                <div id="chart" class="tw-m-10"></div>
            </div>

            <div class="ModalFooter">
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
import Table from "@/Components/TableSky500";
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
// Highcharts
var Highcharts = require('highcharts');
require('highcharts/modules/exporting')(Highcharts);
//Moment Js
import moment from 'moment';
import 'moment/locale/es';

export default {
    data() {
        return {
            now: moment().format("YYYY-MM-DD"),
            tam: "4xl",
            color: "tw-bg-sky-500",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showDetalle: false,
            showCotizacion: false,
            showReporte: false,
            showEdit: false,
            Estatus: 0,
            Costos:{
                CostoAnualHLA: 0,
                CostoMensualHLA: 0,
                CostoAnualHilesa: 0,
                CostoMensualHilesa: 0,
                HilesaAnual: 0,
                HilesaMensual: 0,
                HilaturaAnual: 0,
                HilaturaMensual: 0,
            },
            form: {
                IdUser: this.Session.id,
                TotalRequisicion: 0,
            },
            params: {
                Year: '',
                Month: '',
                Status: '',
                Req: '',
            }
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
        Departamentos: Object,
        RequisicionesSistemas: Object, //Consulta inicial
        RequisicionSistemas: Object, //Consulta detalle
        CostosHLA: Object,
        CostosHilesa: Object,
        CostoAñoHLA: Object,
        CostoAñoHilesa: Object,
    },

    mounted() {
        this.$nextTick(() => {
            this.tabla();
        });

        var query  = window.location.search.substring(1);
        var vars = query.split("&");
            for (var i=0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if(pair[0] == 'Year') {
                    this.params.Year = pair[1];
                }
                if(pair[0] == 'Month') {
                    this.params.Month = pair[1];
                }
                if(pair[0] == 'Status') {
                    this.params.Status = pair[1];
                }
        }

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
                TotalRequisicion: 0,
            };
        },

        Filtros(){
            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();

            this.$inertia.get('/Supply/AutorizaReqSistemas', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla();
                }, preserveState: true})
        },

        chageCotizacion(){
            this.showCotizacion  = !this.showCotizacion;
        },

        VisualizaCotizacion(data){
            let PreciosArticulos = 0;
            let CostoExtra = 0;
            let TotalRequisicion = 0;

            var query  = window.location.search.substring(1);
            var vars = query.split("&");
                for (var i=0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == 'Year') {
                        this.params.Year = pair[1];
                    }
                    if(pair[0] == 'Month') {
                        this.params.Month = pair[1];
                    }
                    if(pair[0] == 'Status') {
                        this.params.Status = pair[1];
                    }
                    if(pair[0] == 'Req') {
                        this.params.Req = pair[1];
                    }
            }
            this.params.Req = data.id;

            this.$inertia.get('/Supply/AutorizaReqSistemas', this.params, { //envio de variables por url
            onSuccess: () => {
                this.Estatus = this.RequisicionSistemas.Estatus;
                this.RequisicionSistemas.cotizacion.forEach(e => {
                    CostoExtra = parseFloat(e.CostoExtra);
                    e.precios.forEach(pre => {
                        pre.Total = pre.Total.replace(/,/g, "");
                        var PreciosArt = parseFloat(pre.Total);
                        PreciosArticulos = PreciosArticulos + PreciosArt;
                    });
                });
                TotalRequisicion = PreciosArticulos + CostoExtra;
                this.TotalRequisicion = new Intl.NumberFormat('es-MX', {style: 'currency',currency: 'MXN', minimumFractionDigits: 2}).format(TotalRequisicion);
                this.chageCotizacion();

            }, preserveState: true })
        },

        AutorizaCotizacion(data){
            data.Metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Supply/AutorizaReqSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.reset();
                    this.alertSucces();
                },
            });
        },

        RechazaCotizacion(data){
            data.Metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Supply/AutorizaReqSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.reset();
                    this.alertSucces();
                },
            });
        },

        chageReporte(){
            this.showReporte  = !this.showReporte;
        },

        openReportes(){
            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();

            this.chageReporte();
            this.$inertia.get('/Supply/AutorizaReqSistemas', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla();
                    this.Suma();
                }, preserveState: true})
        },

        GraficaCostos(){
            //variables internas
            Highcharts.chart('chart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Comparación de Costos'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name} {point.maq} {point.mate} {point.cat} {point.tr} {point.eq} {point.parti} {point.cl}</b>: {point.y} - {point.percentage:.1f}%'
                    }
                    }
                },
                series: [{
                    name: 'prpa',
                    colorByPoint: true,
                    data: [{
                        name: 'Hilaturas',
                        y: this.Costos.HilaturaMensual,
                        sliced: true,
                        selected: true
                    },{
                        name: 'Hilesa',
                        y: this.Costos.HilesaMensual
                    }]
                }]
            });
        },

        Suma() {
            var Costo1 = 0;
            this.CostosHLA.forEach(e => {
                Costo1 = e.CostoReq.replace(/,/g, "");
                var CostosRequi = parseFloat(Costo1);
                this.Costos.HilaturaMensual = this.Costos.HilaturaMensual + CostosRequi;
            });
            this.Costos.CostoMensualHLA = this.MonedaMexico(this.Costos.HilaturaMensual);

            var Costo2 = 0;
            this.CostosHilesa.forEach(e => {
                Costo2 = e.CostoReq.replace(/,/g, "");
                var CostosRequi = parseFloat(Costo2);
                this.Costos.HilesaMensual = this.Costos.HilesaMensual + CostosRequi;
            });
            this.Costos.CostoMensualHilesa = this.MonedaMexico(this.Costos.HilesaMensual);

            var CostoAnio1 = 0;
            this.CostoAñoHLA.forEach(e => {
                CostoAnio1 = e.CostoReq.replace(/,/g, "");
                var CostosRequi = parseFloat(CostoAnio1);
                this.Costos.HilaturaAnual = this.Costos.HilaturaAnual + CostosRequi;
            });
            this.Costos.CostoAnualHLA = this.MonedaMexico(this.Costos.HilaturaAnual);

            var CostoAnio2 = 0;
            this.CostoAñoHilesa.forEach(e => {
                CostoAnio2 = e.CostoReq.replace(/,/g, "");
                var CostosRequi = parseFloat(CostoAnio2);
                this.Costos.HilesaAnual = this.Costos.HilesaAnual + CostosRequi;
            });
            this.Costos.CostoAnualHilesa = this.MonedaMexico(this.Costos.HilesaAnual);

            if(this.Costos.Hilesa != '' && this.Costos.Hilatura != ''){
                this.GraficaCostos();
            }
        },
    },

    computed:{

    },

    watch: {
    },
};
</script>
