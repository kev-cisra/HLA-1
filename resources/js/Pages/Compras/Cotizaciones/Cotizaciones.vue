<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                        Requisiciones Solicitadas
                </h3>
            </slot>
        </Header>

        <div class="tw-flex tw-items-center tw-justify-center tw-mt-4">
            <div class="tw-w-full tw-mx-auto tw-max-w-7xl sm:tw-px-8 lg:tw-px-10">
                <div class="tw-flex tw-flex-col tw-w-full tw-mb-2 tw-space-y-8 lg:tw-flex-row lg:tw-space-x-10 lg:tw-space-y-0 lg:tw-mb-4">

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="Filtro(1)">
                        <div class="tw-w-full tw-p-4 tw-bg-white tw-border-l-4 tw-border-green-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-14 tw-p-3.5 tw-bg-green-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg">{{Almacen}}</div>
                                    <div class="tw-text-xs tw-text-gray-400">Artículos pendientes por Entregar</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4">
                        <div class="tw-w-full tw-p-4 tw-bg-white tw-border-l-4 tw-border-indigo-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-14 tw-p-3.5 tw-bg-indigo-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Cotizacion }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Articulos Pendientes Por cotizar</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4">
                        <div class="tw-w-full tw-p-4 tw-bg-white tw-border-l-4 tw-border-indigo-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-14 tw-p-3.5 tw-bg-indigo-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Autorizados }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por revisar</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="tw-overflow-auto">
            <div class="tw-shadow-full tw-row tw-justify-content-center">
                <div class="tw-flex tw-items-center tw-mt-2 tw-text-center tw-text-white tw-border tw-shadow-xl">
                    <div class="tw-m-3" @click="FiltroMes(1)">
                        <button class="EneroActivo" v-if="mes == 1">
                            <span class="mx-auto">Enero</span>
                        </button>
                        <button class="Enero" v-else>
                            <span class="mx-auto">Enero</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(2)">
                        <button class="FebreroActivo" v-if="mes == 2">
                            <span class="mx-auto">Febrero</span>
                        </button>
                        <button class="Febrero" v-else>
                            <span class="mx-auto">Febrero</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(3)">
                        <button class="MarzoActivo" v-if="mes == 3">
                            <span class="mx-auto">Marzo</span>
                        </button>
                        <button class="Marzo" v-else>
                            <span class="mx-auto">Marzo</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(4)">
                        <button class="AbrilActivo" v-if="mes == 4">
                            <span class="mx-auto">Abril</span>
                        </button>
                        <button class="Abril" v-else>
                            <span class="mx-auto">Abril</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(5)">
                        <button class="MayoActivo" v-if="mes == 5">
                            <span class="mx-auto">Mayo</span>
                        </button>
                        <button class="Mayo" v-else>
                            <span class="mx-auto">Mayo</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(6)">
                        <button class="JunioActivo" v-if="mes == 6">
                            <span class="mx-auto">Junio</span>
                        </button>
                        <button class="Junio" v-else>
                            <span class="mx-auto">Junio</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(7)">
                        <button class="JulioActivo" v-if="mes == 7">
                            <span class="mx-auto">Julio</span>
                        </button>
                        <button class="Julio" v-else>
                            <span class="mx-auto">Julio</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(8)">
                        <button class="AgostoActivo" v-if="mes == 8">
                            <span class="mx-auto">Agosto</span>
                        </button>
                        <button class="Agosto" v-else>
                            <span class="mx-auto">Agosto</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(9)">
                        <button class="SeptiembreActivo" v-if="mes == 9">
                            <span class="mx-auto">Septiembre</span>
                        </button>
                        <button class="Septiembre" v-else>
                            <span class="mx-auto">Septiembre</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(10)">
                        <button class="OctubreActivo" v-if="mes == 10">
                            <span class="mx-auto">Octubre</span>
                        </button>
                        <button class="Octubre" v-else>
                            <span class="mx-auto">Octubre</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(11)">
                        <button class="NoviembreActivo" v-if="mes == 11">
                            <span class="mx-auto">Noviembre</span>
                        </button>
                        <button class="Noviembre" v-else>
                            <span class="mx-auto">Noviembre</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(12)">
                        <button class="DiciembreActivo" v-if="mes == 12">
                            <span class="mx-auto">Diciembre</span>
                        </button>
                        <button class="Diciembre" v-else>
                            <span class="mx-auto">Diciembre</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-between tw-px-4">
                <div class="tw-flex tw-flex-wrap tw-content-center">
                    <select class="InputSelect" v-model="params.Estatus">
                            <option value="">QUITA FILTRO</option>
                            <option value="1">SIN ENVIAR</option>
                            <option value="EN ALMACEN">EN ALMACEN</option>
                            <option value="3">EN COTIZACION</option>
                            <option value="2">SOLICITADO</option>
                            <option value="EN AUTORIZACION">EN AUTORIZACION</option>
                            <option value="ENTREGADO">ENTREGADO</option>
                    </select>
                </div>
                <div>

                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
                <Table id="Articulos">
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna"># REQUISICIÓN</th>
                        <th class="columna">CÓDIGO</th>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">DESCRIPCIÓN</th>
                        <th class="columna">MAQUINA</th>
                        <th class="columna">MARCA</th>
                        <th class="columna">ESTATUS</th>
                        <th class="columna">FECHA LLEGADA</th>
                        <th class="columna">ACCIONES</th>
                        <th class="columna">DETALLES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in ArticuloRequisicion" :key="datos.id">
                            <td class="tw-p-2">{{ datos.Fecha }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.NumReq }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.Codigo }}</td>
                            <td class="tw-p-2">{{ datos.Cantidad }}</td>
                            <td class="tw-p-2">{{ datos.Unidad }}</td>
                            <td class="tw-p-2">{{ datos.Descripcion }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.requisicion_maquina.Nombre }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.requisicion_marca.Nombre }}</td>
                            <td class="tw-p-2">
                                <div v-if="datos.EstatusArt == 3">
                                    <span tooltip="Articulo en espera de cotización" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-indigo-500 tw-rounded-full">COTIZAR</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 4">
                                    <span tooltip="COTIZAR MATERIAL SOLICITADO" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">AUTORIZADA</span>
                                    </span>
                                </div>
                            </td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.Fecha }}</td>
                            <td class="fila">
                                <div class="columnaIconos" v-if="datos.EstatusArt == 3">
                                    <div class="iconoPurple" @click="Cotizar(datos, 4)">
                                        <span tooltip="Realizar Cotizacion" flow="left">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </span>
                                    </div>
                                    <div class="iconoEdit" @click="ConfirmaCotizacion(datos)">
                                        <span tooltip="Enviar Cotizacion a Autorización" flow="left">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else>
                                    <div class="tw-w-4 tw-mr-2 tw-transform tw-cursor-pointer hover:tw-text-green-500 hover:tw-scale-125">
                                        <span tooltip="En proceso" flow="left">
                                            <i class="fas fa-thumbs-up"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="tw-p-2">
                                <div class="tw-flex tw-justify-center">
                                    <div class="iconoDetails" v-if="detalles != datos.id" @click="show(datos.id)">
                                        <span tooltip="Detalles" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div v-if="detalles == datos.id" class="tw-w-80">
                                        <div class="border-b">
                                            <h2 class="tw-text-sm tw-text-center">Requisición <strong>#{{datos.articulos_requisicion.NumReq}}</strong> </h2>
                                        </div>
                                        <div>
                                            <div class="tw-text-xs tw-border-b md:tw-grid md:tw-grid-cols-2 hover:tw-bg-gray-50">
                                                <p class="tw-text-gray-600">FOLIO: </p>
                                                <p class="tw-font-semibold">{{datos.articulos_requisicion.Folio}}</p>
                                            </div>
                                            <div class="tw-text-xs tw-border-b md:tw-grid md:tw-grid-cols-2 hover:tw-bg-gray-50">
                                                <p class="tw-text-gray-600">SOLICITANTE: </p>
                                                <p class="tw-font-semibold">{{datos.articulos_requisicion.requisiciones_perfil.Nombre}} {{datos.articulos_requisicion.requisiciones_perfil.ApPat}} {{datos.articulos_requisicion.requisiciones_perfil.ApMat}}</p>
                                            </div>
                                            <div class="tw-text-xs tw-border-b md:tw-grid md:tw-grid-cols-2 hover:tw-bg-gray-50">
                                                <p class="tw-text-gray-600">OBSERVACIONES</p>
                                                <p class="tw-font-semibold">{{datos.articulos_requisicion.Observaciones}}</p>
                                            </div>
                                            <div class="tw-flex tw-justify-center">
                                                <div @click="hidden()" class="tw-w-4 tw-mr-2 tw-transform tw-cursor-pointer hover:tw-text-red-500 hover:tw-scale-125">
                                                    <i class="fas fa-window-close"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>

        </div>
    </div>

    <modal :show="showModal" @close="chageClose" :maxWidth="tam">

        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Realiza Cotización</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div>
                            <jet-label>Número de Requisición</jet-label>
                            <input type="text" class="InfoData" v-model="form.NumReq" disabled/>

                            <jet-label>Folio</jet-label>
                            <input type="text" class="InfoData" v-model="form.Folio" disabled/>

                            <jet-label>Departamento</jet-label>
                            <input type="text" class="InfoData" v-model="form.Area" disabled/>

                            <jet-label>Nombre Solicitante</jet-label>
                            <input type="text" class="InfoData" v-model="form.Nombre" disabled/>

                            <jet-label>Observaciones</jet-label>
                            <input type="text" class="InfoData" v-model="form.Observaciones" disabled/>

                            <jet-label>Cantidad</jet-label>
                            <input type="text" class="InfoData" v-model="form.Cantidad" disabled/>

                            <jet-label>Unidad</jet-label>
                            <input type="text" class="InfoData" v-model="form.Unidad" disabled/>

                            <jet-label>Descripción</jet-label>
                            <input type="text" class="InfoData" v-model="form.Descripcion" disabled/>
                    </div>

                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>PRECIO UNITARIO</jet-label>
                                <jet-input type="text" v-model="form.Precio"></jet-input>
                                <!-- <small v-if="errors.variable" class="validation-alert">{{errors.variable}}</small> -->
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>MARCA</jet-label>
                                <jet-input type="text" v-model="form.Marca"></jet-input>
                                <!-- <small v-if="errors.variable" class="validation-alert">{{errors.variable}}</small> -->
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>PROVEEDOR</jet-label>
                                <select id="Jefe" v-model="form.Proveedor"  class="InputSelect">
                                    <option v-for="select in Proveedores" :key="select.id" :value="select.id" >{{ select.Nombre }}</option>
                                </select>
                                <!-- <small v-if="errors.variable" class="validation-alert" >{{ errors.variable }}</small> -->
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label>ARCHIVO</jet-label>
                                <label class="tw-flex tw-flex-col tw-items-center tw-w-48 tw-w-full tw-p-2 tw-font-bold tw-tracking-wide tw-text-center tw-text-gray-600 tw-uppercase tw-bg-gray-100 tw-border tw-rounded-lg tw-cursor-pointer">
                                    <svg class="tw-w-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                    </svg>
                                    <span class="tw-mt-2 tw-text-xs">Selecciona un Archivo</span>
                                    <input type='file' class="tw-hidden" @input="form.archivo = $event.target.files[0]"/>
                                </label>
                                <!-- <small v-if="errors.variable" class="validation-alert">{{errors.variable}}</small> -->
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>COMENTARIOS</jet-label>
                                <textarea name="" id="" cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)">Guardar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </form>
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
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
//Moment Js
import moment from 'moment';
import 'moment/locale/es';
import throttle from 'lodash/throttle'

