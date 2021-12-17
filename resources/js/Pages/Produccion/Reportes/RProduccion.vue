<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-folder-open"></i>
                        Reporte de  Producción
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <div class="sm:tw-flex tw-gap-3">
                    <select class="InputSelect sm:tw-w-full" v-model="S_Area">
                        <option value="" disabled>Selecciona un departamento</option>
                        <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                    </select>
                </div>
            </template>
            <template v-slot:BtnNuevo v-if="S_Area">
                <div class="md:tw-flex tw-gap-3 tw-mr-10">
                    <!-- boton de carga masiva -->
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" @click="openModalC">Carga masiva</jet-button>
                    </div>
                    <!-- Boton de filtros -->
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" data-bs-toggle="collapse" data-bs-target="#filtro" aria-expanded="false" aria-controls="filtro"><i class="fas fa-filter"> </i> Filtros</jet-button>
                    </div>
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" data-bs-toggle="collapse" data-bs-target="#grafica" aria-expanded="false" aria-controls="grafica"><i class="fas fa-chart-pie"></i> Graficas</jet-button>
                    </div>
                </div>
            </template>
        </Accions>

        <!------------------------------------ Muestra las opciones de filtros ------------------------------------------->
        <div class="collapse md:tw-ml-10 tw-p-6 tw-bg-blue-300 tw-rounded-3xl tw-shadow-xl tw-m-10" id="filtro">
            <div class="tw-mb-6 lg:tw-flex lg:tw-flex-col tw-w-full">
                <div class="tw-mb-6 lg:tw-flex">
                    <!-- Año
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Año</jet-label>
                        <jet-input type="number" class="form-control" v-model="ano" :max="estAño"></jet-input>
                    </div> -->
                    <!-- Tipo de reporte -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Tipo de reporte</jet-label>
                        <div class="tw-flex tw-gap-5">
                            <div>
                                <input type="radio" id="uno" value="1" v-model="FoFiltro.TipRepo">
                                <label for="uno"> Produccion</label>
                            </div>
                            <div>
                                <input type="radio" id="dos" value="2" v-model="FoFiltro.TipRepo">
                                <label for="dos"> Paros</label>
                            </div>
                        </div>
                    </div>
                    <!-- calculos -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label>Boton para Calcular Operaciones</jet-label>
                        <button v-show="vCal" class="btn btn-success" type="button" id="button-addon2" v-if="FoFiltro.iniDia" @click="calcula(form)">
                            <i class="fas fa-calculator" ></i> Calcular
                        </button>
                        <button v-show="!vCal" class="btn btn-success" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Calculando...
                        </button>
                    </div>
                </div>
                <div class="tw-mb-6 lg:tw-flex">
                    <!-- mes -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Mes</jet-label>
                        <jet-input type="month" class="form-control" @click="limInputs(3)" v-model="FoFiltro.mes"></jet-input>
                    </div>
                    <!-- semana -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Semana</jet-label>
                        <jet-input type="week" class="form-control" @click="limInputs(2)" v-model="FoFiltro.semana"></jet-input>
                    </div>
                    <!-- dia -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Fecha Dia</jet-label>
                        <jet-input type="date" class="form-control" @click="limInputs(1.5)" v-model="FoFiltro.iniDia"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-button @click="arrProdu(FoFiltro)">Consultar</jet-button>
                    </div>
                </div>
            </div>
        </div>

        <pre>
            {{ recoTabla }}
        </pre>

        <!------------------------------------- Modal para carga de datos masivas ------------------------------------------------>
        <modal :show="showModalC" @close="chageCloseC">
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Carga Masiva</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <a target="_blank" href="../public/FormatosExcel/FileNotFound404.jpg" download="not.jpg">Link de descarga</a>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha de inicio de carga</jet-label>
                                <input type="file" @input="docu.file = $event.target.files[0]" ref="file" accept=".xlsx">
                                <br>
                                <small v-if="errors.file" class="validation-alert">{{errors.file}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                                <jet-button class="" v-show="vMasi" @click="carMasi">Guardar</jet-button>
                                <jet-button v-show="!vMasi" disabled>
                                    <span class="spinner-grow spinner-grow-sm" v-show="!vMasi" role="status" aria-hidden="true"></span>
                                    Guardando...
                                </jet-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table';
    import TableBlue from '@/Components/TableBlue';
    import Modal from '@/Jetstream/Modal';
    import JetButton from '@/Components/Button';
    import JetInput from '@/Components/Input';
    import JetLabel from '@/Jetstream/Label';
    import Select2 from 'vue3-select2-component';
    import moment from 'moment';
    import 'moment/locale/es';
    //datatable
    import datatable from 'datatables.net-bs5';
    require( 'datatables.net-buttons-bs5/js/buttons.bootstrap5' );

    require( 'datatables.net-buttons/js/buttons.html5' );
    require ( 'datatables.net-buttons/js/buttons.colVis' );
    import print from 'datatables.net-buttons/js/buttons.print';
    import jszip from 'jszip/dist/jszip';
    import pdfMake from 'pdfmake/build/pdfmake';
    import pdfFonts from 'pdfmake/build/vfs_fonts';
    import $ from 'jquery';
import { watch } from '@vue/runtime-core';
import axios from 'axios';

    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    window.JSZip = jszip;

    var Highcharts = require('highcharts');
    // Load module after Highcharts is loaded
    require('highcharts/modules/exporting')(Highcharts);

    export default {
        props: [
            'usuario',
            'depa',
            'materiales',
            'maquinas',
            'procesos',
            'claParo',
            'errors'
        ],

        components: {
            AppLayout,
            Header,
            Accions,
            Table,
            TableBlue,
            JetButton,
            JetInput,
            Modal,
            Select2,
            JetLabel,
        },

        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                showModalC: false,
                vMasi: true,
                vCal: true,
                recoTabla: [],
                docu: {
                    file: null
                },
                FoFiltro: {
                    TipRepo: 1,
                    mes: null,
                    semana: null,
                    iniDia: null,
                    finDia: null,
                },
            }
        },

        mounted() {

        },

        methods: {
            /***************************** Carga Masiva ************************************/
            carMasi(){
                const form = this.docu;
                this.$inertia.post('/Produccion/CargaExcel', form, {
                    onSuccess: (v) => { this.openModalC(), this.resetC(), this.alertSucces(), this.vMasi = true },
                    onError: (e) => { this.vMasi = true },
                    preserveState: true
                });
            },
            /***************************** Modal de carga masiva ********************************************/
            //abrir modal carga masiva
            openModalC(){
                this.chageCloseC();
                this.resetC();
            },
            //abrir o cerrar modal procesos
            chageCloseC(){
                this.showModalC = !this.showModalC
            },
            //reset de file
            resetC(){
                this.docu.file = null
            },
            /***************************** Datos de procesos *******************************************/
            //Limpia los inputs de fechas
            limInputs(val){
                if(val == 1.5){
                    this.FoFiltro.semana = null;
                    this.FoFiltro.mes = null;
                }else if(val == 2){
                    this.FoFiltro.iniDia = null;
                    this.FoFiltro.finDia = null;
                    this.FoFiltro.mes = null;
                    this.horas = '07:00';
                    this.limpPro = true;
                }else if(val == 3){
                    this.FoFiltro.iniDia = null;
                    this.FoFiltro.finDia = null;
                    this.FoFiltro.semana = null;
                    this.horas = '07:00';
                    this.limpPro = true;
                }
                else{
                    this.FoFiltro.iniDia = null;
                    this.FoFiltro.finDia = null;
                    this.FoFiltro.semana = null;
                    this.FoFiltro.mes = null;
                    this.limpPro = true;
                }
            },
            //consulta la produccion para la tabla
            async arrProdu(data){
                data.departamento_id = this.S_Area;

                if(this.FoFiltro.iniDia != null){
                    data.iniDia = this.FoFiltro.iniDia+' 07:00:00'
                    if (this.S_Area == 7){
                        if (moment(this.FoFiltro.iniDia).isDST()) {
                            data.iniDia = this.FoFiltro.iniDia+' 09:10:00';
                        }else{
                            data.iniDia = this.FoFiltro.iniDia+' 08:10:00';
                        }
                    }

                    //Asigna el dato para la fecha final
                    fin = moment(inicio).add(24, 'hours');
                }

                let pomesa = await axios.post('Produccion/ReportesPro/ConPro', data)
                let fin = pomesa.data
                this.recoTabla = fin
                return console.log(fin)
            }
        },

        computed: {
            //Opciones departamento
            opc: function() {
                const ar = [];
                this.depa.forEach(r => {
                    if (r.departamentos) {
                        ar.push({text: r.departamentos.Nombre, value: r.departamentos.id});
                    }else{
                        ar.push({text: r.Nombre, value: r.id});
                        r.sub__departamentos.forEach(rr => {
                            ar.push({text: rr.Nombre, value: rr.id});
                            //console.log(rr.Nombre);
                        })
                    }
                })
                return ar;
            },
        },

        watch: {
            S_Area: async function(b){
                await this.$inertia.get('/Produccion/ReportesPro',{ busca: b, ano: this.ano }, {
                    onSuccess: (data) => {  },
                    onError: (err) => { console.log(err)},
                    preserveState: true
                });
            },
        }
    }
</script>
