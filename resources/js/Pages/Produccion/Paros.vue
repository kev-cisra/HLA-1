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
                <select class="InputSelect sm:tw-w-full" v-model="S_Area">
                    <option value="" disabled>Selecciona un departamento</option>
                    <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <form ></form>
                <button class="btn btn-danger" @click="logout">Cerrar sesión</button>
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="reset()">Ingresar Paro</jet-button>
            </template>
        </Accions>
        <!------------------------------------ carga de datos de personal y areas ---------------------------------------->
        <div class="collapse m-5 tw-p-6 tw-bg-green-600 tw-rounded-3xl tw-shadow-xl" id="agPer">
            <!-- inputs principales -->
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Proceso proncipal</jet-label>
                    <select class="InputSelect" v-model="proc_prin" :disabled="editMode">
                        <option value="" disabled>SELECCIONA</option>
                        <option v-for="pp in opcPP" :key="pp" :value="pp.value" >{{pp.text}}</option>
                    </select>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="opcSP">
                    <jet-label><span class="required">*</span>Sub proceso </jet-label>
                    <select class="InputSelect" v-model="form.proceso_id" :disabled="editMode">
                        <option value="" disabled>SELECCIONA</option>
                        <option v-for="sp in opcSP" :key="sp" :value="sp.id">{{sp.text}}</option>
                    </select>
                    <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Maquinas</jet-label>
                    <Select2 v-model="form.maq_pro_id"  class="InputSelect" :options="opcMQ"  :settings="{width: '100%', multiple: true, allowClear: true}"/>
                    <!-- <select class="InputSelect" v-model="form.maq_pro_id" :disabled="editMode">
                        <option value="" disabled>SELECCIONA</option>
                        <option v-for="mq in opcMQ" :key="mq.value" :value="mq.value">{{mq.text}}</option>
                    </select> -->
                    <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                </div>
            </div>
            <!-- inputs orden y descripcion -->
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Tipo de paro</jet-label>
                    <Select2 v-model="form.paro_id"  class="InputSelect" :options="opcPR"  :settings="{width: '100%'}"/>
                    <!-- <select  v-model="form.paro_id" v-html="opcPR" ></select> -->
                    <small v-if="errors.paro_id" class="validation-alert">{{errors.paro_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 tw-text-center tw-mx-auto md:tw-mb-0">
                    <jet-label>Folio de orden de trabajo</jet-label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3" v-text="tOrden"></span>
                        <jet-input type="text" class="form-control" v-model="form.orden" @input="(val) => (form.orden = form.orden.toUpperCase())"></jet-input>
                    </div>
                    <small v-if="errors.orden" class="validation-alert">{{errors.orden}}</small>

                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 tw-text-center tw-mx-auto md:tw-mb-0">
                    <jet-label>Descripción</jet-label>
                    <textarea class="InputSelect" v-model="form.descri" maxlength="250" @input="(val) => (form.descri = form.descri.toUpperCase())" placeholder="Máximo 250 caracteres"></textarea>
                    <small v-if="errors.descri" class="validation-alert">{{errors.descri}}</small>
                </div>
            </div>
            <!-- Botones Actualizar guardar y cancelar -->
            <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
                <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="!editMode" @click="save(form)">Guardar</jet-button>
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
        <div class="tw-m-auto" style="width: 98%">
            <Table id="t_paros">
                <template v-slot:TableHeader>
                    <th class="columna tw-text-center">Orden</th>
                    <th class="columna tw-text-center">Maquina</th>
                    <th class="columna tw-text-center">Clave de paro</th>
                    <th class="columna tw-text-center">Nombre de paro</th>
                    <th class="columna tw-text-center">Descripción</th>
                    <th class="columna tw-text-center">Estatus</th>
                    <th class="columna tw-text-center">Inicio</th>
                    <th class="columna tw-text-center">Final</th>
                    <th class="columna tw-text-center">Tiempo cargado</th>
                    <th class="columna tw-text-center" v-if="(usuario.dep_pers.length == 0 | (noCor == 'cor' | noCor == 'enc'))">Plan de Acción</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter v-if="(usuario.dep_pers.length == 0 | (noCor == 'cor' | noCor == 'enc'))">
                    <tr class="fila" v-for="ca in Pcarga" :key="ca.id">
                        <td class="tw-text-center">{{ca.orden}}</td>
                        <td class="tw-text-center">{{ca.maq_pro.maquinas.Nombre}}</td>
                        <td class="tw-text-center">{{ca.paros.clave}}</td>
                        <td class="tw-text-center">{{ca.paros.descri}}</td>
                        <td class="tw-text-center">{{ca.descri}}</td>
                        <td class="tw-text-center">
                            <!-- detener normal -->
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-amber-600 tw-rounded-full tw-cursor-pointer" tooltip="Detener" flow="left" @click="detener(1, ca)" v-if="ca.estatus == 'Activo' & (ca.paro_id != 13 & ca.paro_id != 14 & ca.paro_id != 16)">{{ca.estatus}}</div>
                            <!-- detener con plan de accion -->
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-amber-600 tw-rounded-full tw-cursor-pointer" tooltip="Detener" flow="left" @click="plan(ca)" v-if="ca.estatus == 'Activo' & (ca.paro_id == 13 | ca.paro_id == 14 | ca.paro_id == 16)">{{ca.estatus}}</div>
                            <!-- en revision -->
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-blue-600 tw-rounded-full tw-cursor-pointer" tooltip="Autorizar" flow="left" @click="detener(2, ca)" v-if="(usuario.dep_pers.length == 0 | (noCor == 'cor' | noCor == 'enc')) & ca.estatus == 'En revisión'">{{ca.estatus}}</div>

                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-blue-600 tw-rounded-full" flow="left" v-if="(noCor == 'lid' | noCor == 'ope') & ca.estatus == 'En revisión'">{{ca.estatus}}</div>

                            <!-- Autorizar -->
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-green-600 tw-rounded-full" v-if="ca.estatus == 'Autorizado'">{{ca.estatus}}</div>
                        </td>
                        <td class="tw-text-center">{{ca.iniFecha}}</td>
                        <td class="tw-text-center">{{ca.finFecha == null ? '' : ca.finFecha}}</td>
                        <td class="tw-text-center">{{tiempo(ca.iniFecha, ca.finFecha)}}</td>
                        <td class="tw-text-center">{{ca.pla_acci}}</td>
                        <td class="tw-text-center">
                            <div class="columnaIconos">
                                <div class="iconoDelete" @click="detener(1, ca)" v-if="ca.estatus == 'Activo' & (ca.paro_id != 13 & ca.paro_id != 14 & ca.paro_id != 16)">
                                    <span tooltip="Detener" flow="left">
                                        <svg class="h-8 w-8 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="plan(ca)" v-if="ca.estatus == 'Activo' & (ca.paro_id == 13 | ca.paro_id == 14 | ca.paro_id == 16)">
                                    <span tooltip="Detener" flow="left">
                                        <svg class="h-8 w-8 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDetails" @click="detener(2, ca)" v-if="(usuario.dep_pers.length == 0 | (noCor == 'cor' | noCor == 'enc')) & ca.estatus == 'En revisión'">
                                    <span  tooltip="Autorizar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="elimi(ca)" v-if="usuario.IdEmp == '9999'">
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
                <template v-slot:TableFooter v-else>
                    <tr class="fila" v-for="ca in pcargaLO" :key="ca.id">
                        <td class="tw-text-center">{{ca.orden}}</td>
                        <td class="tw-text-center">{{ca.maq_pro.maquinas.Nombre}}</td>
                        <td class="tw-text-center">{{ca.paros.clave}}</td>
                        <td class="tw-text-center">{{ca.paros.descri}}</td>
                        <td class="tw-text-center">{{ca.descri}}</td>
                        <td class="tw-text-center">
                            <!-- detener normal -->
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-amber-600 tw-rounded-full tw-cursor-pointer" tooltip="Detener" flow="left" @click="detener(1, ca)" v-if="ca.estatus == 'Activo' & (ca.paro_id != 13 & ca.paro_id != 14 & ca.paro_id != 16)">{{ca.estatus}}</div>
                            <!-- detener con plan de accion -->
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-amber-600 tw-rounded-full tw-cursor-pointer" tooltip="Detener" flow="left" @click="plan(ca)" v-if="ca.estatus == 'Activo' & (ca.paro_id == 13 | ca.paro_id == 14 | ca.paro_id == 16)">{{ca.estatus}}</div>
                        </td>
                        <td class="tw-text-center">{{ca.iniFecha}}</td>
                        <td class="tw-text-center">{{ca.finFecha == null ? '' : ca.finFecha}}</td>
                        <td class="tw-text-center">{{tiempo(ca.iniFecha, ca.finFecha)}}</td>
                        <td class="tw-text-center">
                            <div class="columnaIconos">
                                <div class="iconoDelete" @click="detener(1, ca)" v-if="ca.estatus == 'Activo' & (ca.paro_id != 13 & ca.paro_id != 14 & ca.paro_id != 16)">
                                    <span tooltip="Detener" flow="left">
                                        <svg class="h-8 w-8 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="plan(ca)" v-if="ca.estatus == 'Activo' & (ca.paro_id == 13 | ca.paro_id == 14 | ca.paro_id == 16)">
                                    <span tooltip="Detener" flow="left">
                                        <svg class="h-8 w-8 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDetails" @click="detener(2, ca)" v-if="(usuario.dep_pers.length == 0 | (noCor == 'cor' | noCor == 'enc')) & ca.estatus == 'En revisión'">
                                    <span  tooltip="Autorizar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="elimi(ca)" v-if="usuario.IdEmp == '9999'">
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

        <!-- Modal -->
        <modal :show="showModal" @close="chageClose">
            <form>
                <!--------------------------- PROCESOS ------------------------------------>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Plan de acción</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 tw-w-full md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Plan de acción</jet-label>
                                    <textarea class="InputSelect" v-model="planA.pla_acci"  @input="(val) => (planA.pla_acci = planA.pla_acci.toUpperCase())" placeholder="Máximo 250 caracteres"></textarea>
                                    <small v-if="errors.pla_acci" class="validation-alert">{{errors.pla_acci}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ModalFooter">
                    <jet-button type="button" @click="update(planA)">Guardar</jet-button>
                    <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
                </div>
            </form>
        </modal>
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
import Select2 from 'vue3-select2-component';
//datatable
import datatable from 'datatables.net-bs5';
import $ from 'jquery';

import moment from 'moment';
import 'moment/locale/es';
import axios from 'axios';

export default {
    props: [
        'usuario',
        'depa',
        'paros',
        'errors'
    ],
    components: {
        Select2,
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
            procesos: [],
            materiales: [],
            Pcarga: [],
            pcargaLO: [],
            proc_prin: '',
            showModal: false,
            editMode: false,
            form: {
                fecha: moment().format("YYYY-MM-DD HH:mm:ss"),
                usu:  this.usuario.id,
                departamento_id: this.S_Area,
                tiempo: null,
                proceso_id: '',
                maq_pro_id: '',
                estatus: 'Activo',
                paro_id: '',
                descri: '',
                orden: ''
            },
            planA: {
                id: '',
                fecha: '',
                finFecha: moment().format("YYYY-MM-DD HH:mm:ss"),
                usu:  this.usuario.id,
                iniFecha: '',
                pla_acci: '',
                estatus: '',
                paro_id: '',
                tiempo: null,
            }
        }
    },
    mounted(){
        this.global()
    },
    methods: {
        temporizador() {
            setInterval(() => {
                this.ParosCarga(false)
                /* var changes = ((Math.random() * 100).toFixed(2))+'%'; */
                console.log ('ya');
            }, 300000);
        },
        async ParosCarga(limp){
            var datos = {'departamento_id': this.S_Area, 'modulo': 'Paros'};
            if(limp){
                $('#t_paros').DataTable().clear();
            }
            //Consulta los paros cargados
            let promesa = await axios.post('Paros/ParCar', datos);
            this.Pcarga = promesa.data;
            this.pcargaLO = this.Pcarga.filter(ele => {return ele.estatus == "Activo"})
            //console.log(this.pcargaLO)
            $('#t_paros').DataTable().destroy();
            this.tabla()

        },
        //datatable de carga
        tabla() {
            this.$nextTick(() => {
                $('#t_paros').DataTable({
                    "language": this.español,
                    "order": [[5, 'asc']],
                    "scrollX": true,
                    //"stateSave": true,
                    "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    "scrollX": true,
                    "columnDefs": [
                        { "width": "15%", "targets": [3,4,9] },
                        { "width": "10%", "targets": [0,1,2,5,6,7] }
                    ],
                    scrollY:        '50vh',
                    scrollCollapse: true,
                    paging:         false,
                })
            })
        },
        global(){
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
        tiempo(ini, fin){
            var tini = moment(ini);
            var tfin = fin == null ? moment() : moment(fin);
            return tfin.from(tini, true);
        },
        //plan de trabajo
        plan(data){
            this.showModal = !this.showModal
            this.planA.id = data.id;
            this.planA.fecha = data.fecha;
            this.planA.iniFecha = data.iniFecha
            this.planA.pla_acci = '';
            this.planA.paro_id = data.paro_id;
            this.planA.estatus = 'En revisión';
            this.planA.tiempo =  this.tiempo(data.iniFecha, data.finFecha);

        },
        resetPlan(){
            if (this.planA.pla_acci != '') {
                this.showModal = !this.showModal
            }
            this.planA.id = '';
            this.planA.fecha = '';
            this.planA.iniFecha = '';
            this.planA.pla_acci = '';
            this.planA.paro_id = '';
            this.planA.estatus = '';
            this.planA.tiempo = null;
        },
        /****************************** carga de carga de datos ******************************************/
        reset(){
            //this.claParo();
            //this.form.fecha = moment().format("YYYY-MM-DD HH:mm:ss");
            this.proc_prin = '';
            this.form.proceso_id = '';
            this.form.maq_pro_id = '';
            this.form.paro_id = '';
            this.form.descri = '';
            this.form.tiempo = null;
            this.form.estatus = 'Activo',
            this.form.orden = '';
            this.form.departamento_id = this.S_Area;
            this.editMode = false;
        },
        async save(data){
            data.fecha = moment().format("YYYY-MM-DD HH:mm:ss");
            data.departamento_id = this.S_Area;
            //$('#t_paros').DataTable().clear();
            data.VerInv = '0';


            if ( data.orden != '' & (data.paro_id == 13 | data.paro_id == 14 | data.paro_id == 16) ) {
                var er = data.orden;
                if (er.includes(this.tOrden) == false) {
                    data.orden = this.tOrden+data.orden;
                }
            }
            await axios.post('/Produccion/Paros', data)
            .then(resp => {this.reset(), this.alertSucces()})
            .catch(e => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: '¡Aun Faltan registros por llenar!',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
            this.ParosCarga(false)
        },
        //actualiza el estatus y lo detiene
        detener(det, data){
            //primer stop cambia estatus a "En revisión"
            if (det == 1) {
                data.estatus = 'En revisión';
                data.usu = this.usuario.id;
                data.finFecha = moment().format("YYYY-MM-DD HH:mm:ss");
                data.tiempo = this.tiempo(data.iniFecha, data.finFecha);
                this.update(data);
            }
            //pregunta si ya se va a guardas el dato o se deniega cambia estatus a "Autorizado" o "Activo"
            else if(det == 2){

                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger mx-3'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: '¿Autorizar?',
                    text: "Selecciona una opción",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Denegar',
                    reverseButtons: true
                }).then((result) => {
                    //si se acepta el paro se guarda
                    if (result.isConfirmed) {
                        swalWithBootstrapButtons.fire(
                        '¡Autorizado!',
                        'El paro fue autorizado correctamente',
                        'success'
                        )
                        data.estatus = 'Autorizado';
                        data.usu = data.perfil_fin_id;
                        this.update(data);
                    }//en caso de que no, reinicia y manda a nulo algunos datos
                    else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        '¡Denegado!',
                        'El paro se actualizó correctamente',
                        'error'
                        )
                        data.estatus = 'Activo';
                        data.finFecha = null;
                        data.tiempo = null;
                        this.update(data);
                    }
                })

            }

        },
        //actualiza los paros y sus estatus
        async update(data){
            /*axios.post('/Produccion/Paros/' + data.id, data)
            .then(resp => {this.ParosCarga(false), this.resetPlan(), this.alertSucces()});*/
            await this.$inertia.put('/Produccion/Paros/' + data.id, data, {
                onSuccess: () => {this.ParosCarga(false), this.alertSucces(), this.resetPlan()}, onError: () => {this.tabla()}
            });
        },
        //elimina los paros
        async elimi(dat){
            //console.log(dat)
            dat._method = 'DELETE';
            this.$inertia.post('/Produccion/Paros/' + dat.id, dat, {
                onSuccess: (eve) => { this.ParosCarga(false), this.alertSucces() },
                onError: (err) => {  }
            });

        },
        logout() {
            this.$inertia.post(route('logout'));
        },
    },
    computed: {
        noCor: function() {
            if (this.usuario.dep_pers.length != 0) {
                return this.usuario.dep_pers[0].ope_puesto;
            }
        },
        tOrden: function() {
            var depa = this.S_Area
            if(depa == 4){
                return '1-H1-';
            }else if(depa == 5){
                return '1-H2-';
            }else if(depa == 6){
                return '1-H3-';
            }else if(depa == 7){
                return 'AP-';
            }else if(depa == 18){
                return '1-PREP-';
            }
            else if(depa == 8){
                return 'HA-';
            }
            else {
                return 'N/A'
            }
        },
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
                if (pp.tipo == 0 & pp.tipo_carga == 'pro') {
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
                if ((sp.tipo == 1 & sp.proceso_id == this.proc_prin) | this.editMode ) {
                    ssp.push({id: sp.id, text: sp.id+' - '+sp.nompro});
                }
            })
            return ssp;
        },
        //Opciones maquinas
        opcMQ: function() {
            const mq = [];
            var mar = '';
            if (this.form.proceso_id != '') {
                this.procesos.forEach(pm => {
                    if (this.form.proceso_id == pm.id) {
                        pm.maq_pros.forEach(mp => {
                            mar = mp.maquinas.marca == null ? 'N/A' :  mp.maquinas.marca.Nombre
                            mq.push({id: mp.id, text: mp.id+' - '+mp.maquinas.Nombre + ' ' + mar});
                        })
                    }
                })
            }
            return mq;
        },
        opcPR: function() {
            //select paros
            var pr = []
            this.paros.forEach(pa => {
                pr.push({id: pa.id, text: pa.clave+' - '+pa.descri });
            })
            return pr;
        }
    },
    watch: {
        S_Area: async function(b){
            var datos = {'departamento_id': this.S_Area, 'modulo': 'Paros'};
             //Produccion
            let produ = await axios.post('General/ConProduccion', datos)
            this.procesos = produ.data;

            //Materiales
            let mate = await axios.post('General/ConMateriales', datos)
            this.materiales = mate.data

            this.ParosCarga(true)
        }
    }
}
</script>
