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
                            <option value="EN COTIZACION">EN COTIZACION</option>
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
                        <th class="columna">F. LLEGADA</th>
                        <th class="columna">O.C</th>
                        <th class="columna">ESTATUS</th>
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
                            <td class="tw-p-2">{{ datos.articulos_requisicion.Fecha }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.OrdenCompra }}</td>
                            <td class="tw-p-2">
                                <div v-if="datos.EstatusArt == 2">
                                    <span tooltip="Material Solicitado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-400 tw-rounded-full">SOLICITADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 3 || datos.EstatusArt == 4">
                                    <span tooltip="Articulo en espera de cotización" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-indigo-500 tw-rounded-full">EN COTIZACION</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 5">
                                    <span tooltip="EN ESPERA DE AUTORIZACIÓN" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">EN AUTORIZACION</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 6">
                                    <span tooltip="ARTICULO AUTORIZADO" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-600 tw-rounded-full">AUTORIZADO</span>
                                    </span>
                                </div>
                            </td>
                            <td class="fila">
                                <div class="columnaIconos" v-if="datos.EstatusArt == 2">
                                    <div class="iconoPurple" @click="EnviaCotizar(datos, 3)">
                                        <span tooltip="Envia a Cotización" flow="left">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </span>
                                    </div>
                                    <div class="iconoEdit" @click="ConfirmaExistencia(datos)">
                                        <span tooltip="Confirma existencia en Almacén" flow="left">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    </div>
                                    <div class="iconoCyan" @click="Parcialidad(datos)">
                                        <span tooltip="Confirma Parcialidad" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
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
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Crea Parcialidad</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-flex tw-items-center tw-justify-center tw-uppercase">
                            <div class="tw-w-full tw-bg-white tw-rounded-lg tw-shadow-xl">
                                <div class="tw-p-2 tw-ml-4 tw-space-y-1 tw-border-b md:tw-grid md:tw-grid-cols-3 tw-justify-items-stretch hover:tw-bg-gray-50 md:tw-space-y-0">
                                    <div class="tw-justify-self-start">
                                        <p class="tw-text-gray-600">Número de requisición</p>
                                        <input type="text" class="InfoData" v-model="form.NumReq" disabled/>
                                    </div>
                                    <div class="tw-justify-self-start">
                                        <p class="tw-text-gray-600">Fecha</p>
                                        <input type="text" class="InfoData" v-model="form.Fecha" disabled/>
                                    </div>
                                </div>
                                <div class="tw-p-2 tw-ml-4 tw-space-y-1 tw-border-b md:tw-grid md:tw-grid-cols-3 tw-justify-items-stretch hover:tw-bg-gray-50 md:tw-space-y-0">
                                    <div class="tw-justify-self-start">
                                        <p class="tw-text-gray-600">Cantidad</p>
                                        <input type="text" class="InfoData" v-model="form.Cant" disabled/>
                                    </div>
                                    <div class="tw-justify-self-start">
                                        <p class="tw-text-gray-600">Unidad</p>
                                        <input type="text" class="InfoData" v-model="form.Uni" disabled/>
                                    </div>
                                    <div class="tw-justify-self-start">
                                        <p class="tw-text-gray-600">descripción</p>
                                        <input type="text" class="InfoData" v-model="form.Desc" disabled/>
                                    </div>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center tw-text-center tw-uppercase tw-rounded">
                                    <div class="tw-p-4">
                                        <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                            <jet-label><span class="required">*</span>Confirma Parcialidad</jet-label>
                                            <jet-input type="number" v-model="form.Parcialidad"></jet-input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="update(form, 3.1)">Guardar</jet-button>
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
import Table from "@/Components/TableCyan";
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
            showModal: false,
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            tam: "5xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            form: {
                IdArt:  null,
                Parcialidad: null,
                NumReq: null,
                Dpto: null,
                Fecha: null,
                Cant: null,
                Uni: null,
                Desc: null,
            },
            params:{
                month: null,
                Estatus: null,
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
        Departamentos: Object,
        Maquinas: Object,
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
                IdArt:  null,
                Parcialidad: null,
                NumReq: null,
                Dpto: null,
                Fecha: null,
                Cant: null,
                Uni: null,
                Desc: null,
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

        EnviaCotizar(data, metodo){
            data.metodo = 3;
            data._method = "PUT";
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        Parcialidad(data){
            this.form.IdArt = data.id;
            this.form.NumReq = data.articulos_requisicion.NumReq;
            this.form.Fecha = data.Fecha;
            this.form.Cant = data.Cantidad;
            this.form.Uni = data.Unidad;
            this.form.Desc = data.Descripcion;
            this.chageClose();
            this.editMode = false;
        },

        update(data, metodo) {
            data.metodo = "Parcialidad";
            data._method = "PUT";
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
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
                this.$inertia.get('/Almacen/Requisiciones', this.params , {
                    onSuccess: () => {
                        this.tabla() //regeneracion de tabla
                        }, preserveState: true})
            }, 150),
        },
    },
};
</script>
