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
                <div class="md:tw-flex tw-gap-3">
                    <!-- boton de carga masiva -->
                    <div class="tw-m-3">
                        <button class="btn btn-primary tw-w-full" @click="openModalC">Carga masiva</button>
                    </div>
                    <!-- Boton de filtros -->
                    <div class="tw-m-3">
                        <button class="btn btn-primary tw-w-full" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><i class="fas fa-filter"> </i> Filtros</button>
                    </div>
                    <div class="tw-m-3">
                        <button class="btn tw-bg-green-600 hover:tw-bg-green-700 tw-text-white hover:tw-text-white tw-w-full" data-bs-toggle="collapse" data-bs-target="#grafica" aria-expanded="false" aria-controls="grafica"><i class="fas fa-chart-pie"></i> Graficas</button>
                    </div>
                </div>
            </template>
        </Accions>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Filtros</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="tw-mb-6">
                    <!-- Tipo de reporte -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-mb-0">
                        <jet-label class=""><span class="required">*</span>Tipo de reporte</jet-label>
                        <div class="tw-flex tw-gap-5">
                            <div>
                                <input type="radio" id="uno" value="1" v-model="FoFiltro.TipRepo">
                                <label for="uno" class=""> Produccion</label>
                            </div>
                            <div>
                                <input type="radio" id="dos" value="2" v-model="FoFiltro.TipRepo">
                                <label for="dos" class=""> Paros</label>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="tw-px-3 tw-mb-6">
                        <jet-label class=" tw-text-gray-500">--</jet-label>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <!-- calculos -->
                            <BotonCarga :verBot="vCal" :iconoV="'fas fa-calculator'" :textoV="'Calcular'" :textoOC="'Calculando...'" :class="'btn-success'" @click="calcula(form)"></BotonCarga>
                            <!-- consulta produccion -->
                            <BotonCarga v-if="FoFiltro.TipRepo == 1" :verBot="vTab" :textoV="'Consultar'" :textoOC="'Buscando...'" :class="'btn-primary'" @click="arrProdu()"></BotonCarga>
                            <!-- consulta paros -->
                            <BotonCarga v-if="FoFiltro.TipRepo == 2" :verBot="vTab" :textoV="'Consultar'" :textoOC="'Buscando...'" :class="'btn-primary'" @click="arrParo()"></BotonCarga>
                            <button class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#filtro" aria-expanded="false" aria-controls="filtro">Cerrar</button>
                        </div>

                    </div>

                    <!-- Opciones de consulta -->
                    <div class="tw-px-3 tw-mb-6">
                        <jet-label class="">Opciones de consulta</jet-label>
                        <div class="tw-flex tw-gap-5">
                            <div>
                                <input type="radio" id="Rdia" value="1" v-model="FoFiltro.rango">
                                <label for="Rdia" class=""> Dia</label>
                            </div>
                            <div>
                                <input type="radio" id="Rrango" value="2" v-model="FoFiltro.rango">
                                <label for="Rrango" class=""> Rango</label>
                            </div>
                        </div>
                    </div>

                    <div class="tw-grid tw-gap-2 tw-grid-cols-2 lg:tw-grid-cols-4">
                        <!-- Año -->
                        <div class="">
                            <jet-label class=""><span class="required">*</span>Año</jet-label>
                            <select v-model="FoFiltro.ano" class="InputSelect">
                                <option v-for="y in year" :key="y" :value="y">{{y}}</option>
                            </select>
                        </div>
                        <!-- mes -->
                        <div class="">
                            <jet-label class=""><span class="required">*</span>Mes</jet-label>
                            <select v-model="FoFiltro.mes" class="InputSelect">
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                        <!-- dia -->
                        <div class="">
                            <div>
                                <jet-label class=""><span class="required">*</span>Dia</jet-label>
                                <jet-input type="number" v-model="FoFiltro.dia" class="form-control" min="1" max="31"></jet-input>
                            </div>
                        </div>
                        <!-- Horas
                        <div v-if="FoFiltro.TipRepo == 1">
                            <jet-label class=""><span class="required">*</span>Hora</jet-label>
                            <jet-input type="time" class="form-control" v-model="FoFiltro.hrs"></jet-input>
                        </div> -->
                    </div>

                    <div class="">
                        <!-- semana -->
                        <div class="" v-if="FoFiltro.TipRepo == 1">
                            <jet-label class=""><span class="required">*</span>Semana</jet-label>
                            <jet-input type="week" class="form-control" v-model="FoFiltro.semana"></jet-input>
                        </div>
                    </div>
                </div>

            </div>
        </div>

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
                        <div v-if="S_Area == 7">
                            <!-- Input formulario -->
                            <div class="tw-mt-10 tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 md:tw-mb-0 tw-justify-center">
                                    <jet-label><span class="required">*</span>Carga masiva Producción</jet-label>
                                    <input type="file" class="" @input="docu.file = $event.target.files[0]" ref="file" accept=".xlsx">
                                    <br>
                                    <small v-if="errors.file" class="validation-alert">{{errors.file}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                                    <BotonCarga :verBot="vMasi" :textoV="'Guardar'" :textoOC="'Guardando...'" :class="'btn-primary'" @click="carMasi()"></BotonCarga>
                                </div>
                            </div>
                            <!-- archivo de descarga -->
                            <div class="tw-w-full tw-mt-6 tw-mb-6 md:tw-flex tw-m-auto">
                                <div class="tw-px-3 tw-mb-6 md:tw-mb-0">
                                    <a target="_blank" class="tw-text-blue-600 tw-text-xl" :href="descarga" download="Carga Masiva.xlsx">Descargar Archivo Producción</a>
                                </div>
                            </div>
                        </div>

                        <!------------------------------- Carga masiva -------------------------------->
                        <div v-else>
                            <!-- Input formulario -->
                            <div class="tw-mt-10 tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 md:tw-mb-0 tw-justify-center">
                                    <jet-label><span class="required">*</span>Carga masiva Producción</jet-label>
                                    <input type="file" class="" @input="docu2.file = $event.target.files[0]" ref="file" accept=".xlsx">
                                    <br>
                                    <small v-if="errors.file" class="validation-alert">{{errors.file}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                                    <BotonCarga :verBot="vMasi" :textoV="'Guardar'" :textoOC="'Guardando...'" :class="'btn-primary'" @click="carMatriObje()"></BotonCarga>
                                </div>
                            </div>
                            <!-- archivo de descarga -->
                            <div class="tw-w-full tw-mt-6 tw-mb-6 md:tw-flex tw-m-auto">
                                <div class="tw-px-3 tw-mb-6 md:tw-mb-0">
                                    <a target="_blank" class="tw-text-blue-600 tw-text-xl" :href="descarga2" download="Carga Masiva OE.xlsx">Descargar Archivo Producción</a>
                                </div>
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
    import Header from '@/Components/Header';
    import Accions from '@/Components/Accions';
    import Table from '@/Components/Table';
    import TableBlue from '@/Components/TableBlue';
    import Modal from '@/Jetstream/Modal';
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetLabel from '@/Jetstream/Label';
    import Select2 from 'vue3-select2-component';
    import moment from 'moment';
    import 'moment/locale/es';
    import ActionMessage from '@/Components/ActionMessage'
    import axios from 'axios';
    import BotonCarga from '../../../Components/BotonCarga.vue';
    var Highcharts = require('highcharts');


    export default {
        props: [
            'usuario',
            'depa',
            'claParo',
            'errors'
        ],

        components: {
            AppLayout,
            Header,
            Accions,
            Table,
            BotonCarga,
            TableBlue,
            JetButton,
            JetInput,
            Modal,
            Select2,
            JetLabel,
            ActionMessage,
            JetCancelButton
        },

        data() {
            return {
                color: "tw-bg-blue-600",
                descarga: "",
                descarga2: "",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                procesos: [],
                materiales: [],
                editMode: false,
                showModalC: false,
                showModalCar: false,
                vMasi: true,
                vCal: true,
                vTab: true,
                GrafGua: [],
                hoy: moment().format('YYYY-MM-DD'),
                recoTabla: [],
                recoTablaParo: [], 
                graTipo: [],
                proc_prin: '',
                deli:{
                    elimiMasi: []
                },
                docu: {
                    file: null
                },
                docu2: {
                    file: null
                },
                FoFiltro: {
                    TipRepo: 1,
                    rango: 1,
                    ano: moment().format("YYYY"),
                    mes: null,
                    dia: null,
                    hrs: null,
                    semana: null,
                    iniDia: null,
                    finDia: null,
                },
                form: {
                    fecha: null,
                    hoy: null,
                    mañana: null,
                    depa: this.S_Area
                },
                carga: {
                    id: null,
                    idemp: null,
                    noFecha: moment().format('YYYY-MM-DD HH:mm:ss'),
                    usu: this.usuario.id,
                    nomOpe: null,
                    fecha: null,
                    proceso_id: null,
                    maq_pro_id: null,
                    turno: null,
                    equipo: null,
                    norma: null,
                    clave_id: null,
                    partida: null,
                    valor: null,
                    nota: null
                },
                gPie: {
                    id: null,
                    borra: null,
                    rango: 1,
                    propa: 1,
                    tipo: 'generalMaq',
                    tipoParo: 'total',
                    fecha: null,
                    iniDia: null,
                    finDia: null,
                    titulo: null,
                    paro: [],
                    maquinas: [],
                    procesos: [],
                    norma: [],
                    Nmaquinas: [],
                    Nprocesos: [],
                    Nnorma: [],
                    update: false
                },
                gLinea: {
                    id: null,
                    borra: null,
                    titulo: null,
                    subtitulo: '',
                    rango: 1,
                    tipo: 'generalMaq',
                    fecIni: null,
                    fecFin: null,
                    maquinas: [],
                    procesos: [],
                    Nmaquinas: [],
                    Nprocesos: [],
                    norma: [],
                    update: false
                },
                gBarra: {
                    id: null,
                    borra: null,
                    titulo: null,
                    subtitulo: '',
                    rango: 1,
                    tipo: 'generalMaq',
                    fecIni: null,
                    fecFin: null,
                    maquinas: [],
                    procesos: [],
                    Nmaquinas: [],
                    Nprocesos: [],
                    norma: [],
                    update: false
                },
                gBaLi: {
                    id: null,
                    borra: null,
                    titulo: null,
                    subIz: '',
                    subDe: '',
                    rango: 1,
                    tipo: 'generalMaq',
                    fecIni: null,
                    fecFin: null,
                    maquinasBar: [],
                    procesosBar: [],
                    maquinasLin: [],
                    procesosLin: [],
                    NmaquinasBar: [],
                    NprocesosBar: [],
                    NmaquinasLin: [],
                    NprocesosLin: [],
                    norma: [],
                    update: false
                }
            }
        },

        mounted() {
            this.global();
        },

        methods: {
            /****************************** Funciones generales ****************************/
            global(){
                this.descarga = this.URLactual.host != '192.168.11.3' ? this.path+'Archivos/FormatosExcel/Carga_Masiva.xlsx' : 'http://192.168.11.3/storage/Archivos/FormatosExcel/Carga_Masiva.xlsx';
                this.descarga2 = this.URLactual.host != '192.168.11.3' ? this.path+'Archivos/FormatosExcel/Carga_Masiva_OE.xlsx' : 'http://192.168.11.3/storage/Archivos/FormatosExcel/Carga_Masiva_OE.xlsx';
                if (this.usuario.dep_pers.length == 0) {
                    this.S_Area = 7;
                }else{
                    //Asigna el primer departamento
                    this.S_Area = this.usuario.dep_pers[0].departamento_id;
                    this.usuario.dep_pers.forEach(v => {
                        if (v.departamento_id = this.S_Area) {
                            //asigna
                            this.idDep = v.id;
                        }
                    })
                }
            },
            /****************************** Consultas *************************************/
            //consulta la produccion para la tabla
            async arrProdu(){
                var datos = {}
                this.recoTabla = [];
                this.vTab = false;

                //consulta dia
                if (this.FoFiltro.ano != null & this.FoFiltro.mes != null & this.FoFiltro.dia != null) {
                    let uni = this.FoFiltro.ano+'-'+this.FoFiltro.mes+'-'+this.FoFiltro.dia;
                    var ini = '';
                    var fin = '';
                    if (this.S_Area == 7){
                        if (moment(uni).isDST()) {
                            //console.log('horario verano')
                            ini = uni+' 09:10:00';
                            fin = moment(ini).add(24, 'hours').format('YYYY-MM-DD HH:mm:ss');
                            if (moment(fin).isDST() == false) {
                                fin = moment(fin).subtract(1, 'hours').format("YYYY-MM-DD[T]HH:mm")
                            }
                        }else{
                            //console.log('horario invierno')
                            ini = uni+' 08:10:00';
                            fin = moment(ini).add(24, 'hours').format('YYYY-MM-DD HH:mm:ss');
                            if (moment(fin).isDST() == true) {
                                fin = moment(fin).add(1, 'hours').format("YYYY-MM-DD[T]HH:mm")
                            }
                        }
                    } 
                    else{
                        ini = uni+' 07:00:00'
                        fin = moment(ini).add(24, 'hours').format('YYYY-MM-DD HH:mm:ss');
                    }

                    //Asigna el dato para la fecha final
                    datos = {'departamento_id': this.S_Area, 'tipo': 'dia', 'iniDia': ini, 'finDia': fin, 'semana': null, 'mes': null, 'ano': null }
                }
                //input semana no nulo
                else if (this.FoFiltro.semana != null) {
                    datos = {'departamento_id': this.S_Area, 'tipo': 'semana', 'iniDia': null, 'finDia': null, 'semana': this.FoFiltro.semana, 'mes': null, 'ano': null }
                }
                //consulta mes
                else if(this.FoFiltro.ano != null & this.FoFiltro.mes != null){
                    datos = {'departamento_id': this.S_Area, 'tipo': 'mes', 'iniDia': null, 'finDia': null, 'semana': null, 'mes': this.FoFiltro.ano+'-'+this.FoFiltro.mes, 'ano': null }
                }
                //consulta año
                else if(this.FoFiltro.ano != null){
                    datos = {'departamento_id': this.S_Area, 'tipo': 'ano', 'iniDia': null, 'finDia': null, 'semana': null, 'mes': null, 'ano': this.FoFiltro.ano }
                }

                //asigna el recorrido
                let promesa = await axios.post('ReportesPro/ConPro', datos)
                .then(eve => {console.log(eve)})
                .catch(err => {console.log(err)})
                //this.recoTabla = promesa.data
                this.vTab = true;
            },
            /***************************** Carga Masiva ************************************/
            async carMasi(){
                this.vMasi = false;
                const form = this.docu;
                await this.$inertia.post('/Produccion/CargaExcel', form, {
                    onSuccess: (v) => { this.openModalC(), this.resetC(), this.alertSucces(), this.vMasi = true, this.arrProdu() },
                    onError: (e) => { this.vMasi = true },
                    preserveState: true
                });
            },
            /**************************** Carga Matriz Objetivos *****************************/
            async carMatriObje(){
                let form = this.docu2;
                if (this.S_Area == 8) {
                    await this.$inertia.post('/Produccion/cargaAnillo', form, {
                        onSuccess: (v) => { this.openModalC(), this.resetC(), this.alertSucces(), this.arrProdu() },
                        onError: (e) => { this.vMasi = true },
                        preserveState: true
                    });
                } else {
                    await this.$inertia.post('/Produccion/impoMatriz', form, {
                        onSuccess: (v) => { this.openModalC(), this.resetC(), this.alertSucces(), this.arrProdu() },
                        onError: (e) => { this.vMasi = true },
                        preserveState: true
                    });
                }
                /* await axios.post('/Produccion/impoMatriz', this.docu)
                .then(eve => {console.log(eve.data)})
                .catch(err => {console.log(err.response.data.errors)}); */
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
                this.docu.file = null;
                this.docu2.file = null
            },
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

            //Opciones Normas
            opcNM: function() {
                const nm = [];
                this.materiales.forEach(ma => {
                    nm.push({id: ma.id, text: ma.materiales.idmat+' - '+ma.materiales.nommat});
                })
                return nm;
            },

            //Opciones Claves
            opcCL: function() {
                const scl = [];
                /* this.form.clave_id = ''; */
                if (this.carga.norma != '') {
                    this.materiales.forEach(cl => {
                        if (this.carga.norma == cl.id) {
                            //console.log(cl.claves)
                            cl.claves.forEach(c => {
                                scl.push({id: c.id, text: c.CVE_ART+ ' - ' + c.DESCR})
                            })
                        }
                    })
                }
                return scl;
            },

            //Opciones procesos principales
            opcPP: function() {
                const ppi = [];
                this.procesos.forEach(pp =>{
                    if (pp.tipo == 0) {
                        ppi.push({text: pp.nompro, value: pp.id})
                    }
                });
                return ppi;
            },

            //Opciones subprocesos
            opcSP: function() {
                const ssp = [];
                //recorre y muestra los procesos
                this.procesos.forEach(sp =>{
                    if (sp.proceso_id == this.proc_prin) {
                        ssp.push({id: sp.id, text: sp.id+' - '+sp.nompro});
                    }
                })
                return ssp;
            },

            //Opciones de paros
            opcPR: function() {
                //select paros
                var pr = []
                this.claParo.forEach(pa => {
                    pr.push({id: pa.id, text: pa.clave+' - '+pa.descri });
                })
                return pr;
            },

            //Opciones maquinas de procesos
            opcMQ: function() {
                const mq = [];
                var mar = '';
                if (this.carga.proceso_id != '') {
                    this.procesos.forEach(pm => {
                        if (this.carga.proceso_id == pm.id) {
                            //console.log(pm.maq_pros.length)
                            pm.maq_pros.forEach(mp => {
                                mar = mp.maquinas.marca == null ? 'N/A' :  mp.maquinas.marca.Nombre
                                mq.push({id: mp.id, text: mp.id+' - '+mp.maquinas.Nombre + ' ' + mar});
                            })
                        }
                    })
                }
                return mq;
            },

            //Opciones Maquinas
            opcMaq: function() {
                const mq = [];
                var mar = '';
                this.procesos.forEach(pm => {
                    pm.maq_pros.forEach(mp => {
                        mar = mp.maquinas.marca == null ? 'N/A' :  mp.maquinas.marca.Nombre
                        mq.push({id: mp.id, text: pm.nompro + ': ' + mp.maquinas.Nombre + ' ' + mar})
                    })
                })
                return mq;
            },

            //procesos Graficas
            proGrafi: function() {
                var grafi = [];
                if (this.gPie.tipo == 'efiTur') {
                    this.procesos.forEach(gr => {
                        if (gr.tipo == 3 & gr.operacion == 'efi_tur') {
                            grafi.push({id: gr.id, text:gr.nompro})
                            //console.log(gr)
                        }
                    })
                }else if(this.gPie.tipo == 'efiDia'){
                    this.procesos.forEach(gr => {
                        if (gr.tipo == 3 & gr.operacion == 'efi_dia') {
                            console.log(gr)
                            grafi.push({id: gr.id, text:gr.nompro})
                            //console.log(gr)
                        }
                    })
                }else{
                    this.procesos.forEach(gr => {
                        if (gr.tipo != 0) {
                            grafi.push({id: gr.id, text:gr.nompro})
                        }
                    })
                }
                return grafi;
            },

            //Opciones de tipo
            opcTipo: function() {
                const arreg = [
                    {id: 'generalTot', text: 'General Procesos'},
                    {id: 'generalMaq', text: 'General Maquinas'},
                    {id: 'catego', text: 'Categoria'},
                    {id: 'norma', text: 'Norma'},
                    {id: 'partida', text: 'Partida'},
                    {id: 'equipo', text: 'Equipo'},
                    {id: 'efiTur', text: 'Eficiencia por equipo'},
                    {id: 'efiDia', text: 'Eficiencia General'}
                ]
                return arreg;
            },

            opcTipoOt: function() {
                const arreg = [
                    {id: 'generalTot', text: 'General Procesos'},
                    {id: 'generalMaq', text: 'General Maquinas'}
                ]
                return arreg;
            },

            opcTipoParo: function() {
                const arreg = [
                    {id: 'total', text: 'Total'},
                    {id: 'separa', text: 'Separado'}
                ]
                return arreg;
            },

            //input año
            year: function() {
                let anoIni = moment().format('YYYY');
                //console.log(anoIni-10)
                const anos = [];
                for (let index = anoIni; index > anoIni-10; index--) {
                    //const element = array[index];
                    anos.push(parseInt(index))
                    //console.log(index)
                }
                return anos;
            }

        },

        watch: {
            S_Area: async function(b){
                this.FoFiltro.iniDia = this.hoy;

                //this.arrProdu();
                //this.arrParo();

                var datos = {'departamento_id': this.S_Area, 'modulo': 'repoPro'};

                //Produccion
                let produ = await axios.post('General/ConProduccion', datos)
                this.procesos = produ.data;

                //Materiales
                let mate = await axios.post('General/ConMateriales', datos)
                this.materiales = mate.data
            },
        }

    }
</script>
