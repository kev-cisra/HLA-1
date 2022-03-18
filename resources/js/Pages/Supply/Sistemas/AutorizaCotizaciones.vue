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
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-8">
            <div class="tw-flex tw-gap-4 tw-mx-2">
            </div>
            <div>
            </div>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->
        <section class="tw-mx-8">
            <Table id="datos">
                <template v-slot:TableHeader>
                    <th class="columna">FECHA</th>
                    <th class="columna">FOLIO</th>
                    <th class="columna">SOLICITANTE</th>
                    <th class="columna">DEPARTAMENTO</th>
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
                            <div class="FlexCenter">
                                <div v-if="data.Estatus == 3">
                                    <span tooltip="Cotizado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-500 tw-rounded-full">AUTORIZA</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 4">
                                    <span tooltip="Autorizado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-500 tw-rounded-full">APROBADA</span>
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
                                <div class="iconoCyan" @click="VisualizaCotizacion(data)" v-if="data.Estatus > 1">
                                    <span tooltip="Realizar Cotizacion" flow="left">
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
                                <th class="columna">COMENTARIOS</th>
                                <th class="columna">AUTORIZADA</th>
                                <th class="columna">ACCIONES</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" >
                                    <td class="tw-text-center">{{data.TipoPago}}</td>
                                    <td class="tw-text-center">{{data.Moneda}}</td>
                                    <td class="tw-text-center">{{data.TipoCambio}}</td>
                                    <td class="tw-text-center">{{data.Comentario}}</td>
                                    <td class="FlexCenter">
                                        <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
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
                                <th class="columna">MARCA</th>
                                <th class="columna">PRECIO</th>
                                <th class="columna">TOTAL</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" v-for="pre in data.precios" :key="pre.id">
                                    <td class="tw-text-center">{{pre.Marca}}</td>
                                    <td class="tw-text-center">{{pre.Precio}}</td>
                                    <td class="tw-text-center">{{pre.Total}}</td>
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
            showEdit: false,
            Estatus: 0,
            form: {
                IdUser: this.Session.id,
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
        RequisicionesSistemas: Object, //Consulta inicial
        RequisicionSistemas: Object, //Requisicion con Cotizacion
    },

    methods: {
        //Datatables
        tabla() {
        },

        reset() {
            this.form = {
                IdUser: this.Session.id,
            };
        },

        chageCotizacion(){
            this.showCotizacion  = !this.showCotizacion;
        },

        VisualizaCotizacion(data){
                this.$inertia.get('/Supply/AutorizaReqSistemas', { Req: data.id }, { //envio de variables por url
                onSuccess: () => {
                    this.chageCotizacion();
                    this.Estatus = this.RequisicionSistemas.Estatus;
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
    },

    computed:{
    },

    watch: {
    },
};
</script>
