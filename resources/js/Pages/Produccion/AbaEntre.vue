<template>
    <app-layout>
        <Header :class="['tw-bg-blue-600', 'tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl']">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-folder-open"></i>
                        Abastos y Entregas
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
        </Accions>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" @click="ConAba(S_Area, busAbas)">Abastos</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" @click="resetEntr()" aria-selected="false">Entregas</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <!-- Abastos -->
            <div class="tab-pane fade show active tw-p-5 overflow-auto" style="height: 70vh" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="tw-w-full tw-m-6">
                    <div class="tw-w-full md:tw-w-2/4 lg:tw-w-1/4 tw-ml-auto tw-p-3">
                        <input type="search" v-model="busAbas" class="InputSelect" @keyup="ConAba(S_Area, busAbas)" placeholder="Buscar partida">
                    </div>
                </div>
                <div class="tw-grid tw-gap-x-2 tw-gap-y-4 md:tw-grid-cols-2 lg:tw-grid-cols-3">
                    <!-- cuerpo tarjeta -->
                    <div class="card tw-shadow-xl" v-for="ae in abaentre" :key="ae">
                        <!-- info tarjeta -->
                        <div :class="'card-body '+color(ae)">
                            <table class="tw-w-full">
                                <tr>
                                    <th colspan="2" class=" tw-text-center">
                                        <div class="tw-w-1/2 input-group input-group-sm" v-if="editPar == ae.id">
                                            <input type="text" class="form-control" v-model="ae.partida" @keyup.enter="updatParti(ae)" @input="(val) => (ae.partida = ae.partida.toUpperCase())">
                                            <button class="input-group-text btn btn-success" :id="'Guar'+ae.id" @click="updatParti(ae)"><i class="fas fa-save"></i></button>
                                            <button class="input-group-text btn btn-danger" :id="'close'+ae.id" @click="editPar = ''"><i class="fas fa-times"></i></button>
                                        </div>
                                        <label class="tw-text-cyan-600 hover:tw-text-xl tw-cursor-pointer" @click="changePart(ae.id)" tooltip="Editar partida" flow="left" v-else>
                                            <i class="fas fa-pen"></i> {{ ae.partida }}
                                        </label> /-\
                                        <label class=" tw-text-teal-600 hover:tw-text-xl">{{ ae.folio2 }}</label>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>{{ ae.total }}</td>
                                </tr>
                                <tr>
                                    <th>Estatus:</th>
                                    <td>
                                        <select class="tw-rounded tw-rounded-md tw-bg-transparent tw-w-full" v-model="ae.estatus" @change="finEstaAbas(ae)">
                                            <option value="1">Activar</option>
                                            <option value="2">En espera</option>
                                            <option value="0">Finalizar</option>
                                            <option value="3" disabled>Desactivado</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- Acordion -->
                        <div class="accordion accordion-flush" :id="'accordion'+ae.id">
                            <!-- Claves producto final -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" :id="'opcla'+ae.id">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#flushCla'+ae.id" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Producto final
                                    </button>
                                </h2>
                                <div :id="'flushCla'+ae.id" class="accordion-collapse collapse" :aria-labelledby="'opcla'+ae.id" :data-bs-parent="'#accordion'+ae.id">
                                    <div class="accordion-body overflow-auto" style="height: 10rem">
                                        <div class="tw-grid tw-gap-x-2 tw-gap-y-4 tw-grid-cols-2">
                                            <div class="card tw-shadow-xl" v-for="cl in ae.proc_final_aba" :key="cl">
                                                <div class="tw-w-full">
                                                    <select v-model="cl.estatus" class="tw-rounded tw-rounded-md tw-bg-transparent tw-w-full" @change="estaProcFin(cl)">
                                                        <option value="1">Activo</option>
                                                        <option value="2">Desactivar</option>
                                                    </select>
                                                </div>
                                                <div class="hover:tw-border hover:tw-border-4 hover:tw-border-teal-300">
                                                    <div class="tw-w-full">
                                                        <strong>Norma:</strong> {{ cl.norma.materiales.idmat }}
                                                    </div>
                                                    <div class="tw-w-full">
                                                        <strong>Clave:</strong> {{ cl.clave.CVE_ART }}
                                                    </div>
                                                    <div class="tw-w-full">
                                                        <strong>Descripción:</strong> {{ cl.clave.DESCR }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Abastos -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" :id="'open'+ae.id">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#flushOne'+ae.id" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Abasto
                                    </button>
                                </h2>
                                <div :id="'flushOne'+ae.id" class="accordion-collapse collapse" :aria-labelledby="'open'+ae.id" :data-bs-parent="'#accordion'+ae.id">
                                    <div class="accordion-body overflow-auto" style="height: 10rem">
                                        <div class="tw-grid tw-gap-x-2 tw-gap-y-4 tw-grid-cols-2">
                                            <div class="card tw-shadow-xl hover:tw-border hover:tw-border-4 hover:tw-border-teal-300 tw-cursor-pointer" v-for="ab in ae.aba_entregas" :key="ab">
                                                <div>
                                                    <strong>Folio:</strong> {{ ab.folio }}
                                                </div>
                                                <div>
                                                    <strong>Banco:</strong> {{ ab.banco }}
                                                </div>
                                                <div>
                                                    <strong>Total:</strong> {{ ab.total }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Produccion -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" :id="'open2'+ae.id">
                                    <button class="accordion-button collapsed" :id="'bo'+ae.id" type="button" @click="conProdu(ae)" data-bs-toggle="collapse" :data-bs-target="'#flushTwo'+ae.id" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        Producción
                                    </button>
                                </h2>
                                <div :id="'flushTwo'+ae.id" class="accordion-collapse collapse" :aria-labelledby="'open2'+ae.id" :data-bs-parent="'#accordion'+ae.id">
                                    <!-- recorrido maquinas produccion -->
                                    <div class="tw-flex accordion-body justify-items-end overflow-auto" style="height: 12rem">
                                        <div class="tw-grid tw-gap-x-2 tw-gap-y-4 tw-grid-cols-2">
                                            <div class="tw-rounded-md hover:tw-border hover:tw-border-4 hover:tw-border-teal-300" v-for="ap in abaPro" :key="ap">
                                                <div class="tw-m-auto">
                                                    <strong> {{ ap.proceso.nompro }} {{ ap.maq_pro ? ap.maq_pro.maquinas.Nombre : 'N/A' }}: </strong>
                                                </div>
                                                <div class="tw-m-auto">
                                                    {{ ap.valor.toFixed(2) }} {{ ap.clave.UNI_MED }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- restante abasto -->
                                    <div class="tw-z-10">
                                        <div class="tw-m-auto tw-text-xl">
                                            <strong>Abasto restante: </strong>
                                            <label>
                                                {{ resProdu(ae, abaPro) }}
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Entregas -->
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <!-- select de partidas -->
                <div class="tw-p-3 lg:tw-flex">
                    <!-- Select Area -->
                    <div class="tw-px-3 lg:tw-w-4/12 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Departamento para entregar</jet-label>
                        <select class="InputSelect" v-model="formAba.departamento_id" @change="buscaNorma">
                            <option value="">SELECCIONA</option>
                            <option v-for="dep in opcDep" :key="dep" :value="dep.id">{{ dep.text }}</option>
                        </select>
                        <small v-if="errors.departamento_id" class="validation-alert">{{errors.departamento_id}}</small>
                    </div>
                    <!-- partida -->
                    <div class="tw-px-3 lg:tw-w-4/12 lg:tw-mb-0" v-if="formAba.departamento_id != ''">
                        <jet-label><span class="required">*</span>Partida</jet-label>
                        <div class="input-group">
                            <!-- selector para saber si existe o no la partida -->
                            <select class="input-group-text tw-w-2/5" id="btnGroupAddon" @click="busPart" v-model="formAba.abasExis">
                                <option value="">Nueva partida</option>
                                <option value="1">Partida existente</option>
                            </select>
                            <!-- si no existe partida manda input -->
                            <input v-if="formAba.abasExis == ''" v-model="formAba.partida" @input="(val) => (formAba.partida = formAba.partida.toUpperCase())" type="text" class="form-control" placeholder="Ingresa una partida" aria-label="Input group example" aria-describedby="btnGroupAddon">
                            <!-- si existe te enlista las partidas activas -->
                            <select v-else v-model="formAba.partida" class="form-select tw-w-3/5">
                                <option v-for="ab in opcAbas" :key="ab" :value="ab.id"> {{ ab.text }} </option>
                            </select>
                        </div>
                        <small v-if="errors.partida" class="validation-alert">{{errors.partida}}</small>
                    </div>
                </div>
                <!-- Proceso proncipal, sub procesos, operador -->
                <div class="tw-p-3 lg:tw-flex">
                    <!-- input Folio -->
                    <div class="tw-px-3 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Folio</jet-label>
                        <jet-input class="InputSelect" v-model="formAba.folio" @input="(val) => (formAba.folio = formAba.folio.toUpperCase())"></jet-input>
                        <small v-if="errors.folio" class="validation-alert">{{errors.folio}}</small>
                    </div>
                    <!-- input Banco -->
                    <div class="tw-px-3 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label>Banco</jet-label>
                        <jet-input class="InputSelect" v-model="formAba.banco" @input="(val) => (formAba.banco = formAba.banco.toUpperCase())"></jet-input>
                        <small v-if="errors.banco" class="validation-alert">{{errors.banco}}</small>
                    </div>
                    <!-- input total -->
                    <div class="tw-px-3 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label>Total</jet-label>
                        <jet-input type="number" class="InputSelect" v-model="formAba.total"></jet-input>
                        <small v-if="errors.total" class="validation-alert">{{errors.total}}</small>
                    </div>
                </div>
                <!-- normas, claves -->
                <div class="tw-my-4" v-if="formAba.departamento_id != ''">
                    <!-- boton para agregar procesos -->
                    <div class="tw-flex tw-justify-center">
                        <button type="button" class="btn btn-primary tw-w-1/4" @click="addForRow()"><i class="fas fa-plus"></i></button>
                    </div>
                    <!-- recorrido norma claves -->
                    <div class="tw-grid tw-gap-x-2 tw-gap-y-4 md:tw-grid-cols-2 lg:tw-grid-cols-4 tw-overflow-auto" style="height: 35vh">
                        <div class="tw-shadow-lg tw-p-4" v-for="(nc, index) in formAba.produ" :key="nc">
                            <div class="tw-px-3 lg:tw-mb-0">
                                <jet-label><span class="required">*</span>Norma</jet-label>
                                <div class="input-group">
                                    <select class="tw-rounded tw-rounded-md tw-bg-transparent tw-w-full form-select" id="quitButon" v-model="nc.norma">
                                        <option value="" disabled>SELECCIONA</option>
                                        <option v-for="nm in opcNM2" :key="nm" :value="nm.value">{{nm.text}}</option>
                                    </select>
                                    <button type="button" class="btn btn-danger input-group-text" aria-describedby="quitButon" @click="removeForRow(index)">Quitar</button>
                                </div>
                            </div>
                            <div class="tw-px-3 lg:tw-mb-0">
                                <jet-label><span class="required">*</span>Clave</jet-label>
                                <Select2 v-model="nc.clave" class="tw-rounded tw-rounded-md tw-bg-transparent" :settings="{width: '100%', allowClear: true}" :options="opcCL2(nc)"/>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- boton deguardado -->
                <div class="lg:tw-flex tw-justify-center" v-if="S_Area != ''">
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0 d-grid gap-2">
                        <button type="button" class="btn btn-success" @click="saveEntre(formAba)">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    </app-layout>
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header';
    import Accions from '@/Components/Accions';
    import TableGreen from '@/Components/TableTeal';
    import JetLabel from '@/Jetstream/Label';
    import JetInput from '@/Components/Input';
    import Select2 from 'vue3-select2-component';
    import Modal from '@/Jetstream/Modal';
    import axios from 'axios';
    import moment from 'moment';
    import 'moment/locale/es';
    import Table from '@/Components/Table';
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

    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    window.JSZip = jszip;

    export default {
        props: [
            'usuario',
            'depa',
            'depaT'
        ],
        components: {
            AppLayout,
            Header,
            Accions,
            TableGreen,
            JetLabel,
            JetInput,
            Select2,
            Modal
        },

        data() {
            return {
                S_Area: '',
                carga: [],
                materiales: [],
                materiales2: [],
                abaentre: [],
                abaPro: [],
                errors: [],
                abafin: [],
                optPart: [],
                busAbas: "",
                editPar: "",
                showModal: false,
                formAba: {
                    id: '',
                    partida: '',
                    folio: '',
                    banco: '',
                    total: 0,
                    abasExis: '',
                    perfi_abas: this.usuario.id,
                    esta_inicio: '',
                    esta_final: '',
                    departamento_id: '',
                    produ: [{
                        norma: '',
                        clave: null,
                    }]
                },
                formBus:{
                    fechaini: '',
                    fechafin: '',
                    departamento: ''
                }
            }
        },

        mounted() {
            this.global();
        },

        methods: {
            /************************************* Consultas ***********************************/
            async conProdu(dat){
                this.abaPro = [];
                this.abaentre.forEach(re => {
                    if(re.id != dat.id){
                        $('#bo'+re.id).addClass('collapsed');
                        $('#flushTwo'+re.id).removeClass('show');
                        $('#bo'+re.id).attr('aria-expanded', false);
                    }
                })
                //console.log(dat)
                let ab = await axios.post('AbaEntre/ConAbaPro', dat);
                //console.log(ab.data)
                this.abaPro = ab.data;
            },
            resProdu(aba, res){
                let sum = 0;
                res.forEach(resu => {
                    if(resu.proceso.tipo != 1){
                        //console.log(resu)
                        sum += resu.valor
                    }
                })
                let resta = aba.total-sum;

                return aba.total+'Kg - '+sum.toFixed(2)+'Kg = '+resta.toFixed(2)+'Kg';
            },
            //Consulta de abastos
            async ConAba(depa, bus){
                this.editPar = "";
                var datos = {'departamento_id': depa, 'modulo': 'abaEntre', 'busca': bus};
                //console.log(datos)
                //abasto entregas
                let aba = await axios.post('AbaEntre/conabaent', datos);
                //console.log(aba.data)
                this.abaentre = aba.data;
            },
            /************************************* Globales ************************************/
            color(data){
                if (data.estatus == '1') {
                    return 'tw-bg-green-50';
                } else if(data.estatus == '2') {
                    return 'tw-bg-blue-50';
                }else {
                    return 'tw-bg-red-50';
                }
            },
            global(){
                if (this.usuario.dep_pers.length == 0) {
                    this.S_Area = 7;
                }else{
                    //Asigna el primer departamento
                    this.S_Area = this.usuario.dep_pers[0].departamento_id;
                }
            },
            /************************************* Entregas guardar y pasar a otro departamento */
            async saveEntre(data){
                data.depa_recibe = this.S_Area;
                data.esta_inicio = 'Revisando';
                data.esta_final = 'Desactivado';
                this.errors = []
                await axios.post('AbaEntre/entIns', data)
                .then(dat => {this.resetEntr(), this.alertSucces()})
                .catch(err => {this.errors = err.response.data.errors, this.alertWarning()})
            },
            resetEntr(){
                this.errors = [];
                this.editPar = "";
                this.optPart =  []
                this.busAbas = "";
                this.formAba.id = '';
                this.formAba.partida = '';
                this.formAba.folio = '';
                this.formAba.banco = '';
                this.formAba.total = 0;
                this.formAba.abasExis = '';
                this.formAba.esta_inicio = '';
                this.formAba.esta_final = '';
                this.formAba.departamento_id = '';
                this.formAba.produ = [{ norma: '', clave: null }];
            },
            async buscaNorma(event){
                this.formAba.produ = [{ norma: '', clave: null }];
                var datos = {'departamento_id': event.target.value, 'modulo': 'abaEntre'};
                this.optPart =  [];

                let mate = await axios.post('General/ConMateriales', datos)
                this.materiales2 = mate.data

                //consulta partidas
                this.formAba.partida = "";
                this.ConAba(this.formAba.departamento_id, this.busAbas);
            },
            async busPart(event){
                this.formAba.partida = "";
            },
            /************************************** Finciones de abastos *****************/
            //Cambio de estatus a la partida o admin abasto
            async estaParti(dat){
                await axios.post('AbaEntre/EstatusParti', dat)
                .then(resp => {this.ConAba(this.S_Area, this.busAbas, this.alertSucces())})
            },
            finEstaAbas(dat){
                //console.log(dat)
                if (dat.estatus == "0") {
                    Swal.fire({
                        title: 'Finalizar Abasto?',
                        html: "Estas seguro de finalizar la partida <strong>"+dat.partida+"</strong>?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Finalizar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                            'Actualizado!',
                            'El registro se actualizo correctamente.',
                            'success'
                            )
                            this.estaParti(dat)
                        }else{
                            dat.estatus = "2";
                            this.estaParti(dat)
                        }
                    })
                }else{
                    this.estaParti(dat)
                }
            },
            //Cambio de estatus al producto final
            async estaProcFin(dat){
                await axios.post('AbaEntre/EstatusProcFin', dat)
                .then(resp => {this.alertSucces()})
            },
            //Edicion de partida
            changePart(data){
                this.editPar = data;
            },
            alertWarningPart() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });

                Toast.fire({
                    icon: "warning",
                    title: "Esta partida ya existe",
                    // background: '#FDBA74',
                });
            },
            async updatParti(da){
                await axios.post('AbaEntre/UpdaPart', da)
                .then(resp => {this.resetEntr(), this.alertSucces()})
                .catch(err => {this.alertWarningPart()})
                //console.log(da)
            },
            /************************** agrega inputs a formulas  ************************/
            addForRow: function () {
                this.formAba.produ.push({norma: "", clave: null,});
            },
            removeForRow: function (row) {
                this.formAba.produ.splice(row,1);
            },
            /************************************* Opciones ************************************/
            opcCL2(da){
                //console.log(da)
                const scl = [];
                if (da.norma != '') {
                    this.materiales2.forEach(cl => {
                        if (da.norma == cl.id) {
                            //console.log(cl.claves)
                            cl.claves.forEach(c => {
                                scl.push({id: c.id, text: c.CVE_ART+ ' - ' + c.DESCR})
                            })
                        }
                    })
                }
                return scl;
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
            opcDep: function() {
                const dep = [];
                this.depaT.forEach(val => {
                    dep.push({id: val.id, text: val.Nombre})
                })
                return dep;
            },
            //Opciones Normas
            opcNM: function() {
                const nm = [];
                this.materiales.forEach(ma => {
                    nm.push({value: ma.id, text: ma.materiales.idmat+' - '+ma.materiales.nommat});
                })
                return nm;
            },
            //Opciones Normas
            opcNM2: function() {
                const nm = [];
                this.materiales2.forEach(ma => {
                    nm.push({value: ma.id, text: ma.materiales.idmat+' - '+ma.materiales.nommat});
                })
                return nm;
            },
            //Opciones abastos
            opcAbas: function() {
                const aba = [];
                this.abaentre.forEach(ab => {
                    aba.push({id: ab.id, text: ab.partida});
                })
                return aba;
            }
        },

        watch: {
            S_Area: async function(b){

                var datos = {'departamento_id': this.S_Area, 'modulo': 'abaEntre'};

                //Produccion
                let car = await axios.post('AbaEntre/Carga', datos)
                this.carga = car.data;

                //Materiales
                /* let mate = await axios.post('General/ConMateriales', datos)
                this.materiales = mate.data */

                //abasto entregas
                let aba = await axios.post('AbaEntre/conabaent', datos);
                this.abaentre = aba.data;
            },
        }
    }
</script>
