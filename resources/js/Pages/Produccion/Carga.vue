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
                <select class="InputSelect sm:tw-w-full" v-model="S_Area">
                    <option value="" disabled>Selecciona un departamento</option>
                    <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                </select>
            </template>
            <!-- <template v-slot:calcula v-if="usuario.dep_pers.length == 0 | (noCor == 'cor' | noCor == 'enc')">
                <div class="input-group" tooltip="Calcular" flow="right">
                    <input type="date" class="form-control tw-rounded-lg" v-model="calcu" :max="hoy" aria-describedby="button-addon2">
                    <button class="btn btn-outline-success" type="button" id="button-addon2" :disabled="btnOff" @click="calcula()">
                        <i class="fas fa-calculator" ></i>
                    </button>
                </div>
            </template> -->
            <template v-slot:BtnNuevo>
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="resetCA()">Cargar datos</jet-button>
            </template>
        </Accions>

        <!------------------------------------ carga de datos de personal y areas ---------------------------------------->
        <div class="collapse m-5 tw-p-6 tw-bg-blue-300 tw-rounded-3xl tw-shadow-xl" id="agPer">
            <form>
                <!-- Proceso proncipal, sub procesos, operador -->
                <div class="tw-mb-6 lg:tw-flex" v-if="(form.notaPen == 1 & !editMode )| editMode">
                    <!-- Select proceso principal -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Proceso proncipal</jet-label>
                        <select class="InputSelect" v-model="proc_prin" :disabled="editMode">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="pp in opcPP" :key="pp" :value="pp.value" >{{pp.text}}</option>
                        </select>
                        <small v-if="errors.proc_prin" class="validation-alert">{{errors.proc_prin}}</small>
                    </div>
                    <!-- select Sub proceso -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" v-if="opcSP">
                        <jet-label><span class="required">*</span>Sub proceso </jet-label>
                        <select class="InputSelect" v-model="form.proceso_id" :disabled="editMode">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="sp in opcSP" :key="sp" :value="sp.id">{{sp.text}}</option>
                        </select>
                        <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                    </div>
                    <!-- select operador -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" v-if="(noCor != 'cor' & noCor != 'ope') | editMode">
                        <jet-label><span class="required">*</span>Operador</jet-label>
                        <select class="InputSelect" @change="eq_tu" v-model="form.dep_perf_id" :disabled="editMode">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="pe in opcPE" :key="pe" :value="pe.value">{{pe.text}}</option>
                        </select>
                        <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                    </div>
                </div>
                <!-- Maquinas, Normas, Claves, Partida, Kilogramos -->
                <div class="tw-mb-6 lg:tw-flex" v-if="(form.notaPen == 1 & form.proceso_id != '') | editMode">
                    <!-- select Maquinas -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Maquinas</jet-label>
                        <select class="InputSelect" v-model="form.maq_pro_id" :disabled="editMode">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="mq in opcMQ" :key="mq.value" :value="mq.value">{{mq.text}}</option>
                        </select>
                        <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                    </div>
                    <!-- Select Normas -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/5 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Norma</jet-label>
                        <select class="InputSelect" v-model="form.norma" :disabled="editMode">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="nm in opcNM" :key="nm" :value="nm.value">{{nm.text}}</option>
                        </select>
                        <small v-if="errors.norma" class="validation-alert">{{errors.norma}}</small>
                    </div>
                    <!-- select Clave -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/5 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Clave</jet-label>
                        <select class="InputSelect" v-model="form.clave_id">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="cl in opcCL" :key="cl" :value="cl.id">{{cl.text}}</option>
                        </select>
                        <small v-if="errors.clave_id" class="validation-alert">{{errors.clave_id}}</small>
                    </div>
                    <!-- Inout partida -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/5 lg:tw-mb-0" v-if="noCor != 'cor' | editMode">
                        <jet-label>Partida</jet-label>
                        <jet-input class="InputSelect" v-model="form.partida" @input="(val) => (form.partida = form.partida.toUpperCase())"></jet-input>
                        <small v-if="errors.partida" class="validation-alert">{{errors.partida}}</small>
                    </div>
                    <!-- Input kilogramos -->
                    <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-w-1/5 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>KG</jet-label>
                        <jet-input type="number" min="0" class="InputSelect tw-bg-lime-300" v-model="form.valor"></jet-input>
                        <small v-if="errors.valor" class="validation-alert">{{errors.valor}}</small>
                    </div>
                </div>
                <!-- Notas -->
                <div class="tw-mb-6 lg:tw-flex" v-if="form.notaPen == 2">
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 tw-text-center tw-mx-auto lg:tw-mb-0 tw-bg-emerald-700 tw-bg-opacity-50 tw-rounded-lg" v-if="editMode">
                        <jet-label>Nota anterior</jet-label>
                        <jet-label v-html="nAnte"></jet-label>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-2/3 tw-text-center tw-mx-auto lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Nota</jet-label>
                        <textarea class="InputSelect" v-model="form.nota" maxlength="250" @input="(val) => (form.nota = form.nota.toUpperCase())" placeholder="Maximo 250 caracteres"></textarea>
                        <small v-if="errors.nota" class="validation-alert">{{errors.nota}}</small>
                    </div>
                </div>
                <!-- Botones -->
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
            </form>
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
                proc_prin: '',
                btnOff: false,
                v: [],
                calcu: '',
                hoy: moment().format('YYYY-MM-DD'),
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
            this.global();
            /* this.tabla(); */
            this.reCarga();
        },
        methods: {
            //calcula
            calcula() {
                if (this.calcu != '' & this.S_Area != '') {
                    console.log(this.calcu+' '+this.S_Area);
                    /* this.btnOff = true; */
                    const form = {fecha: this.calcu, depa: this.S_Area};
                    this.$inertia.post('/Produccion/Calcula', form, {
                        onSuccess: (v) => { this.btnOff = false, this.alertSucces()}, onError: (e) => { this.btnOff = false }, preserveState: true
                    });
                }else{
                    this.calcu == '' ? Swal.fire('Por favor selecciona una fecha') : '';
                    this.S_Area == '' ? Swal.fire('Por favor selecciona un departamento') : '';
                }

            },
            //consulta para generar datos de la tabla
            /* verTabla(event){
                event.target.value == '' ? '' : $('#t_carg').DataTable().clear();
                $('#t_carg').DataTable().destroy();
                this.resetCA();
                this.proc_prin = '';
                this.$inertia.get('/Produccion/Carga',{ busca: event.target.value }, {
                    onSuccess: () => { this.reCarga(), this.tabla()  }, onError: () => {this.tabla()}, preserveState: true
                });
            }, */
            /****************************** Globales **********************************************************/
            global(){
                if (this.usuario.dep_pers.length == 0) {
                    this.S_Area = 7;
                }else{
                    //Asigna el primer departamento
                    this.S_Area = this.usuario.dep_pers[0].departamento_id;
                    //asigna el puesto a una variable
                    this.noCor = this.usuario.dep_pers[0].ope_puesto;
                }
            },
            /****************************** Selects de muestra ************************************************/
            //equipo y turno
            eq_tu(event){
                this.personal.forEach(sp => {
                    if (sp.id == event.target.value) {
                        /* console.log(sp) */
                        this.form.equipo_id = sp.equipo == null ? null : sp.equipo.id;
                        this.form.vacio = sp.equipo == null ? 'N/A' : sp.equipo.turnos.nomtur;
                        this.form.turno_id = sp.equipo == null ? null : sp.equipo.turno_id;
                    }
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
                if (moment().isDST()) {
                    form.VerInv = 'Verano';
                }else{
                    form.VerInv = 'Invierno';
                }
                $('#t_carg').DataTable().clear();
                $('#t_carg').DataTable().destroy();
                this.$inertia.post('/Produccion/Carga', form, {
                    onSuccess: (v) => { this.reCarga(), this.tabla(), this.resetCA(), this.alertSucces()}, onError: (e) => { this.tabla()}, preserveState: true
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
            //Opciones procesos principales
            opcPP: function() {
                const ppi = [];
                this.procesos.forEach(pp =>{
                    switch (this.noCor) {
                        case 'cor':
                            if (pp.tipo == 0 & pp.tipo_carga == 'pro-cor') {
                                ppi.push({text: pp.nompro, value: pp.id})
                            }
                            break;
                        case 'enc':
                            if (pp.tipo == 0 & (pp.tipo_carga == 'pro-cor' | pp.tipo_carga == 'pro')) {
                                ppi.push({text: pp.nompro, value: pp.id})
                            }
                            break;
                        case '':
                            if (pp.tipo == 0 & (pp.tipo_carga == 'pro-cor' | pp.tipo_carga == 'pro')) {
                                ppi.push({text: pp.nompro, value: pp.id})
                            }
                            break;
                        default:
                            if (pp.tipo == 0 & pp.tipo_carga == 'pro') {
                                ppi.push({text: pp.nompro, value: pp.id})
                            }
                            break;
                    }
                });
                return ppi;
            },
            //Opciones Personal
            opcPE: function() {
                const spe = [];
                if (this.usuario.dep_pers.length == 0) {
                    //asignacion de select personal
                    this.personal.forEach(pe => {
                        spe.push({value: pe.id, text: pe.perfiles.IdEmp +' - '+ pe.perfiles.Nombre+' '+pe.perfiles.ApPat+' '+pe.perfiles.ApMat});
                    })
                }else{
                    //asignacion de personal a select
                    this.personal.forEach(pe => {
                        if (this.noCor == 'enc') {
                            if (pe.ope_puesto != 'cor') {
                                spe.push({value: pe.id, text: pe.perfiles.Nombre+' '+pe.perfiles.ApPat+' '+pe.perfiles.ApMat});
                            }
                        }else{
                            if (pe.ope_puesto != 'cor' & pe.ope_puesto != 'enc') {
                                spe.push({value: pe.id, text: pe.perfiles.Nombre+' '+pe.perfiles.ApPat+' '+pe.perfiles.ApMat});
                            }
                        }

                    })
                }
                return spe;
            },
            //Opciones Normas
            opcNM: function() {
                const nm = [];
                this.materiales.forEach(ma => {
                    nm.push({value: ma.id, text: ma.materiales.idmat+' - '+ma.materiales.nommat});
                })
                return nm;
            },
            //Opciones subprocesos
            opcSP: function() {
                const ssp = [];
                if (this.usuario.dep_pers.length != 0) {
                    //recorre y muestra los procesos
                    this.procesos.forEach(sp =>{
                        if ((this.noCor == 'lid' | this.noCor == 'ope') & (sp.tipo == 1 & sp.proceso_id == this.proc_prin) | this.editMode ) {
                            ssp.push({id: sp.id, text: sp.nompro});
                        }
                        if (this.noCor == 'enc' & sp.proceso_id == this.proc_prin | this.editMode ) {
                            ssp.push({id: sp.id, text: sp.nompro});
                        }
                        if (this.noCor == 'cor' & (sp.tipo == 2 & sp.proceso_id == this.proc_prin) | this.editMode) {
                            ssp.push({id: sp.id, text: sp.nompro});
                        }
                    })
                }else{
                    //recorre y muestra los procesos
                    this.procesos.forEach(sp =>{
                        if (sp.tipo != 3 & sp.proceso_id == this.proc_prin) {
                            ssp.push({id: sp.id, text: sp.nompro});
                        }
                    })
                }
                return ssp;
            },
            //Opciones maquinas
            opcMQ: function() {
                this.form.maq_pro_id = '';
                const mq = [];
                var mar = '';
                if (this.form.proceso_id != '') {
                    this.procesos.forEach(pm => {
                        if (this.form.proceso_id == pm.id) {
                            //console.log(pm.maq_pros.length)
                            pm.maq_pros.forEach(mp => {
                                mar = mp.maquinas.marca == null ? 'N/A' :  mp.maquinas.marca.Nombre
                                mq.push({value: mp.id, text:mp.maquinas.Nombre + ' ' + mar});
                            })
                        }
                    })
                }
                return mq;
            },
            //Opciones Claves
            opcCL: function() {
                const scl = [];
                this.form.clave_id = '';
                if (this.form.norma != '') {
                    this.materiales.forEach(cl => {
                        if (this.form.norma == cl.id) {
                            //console.log(cl.claves)
                            cl.claves.forEach(c => {
                                scl.push({id: c.id, text: c.CVE_ART+ ' - ' + c.DESCR})
                            })
                        }
                    })
                }
                return scl;
            }
        },
        watch: {
            S_Area: function(b){
                $('#t_carg').DataTable().clear();
                $('#t_carg').DataTable().destroy();
                this.resetCA();
                this.proc_prin = '';
                this.$inertia.get('/Produccion/Carga',{ busca: b }, {
                    onSuccess: () => { this.reCarga(), this.tabla()  }, onError: () => {this.tabla()}, preserveState: true
                });
            },
            proc_prin: function(v) {
                //cuando no se edita
                if (!this.editMode) {
                    this.form.proceso_id = '';
                    this.form.maq_pro_id = '';
                    this.form.clave_id = '';
                    this.form.norma = '';
                }
            }
        }
    }
</script>
