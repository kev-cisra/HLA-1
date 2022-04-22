<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-sky-800 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Carga de Información</h3>
            </div>
        </template>
        <Accions>
            <template  v-slot:SelectB>
                <select class="InputSelect sm:tw-w-full" v-model="cat_pro">
                    <option value="" disabled>Procesos</option>
                    <option v-for="o in catproce" :key="o.id" :value="o.id">{{o.nombre}}</option>
                </select>
            </template>
        </Accions>
        <div class="overflow-auto" style="height: 70vh">
            <!-- Acordion -->
            <div class="accordion tw-m-auto" id="accordionExample">
                <input type="search" v-model="buscaProc" v-show="cat_pro" placeholder="Buscar" @input="(val) => (buscaProc = buscaProc.toUpperCase())" @keyup="conLisTable()" class="InputSelect lg:tw-w-1/4 tw-ml-auto tw-m-5">
                <div class="accordion-item" v-for="lc in lisa_carga" :key="lc">
                    <h2 class="accordion-header" :id="'heading'+lc.id">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse'+lc.id" aria-expanded="false" :aria-controls="'collapse'+lc.id" @click="limMeFibra(lc)">
                            {{ lc.partida }} - {{ lc.maquina.Nombre }} {{ lc.maquina.marca.Nombre }} - {{ lc.clave.DESCR }}
                        </button>
                    </h2>
                    <div :id="'collapse'+lc.id" class="accordion-collapse collapse" :aria-labelledby="'heading'+lc.id" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="lg:tw-w-1/4">
                                <select v-model="lc.estatus" class="form-select" @change="finProc">
                                    <option value="1">Activo</option>
                                    <option value="0">Finalizar</option>
                                </select>
                            </div>
                            <!-- Formulario Medición de fibras -->
                            <div v-if="cat_pro == 5">
                                <div class="lg:tw-flex">
                                    <div class="tw-p-3 lg:tw-w-4/12 lg:tw-mb-0">
                                        <jet-label><span class="required">*</span>Frecuencia</jet-label>
                                        <div>
                                            <input type="radio" id="arra" v-model="formMeFibra.frecuencia" value="1">
                                            <label for="arra">Arranque</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="segui" v-model="formMeFibra.frecuencia" value="2">
                                            <label for="segui">Seguimiento</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="extra" v-model="formMeFibra.frecuencia" value="3">
                                            <label for="extra">Pruebas Extraordinarias</label>
                                        </div>
                                        <small v-if="errors.frecuencia" class="validation-alert">{{errors.frecuencia}}</small>
                                    </div>
                                    <div class="tw-p-3 lg:tw-w-4/12 lg:tw-mb-0">
                                        <!-- <jet-label><span class="required">*</span>ML</jet-label> -->
                                        <input type="number" v-model="formMeFibra.ml" class="InputSelect" min="0" placeholder="ML">
                                        <small v-if="errors.ml" class="validation-alert">{{errors.ml}}</small>
                                    </div>
                                    <div class="tw-p-3 lg:tw-w-4/12 lg:tw-mb-0">
                                        <!-- <jet-label><span class="required">*</span>SFC</jet-label> -->
                                        <input type="number" v-model="formMeFibra.sfc" class="InputSelect" min="0" placeholder="SFC">
                                        <small v-if="errors.sfc" class="validation-alert">{{errors.sfc}}</small>
                                    </div>
                                    <div class="tw-p-3 lg:tw-w-4/12 lg:tw-mb-0">
                                        <!-- <jet-label><span class="required">*</span>% Anillo Calculo</jet-label> -->
                                        <input type="number" v-model="formMeFibra.calculo_anillo" class="InputSelect" min="0" placeholder="% Anillo Calculo">
                                        <small v-if="errors.calculo_anillo" class="validation-alert">{{errors.calculo_anillo}}</small>
                                    </div>
                                </div>
                                <div class="lg:tw-flex">
                                    <div class="tw-p-3 lg:tw-w-4/12 lg:tw-mb-0">
                                        <!-- <jet-label><span class="required">*</span>% Calculo Algodón</jet-label> -->
                                        <input type="number" v-model="formMeFibra.calculo_algodon" class="InputSelect" min="0" placeholder="% Calculo Algodón">
                                        <small v-if="errors.calculo_algodon" class="validation-alert">{{errors.calculo_algodon}}</small>
                                    </div>
                                    <div class="tw-p-3 lg:tw-w-4/12 lg:tw-mb-0">
                                        <!-- <jet-label><span class="required">*</span>Composición Final Real</jet-label> -->
                                        <input type="text" v-model="formMeFibra.composicion" class="InputSelect" placeholder="Composición Final Real">
                                        <small v-if="errors.composicion" class="validation-alert">{{errors.composicion}}</small>
                                    </div>
                                    <div class="tw-p-3 lg:tw-w-4/12 lg:tw-mb-0">
                                        <!-- <jet-label><span class="required">*</span>Observaciones</jet-label> -->
                                        <textarea v-model="formMeFibra.observaciones" class="InputSelect" placeholder="Observaciones"></textarea>
                                        <!-- <input type="text" v-model="formMeFibra.composicion" class="InputSelect" min="0"> -->
                                        <small v-if="errors.observaciones" class="validation-alert">{{errors.observaciones}}</small>
                                    </div>
                                    <div class="tw-p-3 lg:tw-w-4/12 lg:tw-mb-0">
                                        <BotonCarga :verBot="buMeFi" :textoV="'Guardar'" :textoOC="'Guardando...'" :class="'btn btn-success tw-mr-4'" @click="saveMeFibra(formMeFibra)"></BotonCarga>
                                        <!-- <button class="btn btn-success" @click="saveMeFibra(formMeFibra)">
                                            <i class="fas fa-save"></i>
                                            Guardar
                                        </button> -->
                                    </div>
                                </div>
                            </div>
                            <!-- Tabla -->
                            <ag-grid-vue
                                style="width: 100%; height: 30vh"
                                class="ag-theme-balham"
                                :localeText="ag_español"
                                :columnDefs="encaTabla"
                                :rowData="datTabla"
                            >
                            </ag-grid-vue>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import { Link } from '@inertiajs/inertia-vue3';
    import Table from '@/Components/Table';
    import Select2 from 'vue3-select2-component';
    import Accions from '@/Components/Accions';
    import axios from 'axios';
    import JetLabel from '@/Jetstream/Label';
    import BotonCarga from '@/Components/BotonCarga.vue';

    import { AgGridVue } from "ag-grid-vue3";

    import "ag-grid-community/dist/styles/ag-grid.css";
    import "ag-grid-community/dist/styles/ag-theme-balham.css";
