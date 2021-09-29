<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-clipboard-list"></i>
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
            </template>
        </Accions>
        <JetBanner><h1>listo para empezar</h1></JetBanner>
        <!------------------------------------ carga de datos de personal y areas ---------------------------------------->
        <div class="collapse m-5 tw-p-6 tw-bg-blue-300 tw-rounded-3xl tw-shadow-xl" id="agPer">
            <div class="tw-mb-6 md:tw-flex" v-if="(form.notaPen == 1 & !editMode )| editMode">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Proceso proncipal</jet-label>
                    <select class="InputSelect" v-model="proc_prin" v-html="opcPP" :disabled="editMode"></select>
                    <small v-if="errors.proc_prin" class="validation-alert">{{errors.proc_prin}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="opcSP">
                    <jet-label><span class="required">*</span>Sub proceso </jet-label>
                    <select class="InputSelect" v-model="form.proceso_id" v-html="opcSP" :disabled="editMode"></select>
                    <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="(noCor != 'cor' & noCor != 'ope') | editMode">
                    <jet-label><span class="required">*</span>Operador</jet-label>
                    <select class="InputSelect" @change="eq_tu" v-model="form.dep_perf_id" v-html="opcPE" :disabled="editMode"></select>
                    <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                </div>
            </div>
            <div class="tw-mb-6 md:tw-flex" v-if="(form.notaPen == 1 & form.proceso_id != '') | editMode">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Maquinas</jet-label>
                    <select class="InputSelect" v-model="form.maq_pro_id" v-html="opcMQ" :disabled="editMode"></select>
                    <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/5 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Norma</jet-label>
                    <select class="InputSelect" v-model="form.norma" v-html="opcNM" :disabled="editMode"></select>
                    <small v-if="errors.norma" class="validation-alert">{{errors.norma}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/5 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Clave</jet-label>
                    <select class="InputSelect" v-model="form.clave_id" v-html="opcCL"></select>
                    <small v-if="errors.clave_id" class="validation-alert">{{errors.clave_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/5 md:tw-mb-0" v-if="noCor != 'cor' | editMode">
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
            <div class="tw-mb-6 md:tw-flex" v-if="form.notaPen == 2">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 tw-text-center tw-mx-auto md:tw-mb-0 tw-bg-emerald-700 tw-bg-opacity-50 tw-rounded-lg" v-if="editMode">
                    <jet-label>Nota anterior</jet-label>
                    <jet-label v-html="nAnte"></jet-label>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 tw-text-center tw-mx-auto md:tw-mb-0">
                    <jet-label><span class="required">*</span>Nota</jet-label>
                    <textarea class="InputSelect" v-model="form.nota" maxlength="250" @input="(val) => (form.nota = form.nota.toUpperCase())" placeholder="Maximo 250 caracteres"></textarea>
                    <small v-if="errors.nota" class="validation-alert">{{errors.nota}}</small>
                </div>
            </div>
            <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
              <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 2 & !editMode" @click="saveNot(form)">Agregar</jet-button>
              </div>
               <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 1 & !editMode" @click="saveCA(form)">Guardar</jet-button>
               </div>
               <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="editMode" @click="updateCA(form)">Actualizar</jet-button>
               </div>
                <div>
                    <jet-button class="tw-bg-red-700 hover:tw-bg-red-500" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="resetCA()" v-if="editMode">CANCELAR</jet-button>
                </div>
            </div>
        </div>
        <!------------------------------------ Data table de carga ------------------------------------------------------->
        <div class="table-responsive">
            <Table id="t_carg">
                <template v-slot:TableHeader>
                    <th class="columna">Fecha</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Proceso</th>
                    <th class="columna">Estatus</th>
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
                    <tr v-for="ca in v" :key="ca.id">
                        <td class="fila">{{ca.fecha}}</td>
                        <td class="fila">{{ca.dep_perf.perfiles.Nombre}} {{ca.dep_perf.perfiles.ApPat}} {{ca.dep_perf.perfiles.ApMat}}</td>
                        <td class="fila">{{ca.dep_perf.departamentos.Nombre}}</td>
                        <td class="fila">{{ca.proceso.nompro}}</td>
                        <td class="fila tw-w-40">
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-emerald-600 tw-rounded-full" v-if="ca.notaPen == 2 & ca.proceso.tipo == 2">NOTA COORDINADOR</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-cyan-600 tw-rounded-full" v-else-if="ca.notaPen == 2 & (ca.dep_perf.ope_puesto == 'ope' | ca.dep_perf.ope_puesto == 'lid')">NOTA OPERADOR</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-coolGray-600 tw-rounded-full" v-if="ca.notaPen == 1 & ca.notas.length <= 1">SIN NOTA</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-blue-600 tw-rounded-full" v-if="ca.notaPen == 1 & ca.notas.length > 1">ACTUALIZADO</div>
                        </td>
                        <td class="fila">{{ca.equipo == null ? 'N/A' : ca.equipo.nombre}}</td>
                        <td class="fila">{{ca.turno == null ? 'N/A' : ca.turno.nomtur}}</td>
                        <td class="fila">{{ca.partida == null ? 'N/A' : ca.partida}}</td>
                        <td class="fila">{{ca.dep_mat == null ? 'N/A' : ca.dep_mat.materiales.idmat+' - '+ca.dep_mat.materiales.nommat}}</td>
                        <td class="fila">{{ca.clave == null ? 'N/A' : ca.clave.CVE_ART}}</td>
                        <td class="fila">{{ca.clave == null ? 'N/A' : ca.clave.DESCR}}</td>
                        <td class="fila">{{ca.maq_pro == null ? 'N/A' : ca.maq_pro.maquinas.Nombre}}</td>
                        <td class="fila">{{ca.valor}}</td>
                        <td class="fila">
                            <div class="columnaIconos">
                                <div class="iconoDetails tw-cursor-pointer" @click="notaCA(ca)" v-show="usuario.dep_pers.length != 0 & (((noCor == 'cor' | noCor == 'enc') & ca.proceso.tipo == 2 & ca.notaPen == 1) | ((noCor == 'lid' | noCor == 'ope') & ca.equipo_id != null & ca.notaPen == 1))">
                                    <span tooltip="Agregar nota" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoEdit tw-cursor-pointer" @click="editCA(ca)" v-show="usuario.dep_pers.length == 0 | (ca.proceso.tipo != 2 & (noCor == 'cor' | noCor == 'enc'))">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
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
    import JetBanner from '@/Components/Banner';
    import JetLabel from '@/Jetstream/Label';
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
            JetBanner,
            AppLayout,
            Header,
            Accions,
            Table,
            JetButton,
            JetCancelButton,
            JetInput,
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
                nAnte: '',
                form: {
                    id: null,
                    fecha: moment().format("YYYY-MM-DD HH:mm:ss"),
                    semana: moment().format("GGGG-[W]WW"),
                    usu: this.usuario.id,
                    per_carga: this.usuario.id,
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
                this.resetCA();
                this.proc_prin = '';
                this.$inertia.get('/Produccion/Carga',{ busca: event.target.value }, {
                    onSuccess: () => { this.selePP(),/* this.selePE(), this.seleNM(),*/ this.reCarga(), this.tabla()  }, onError: () => {this.tabla()}, preserveState: true
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
                        switch (this.noCor) {
                            case 'cor':
                                if (pp.tipo == 0 & pp.tipo_carga == 'pro-cor') {
                                    this.opcPP += `<option value="${pp.id}">${pp.nompro}</option>`
                                }
                                break;
                            case 'enc':
                                if (pp.tipo == 0 & (pp.tipo_carga == 'pro-cor' | pp.tipo_carga == 'pro')) {
                                    this.opcPP += `<option value="${pp.id}">${pp.nompro}</option>`
                                }
                                break;
                            case '':
                                if (pp.tipo == 0 & (pp.tipo_carga == 'pro-cor' | pp.tipo_carga == 'pro')) {
                                    this.opcPP += `<option value="${pp.id}">${pp.nompro}</option>`
                                }
                                break;
                            default:
                                if (pp.tipo == 0 & pp.tipo_carga == 'pro') {
                                    this.opcPP += `<option value="${pp.id}">${pp.nompro}</option>`
                                }
                                break;
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
                        //asignacion de personal a select
                        this.personal.forEach(pe => {
                            if (this.noCor == 'enc') {
                                if (pe.ope_puesto != 'cor') {
                                    this.opcPE += `<option value="${pe.id}">${pe.perfiles.Nombre} ${pe.perfiles.ApPat} ${pe.perfiles.ApMat}</option>`;
                                }
                            }else{
                                if (pe.ope_puesto != 'cor' & pe.ope_puesto != 'enc') {
                                    this.opcPE += `<option value="${pe.id}">${pe.perfiles.Nombre} ${pe.perfiles.ApPat} ${pe.perfiles.ApMat}</option>`;
                                }
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
            //reordana los datos para mostrar la información en el datatable
            reCarga(){
                this.cargas.forEach(ca => {
                    if (ca.dep_perf) {
                        if (this.usuario.dep_pers.length != 0) {
                            if (this.noCor != 'cor' & this.noCor != 'enc') {
                                if (ca.proceso.tipo != 2) {
                                    this.v.push(ca);
                                }
                            }else{
                                this.v.push(ca);
                            }
                        }else{
                            this.v.push(ca)
                        }
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
                        "order": [[4, 'asc'], [0, 'desc']],
                        "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                    })
                })
            },
            /****************************** carga de carga de datos ******************************************/
            saveCA(form){
                this.form.fecha = moment().format("YYYY-MM-DD HH:mm:ss");
                this.form.semana = moment().format("GGGG-[W]WW");
                $('#t_carg').DataTable().clear();
                $('#t_carg').DataTable().destroy();
                this.$inertia.post('/Produccion/Carga', form, {
                    onSuccess: () => { this.reCarga(), this.tabla(), this.resetCA(), this.alertSucces()}, onError: () => {this.tabla()}, preserveState: true
                });
                //console.log(form);
            },
            resetCA(){
                this.proc_prin = '';
                this.editMode = false;
                this.form.valor = '';
                this.form.norma = '';
                this.form.partida = '';
                this.form.maq_pro_id = '';
                this.form.clave_id = '';
                this.form.agNot = 0;
                this.form.notaPen = 1;
                this.form.nota = '';
                this.form.usu = this.usuario.id;

                if (this.usuario.dep_pers.length != 0) {
                    /* if (this.noCor != 'ope' | this.noCor != 'cor') {
                    } */
                    if(this.noCor == 'ope' | this.noCor == 'lid'){
                        this.form.dep_perf_id = this.usuario.dep_pers[0].id;
                        this.form.equipo_id = this.usuario.dep_pers[0].equipo.id;
                        this.form.turno_id = this.usuario.dep_pers[0].equipo.turno_id;
                    }
                    else if(this.noCor == 'cor'){
                        this.form.dep_perf_id = this.usuario.dep_pers[0].id;
                    }else{
                        this.form.dep_perf_id = this.usuario.dep_pers[0] != null ? this.usuario.dep_pers[0].id : '';
                        this.form.turno_id = this.usuario.dep_pers[0] != null ? this.usuario.dep_pers[0].equipo_id : '';
                        this.form.equipo_id = this.usuario.dep_pers[0].equipo != null ? this.usuario.dep_pers[0].equipo.turno_id : '';
                    }
                }else{
                    this.form.dep_perf_id = '';
                    this.form.turno_id = '';
                    this.form.equipo_id = '';
                }
            },
            editCA(form){
                //console.log(form)
                this.proc_prin = form.proceso.proceso_id;
                this.form.dep_perf_id = form.dep_perf_id;
                this.form.turno_id = form.turno_id;
                this.form.equipo_id = form.equipo_id;
                this.form.proceso_id = form.proceso_id;
                this.form.id = form.id;
                this.form.valor = form.valor;
                this.form.norma = form.norma;
                this.form.partida = form.partida;
                this.form.maq_pro_id = form.maq_pro_id;
                this.form.clave_id = form.clave_id;
                this.form.notaPen = 2;
                this.form.nota = '';
                this.editMode = true;
                this.nAnte = form.notas.length == 0 ? '' : `<label class="tw-text-base tw-w-full tw-text-black">Fecha: ${form.notas[0].fecha}</label><label class="tw-text-base tw-w-full tw-text-black tw-capitalize"> ${form.notas[0].nota}</label>`;
                $('#agPer').addClass('show')
            },
            updateCA(data){
                //console.log(data)
                if (data.nota != '' & data.clave_id != '' & data.valor != '') {
                    $('#t_carg').DataTable().clear();
                    $('#t_carg').DataTable().destroy();
                }
                this.$inertia.put('/Produccion/Carga/' + data.id, data, {
                    onSuccess: () => {this.reCarga(), this.tabla(), this.resetCA(), this.alertSucces()}, onError: () => {this.tabla()}
                });
            },
            /****************************** Carga de notas */
            notaCA(form){
                //console.log(form)
                this.resetCA();
                this.form.id = form.id;
                this.form.agNot = 1;
                this.form.notaPen = 2;
                this.form.nota = '';
                $('#agPer').addClass('show')

            },
            saveNot(data){
                $('#t_carg').DataTable().clear();
                $('#t_carg').DataTable().destroy();
                this.$inertia.put('/Produccion/Nota/' + data.id, data, {
                    onSuccess: () => {this.reCarga(), this.resetCA(), this.tabla(), this.alertSucces()}, onError: () => {this.tabla()},
                });
            }
        },
        watch: {
            proc_prin: function(v) {
                //cuando no se edita
                if (!this.editMode) {
                    this.form.proceso_id = '';
                    this.form.maq_pro_id = '';
                    this.form.clave_id = '';
                    this.form.norma = '';
                }
                this.opcSP= '<option value="" >SELECCIONA</option>';
                if (this.usuario.dep_pers.length != 0) {
                    //recorre y muestra los procesos
                    this.procesos.forEach(sp =>{
                        if ((this.noCor == 'lid' | this.noCor == 'ope') & (sp.tipo == 1 & sp.proceso_id == v) | this.editMode ) {
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`;
                        }
                        if (this.noCor == 'enc' & sp.proceso_id == v | this.editMode ) {
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`;
                        }
                        if (this.noCor == 'cor' & (sp.tipo == 2 & sp.proceso_id == v) | this.editMode) {
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`;
                        }
                    })
                }else{
                    //recorre y muestra los procesos
                    this.procesos.forEach(sp =>{
                        if (sp.tipo != 3 & sp.proceso_id == v) {
                            this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`
                        }
                    })
                }
            },
            form: {
                deep: true,
                handler: function(f) {
                    //console.log(f)
                    //select de maquinas
                    if (f.proceso_id != '') {
                        this.opcMQ = '<option value="" >SELECCIONA</option>';
                        this.procesos.forEach(pm => {
                            if (f.proceso_id == pm.id) {
                                //console.log(pm.maq_pros.length)
                                pm.maq_pros.forEach(mp => {
                                    this.opcMQ += `<option value="${mp.id}" >${mp.maquinas.Nombre} - ${mp.maquinas.marca.Nombre}</option>`;
                                })
                            }
                        })
                    }
                    //select para claves
                    if (f.norma != '') {
                        this.opcCL = '<option value="">SELECCIONA</option>';
                        this.materiales.forEach(cl => {
                            if (f.norma == cl.id) {
                                //console.log(cl.claves)
                                cl.claves.forEach(c => {
                                    this.opcCL += `<option value="${c.id}">${c.CVE_ART} - ${c.DESCR}</option>`;
                                })
                            }
                        })
                    }
                }
            }
        }
    }
</script>
