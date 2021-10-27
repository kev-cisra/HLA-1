<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-store tw-ml-3 tw-mr-3"></i>
                        Insumos Solicitados
                </h3>
            </slot>
        </Header>

        <div class="tw-overflow-auto">
            <div class="tw-shadow-full tw-row tw-justify-content-center">
                <div class="tw-flex tw-items-center tw-mt-2 tw-text-center tw-text-white tw-border tw-shadow-xl">
                    <div class="tw-m-3" @click="FiltroPorMes(1)">
                        <button class="EneroActivo" v-if="mes == 1">
                            <span class="mx-auto">Enero</span>
                        </button>
                        <button class="Enero" v-else>
                            <span class="mx-auto">Enero</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(2)">
                        <button class="FebreroActivo" v-if="mes == 2">
                            <span class="mx-auto">Febrero</span>
                        </button>
                        <button class="Febrero" v-else>
                            <span class="mx-auto">Febrero</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(3)">
                        <button class="MarzoActivo" v-if="mes == 3">
                            <span class="mx-auto">Marzo</span>
                        </button>
                        <button class="Marzo" v-else>
                            <span class="mx-auto">Marzo</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(4)">
                        <button class="AbrilActivo" v-if="mes == 4">
                            <span class="mx-auto">Abril</span>
                        </button>
                        <button class="Abril" v-else>
                            <span class="mx-auto">Abril</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(5)">
                        <button class="MayoActivo" v-if="mes == 5">
                            <span class="mx-auto">Mayo</span>
                        </button>
                        <button class="Mayo" v-else>
                            <span class="mx-auto">Mayo</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(6)">
                        <button class="JunioActivo" v-if="mes == 6">
                            <span class="mx-auto">Junio</span>
                        </button>
                        <button class="Junio" v-else>
                            <span class="mx-auto">Junio</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(7)">
                        <button class="JulioActivo" v-if="mes == 7">
                            <span class="mx-auto">Julio</span>
                        </button>
                        <button class="Julio" v-else>
                            <span class="mx-auto">Julio</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(8)">
                        <button class="AgostoActivo" v-if="mes == 8">
                            <span class="mx-auto">Agosto</span>
                        </button>
                        <button class="Agosto" v-else>
                            <span class="mx-auto">Agosto</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(9)">
                        <button class="SeptiembreActivo" v-if="mes == 9">
                            <span class="mx-auto">Septiembre</span>
                        </button>
                        <button class="Septiembre" v-else>
                            <span class="mx-auto">Septiembre</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(10)">
                        <button class="OctubreActivo" v-if="mes == 10">
                            <span class="mx-auto">Octubre</span>
                        </button>
                        <button class="Octubre" v-else>
                            <span class="mx-auto">Octubre</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(11)">
                        <button class="NoviembreActivo" v-if="mes == 11">
                            <span class="mx-auto">Noviembre</span>
                        </button>
                        <button class="Noviembre" v-else>
                            <span class="mx-auto">Noviembre</span>
                        </button>
                    </div>

                    <div class="tw-m-3" @click="FiltroPorMes(12)">
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

        <div class="tw-overflow-x-auto tw-mt-8 tw-mx-48">
            <Table id="Insumos">
                <template v-slot:TableHeader>
                    <th class="columna">SOLICITANTE</th>
                    <th class="columna">DEPARTAMENTO</th>
                    <th class="columna">CANTIDAD</th>
                    <th class="columna">MATERIAL</th>
                    <th class="columna">UNIDAD</th>
                    <th class="columna">ESTATUS</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="dato in ReqInsumos" :key="dato.id">
                        <td class="tw-p-2">{{ dato.requisiciones_insumos_perfil.Nombre }} {{ dato.requisiciones_insumos_perfil.ApPat }} {{ dato.requisiciones_insumos_perfil.ApMat }}</td>
                        <td class="tw-p-2">{{ dato.requisicion_insumos_departamento.Nombre}}</td>
                        <td class="tw-p-2">{{ dato.Cantidad }}</td>
                        <td class="tw-p-2">{{ dato.requisiciones_insumos_material.Nombre }}</td>
                        <td class="tw-p-2">{{ dato.requisiciones_insumos_material.Unidad }}</td>
                        <td class="tw-p-2">{{ dato.Estatus}}</td>
                    </tr>
                </template>
            </Table>
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

export default {
    mounted() {
        this.tabla();
    },

    data() {
        return {
            tam: "3xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showModalInsumos: false,
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
            },
            params:{
                month: moment().format("MM"),
                Estatus: null,
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
        mes: Object,
        Insumos: Object,
        NumInsumos: Object,
        ReqInsumos: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
            };
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Insumos").DataTable({
                language: this.español,
                });
            });
        },

        FiltroPorMes(value){
            this.params.month = value;
            $('#Insumos').DataTable().clear(); //limpio
            $('#Insumos').DataTable().destroy(); //destruyo tabla
            this.$inertia.get('/Supply/InsumosSolicitados', this.params , { //envio de variables por url
            onSuccess: () => {
                this.tabla() //regeneracion de tabla
            }, preserveState: true})
        },
    },
};
</script>
