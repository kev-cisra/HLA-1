<template>
    <app-layout>
        <!-- ****************************************** TITULO ********************************************* -->
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fa-solid fa-dollar-sign tw-ml-3 tw-mr-3"></i>COSTOS REQUISICIONES</h3>
                </slot>
            </Header>
        </section>

        <!-- ********************************************* FILTROS ************************************************* -->
        <section class="tw-my-4 tw-mx-4 lg:tw-flex lg:tw-gap-4 lg:tw-content-center lg:tw-border lg:tw-p-2 lg:tw-mb-4">
            <div class="lg:tw-flex lg:tw-gap-4">
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
                    <jet-label class="tw-text-center">Departamento</jet-label>
                    <select class="InputSelect" v-model="params.Dpto">
                        <option v-for="Dpto in Departamentos" :key="Dpto.id" :value="Dpto.id"> {{ Dpto.Nombre }}</option>
                    </select>
                </div>
            </div>
            <div class="lg:tw-mt-4">
                <jet-button v-if="loading == true" @click="Filtros" class="BtnFiltros">
                    <span class="tw-animate-ping tw-relative tw-inline-flex tw-rounded-full tw-h-2 tw-w-2 tw-mr-2 tw-bg-coolGray-100"></span>
                    <p class="tw-animate-pulse">Cargando </p>
                </jet-button>
                <jet-button v-else @click="Filtros" class="BtnFiltros"> <i class="fas fa-filter tw-mr-1"></i> Aplica Filtros
                </jet-button>
            </div>
        </section>
        <!-- ****************************************** TABLAS ********************************************* -->
        <section class="tw-mx-4 tw-my-4">
            <Table id="Precios">
                <template v-slot:TableHeader>
                    <th class="columna">Fecha</th>
                    <th class="columna">NumReq</th>
                    <th class="columna">O.C</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Maquina</th>
                    <th class="columna">Cantidad</th>
                    <th class="columna">Unidad</th>
                    <th class="columna">Descripcion</th>
                    <th class="columna">Precio</th>
                    <th class="columna">Total</th>
                    <th class="columna">Moneda</th>
                    <th class="columna">Proveedor</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="datos in PreciosRequisiciones" :key="datos.id">
                        <td class="tw-text-center">{{ datos.precios_articulo.articulos_requisicion.Fecha }}</td>
                        <td class="tw-text-center">{{ datos.precios_articulo.articulos_requisicion.NumReq }}</td>
                        <td class="tw-text-center">{{ datos.precios_articulo.articulos_requisicion.OrdenCompra }}</td>
                        <td>{{ datos.precios_articulo.articulos_requisicion.requisicion_departamento.Nombre }}</td>
                        <td>{{ datos.precios_articulo.articulos_requisicion.requisicion_maquina.Nombre }}</td>
                        <td class="tw-text-center">{{ datos.precios_articulo.Cantidad }}</td>
                        <td class="tw-text-center">{{ datos.precios_articulo.Unidad }}</td>
                        <td>{{ datos.precios_articulo.Descripcion }}</td>
                        <td class="tw-text-center">{{ datos.Precio }}</td>
                        <td class="tw-text-center">{{ datos.Total }}</td>
                        <td class="tw-text-center">{{ datos.Moneda }}</td>
                        <td class="tw-text-center" >
                            <div v-if="datos.precio_proveedor.Nombre != ''">{{ datos.precio_proveedor.Nombre }}</div>
                            <div v-else>SIN PROVEEDOR</div></td>
                    </tr>
                </template>
            </Table>
        </section>
    </app-layout>
</template>

<script>

/* --------- Imports Librerias para Datatables ------------- */
require( 'datatables.net-buttons-bs5/js/buttons.bootstrap5' );
require( 'datatables.net-buttons/js/buttons.html5' );
require ( 'datatables.net-buttons/js/buttons.colVis' );

/* -------------- Import de Datatables ---------------- */
import print from 'datatables.net-buttons/js/buttons.print';
import pdfFonts from 'pdfmake/build/vfs_fonts';
import pdfMake from 'pdfmake/build/pdfmake';
import jszip from 'jszip/dist/jszip';
import datatable from 'datatables.net-bs5';
pdfMake.vfs = pdfFonts.pdfMake.vfs;
window.JSZip = jszip

/*  ------- Moment Js ------------ */
import moment from 'moment';
import 'moment/locale/es';
import throttle from 'lodash/throttle'
/* ------- Imports -------- */
import $ from 'jquery';
import axios from 'axios';
/* ----- Componentes de Inertia ------ */
import AppLayout from "@/Layouts/AppLayout";
import NProgress from 'nprogress';
import { Inertia } from '@inertiajs/inertia';
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableViolet";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetLabel from '@/Jetstream/Label';
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";

export default {
    data() {
        return {
            tam: "4xl",
            color: "tw-bg-violet-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            loading: false,
            params: {
                Year: moment().format("YYYY"),
                Month: moment().format("M"),
                Dpto: 0,
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
        errors: Object,
        Departamentos: Object,
        PreciosRequisiciones: Object,
    },

    mounted() {
        this.tabla();

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
                if(pair[0] == 'Dpto') {
                    this.params.Dpto = pair[1];
                }
        }
    },

    methods: {
        tabla(){ //Generacion de tabla con Datatables
            this.$nextTick(() => {
                $("#Precios").DataTable({
                    destroy: true,
                    stateSave: true,
                    language: this.español,
                    paging: true,
                    pageLength : 20,
                    bInfo: false,
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

        Filtros(){
            console.log(this.params);
            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();
            this.$inertia.get('/Contabilidad/CostosRequisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                console.log(this.params);
                }, preserveState: true})
        },

    },

    computed:{
        Departamento: function () {
            const Areas = []; //Declaracion del nuevo arreglo
                this.Departamentos.forEach(element => {
                    element.sub__departamentos.forEach( el => {
                        Areas.push(el)
                    })
                });
            return Areas;
        },

    }
};
</script>
