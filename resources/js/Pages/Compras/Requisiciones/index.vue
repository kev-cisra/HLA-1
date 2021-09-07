<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                        Mis Requisiciones
                </h3>
            </slot>
        </Header>

        <div class="tw-flex tw-items-center tw-justify-center tw-mt-4">
            <div class="tw-w-full tw-mx-auto tw-max-w-7xl sm:tw-px-8 lg:tw-px-10">
                <div class="tw-flex tw-flex-col tw-w-full tw-mb-2 tw-space-y-8 lg:tw-flex-row lg:tw-space-x-10 lg:tw-space-y-0 lg:tw-mb-4">

                    <div class="tw-w-full lg:tw-w-1/4">
                        <div class="tw-w-full tw-p-4 tw-bg-white tw-border-l-4 tw-border-green-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-14 tw-p-3.5 tw-bg-green-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg">{{Almacen}}</div>
                                    <div class="tw-text-xs tw-text-gray-400">Artículos pendientes por recoger en almacén</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full lg:tw-w-1/4">
                        <div class="tw-w-full tw-p-4 tw-bg-white tw-border-l-4 tw-border-indigo-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-14 tw-p-3.5 tw-bg-indigo-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Cotizacion }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">En espera de Cotización</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full lg:tw-w-1/4">
                        <div class="tw-w-full tw-p-4 tw-bg-white tw-border-l-4 tw-border-indigo-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-14 tw-p-3.5 tw-bg-indigo-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Autorizados }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Articulos Autorizados</div>
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
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-green-500 tw-rounded tw-shadow-md hover:tw-border-green-600 hover:tw-bg-green-200 hover:tw-text-white">
                            <span class="mx-auto">Enero</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroMes(2)">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Febrero</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Marzo</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Abril</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Mayo</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Junio</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Julio</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Agosto</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Septiembre</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Octubre</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Noviembre</span>
                        </button>
                    </div>

                    <div class="tw-m-3">
                        <button class="tw-inline-flex tw-items-center tw-w-32 tw-px-6 tw-py-2 tw-font-bold tw-tracking-wide tw-text-gray-800 tw-bg-white tw-border-b-2 tw-border-cyan-500 tw-rounded tw-shadow-md hover:tw-border-cyan-600 hover:tw-bg-cyan-200 hover:tw-text-white">
                            <span class="mx-auto">Diciembre</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-end">
                <div>
                    <jet-button @click="openModal" class="BtnNuevo">Nueva Requisición</jet-button>
                </div>
            </div>


        </div>
    </div>

    <pre>
        {{ ArticuloRequisicion }}
    </pre>

    <modal :show="showModal" @close="chageClose" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Nueva Requisición</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>FECHA</jet-label>
                                <jet-input type="date" :min="min" v-model="form.Fecha"></jet-input>
                                <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>AREA</jet-label>
                                <select id="Jefe" v-model="form.Departamento_id" class="InputSelect">
                                    <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                </select>
                                <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Num Requisicion</jet-label>
                                <jet-input type="number" v-model="form.NumReq"></jet-input>
                                <small v-if="errors.NumReq" class="validation-alert">{{errors.NumReq}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Código</jet-label>
                                <select id="Empresa" v-model="form.Codigo" class="InputSelect">
                                    <option value="A - EXTRAORDINARIA">A - EXTRAORDINARIA</option>
                                    <option value="B - REGULAR">B - REGULAR</option>
                                    <option value="C - PRESUPUESTO">C - PRESUPUESTO</option>
                                </select>
                                <small v-if="errors.Codigo" class="validation-alert">{{errors.Codigo}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>MÁQUINA</jet-label>
                                <select id="Maquina" v-model="form.Maquina" name="Maquina" class="InputSelect" @change="loadMarcas($event)">
                                    <option v-for="maq in Maquinas" :key="maq.id" :value="maq.id"> {{ maq.Nombre }}</option>
                                </select>
                                <small v-if="errors.Maquina" class="validation-alert">{{errors.Maquina}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>MARCA</jet-label>
                                <select id="Marca" v-model="form.Marca" class="InputSelect">
                                    <option v-for="maq in Marcas" :key="maq.id" :value="maq.id" > {{ maq.Nombre }}</option>
                                </select>
                                <small v-if="errors.Marca" class="validation-alert">{{errors.Marca}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>TIPO DE COMPRA</jet-label>
                                <select id="Tipo" v-model="form.Tipo" class="InputSelect">
                                    <option value="REQUISICIÓN">REQUISICIÓN</option>
                                    <option value="REFACCIONES">REFACCIONES</option>
                                    <option value="SERVICIOS EXTERNOS">SERVICIOS EXTERNOS</option>
                                    <option value="ORDEN DE TRABAJO">ORDEN DE TRABAJO</option>
                                    <option value="PRODUCTOS AUXILIARES">PRODUCTOS AUXILIARES</option>
                                    <option value="MODIFICACIONES Y PROYECTOS">MODIFICACIONES Y PROYECTOS</option>
                                </select>
                                <small v-if="errors.Tipo" class="validation-alert">{{errors.Tipo}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>NOMBRE SOLICITANTE</jet-label>
                                <select id="Nombre" v-model="form.Nombre" class="InputSelect">
                                    <option v-for="per in PerfilesUsuarios" :key="per.id" :value="per.id" > {{ per.Nombre }} {{per.ApPat}} {{per.ApMat}}</option>
                                </select>
                                <small v-if="errors.Nombre" class="validation-alert">{{errors.Nombre}}</small>
                            </div>
                        </div>
                        <input type="button" @click="addRow()" value="Añadir Partida" class="BtnCancel">
                        <div class="tw-mb-6 md:tw-flex" v-for="(form) in form.Partida" :key="form.id">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                                <jet-input type="number" v-model="form.Cantidad"></jet-input>
                                <small v-if="errors.Cantidad" class="validation-alert">{{errors.Cantidad}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                <jet-label><span class="required">*</span>UNIDAD</jet-label>
                                <select id="Unidad" v-model="form.Unidad" class="InputSelect">
                                    <option value="PZ">PIEZAS</option>
                                    <option value="LTS">LITROS</option>
                                    <option value="KG">KILOGRAMOS</option>
                                    <option value="MT">METROS</option>
                                    <option value="SERVICIO">SERVICIO</option>
                                    <option value="CAJA">CAJA</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <small v-if="errors.Unidad" class="validation-alert">{{errors.Unidad}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-6/12 md:tw-mb-0">
                                <jet-label><span class="required">*</span>DESCRIPCIÓN</jet-label>
                                <jet-input type="text" v-model="form.Descripcion" @input="(val) => (form.Descripcion = form.Descripcion.toUpperCase())"></jet-input>
                                <small v-if="errors.Descripcion" class="validation-alert">{{errors.Descripcion}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                <button type="button" class="btn btn-primary" @click="removeRow(index)">Quitar</button>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>OBSERVACIONES</jet-label>
                                <textarea name="" id="" cols="2" v-model="form.Observaciones" @input="(val) => (form.Observaciones = form.Observaciones.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
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

export default {
    data() {
        return {
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            tam: "5xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Fecha: new Date(),
                Departamento_id: null,
                NumReq: null,
                Codigo: null,
                Maquina: null,
                Marca: null,
                Tipo: null,
                Nombre: null,
                Partida: [{
                    Cantidad: null,
                    Unidad: null,
                    Descripcion: null,
                    }],
                Observaciones: null,
            },
            params:{
                month: null,
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
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Fecha: new Date(),
                Departamento_id: null,
                NumReq: null,
                Codigo: null,
                Maquina: null,
                Marca: null,
                Tipo: null,
                Nombre: null,
                Partida: [{
                    Cantidad: null,
                    Unidad: null,
                    Descripcion: null,
                    }],
                Observaciones: null,
            };
        },

        loadMarcas(event) {
            axios.get('/Compras/Marcas',{
                params: {
                    Maquina: event.target.value
                }
            })
            .then(response => this.Marcas = response.data.Marcas)
            .catch(error => console.log(error))
        },

        FiltroMes(value){

            this.params.month = value;
            console.log(this.params.month);
            $('#Articulos').DataTable().clear(); //limpio
            $('#Articulos').DataTable().destroy(); //destruyo tabla
            this.$inertia.get('/Compras/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
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
            console.log(this.detalles);
        },

        hidden(id){
            this.detalles = null;
        },

        addRow: function () {
            this.form.Partida.push({Part: ""});
        },

        removeRow: function (row) {
            this.form.Partida.splice(row,1);
        },

        save(data) {
            console.log(data);
            this.$inertia.post("/Compras/Requisiciones", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },

        edit: function (data) {

        },

        update(data) {
        },

        ConfirmaReq(data, metodo){
            data.metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Compras/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        deleteRow: function (data) {

        },
    },
};
</script>