import moment from 'moment';

    export default {
        props: [
            'usuario',
            'catproce'
        ],
        components: {
            AppLayout,
            Accions,
            Link,
            AgGridVue,
            Table,
            JetLabel,
            BotonCarga,
            Select2
        },
        data() {
            return {
                cat_pro: "",
                buscaProc: "",
                lisa_carga: [],
                encaTabla: [],
                datTabla: [],
                buMeFi: true,
                errors: [],
                formMeFibra:{
                    ml: "",
                    sfc: "",
                    calculo_anillo: "",
                    calculo_algodon: "",
                    composicion: "",
                    proce_calidad_id: "",
                    clave_id: "",
                    frecuencia: 1,
                    observaciones: ""
                }
            }
        },

        methods: {
            /***************************** Consultas *****************************************/
            async conLisTable(proc = this.cat_pro, busca = this.buscaProc){
                let datos = {'proceso': proc, 'busca': busca};

                await axios.post('CargaCali/ConLisProce', datos)
                .then(resp => {console.log(resp.data), this.lisa_carga = resp.data})
                .catch(err => {})
            },
            /***************************** Opciones Medicion Fibra ***************************/
            limMeFibra(proc) {
                //console.log(proc)
                this.formMeFibra.ml = "";
                this.formMeFibra.sfc = "";
                this.formMeFibra.calculo_anillo = "";
                this.formMeFibra.calculo_algodon = "";
                this.formMeFibra.composicion = "";
                this.formMeFibra.proce_calidad_id = proc.id;
                this.formMeFibra.clave_id = proc.clave_id;
                this.formMeFibra.frecuencia = 1;
                this.formMeFibra.observaciones = "";
                this.tabla(proc);
            },
            async saveMeFibra(datos){
                datos.user = this.usuario.id;
                this.buMeFi = false;
                await axios.post('CargaCali/saveMeFib', datos)
                .then(resp => {this.errors = [], this.alertSucces(), this.conLisTable(), this.buMeFi = true})
                .catch(err => {this.errors = err.response.data.errors ,this.alertWarning(), this.buMeFi = true})
            },
            tabla(proc){
                //medicion de fibras
                if (proc.proceso_id == 5) {
                    //opciones de frecuencia
                    const fre = function(params){
                        if (params.data.frecuencia == 1) {
                            return "Arranque";
                        }else if (params.data.frecuencia == 2) {
                            return "Seguimiento";
                        }else if(params.data.frecuencia == 3){
                            return "Prueba Extraordinaria";
                        }
                    }

                    //Fecha
                    let fec = function(params) {
                        return moment(params.value).format("DD/MM/YYYY hh:mm:ss")
                    }

                    //comparador ml
                    const fml = function(params) {
                        //console.log(params)
                        if (params.data.cata_medi_fibra_id != null) {
                            if (parseFloat(params.value) >= parseFloat(params.data.cata_medi_fibra.min_ml) &&  parseFloat(params.value) <= parseFloat(params.data.cata_medi_fibra.max_ml)) {
                                return '<label class="tw-text-lime-600">'+parseFloat(params.value)+'</label>';
                            } else {
                                return '<label class="tw-text-red-600">'+parseFloat(params.value)+'</label>';
                            }
                        } else {
                            return '<label class="tw-text-lime-600">'+parseFloat(params.value)+'</label>';
                        }
                    }

                    //comparador sfc
                    const fsfc = function(params) {
                        if (params.data.cata_medi_fibra_id != null) {
                            if (parseFloat(params.value) >= parseFloat(params.data.cata_medi_fibra.min_sfc) &&  parseFloat(params.value) <= parseFloat(params.data.cata_medi_fibra.max_sfc)) {
                                return '<label class="tw-text-lime-600">'+parseFloat(params.value)+'</label>';
                            } else {
                                return '<label class="tw-text-red-600">'+parseFloat(params.value)+'</label>';
                            }
                        } else {
                            return '<label class="tw-text-lime-600">'+parseFloat(params.value)+'</label>';
                        }
                    }

                    //comparador anillo
                    const fanill = function(params) {
                        if (params.data.cata_medi_fibra_id != null) {
                            if (parseFloat(params.value) >= parseFloat(params.data.cata_medi_fibra.min_anillo) &&  parseFloat(params.value) <= parseFloat(params.data.cata_medi_fibra.max_anillo)) {
                                return '<label class="tw-text-lime-600">'+parseFloat(params.value)+'</label>';
                            } else {
                                return '<label class="tw-text-red-600">'+parseFloat(params.value)+'</label>';
                            }
                        } else {
                            return '<label class="tw-text-lime-600">'+parseFloat(params.value)+'</label>';
                        }
                    }

                    //comparador anillo
                    const falgo = function(params) {
                        if (params.data.cata_medi_fibra_id != null) {
                            if (parseFloat(params.value) >= parseFloat(params.data.cata_medi_fibra.min_algodon) &&  parseFloat(params.value) <= parseFloat(params.data.cata_medi_fibra.max_algodon)) {
                                return '<label class="tw-text-lime-600">'+parseFloat(params.value)+'</label>';
                            } else {
                                return '<label class="tw-text-red-600">'+parseFloat(params.value)+'</label>';
                            }
                        } else {
                            return '<label class="tw-text-lime-600">'+parseFloat(params.value)+'</label>';
                        }
                    }

                    //personal
                    const fper = function(params) {
                        //console.log(params)
                        return params.data.perfil_me_fi.Nombre+' '+params.data.perfil_me_fi.ApPat+' '+params.data.perfil_me_fi.ApMat
                    }

                    //opciones para tabla
                    this.encaTabla = [
                        { headerName: "Fecha",  valueGetter: fec },
                        { headerName: "Frecuencia", valueGetter: fre, filter: 'agTextColumnFilter' },
                        { headerName: "ML", field: "ml", cellRenderer: fml, filter: 'agNumberColumnFilter' },
                        { headerName: "SFC", field: "sfc", cellRenderer: fsfc },
                        { headerName: "% Anillo Calculo", field: "ani_cal", cellRenderer: fanill },
                        { headerName: "% Calculo Algodón", field: "algod_cal", cellRenderer: falgo },
                        { headerName: "Composición", field: "composi" },
                        { headerName: "Observaciones", field: "observacion" },
                        { headerName: "Operador", field: "perfil_me_fi.Nombre", cellRenderer: fper }
                    ]
                    //retorno de datos
                    this.datTabla = proc.carg_mefibra;
                }
            }
        },

        computed: {},

        watch: {
            cat_pro: async function(b){
                this.conLisTable(b)
            }
        }


    }
</script>
