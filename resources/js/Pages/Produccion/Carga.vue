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
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="resetCA()">Cargar datos</jet-button>
                <jet-button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Agregar Reporte</jet-button>
            </template>
        </Accions>
        <!------------------------------------ carga de datos de personal y areas ---------------------------------------->
        <div class="collapse m-5 tw-p-6 tw-bg-blue-300 tw-rounded-3xl tw-shadow-xl" id="agPer">
            <div class="tw-mb-6 md:tw-flex" v-if="form.notaPen == 1">
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
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="noCor != 'cor' & noCor != 'ope'">
                    <jet-label><span class="required">*</span>Operador</jet-label>
                    <select class="InputSelect" @change="eq_tu" v-model="form.dep_perf_id" v-html="opcPE"></select>
                    <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                </div>
            </div>
            <div class="tw-mb-6 md:tw-flex" v-if="form.notaPen == 1 & form.proceso_id != ''">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0" v-show="noCor != 'cor'">
                    <jet-label><span class="required">*</span>Maquinas</jet-label>
                    <select class="InputSelect" v-model="form.maq_pro_id" v-html="opcMQ"></select>
                    <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/5 md:tw-mb-0" v-if="noCor != 'cor'">
                    <jet-label><span class="required">*</span>Norma</jet-label>
                    <select class="InputSelect" @change="seleCL" v-model="form.norma" v-html="opcNM"></select>
                    <small v-if="errors.norma" class="validation-alert">{{errors.norma}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/5 md:tw-mb-0" v-if="noCor != 'cor'">
                    <jet-label><span class="required">*</span>Clave</jet-label>
                    <select class="InputSelect" v-model="form.clave_id" v-html="opcCL"></select>
                    <small v-if="errors.clave_id" class="validation-alert">{{errors.clave_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/5 md:tw-mb-0" v-if="noCor != 'cor'">
                    <jet-label>Partida</jet-label>
                    <jet-input class="InputSelect" v-model="form.partida" @input="(val) => (form.partida = form.partida.toUpperCase())"></jet-input>
                    <small v-if="errors.partida" class="validation-alert">{{errors.partida}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 tw-w-full md:tw-w-1/5 md:tw-mb-0">
                    <jet-label><span class="required">*</span>KG</jet-label>
                    <jet-input type="number" min="0" class="InputSelect tw-bg-lime-300" v-model="form.valor"></jet-input>
                    <small v-if="errors.valor" class="validation-alert">{{errors.valor}}</small>
                </div>
            </div>
            <div class="tw-mb-6" v-if="form.notaPen == 2">
                <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 tw-text-center tw-mx-auto md:tw-mb-0">
                    <jet-label><span class="required">*</span>Nota</jet-label>
                    <textarea class="InputSelect" v-model="form.nota" @input="(val) => (form.nota = form.nota.toUpperCase())"></textarea>
                    <small v-if="errors.nota" class="validation-alert">{{errors.nota}}</small>
                </div>
            </div>
            <div class="w-100 tw-mx-auto" align="center">
                <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 2" @click="saveNot(form)">Agregar</jet-button>
                <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 1" @click="saveCA(form)">Guardar</jet-button>
            </div>
        </div>
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
                    <th class="columna">Descripción de clave</th>
                    <th class="columna">Maquina</th>
                    <th class="columna">KG</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter >
                    <tr v-for="ca in v" :key="ca">
                        <td class="fila">{{ca.Cfec}}</td>
                        <td class="fila">{{ca.Pnom}} {{ca.Pap}} {{ca.Pam}}</td>
                        <td class="fila">{{ca.Dnom}}</td>
                        <td class="fila">{{ca.Enom}}</td>
                        <td class="fila">{{ca.Tnom}}</td>
                        <td class="fila">{{ca.Cpar}}</td>
                        <td class="fila">{{ca.Midm}} - {{ca.Mnom}}</td>
                        <td class="fila">{{ca.CLcla}}</td>
                        <td class="fila">{{ca.CLdes}}</td>
                        <td class="fila">{{ca.MAnom}}</td>
                        <td class="fila">{{ca.Cval}}</td>
                        <td class="fila">
                            <div class="columnaIconos">
                                <div class="iconoDetails" @click="notaCA(ca)" v-show="usuario.dep_pers.length != 0 & ((noCor == 'cor' & ca.Enom == null) | (noCor != 'cor' & ca.Enom != null))">
                                    <span tooltip="Agregar nota" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>

                                </div>
                                <div class="iconoEdit" @click="edit(proceso)" v-show="usuario.dep_pers.length == 0 | (ca.Cnp == 2 & ca.DPpue != 'cor' & noCor == 'cor')">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="deleteRow(proceso)" v-show="usuario.dep_pers.length == 0">
                                    <span tooltip="Eliminar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
        </div>
        <pre>
            {{ materiales }}
        </pre>
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
                S_Area: '',
                noCor: '',
                opc: '<option value="" disabled>Selecciona</option>',
                opcPP: '',
                opcSP: '',
                opcPE: '',
                opcMQ: '<option value="" disabled>SELECCIONA</option>',
                opcNM: '<option value="" disabled>SELECCIONA</option>',
                opcCL: '<option value="" disabled>SELECCIONA</option>',
                proc_prin: '',
                v: [],
                editMode: false,
                form: {
                    idnota: null,
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
                    notaPen: 1,
                    nota: '',
                    agNot: 0
                }
            }
        },
        mounted() {
            this.mostSelect();
            this.global();
            this.selePP();
            this.tabla();
            /*this.tablaRep();
            this.selePE();
            this.seleNM();*/
            this.reCarga();
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
                event.target.value == '' ? '' : $('#t_carg').DataTable().clear();
                $('#t_carg').DataTable().destroy();
                this.$inertia.get('/Produccion/Carga',{ busca: event.target.value }, {
                    onSuccess: () => { this.selePP(),/* this.selePE(), this.seleNM(),*/ this.reCarga(), this.tabla()  }, preserveState: true
                });
            },
            /****************************** Globales **********************************************************/
            global(){
                if (this.usuario.dep_pers.length == 0) {

                }else{
                    //asigna el puesto a una variable
                    this.noCor = this.usuario.dep_pers[0].ope_puesto;
                }
            },
            /****************************** Selects de muestra ************************************************/
            //equipo y turno
            eq_tu(event){
                this.personal.forEach(sp => {
                    if (sp.id == event.target.value) {
                        this.form.equipo_id = sp.equipo == null ? null : sp.equipo.id;
                        this.form.turno_id = sp.equipo == null ? null : sp.equipo.turno_id;
                    }
                })
            },
            //select para proceso principal, normas y personal
            selePP(){
                this.$nextTick(() => {
                    //select de procesos principales
                    this.opcPP= '<option value="" >SELECCIONA</option>'
                    this.procesos.forEach(pp =>{
                        if (pp.tipo == 0) {
                            this.opcPP += `<option value="${pp.id}">${pp.nompro}</option>`
                        }
                    })
                    //select de personal
                    this.opcPE= '<option value="" >SELECCIONA</option>';
                    if (this.usuario.dep_pers.length == 0) {
                        //asignacion de select personal
                        this.personal.forEach(pe => {
                            this.opcPE += `<option value="${pe.id}">${pe.perfiles.Nombre} ${pe.perfiles.ApPat} ${pe.perfiles.ApMat}</option>`;
                        })
                    }else{
                        //asigna el puesto a una variable
                        this.noCor = this.usuario.dep_pers[0].ope_puesto;
                        //asigna quien carga
                        this.form.per_carga = this.usuario.dep_pers[0].id;
                        //asignacion de personal a select
                        this.personal.forEach(pe => {
                            if (pe.ope_puesto == 'ope' | pe.ope_puesto == 'lid') {
                                this.opcPE += `<option value="${pe.id}">${pe.perfiles.Nombre} ${pe.perfiles.ApPat} ${pe.perfiles.ApMat}</option>`;
                            }
                        })
                    }
                    //select normas
                    this.opcNM = '<option value="">SELECCIONA</option>';
                    this.materiales.forEach(ma => {
                        this.opcNM += `<option value="${ma.id}">${ma.materiales.idmat} - ${ma.materiales.nommat}</option>`;
                    })
                })
            },
            //select para sub proceso
            seleSP(event){
                //console.log(this.usuario.dep_pers[0].ope_puesto)
                this.form.proceso_id = '';
                this.opcSP= '<option value="" >SELECCIONA</option>';
                if (this.usuario.dep_pers.length != 0) {
                    //recorre y muestra los procesos
                    this.procesos.forEach(sp =>{
                        if (this.usuario.dep_pers[0].ope_puesto != 'cor' & (sp.tipo == 1 & sp.proceso_id == event.target.value) ) {
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`;
                        }
                        if (this.usuario.dep_pers[0].ope_puesto == 'cor' & (sp.tipo == 2 & sp.proceso_id == event.target.value)) {
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`;
                        }
                    })
                }else{
                    //recorre y muestra los procesos
                    this.procesos.forEach(sp =>{
                        if (sp.tipo != 3 & sp.proceso_id == event.target.value) {
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`
                        }
                    })
                }

            },
            //select de maquinas
            seleMQ(event){
                this.form.maq_pro_id = '';
                this.opcMQ = '<option value="" >SELECCIONA</option>';
                this.procesos.forEach(pm => {
                    if (event.target.value == pm.id) {
                        //console.log(pm.maq_pros.length)
                        pm.maq_pros.forEach(mp => {
                            this.opcMQ += `<option value="${mp.id}" >${mp.maquinas.Nombre}</option>`;
                        })
                    }
                })
            },
            //claves
            seleCL(event){
                this.form.clave_id = '';
                this.opcCL = '<option value="">SELECCIONA</option>';
                this.materiales.forEach(cl => {
                    if (event.target.value == cl.id) {
                        //console.log(cl.claves)
                        cl.claves.forEach(c => {
                            this.opcCL += `<option value="${c.id}">${c.CVE_ART} - ${c.DESCR}</option>`;
                        })
                    }
                })
            },
            //reordana los datos para mostrar la información en el datatable
            reCarga(){
                this.cargas.forEach(ca => {
                    if (this.usuario.dep_pers.length != 0) {
                        if (this.usuario.dep_pers[0].ope_puesto != 'cor') {
                            if (ca.DPpue != 'cor' & ca.Cnp == 1) {
                                this.v.push(ca);
                            }
                        }else{
                            this.v.push(ca);
                        }
                    }else{
                        this.v.push(ca)
                    }
                })
                //console.log(this.v)
            },
            /****************************** datatables ********************************************************/
            //datatable de carga
            tabla() {
                this.$nextTick(() => {
                    $('#t_carg').DataTable({
                        "language": this.español,
                        "order": [0, 'desc'],
                        "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                    })
                })
            },
            //datatable de paros
            /* tablaRep() {
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
            }, */
            /****************************** carga de carga de datos ******************************************/
            saveCA(form){
                $('#t_carg').DataTable().clear();
                $('#t_carg').DataTable().destroy();
                this.$inertia.post('/Produccion/Carga', form, {
                    onSuccess: () => { this.reCarga(), this.tabla(), this.resetCA(), this.alertSucces()}, preserveState: true
                });
                //console.log(form);
            },
            resetCA(){
                this.form.valor = '';
                this.form.norma = '';
                this.form.partida = '';
                this.form.maq_pro_id = '';
                this.form.clave_id = '';
                this.form.agNot = 0;
                this.form.notaPen = 1;
                this.form.nota = '';

                if (this.usuario.dep_pers.length != 0) {
                    if (this.usuario.dep_pers[0].ope_puesto != 'ope' | this.usuario.dep_pers[0].ope_puesto != 'cor') {
                        this.form.dep_perf_id = '';
                        this.form.turno_id = '';
                        this.form.equipo_id = '';
                    }
                    if(this.usuario.dep_pers[0].ope_puesto == 'ope'){
                        this.form.dep_perf_id = this.usuario.dep_pers[0].id;
                        this.form.equipo_id = this.usuario.dep_pers[0].equipo.id;
                        this.form.turno_id = this.usuario.dep_pers[0].equipo.turno_id;
                    }
                    if(this.usuario.dep_pers[0].ope_puesto == 'cor'){
                        this.form.dep_perf_id = this.usuario.dep_pers[0].id;
                    }
                }else{
                    this.form.dep_perf_id = '';
                    this.form.turno_id = '';
                    this.form.equipo_id = '';
                }
            },
            editCA(form){
                console.log(form)
            },
            /****************************** Carga de notas */
            notaCA(form){
                //console.log(form)
                this.form.idnota = form.id;
                //console.log(this.form.idnota);
                this.form.agNot = 1;
                this.form.notaPen = 2;
                $('#agPer').addClass('show')

            },
            saveNot(data){
                //console.log(data)
                //data._method = 'PUT';
                this.$inertia.put('/Produccion/Nota/' + data.id, data, {
                    onSuccess: () => {},
                });
            }
        }
    }
</script>
