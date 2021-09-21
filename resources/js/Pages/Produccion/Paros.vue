<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-clipboard-list"></i>
                        Paros
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <select @change="verTabla" class="InputSelect" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="reset()">Cargar datos</jet-button>
            </template>
        </Accions>
        <!------------------------------------ carga de datos de personal y areas ---------------------------------------->
        <div class="collapse m-5 tw-p-6 tw-bg-red-400 tw-rounded-3xl tw-shadow-xl" id="agPer">
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Proceso proncipal</jet-label>
                    <select class="InputSelect" v-model="proc_prin" v-html="opcPP" :disabled="editMode"></select>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="opcSP">
                    <jet-label><span class="required">*</span>Sub proceso </jet-label>
                    <select class="InputSelect" v-model="form.proceso_id" v-html="opcSP" :disabled="editMode"></select>
                    <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Maquinas</jet-label>
                    <select class="InputSelect" v-model="form.maq_pro_id" v-html="opcMQ" :disabled="editMode"></select>
                    <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                </div>
            </div>
            <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
               <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="!editMode" @click="saveCA(form)">Guardar</jet-button>
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
            <Table id="t_paros">
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
                    <tr v-for="ca in cargas" :key="ca.id">
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

        <pre>
            {{paros}}
        </pre>
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
    import Modal from '@/Jetstream/Modal';
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
            'paros',
            'materiales',
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
            Modal,
            JetLabel
        },
        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                opc: '<option value="" disabled>Selecciona</option>',
                opcPP: '',
                opcSP: '<option value="" disabled>Selecciona</option>',
                opcMQ: '<option value="" disabled>Selecciona</option>',
                proc_prin: '',
                editMode: false,
                form: {
                    fecha: moment().format("YYYY-MM-DD HH:mm:ss"),
                    semana: moment().format("GGGG-[W]WW"),
                    usu:  this.usuario.id,
                    proceso_id: '',
                    maq_pro_id: '',
                }
            }
        },
        mounted() {
            this.mostSelect();
            this.selePP();
            this.tabla();
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
                event.target.value == '' ? '' : $('#t_paros').DataTable().clear();
                $('#t_paros').DataTable().destroy();
                /* this.reset(); */
                this.proc_prin = '';
                this.$inertia.get('/Produccion/Paros',{ busca: event.target.value }, {
                    onSuccess: () => { this.selePP(), this.tabla() }, preserveState: true
                });
            },
            //select para proceso principal, normas y personal
            selePP(){
                this.$nextTick(() => {
                    //select de procesos principales
                    this.opcPP= '<option value="" >SELECCIONA</option>'
                    this.procesos.forEach(pp =>{
                        if (pp.tipo == 0 & pp.tipo_carga == 'pro') {
                            this.opcPP += `<option value="${pp.id}">${pp.nompro}</option>`
                        }
                    })
                    //select normas
                    this.opcNM = '<option value="">SELECCIONA</option>';
                    this.materiales.forEach(ma => {
                        this.opcNM += `<option value="${ma.id}">${ma.materiales.idmat} - ${ma.materiales.nommat}</option>`;
                    })
                })
            },
            /****************************** datatables ********************************************************/
            //datatable de carga
            tabla() {
                this.$nextTick(() => {
                    $('#t_paros').DataTable({
                        "language": this.español,
                        "order": [[4, 'asc'], [0, 'desc']],
                        "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                    })
                })
            },
            /****************************** carga de carga de datos ******************************************/
            reset(){

            }
        },
        computed: {
            noCor: function() {
                if (this.usuario.dep_pers.length != 0) {
                    return this.usuario.dep_pers[0].ope_puesto;
                }
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
                //select sub peocesos
                this.opcSP= '<option value="" >SELECCIONA</option>';
                //recorre y muestra los procesos
                this.procesos.forEach(sp =>{
                    if ((sp.tipo == 1 & sp.proceso_id == v) | this.editMode ) {
                        this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`;
                    }
                })

            },
            form: {
                deep: true,
                handler: function(f) {
                    //select de maquinas
                    if (f.proceso_id != '') {
                        this.opcMQ = '<option value="" >SELECCIONA</option>';
                        this.procesos.forEach(pm => {
                            if (f.proceso_id == pm.id) {
                                //console.log(pm.maq_pros.length)
                                pm.maq_pros.forEach(mp => {
                                    this.opcMQ += `<option value="${mp.id}" >${mp.maquinas.Nombre}</option>`;
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
