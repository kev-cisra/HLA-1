<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user-clock"></i>
                        Turnos
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB class="sm:tw-w-full" v-if="usuario.dep_pers.length != 1">
                <select @change="verTabla" class="InputSelect sm:tw-w-full" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button @click="openModal" class="BtnNuevo">Nuevo Turno </jet-button>
                <jet-button class="BtnNuevo" data-bs-toggle="modal" href="#tablaEquipo">Agregar Equipo</jet-button>
            </template>
        </Accions>
        <div class="">
            <jet-button v-for="bTur in turno" :key="bTur" class="BtnNuevo" data-bs-toggle="collapse" :data-bs-target="'#col'+bTur.id" aria-expanded="false" :aria-controls="'col'+bTur.id">{{bTur.nomtur}}</jet-button>
        </div>
        <div class="lg:tw-flex tw-p-4 tw-gap-3">
            <div v-for="cTur in turno" :key="cTur" :id="'col'+cTur.id" class="collapse multi-collapse tw-flex-auto">
                <div class="card card-body">
                    <!----------------- Tabla de turnos -------------->
                    <table class="table table-striped tw-table-fixed">
                        <tr class="tw-text-center tw-bg-teal-600">
                            <th colspan="2" class="columna tw-border-2">{{ cTur.nomtur }}</th>
                        </tr>
                        <tr >
                            <th class="fila tw-text-center tw-border-2">Departamento</th>
                            <td class="fila tw-text-center tw-border-2">{{cTur.departamento.Nombre}}</td>
                        </tr>
                        <tr >
                            <th class="fila tw-text-center tw-font-semibold tw-border-2" colspan="2">Horario de la semana</th>
                        </tr>
                        <tr >
                            <th class="fila">
                                <label class="tw-w-full tw-h-full tw-text-center tw-border-2">Lunes A Viernes</label>
                                <label class="tw-w-full tw-h-full tw-text-center tw-border-2">{{cTur.LVIni}} - {{cTur.LVFin}}</label>
                            </th>
                            <th class="fila">
                                <label class="tw-w-full tw-h-full tw-text-center tw-border-2">Sabado y Domingo</label>
                                <label class="tw-w-full tw-h-full tw-text-center tw-border-2">{{cTur.SDIni}} - {{cTur.SDFin}}</label>
                            </th>
                        </tr>
                        <tr >
                            <th class="fila tw-text-center tw-border-2">Tiempo extra</th>
                            <td class="fila tw-text-center tw-border-2">{{cTur.cargaExt}}</td>
                        </tr>
                        <tr>
                            <th class="fila tw-text-center  tw-border-2">Equipos asignados</th>
                            <td class="fila tw-text-center  tw-border-2">
                                <tr v-for="equ in cTur.equipos" :key="equ" @click="editE(equ)"  data-bs-target="#modla2" data-bs-toggle="modal" data-bs-dismiss="modal" class="columna tw-text-blue-700 hover:tw-text-blue-900 tw-text-center">{{equ.nombre}}</tr>
                            </td>
                        </tr>
                        <td colspan="2" class="tw-text-center ">
                            <jet-button type="button" class="tw-bg-blue-600 hover:tw-bg-blue-700 tw-text-center tw-w-full md:tw-w-2/6 lg:tw-w-3/12" @click="edit(cTur)">Actualizar</jet-button>
                            <jet-CancelButton type="button" class=" tw-text-center tw-w-full md:tw-w-2/6 lg:tw-w-3/12" @click="deleteRow(cTur)">Eliminar</jet-CancelButton>
                        </td>
                    </table>
                </div>
            </div>
        </div>
        <!------------------ Modal ------------------------->
        <modal :show="showModal" @close="chageClose">
            <form>
                <!---------------------------  ------------------------------------>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Turnos</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex" v-show="!editMode">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Departamento</jet-label>
                                    <select class="InputSelect" v-model="form.departamento_id" :disabled="S_Area != '' ? 1 : 0" v-html="opc">
                                    </select>
                                    <small v-if="errors.departamento_id" class="validation-alert">{{errors.departamento_id}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Turno</jet-label>
                                    <select v-model="form.nomtur" class="InputSelect">
                                        <option value="" disabled>Selecciona un turno</option>
                                        <option value="Turno 1">Turno 1</option>
                                        <option value="Turno 2">Turno 2</option>
                                        <option value="Turno 3">Turno 3</option>
                                        <option value="Vacio">Turno Vacío</option>
                                    </select>
                                    <small v-if="errors.nomtur" class="validation-alert">{{errors.nomtur}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label>Tiempo para carga</jet-label>
                                    <select v-model="form.cargaExt" class="InputSelect">
                                        <option value="15">15 minutos</option>
                                        <option value="30">30 minutos</option>
                                        <option value="45">45 minutos</option>
                                        <option value="60">60 minutos</option>
                                    </select>
                                    <small v-if="errors.cargaExt" class="validation-alert">{{errors.cargaExt}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Inicio del turno de Lunes a viernes</jet-label>
                                    <jet-input type="time" v-model="form.LVIni" class=""></jet-input>
                                    <small v-if="errors.LVIni" class="validation-alert">{{errors.LVIni}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fin del turno de Lunes a viernes</jet-label>
                                    <jet-input type="time" v-model="form.LVFin" class=""></jet-input>
                                    <small v-if="errors.LVFin" class="validation-alert">{{errors.LVFin}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Inicio del turno de sabado a domingo</jet-label>
                                    <jet-input type="time" v-model="form.SDIni" class=""></jet-input>
                                    <small v-if="errors.SDIni" class="validation-alert">{{errors.SDIni}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fin del turno de sabado a domingo</jet-label>
                                    <jet-input type="time" v-model="form.SDFin" class=""></jet-input>
                                    <small v-if="errors.SDFin" class="validation-alert">{{errors.SDFin}}</small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="ModalFooter">
                    <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                    <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
                    <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
                </div>
            </form>
        </modal>
        <!---------------------- Modal 2 --------------------------------->
        <div class="modal fade" id="tablaEquipo" aria-hidden="true" aria-labelledby="tablaEquipoLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Equipos</h3>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="columna">Turno</th>
                                        <th class="columna">Equipo</th>
                                        <th class="columna tw-w-64">Personal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="equipo in equipos" :key="equipo">
                                        <td class="fila">{{equipo.turnos.nomtur}}</td>
                                        <td class="fila">{{equipo.nombre}}</td>
                                        <td class="">
                                            <div class="overflow-auto tw-h-48">
                                                <div v-for="perso in equipo.dep_pers" :key="perso" class="tw-border-b-4 tw-border-blueGray-700 hover:tw-bg-sky-600 tw-w-full">
                                                        {{perso.perfiles.Nombre}} {{perso.perfiles.ApPat}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#modla2" data-bs-toggle="modal" data-bs-dismiss="modal">Agregar Equipo</button>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------------------------- modal insert ----------------------------------------------->
        <div class="modal fade" id="modla2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Equipos</h3>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" >
                                <jet-label><span class="required">*</span>Departamento</jet-label>
                                <select class="InputSelect" @change="verTabla" v-model="form2.departamento_id" v-html="opc" :disabled="S_Area != '' ? 1 : 0">
                                </select>
                                <small v-if="errors.departamento_id" class="validation-alert">{{errors.departamento_id}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Turno</jet-label>
                                <select v-model="form2.turno_id" class="InputSelect">
                                    <option value="" disabled>Selecciona un turno</option>
                                    <option v-for="(item, index) in turno" :key="index" :value="item.id" >{{ item.nomtur }}</option>
                                </select>
                                <small v-if="errors.turno_id" class="validation-alert">{{errors.turno_id}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Equipo</jet-label>
                                <select v-model="form2.nombre" class="InputSelect">
                                    <option value="" disabled>Selecciona un Equipo</option>
                                    <option value="Equipo 1">Equipo 1</option>
                                    <option value="Equipo 2">Equipo 2</option>
                                    <option value="Equipo 3">Equipo 3</option>
                                    <option value="Equipo 4">Equipo 4</option>
                                </select>
                                <small v-if="errors.nombre" class="validation-alert">{{errors.nombre}}</small>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex tw-justify-center">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-96 md:tw-mb-0 tw-text-left">
                                <jet-label><span class="required">*</span>Personal</jet-label>
                                <div class="overflow-auto tw-h-40 tw-mx-auto">
                                    <div v-for="persona in personal" :key="persona" class="tw-gap-y-10 hover:tw-bg-sky-600">
                                        <input type="checkbox" :id="persona.id" v-model="form2.emp" :value="persona.id">
                                        <label :for="persona.id">
                                            {{persona.perfiles.IdEmp}} - {{persona.perfiles.Nombre}} {{persona.perfiles.ApPat}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-target="#tablaEquipo" data-bs-toggle="modal" data-bs-dismiss="modal" @click="reset2()">Regresar</button>
                        <jet-button type="button" data-bs-target="#tablaEquipo" data-bs-toggle="modal" data-bs-dismiss="modal" @click="saveE(form2)">Guardar</jet-button>
                        <!-- <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal">Back to first</button> -->
                    </div>
                </div>
            </div>
        </div>





        <!-- <modal :show="showModal2" @close="chageClose2">
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Equipos</h3>
                    </div>
                    <div class="tw-flex">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="columna">Turno</th>
                                        <th class="columna">Equipo</th>
                                        <th class="columna tw-w-64">Personal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="equipo in equipos" :key="equipo">
                                        <td class="fila">{{equipo.turnos.nomtur}}</td>
                                        <td class="fila">{{equipo.nombre}}</td>
                                        <td class="">
                                            <div class="overflow-auto tw-h-48">
                                                <div v-for="perso in equipo.dep_pers" :key="perso" class="tw-border-b-4 tw-border-blueGray-700 hover:tw-bg-sky-600 tw-w-full">
                                                        {{perso.perfiles.Nombre}} {{perso.perfiles.ApPat}}
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tw-mt-4">
                            <div class="ModalForm">
                                <div class="tw-mb-6 md:tw-flex">
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" >
                                        <jet-label><span class="required">*</span>Departamento</jet-label>
                                        <select class="InputSelect" @change="verTabla" v-model="form2.departamento_id" v-html="opc" :disabled="S_Area != '' ? 1 : 0">
                                        </select>
                                        <small v-if="errors.departamento_id" class="validation-alert">{{errors.departamento_id}}</small>
                                    </div>
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                        <jet-label><span class="required">*</span>Turno</jet-label>
                                        <select v-model="form2.turno_id" class="InputSelect">
                                            <option value="" disabled>Selecciona un turno</option>
                                            <option v-for="(item, index) in turno" :key="index" :value="item.id" >{{ item.nomtur }}</option>
                                        </select>
                                        <small v-if="errors.turno_id" class="validation-alert">{{errors.turno_id}}</small>
                                    </div>
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                        <jet-label><span class="required">*</span>Equipo</jet-label>
                                        <select v-model="form2.nombre" class="InputSelect">
                                            <option value="" disabled>Selecciona un Equipo</option>
                                            <option value="Equipo 1">Equipo 1</option>
                                            <option value="Equipo 2">Equipo 2</option>
                                            <option value="Equipo 3">Equipo 3</option>
                                            <option value="Equipo 4">Equipo 4</option>
                                        </select>
                                        <small v-if="errors.nombre" class="validation-alert">{{errors.nombre}}</small>
                                    </div>
                                </div>

                                <div class="tw-mb-6 md:tw-flex tw-justify-center">
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-96 md:tw-mb-0 tw-text-left">
                                        <jet-label><span class="required">*</span>Personal</jet-label>
                                        <div class="overflow-auto tw-h-40 tw-mx-auto">
                                            <div v-for="persona in personal" :key="persona" class="tw-gap-y-10 hover:tw-bg-sky-600">
                                                <input type="checkbox" :id="persona.id" v-model="form2.emp" :value="persona.id">
                                                <label :for="persona.id">
                                                    {{persona.perfiles.IdEmp}} - {{persona.perfiles.Nombre}} {{persona.perfiles.ApPat}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="ModalFooter">
                        <jet-button type="button" @click="saveE(form2)">Guardar</jet-button>
                    </div>
                </div>
            </div>
        </modal> -->
        <pre>
            {{turno}}
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
            'turno',
            'equipos',
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
            Modal,
            JetLabel
        },
        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                opc: '<option value="" disabled>Selecciona un departamento </option>',
                campo_max: 10,
                x: 1,
                eq_dep: null,
                showModal: false,
                showModal2: false,
                editMode: false,
                editMode2: false,
                form: {
                    nomtur: '',
                    departamento_id: this.S_Area,
                    LVIni: '',
                    LVFin: '',
                    SDIni: '',
                    SDFin: '',
                    cargaExt: '15'
                },
                form2: {
                    departamento_id: this.S_Area,
                    turno_id: '',
                    nombre: '',
                    emp: []
                }

            }
        },
        mounted() {
            this.mostSelect();
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
                this.$inertia.get('/Produccion/Turnos',{ busca: event.target.value }, {
                    onSuccess: () => {  }, preserveState: true
                });
            },
            /******************************* opciones de modal funciones basicas *******************************************/
            //abrir y reset del modal procesos
            openModal() {
                this.chageClose();
                this.reset();
                this.editMode = false;
            },
            //abrir o cerrar modal procesos
            chageClose(){
                this.showModal = !this.showModal
            },
            //reset de modal procesos
            reset(){
                this.form = {
                    nomtur: '',
                    departamento_id: this.S_Area,
                    LVIni: '',
                    LVFin: '',
                    SDIni: '',
                    SDFin: '',
                    cargaExt: '15'
                }
            },
            /******************************* opciones de modal2 funciones basicas *******************************************/
            //abrir y reset del modal procesos
            openModal2() {
                this.chageClose2();
                this.reset2();
                this.editMode2 = false;
            },
            //abrir o cerrar modal procesos
            chageClose2(){
                this.showModal2 = !this.showModal2
            },
            //reset de modal procesos
            reset2(){
                this.form2 = {
                    departamento_id: this.S_Area,
                    turno_id: '',
                    nombre: '',
                    emp: []
                }
            },
            /******************************** Acciones insert update y delet turnos *************************************/
            //guardar información de procesos
            save(form) {
                //console.log(form)
                if (form.nomtur == 'Vacio') {
                    form.LVIni = '00:01';
                    form.LVFin = '00:01';
                    form.SDIni = '00:01';
                    form.SDFin = '00:01';
                }
                this.$inertia.post('/Produccion/Turnos', form, {
                    onSuccess: () => { this.alertSucces(), this.reset(), this.chageClose()}, preserveState: true
                });
            },
            edit: function(data) {
                //console.log(data);
                this.form = Object.assign({}, data);
                //this.vari = data.id;
                this.editMode = true;
                this.chageClose();
            },
            update(data) {
                if (data.nomtur == 'Vacio') {
                    data.LVIni = '00:01';
                    data.LVFin = '00:01';
                    data.SDIni = '00:01';
                    data.SDFin = '00:01';
                }
                data._method = 'PUT';
                this.$inertia.post('/Produccion/Turnos/' + data.id, data, {
                    onSuccess: () => {this.reset(), this.chageClose()},
                });
            },
            deleteRow: function (data) {
                if (!confirm('¿Estás seguro de querer eliminar este Turno?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/Produccion/Turnos/' + data.id, data, {onSuccess: () => { this.alertDelete() }});
            },
            /******************************** Acciones insert update y delet equipos *************************************/
            saveE(form) {
                //console.log(form)
                this.$inertia.post('/Produccion/Equipos', form, {
                    onSuccess: () => {this.alertSucces(), this.reset2(), this.chageClose2()}, preserveState: true
                })
            },
            editE: function(data) {
                //this.form2 = Object.assign({}, data);
                /* console.log(data) */
                this.form2.departamento_id = data.departamento_id;
                this.form2.turno_id = data.turno_id;
                this.form2.nombre = data.nombre;
                this.form2.emp = [];
                data.dep_pers.forEach(e => {
                    this.form2.emp.push(e.id);
                })
                /* this.editMode2 = true; */
                this.chageClose2();
            }
        }
    }
</script>
