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
                            <option value="1">SIN ENVIAR</option>
                            <option value="EN ALMACEN">EN ALMACEN</option>
                            <option value="EN COTIZACION">EN COTIZACION</option>
                            <option value="2">SOLICITADO</option>
                            <option value="EN AUTORIZACION">EN AUTORIZACION</option>
                            <option value="ENTREGADO">ENTREGADO</option>
                    </select>
                </div>
                <div>
                    <jet-button @click="openModal" class="BtnNuevo">Nueva Requisición</jet-button>
                </div>
            </div>



        </div>
    </div>



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
            showModal2: false,
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            tam: "5xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            form: {

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
        mes: Object,
    },

    methods: {
    },
    watch: {
        params: {
        deep: true,
            handler: throttle(function() {
                $('#Articulos').DataTable().clear(); //limpio
                $('#Articulos').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Compras/Requisiciones', this.params , {
                    onSuccess: () => {
                        this.tabla() //regeneracion de tabla
                        }, preserveState: true})
            }, 150),
        },
    },
};
</script>
