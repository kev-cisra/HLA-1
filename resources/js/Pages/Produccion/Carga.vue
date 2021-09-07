<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-toolbox"></i>
                        Carga de datos
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <select @change="verTabla" class="InputSelect" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer">Cargar datos</jet-button>
                <jet-button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Agregar Reporte</jet-button>
            </template>
        </Accions>
        <!------------------------------------ carga de datos de personal y areas ---------------------------------------->
        <div class="collapse m-5 tw-p-6 tw-bg-blue-300 tw-rounded-3xl tw-shadow-xl" id="agPer">
            <div class="tw-mb-6 md:tw-flex">
                <!--<div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="veFec">
                    <jet-label><span class="required">*</span>Fecha</jet-label>
                    <jet-input type="date" :min="diaIni" :max="diaFin" v-model="form.fecha"></jet-input>
                    <small v-if="errors.fecha" class="validation-alert">{{errors.fecha}}</small>
                     <input type="datetime-local" name="" id="">
                </div>-->
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Proceso proncipal</jet-label>
                    <select class="InputSelect" @change="seleSP" v-model="proc_prin" v-html="opcPP"></select>
                    <small v-if="errors.proc_prin" class="validation-alert">{{errors.proc_prin}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="opcSP">
                    <jet-label><span class="required">*</span>Sub proceso </jet-label>
                    <select class="InputSelect" v-model="form.proceso_id" @change="seleMQ" v-html="opcSP"></select>
                    <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="ocuPE">
                    <jet-label><span class="required">*</span>Operador</jet-label>
                    <select class="InputSelect" @change="eq_tu" v-model="form.dep_perf_id" v-html="opcPE"></select>
                    <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                </div>
            </div>
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0"  v-if="veMa">
                    <jet-label><span class="required">*</span>Maquinas</jet-label>
                    <select class="InputSelect" v-model="form.maq_pro_id" v-html="opcMQ"></select>
                    <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/5 md:tw-mb-0" v-if="usuario.dep_pers[0].ope_puesto != 'cor'">
                    <jet-label><span class="required">*</span>Norma</jet-label>
                    <select class="InputSelect" @change="seleCL" v-model="form.norma" v-html="opcNM"></select>
                    <small v-if="errors.norma" class="validation-alert">{{errors.norma}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/5 md:tw-mb-0" v-if="usuario.dep_pers[0].ope_puesto != 'cor'">
                    <jet-label><span class="required">*</span>Clave</jet-label>
                    <select class="InputSelect" v-model="form.clave_id" v-html="opcCL"></select>
                    <small v-if="errors.clave_id" class="validation-alert">{{errors.clave_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/5 md:tw-mb-0">
                    <jet-label>Partida</jet-label>
                    <jet-input class="InputSelect" v-model="form.partida"></jet-input>
                    <small v-if="errors.partida" class="validation-alert">{{errors.partida}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 tw-w-full md:tw-w-1/5 md:tw-mb-0">
                    <jet-label><span class="required">*</span>KG</jet-label>
                    <jet-input type="number" min="0" class="InputSelect tw-bg-lime-300" v-model="form.valor"></jet-input>
                    <small v-if="errors.valor" class="validation-alert">{{errors.valor}}</small>
                </div>
            </div>
            <div class="w-100 tw-mx-auto" align="center">
                <jet-button type="button" class="tw-mx-auto" @click="saveCA(form)">Guardar</jet-button>
            </div>
        </div>
        <pre>
            {{ cargas }}
        </pre>
        <!------------------------------------ Data table de carga ------------------------------------------------------->
        <div class="table-responsive">
            <Table id="t_carg">
                <template v-slot:TableHeader>
                    <th class="columna">Fecha</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Equipo</th>
                    <th class="columna">Turno</th>
                    <th class="columna">Partida</th>
                    <th class="columna">Norma</th>
                    <th class="columna">Clave</th>
                    <th class="columna">Maquina</th>
                    <th class="columna">KG</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <!-- <tr v-for="pe in personal" :key="pe">
                        <div v-for="ca in pe.cargas" :key="ca">
                            <td class="fila">{{ca.fecha}}</td>
                            <td class="fila">{{pe.perfiles.Nombre}} {{pe.perfiles.ApPat}} {{pe.perfiles.ApMat}}</td>
                            <td class="fila">Departamento</td>
                            <td class="fila">Equipo</td>
                            <td class="fila">Turno</td>
                            <td class="fila">Partida</td>
                            <td class="fila">Norma</td>
                            <td class="fila">Clave</td>
                            <td class="fila">Maquina</td>
                            <td class="fila">KG</td>
                            <td></td>
                        </div>
                    </tr> -->
                </template>
            </Table>
        </div>
        <!--------------------------------------- Carga de reportes y datatable ------------------------------------------->
        <div class="offcanvas offcanvas-bottom tw-h-5/6" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Reportes</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="tw-p-6 tw-bg-blue-300 tw-rounded-3xl">
                    <div class="tw-mb-6 md:tw-flex">
                        <!--<div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>Departamento </jet-label>
                            <select class="InputSelect" v-model="form.departamento_id" v-html="opc"></select>
                            <small v-if="errors.departamento_id" class="validation-alert">{{errors.departamento_id}}</small>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>Material </jet-label>
                            <jet-input type="text" list="per" v-model="form.material_id"></jet-input>
                            <small v-if="errors.material_id" class="validation-alert">{{errors.material_id}}</small>
                            <datalist id="per">
                                <option v-for="material in materiales" :key="material" :value="material.id">{{ material.idmat }} - {{ material.nommat }}</option>
                            </datalist>
                        </div>-->
                    </div>
                    <div class="w-100 tw-mx-auto" align="center">
                        <jet-button type="button" class="tw-mx-auto" @click="saveDM(form)">Guardar</jet-button>
                    </div>
                </div>
                <table id="t_rep" >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Shad Decker</td>
                            <td>Regional Director</td>
                            <td>Edinburgh</td>
                            <td>51</td>
                            <td>2008/11/13</td>
                            <td>$183,000</td>
                        </tr>
                        <tr>
                            <td>Michael Bruce</td>
                            <td>Javascript Developer</td>
                            <td>Singapore</td>
                            <td>29</td>
                            <td>2011/06/27</td>
                            <td>$183,000</td>
                        </tr>
                        <tr>
                            <td>Donna Snider</td>
                            <td>Customer Support</td>
                            <td>New York</td>
                            <td>27</td>
                            <td>2011/01/25</td>
                            <td>$112,000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table'
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetSelect from '@/Components/Select';
    import JetLabel from '@/Jetstream/Label';
    import Select from '../../Components/Select.vue';
    //datatable
    import datatable from 'datatables.net-bs5';
    import $ from 'jquery';

    import moment from 'moment';
    import 'moment/locale/es';

    export default {
        props: [
            'usuario',
            'depa',
            'cargas',
            'procesos',
            'materiales',
            'personal',
            'cargas',
            'errors'
        ],
        components: {
            AppLayout,
            Header,
            Accions,
            Table,
            JetButton,
            JetCancelButton,
            JetInput,
            JetSelect,
            JetLabel
        },
        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                s1: '',
                S_Area: '',
                ocuPE: true,
                veFec: true,
                veMa: false,
                opc: '<option value="" disabled>Selecciona</option>',
                opcPP: '',
                opcSP: '',
                opcPE: '',
                opcMQ: '',
                opcNM: '<option value="" disabled>Selecciona</option>',
                opcCL: '<option value="" disabled>SELECCIONA</option>',
                proc_prin: '',
                norma: '',
                diaIni: moment().format("YYYY-MM-DD"),
                diaFin: moment().weekday(6).format("YYYY-MM-DD"),
                form: {
                    //fecha: moment().format("YYYY-MM-DD H:mm:ss"),
                    semana: moment().format("GGGG-[W]WW"),
                    per_carga: '',
                    proceso_id: '',
                    dep_perf_id: '',
                    maq_pro_id: '',
                    partida: '',
                    valor: '',
                    norma: '',
                    equipo_id: '',
                    clave_id: '',
                    turno_id: '',
                }
            }
        },
        mounted() {
            this.mostSelect();
            this.tabla();
            this.tablaRep();
            this.selePP();
            this.selePE();
            this.seleNM();
        },
        methods: {
            /****************************** opciones de selec del departamento *****************************/
            //información del select area
            mostSelect() {
                this.$nextTick(() => {
                    this.depa.forEach(r => {
                        if (r.departamentos) {
                            this.opc += `<option value="${r.departamentos.id}"> ${r.departamentos.Nombre} </option>`;
                        }else{
                            this.opc += `<option value="${r.id}"> ${r.Nombre} </option>`;
                            r.sub__departamentos.forEach(rr => {
                                this.opc += `<option value="${rr.id}"> ${rr.Nombre} </option>`;
                                //console.log(rr.Nombre);
                            })
                        }
                    })
                });
            },
            //consulta para generar datos de la tabla
            verTabla(event){
                this.$inertia.get('/Produccion/Carga',{ busca: event.target.value }, {
                    onSuccess: () => { this.selePP(), this.selePE(), this.seleNM() }, preserveState: true
                });
                this.proc_prin = '';
                this.form.proceso_id = '';
                this.form.dep_perf_id = '';
                this.form.maq_pro_id = '';
                this.form.maq_pro_id = '';
                this.form.clave_id = '';
            },
            /****************************** Selects de muestra ************************************************/
            //equipo y turno
            eq_tu(event){
                this.personal.forEach(sp => {
                    if (sp.id == event.target.value) {
                        this.form.equipo_id = sp.equipo.id == null ? null : sp.equipo.id;
                        this.form.turno_id = sp.equipo.turno_id == null ? null : sp.equipo.turno_id;
                    }
                })
            },
            //select para proceso principal
            selePP(){
                this.$nextTick(() => {
                    if (this.usuario.dep_pers.length == 0) {
                        this.form.per_carga = '';
                        this.veFec = true;
                    }else{
                        this.form.per_carga = this.usuario.dep_pers[0].id;
                        this.veFec = this.usuario.dep_pers[0].ope_puesto == 'cor';
                    }
                    this.opcPP= '<option value="" disabled>SELECCIONA</option>'
                    this.procesos == null ? '' : this.procesos.forEach(pp =>{
                        if (pp.tipo == 0) {
                            this.opcPP += `<option value="${pp.id}">${pp.nompro}</option>`
                        }
                    })
                })
            },
            //select para sub proceso
            seleSP(event){
                //console.log(this.usuario.dep_pers[0].ope_puesto)
                this.form.proceso_id = '';
                this.opcSP= '<option value="" disabled>SELECCIONA</option>';
                //revisa si existe el usuario en procesos
                if (this.usuario.dep_pers.length != 0) {
                    this.procesos == null ? '' : this.procesos.forEach(sp =>{
                        if (this.usuario.dep_pers[0].ope_puesto != 'cor' & (sp.tipo == 1 & sp.proceso_id == event.target.value) ) {
                            //console.log(sp)
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`
                        }
                        if (this.usuario.dep_pers[0].ope_puesto == 'cor' & (sp.tipo == 2 & sp.proceso_id == event.target.value)) {
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`
                        }
                    })
                }
                //si no existe mandara todos los procesos de la area
                else{
                    this.procesos == null ? '' : this.procesos.forEach(sp =>{
                        if (sp.tipo != 3 & sp.proceso_id == event.target.value) {
                            //console.log(sp)
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`
                        }
                    })
                }

            },
            //select para personal
            selePE(){
                //console.log(this.usuario.dep_pers.length);
                this.opcPE= '<option value="" disabled>SELECCIONA</option>';
                //revisa si existe el usuario en procesos
                if (this.usuario.dep_pers.length != 0) {
                    if (this.usuario.dep_pers[0].ope_puesto == 'ope' || this.usuario.dep_pers[0].ope_puesto == 'cor') {
                        this.ocuPE = false;
                        this.form.dep_perf_id = this.usuario.dep_pers[0].id;
                        this.form.equipo_id = this.usuario.dep_pers[0].equipo == null ? null : this.usuario.dep_pers[0].equipo.id;
                        this.form.turno_id = this.usuario.dep_pers[0].equipo == null ? null : this.usuario.dep_pers[0].equipo.turno_id;
                    }
                    this.personal == null ? '' : this.personal.forEach(pe => {
                        if (pe.ope_puesto == 'ope' | pe.ope_puesto == 'lid') {
                            this.opcPE += `<option value="${pe.id}">${pe.perfiles.Nombre} ${pe.perfiles.ApPat} ${pe.perfiles.ApMat}</option>`;
                        }
                    })
                }
                //muestra a todo el personal
                else{
                    this.personal == null ? '' : this.personal.forEach(pe => {
                        this.opcPE += `<option value="${pe.id}">${pe.perfiles.Nombre} ${pe.perfiles.ApPat} ${pe.perfiles.ApMat}</option>`;
                    })
                }
            },
            //select de maquinas
            seleMQ(event){
                this.form.maq_pro_id = '';
                this.opcMQ = '<option value="" disabled>SELECCIONA</option>';
                this.procesos.forEach(pm => {
                    if (event.target.value == pm.id) {
                        //console.log(pm.maq_pros.length)
                        pm.maq_pros.length == 0 ? this.veMa = false : this.veMa = true, pm.maq_pros.forEach(mp => {
                            this.opcMQ += `<option value="${mp.id}" >${mp.maquinas.Nombre}</option>`;
                        })
                    }
                })
            },
            //select normas
            seleNM(){
                this.opcNM = '<option value="" disabled>SELECCIONA</option>';
                this.materiales == null ? '' : this.materiales.forEach(ma => {
                    this.opcNM += `<option value="${ma.id}">${ma.materiales.idmat} - ${ma.materiales.nommat}</option>`;
                })
            },
            //claves
            seleCL(event){
                this.form.clave_id = '';
                this.opcCL = '<option value="" disabled>SELECCIONA</option>';
                this.materiales.forEach(cl => {
                    if (event.target.value == cl.id) {
                        //console.log(cl.claves)
                        cl.claves.forEach(c => {
                            this.opcCL += `<option value="${c.id}">${c.CVE_ART} - ${c.DESCR}</option>`;
                        })
                    }
                })
            },
            /****************************** datatables ********************************************************/
            //datatable de carga
            tabla() {
                this.$nextTick(() => {
                    $('#t_carg').DataTable({
                        "language": this.español,
                        "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    })
                })
            },
            //datatable de paros
            tablaRep() {
                this.$nextTick(() => {
                    $('#t_rep').DataTable({
                        "language": this.español,
                        "scrollY":        "30vh",
                        "scrollCollapse": true,
                        "paging":         false,
                        "dom": '<"row"<"col-sm-12"f>>'+
                                "<'row'<'col-sm-12'tr>>",
                    });

                })
            },
            /****************************** carga de carga de datos ******************************************/
            saveCA(form){
                $('#t_carg').DataTable().destroy();
                this.$inertia.post('/Produccion/Carga', form, {
                    onSuccess: () => { this.tabla(), this.resetCA() ,this.alertSucces()}, preserveState: true
                });
                //console.log(form);
            },
            resetCA(){
                this.form = {
                    //fecha: moment().format("YYYY-MM-DD"),
                    semana: moment().format("GGGG-[W]WW"),
                    per_carga: '',
                    proceso_id: '',
                    dep_perf_id: '',
                    maq_pro_id: '',
                    partida: '',
                    valor: '',
                    norma: '',
                    equipo_id: '',
                    clave_id: '',
                    turno_id: '',
                }
            }
        }
    }
</script>
