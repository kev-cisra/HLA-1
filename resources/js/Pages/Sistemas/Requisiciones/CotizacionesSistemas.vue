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
                        <td class="FlexCenter">
                            <div v-if="data.Estatus == 0">
                                <span tooltip="Confirmar Solicitud de Papeleria" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blueGray-400 tw-rounded-full">SOLICITADO</span>
                                </span>
                            </div>
                            <div v-if="data.Estatus == 1">
                                <span tooltip="Solicitado" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-emerald-500 tw-rounded-full">EN COMPRA</span>
                                </span>
                            </div>
                            <div v-if="data.Estatus == 2">
                                <span tooltip="Cotizado" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-500 tw-rounded-full">COTIZADO</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4" v-if="data.Estatus == 1">
                                <div class="iconoPurple" @click="CotizarReq(data)">
                                    <span tooltip="Realizar Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4" v-else-if="data.Estatus == 2">
                                <div class="iconoCyan" @click="VisualizaCotizacion(data)">
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
                        <span v-if="form.ImagenServidor != null">{{form.archivo}}</span>
                        <!-- <small v-if="errors.archivo" class="validation-alert">{{errors.archivo}}</small> -->
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="RealizaCotizacion(form)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
                <jet-CancelButton @click="chageDetalle">Cerrar</jet-CancelButton>
            </div>
        </modal>

        <modal :show="showCotizacion" @close="chageCotizacion" maxWidth="3xl">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Cotización SIS-0{{RequisicionSistemas.Folio}}</h3>
            </div>

            <div class="ModalForm">
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
                                <td class="tw-text-center">{{data.Aprobado}}</td>
                                <td class="tw-text-center">{{data.Comentario}}</td>
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

            <div class="ModalFooter">
                <jet-button type="button" @click="RealizaCotizacion(form)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
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
            form: {
                IdUser: this.Session.id,
                requisicion_sistemas_id: '',
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
                requisicion_sistemas_id: '',
                Folio: '',
                Fecha: '',
                Departamento_id: '',
                Estatus: '',
                Moneda: '',
                TipoCambio: 0,
                TipoPago: '',
                Comentario: '',
                archivo: '',
                DatosCotizacion: [],
            };
        },

        chageCreate(){
            this.showCreate = !this.showCreate;
        },

        chageDetalle(){
            this.showDetalle  = !this.showDetalle;
        },

        CotizarReq(data){
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

        chageCotizacion(){
            this.showCotizacion  = !this.showCotizacion;
        },

        VisualizaCotizacion(data){
                this.$inertia.get('/Sistemas/CotizacionSistemas', { Req: data.id }, { //envio de variables por url
                onSuccess: () => {
                    this.chageCotizacion();
                    console.log(this.RequisicionSistemas);
                    console.log(this.RequisicionSistemas.cotizacion);
                    this.RequisicionSistemas;
            }, preserveState: true })
        },

    },

    computed:{
        Cotizacion: function () {
            const Cotizacion = []; //Declaracion d enuevo arreglo

            this.RequisicionSistemas.cotizacion.forEach(cotizacion => {
                Cotizacion.push(cotizacion.TipoPago)
            });

            return Cotizacion;
        }
    },

    watch: {
    },
};
</script>