export default {
    data() {
        return {
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            tam: "5xl",
            color: "tw-bg-teal-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                IdArt: null,
                requisicion_id: null,
                NumReq:  null,
                Folio: null,
                Area: null,
                Observacioens: null,
                Cantidad: null,
                Unidad: null,
                Descripcion: null,
                Comentarios: null,
                    Precio: null,
                    Marca: null,
                    archivo: null,
            },
            params:{
                month: null,
                Estatus: null,
                Proveedor: null,
            },
            Marcas: [],
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
        JetSelect,
    },

    props: {
        Session: Object,
        errors: Object,
        ArticuloRequisicion: Object,
        Precios: Object,
        Proveedores: Object,
        PerfilesUsuarios: Object,
        Almacen: Object,
        Cotizacion: Object,
        Autorizados: Object,
        mes: Object,
    },

    methods: {

        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                IdArt: null,
                requisicion_id: null,
                NumReq:  null,
                Folio: null,
                Area: null,
                Observacioens: null,
                Cantidad: null,
                Unidad: null,
                Descripcion: null,
                Comentarios: null,
                Precio: null,
                Marca: null,
                archivo: null,
            };
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Articulos").DataTable({
                language: this.español,
                });
            });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            $("#Articulos").DataTable().destroy();
                this.$inertia.get("/Compras/Requisiciones", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
        },

        show(id){
            this.detalles = id;
        },

        hidden(id){
            this.detalles = null;
        },

        chageClose() {
            this.showModal = !this.showModal;
        },

        Filtro(value){
            $('#Articulos').DataTable().clear(); //limpio
            $('#Articulos').DataTable().destroy(); //destruyo tabla
            this.params.Estatus = value;
            this.$inertia.get('/Almacen/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
        },

        FiltroMes(value){
            this.params.month = value;
            this.$inertia.get('/Compras/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
        },

        getImage(event){
            this.form.archivo = event.target.files[0];
            console.log(this.form.archivo);
        },

        Cotizar(data, metodo){
            this.chageClose();
            this.reset();
            this.editMode = false;
            this.form.requisicion_id = data.requisicion_id;
            this.form.IdArt = data.articulos_requisicion.id;
            this.form.NumReq = data.articulos_requisicion.NumReq;
            this.form.Folio = data.articulos_requisicion.Folio;
            this.form.Area = data.articulos_requisicion.requisicion_departamento.Nombre;
            this.form.Nombre = data.articulos_requisicion.requisiciones_perfil.Nombre + " " + data.articulos_requisicion.requisiciones_perfil.ApPat + " " + data.articulos_requisicion.requisiciones_perfil.ApMat;
            this.form.Observaciones = data.articulos_requisicion.Observaciones;

            this.form.Cantidad = data.Cantidad;
            this.form.Unidad = data.Unidad;
            this.form.Descripcion = data.Descripcion;
        },

        addRow: function () {
            this.form.Cotizacion.push({Cot: ""});
        },

        removeRow: function (row) {
            this.form.Cotizacion.splice(row,1);
        },

        save(data) {
            console.log(data);
            this.$inertia.post("/Compras/Cotizaciones", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },

    },

    watch: {
        params: {
        deep: true,
            handler: throttle(function() {
                $('#Articulos').DataTable().clear(); //limpio
                $('#Articulos').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Compras/Cotizacion', this.params , {
                    onSuccess: () => {
                        this.tabla() //regeneracion de tabla
                        }, preserveState: true})
            }, 150),
        },
    },
};
</script>
