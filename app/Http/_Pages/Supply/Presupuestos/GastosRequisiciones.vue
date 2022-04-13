<template>
  <app-layout>
    <div class="uppercase tw-mx-4 tw-items-center tw-justify-center">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                    Gastos Requisiciones
                </h3>
            </slot>
        </Header>

        <div class="tw-flex tw-items-center tw-justify-center tw-mt-4">
            <div class="tw-w-full tw-mx-auto tw-max-w-7xl sm:tw-px-8 lg:tw-px-10">
                <div class="tw-flex tw-flex-col tw-w-full tw-mb-2 tw-space-y-8 lg:tw-flex-row lg:tw-space-x-10 lg:tw-space-y-0 lg:tw-mb-4">

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="Filtro(1)">
                        <div class="tw-w-full tw-p-4 tw-bg-white tw-border-l-4 tw-border-emerald-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-14 tw-p-3.5 tw-bg-emerald-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg">$ {{ GastoAño[0].Total }}</div>
                                    <div class="tw-text-xs tw-text-gray-400">Gasto Total de Año</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="Filtro(2)">
                        <div class="tw-w-full tw-p-4 tw-bg-white tw-border-l-4 tw-border-cyan-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-14 tw-p-3.5 tw-bg-cyan-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> $ {{ GastoMes[0].Total }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Gasto Total de Mes</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4">
                        <div class="tw-w-full tw-p-4 tw-bg-white tw-border-l-4 tw-border-indigo-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-14 tw-p-3.5 tw-bg-indigo-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> $ {{ PresupuestoAño[0].Total }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Presupuesto Total del Año</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="tw-p-2 tw-bg-teal-500 tw-mx-56 tw-rounded-full tw-text-center tw-font-semibold tw-text-white">Gastos del Mes</div>

        <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-center tw-my-4 tw-gap-8 tw-uppercase">
            <div class="tw-border-t-8 tw-border-teal-500 tw-shadow-xl tw-rounded">
                <div class="tw-p-4 tw-flex tw-gap-2 tw-align-middle">
                    <div>
                        <svg class="tw-h-16 tw-w-16 tw-text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="tw-flex-col">
                        <div class="tw-text-gray-400 tw-font-extrabold">
                            APERTURA
                        </div>
                        <div class="tw-text-sm tw-text-gray-600 tw-font-extrabold">
                            $ {{ GastoApertura[0].Total }}
                        </div>
                        <div v-if="PerApertura <= 15" class="tw-text-xs tw-text-red-500 tw-bg-red-200 tw-rounded-full tw-text-center tw-p-1 tw-mt-2">
                            {{ PerApertura }} %
                        </div>
                        <div v-else-if="PerApertura > 15 " class="tw-text-xs tw-text-emerald-500 tw-bg-emerald-200 tw-rounded-full tw-text-center tw-p-1 tw-mt-2">
                            {{ PerApertura }} %
                        </div>
                    </div>
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
import Table from "@/Components/TableSky";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';
import throttle from 'lodash/throttle'

export default {
    mounted() {
        this.mostSelect();
        this.tabla();
    },

    data() {
        return {
            tam: "3xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            opc: '',
            dpto: '',
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
            },
            params:{
                dpto: null,
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
        JetSelect,
    },

    props: {
        Session: Object,
        errors: Object,
        flash: Object,
        Departamentos: Object,
        Presupuestos: Object,
        GastoAño: Object,
        GastoMes: Object,
        GastoApertura: Object,
        PresupuestoAño: Object,
        GastoApertura: Object,
        PerApertura: Object,
    },

    methods: {
        mostSelect() {
            this.$nextTick(() => {
                this.Departamentos.forEach(r => {
                    this.opc += `<option value="${r.id}"> ${r.Nombre} </option>`;
                })
            });
        },

        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
            };
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#presupuestos").DataTable({language: this.español,});
            });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            // $('#presupuestos').DataTable().clear(); //limpio
            $('#presupuestos').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Supply/GastosRequisiciones',{ dpto: event.target.value }, {
                onSuccess: () => { this.tabla(); }, preserveState: true
            });
        },

        save(data) {
            this.$inertia.post('/Supply/GastosRequisiciones', data, {
                onSuccess: () => {
                    console.log(this.flash);
                    switch (this.flash) {
                        case 0:
                            this.reset(),
                            this.chageClose(),
                            this.alertSucces()
                            break;
                        case 1:
                            Swal.fire(
                            'Datos Inválidos',
                            'El presupuesto correspondiente al Mes ya se encuentra registrado',
                            'error'
                            )
                        break;
                    }
                    },
            });
        },
    },
};
</script>
