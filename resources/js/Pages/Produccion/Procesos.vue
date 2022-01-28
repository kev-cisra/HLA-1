
<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-cogs"></i>
                        Procesos
                </h3>
            </slot>
        </Header>

        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <select class="InputSelect sm:tw-w-full" @change="verTabla" v-model="S_Area">
                    <option value="" disabled>Selecciona un departamento</option>
                    <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <div class="tw-m-3">
                    <jet-button @click="openModal" class="tw-w-full">Nuevo Proceso </jet-button>
                </div>
            </template>
        </Accions>
        <!-- datatables de los procesos -->
        <div class="tw-m-auto" style="width: 98%">
            <Table id="t_pro" style="width: 100%">
                <template v-slot:TableHeader>
                    <th class="columna tw-text-center">Id</th>
                    <th class="columna tw-text-center">Nombre</th>
                    <th class="columna tw-text-center">Tipo</th>
                    <th class="columna tw-text-center">Descripción</th>
                    <th class="columna tw-text-center">Departamento</th>
                    <th class="columna tw-text-center tw-w-2/12">Máquinas</th>
                    <th class="columna tw-text-center">Sub procesos</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="proceso in procesos" :key="proceso.id"  class="fila">
                        <td>{{ proceso.id }}</td>
                        <td >{{ proceso.nompro }}</td>
                        <td >{{ this.tipoProce(proceso.tipo) }}</td>
                        <td >{{ proceso.descripcion }}</td>
                        <td >{{ proceso.departamentos.Nombre }}</td>
                        <td class="">
                            <tr  v-for="f in proceso.formulas" :key="f.id" class="hover:tw-text-lg">
                                - {{f.proc_relas == null ? 'N/A' : f.proc_relas.nompro}} / {{f.maq_pros == null ? 'N/A' : f.maq_pros.maquinas.Nombre}} -
                            </tr>
                            <tr  v-for="mp in proceso.maq_pros" :key="mp.id" class="hover:tw-text-lg">
                                - <strong class="tw-text-red-500">{{ mp.id }}</strong> - {{mp.maquinas.Nombre}} -
                            </tr>
                        </td>
                        <td class="fila">
                            <tr class="fila hover:tw-text-lg" v-for="sub_proce in proceso.sub_proceso" :key="sub_proce">
                                - {{sub_proce.nompro}} -
                            </tr>
                        </td>
                        <td class="fila">
                            <div class="columnaIconos">
                                <div class="iconoEdit" @click="edit(proceso)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="deleteRow(proceso)">
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

        <!------------------ Modal ------------------------->
        <modal :show="showModal" @close="chageClose">
            <form>
                <!--------------------------- PROCESOS ------------------------------------>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Procesos</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="!editMode">
                                    <jet-label><span class="required">*</span>Departamento</jet-label>
                                    <select class="InputSelect" v-model="form.departamento_id" :disabled="S_Area != '' ? 1 : 0">
                                        <option value="" disabled>Selecciona un departamento</option>
                                        <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                                    </select>
                                    <small v-if="errors.departamento_id" class="validation-alert">{{errors.departamento_id}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Nombre del proceso</jet-label>
                                    <jet-input type="text" v-model="form.nompro" @input="(val) => (form.nompro = form.nompro.toUpperCase())"></jet-input>
                                    <small v-if="errors.nompro" class="validation-alert">{{errors.nompro}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="!editMode">
                                    <jet-label><span class="required">*</span>Tipo de proceso</jet-label>
                                    <select v-model="form.tipo" @change="limpTipo()" class="InputSelect">
                                        <option value="" disabled>Seleccione</option>
                                        <option value="0">Proceso principal</option>
                                        <option value="1">Carga para Lider / Operador</option>
                                        <option value="2">Carga para Coordinador</option>
                                        <option value="5">Merma</option>
                                        <!-- <option value="4">Entregas</option> -->
                                        <option value="3">Formulas</option>
                                    </select>
                                    <small v-if="errors.tipo" class="validation-alert">{{errors.tipo}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="form.tipo == 0 & form.tipo != ''">
                                    <jet-label><span class="required">*</span>Tipo de Carga</jet-label>
                                    <select class="InputSelect" v-model="form.tipo_carga">
                                        <option value="">Selecciona</option>
                                        <!-- <option value="ent">Entregas</option> -->
                                        <option value="pro">Principales para Lider/Operador</option>
                                        <option value="pro-cor">Principales para Coordinador/Encargado</option>
                                        <option value="entre">Entregas</option>
                                        <option value="for">Formulas</option>
                                    </select>
                                    <small v-if="errors.tipo_carga" class="validation-alert">{{errors.tipo_carga}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="form.tipo == 3">
                                    <jet-label><span class="required">*</span>Tipo de formula</jet-label>
                                    <select class="InputSelect" v-model="form.operacion">
                                        <option value="">Selecciona una operación</option>
                                        <option value="sm_d">SUMA DIARIA</option>
                                        <option value="sm_dc">SUMA DIARIA POR CLAVE</option>
                                        <option value="sm_dp">SUMA DIARIA POR PARTIDA</option>
                                        <option value="sm_t">SUMA TURNO</option>
                                        <option value="sm_tc">SUMA TURNO POR CLAVE</option>
                                        <option value="sm_tp">SUMA TURNO POR PARTIDA</option>
                                        <option value="sem_sm">SUMA SEMANAL</option>
                                        <!-- <option value="mes_sm">SUMA MENSUAL</option> -->
                                        <option value="efi_dia">EFICIENCIA DIARIA</option>
                                        <option value="efi_tur">EFICIENCIA DEL TURNO</option>
                                        <option value="efi_sem">EFICIENCIA POR SEMANA</option>
                                        <option value="efi_mes">EFICIENCIA POR MES</option>
                                        <option value="efi_ano">EFICIENCIA ANUAL</option>
                                        <!-- <option value="ano_sm">SUMA ANUAL</option> -->
                                    </select>
                                    <small v-if="errors.operacion" class="validation-alert">{{errors.operacion}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="form.tipo != 0">
                                    <jet-label><span class="required">*</span>Proceso principal</jet-label>

                                    <Select2 v-model="form.proceso_id" class="InputSelect" :settings="{width: '100%', allowClear: true}" :options="opcPP" />

                                    <!-- <select class="InputSelect" v-model="form.proceso_id">
                                        <option value="" disabled>Selecciona un proceso</option>
                                        <option v-for="pp in opcPP" :key="pp" :value="pp.id">{{pp.text}}</option>
                                    </select> -->
                                    <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label>Descripción</jet-label>
                                    <textarea v-model="form.descripcion" class="InputSelect" @input="(val) => (form.descripcion = form.descripcion.toUpperCase())"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------------------------- ENCARGADO Y OPERADOR --------------------------------------->
                <div class="tw-px-4 tw-py-4" v-show="(form.tipo == 1 | form.tipo == 2 | form.tipo == 5)">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de máquinas</h3>
                        </div>
                    </div>
                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <!-- boton para agregar maquinas -->
                            <div class="tw-flex tw-justify-center">
                                <button type="button" class="btn btn-success tw-w-1/3 " @click="addRow()">Agregar Máquina</button>
                            </div>
                            <!-- div de los difierentes procesos -->
                            <div class="row tw-overflow-auto" style="height: 20rem">
                                <div class="tw-flex tw-justify-center tw-h-1/6" v-for="(row, index) in form.maquinas" :key="row.id">
                                    <div class="input-group tw-my-2">
                                        <Select2 v-model="row.value" class="form-select" :settings="{width: '100%', allowClear: true}" :options="opcMaq" />
                                        <!-- <select class="form-select" v-model="row.value" >
                                            <option value="" disabled>Selecciona una máquina</option>
                                            <option v-for="mq in opcMaq" :key="mq" :value="mq.id">{{mq.text}} - {{mq.marca}}</option>
                                        </select> -->
                                        <button type="button" class="btn btn-success" @click="addRow()">Agregar</button>
                                        <button type="button" class="btn btn-danger" @click="removeRow(index)">Quitar</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-------------------------------- FORMULAS --------------------------------------->
                <div class="tw-px-4 tw-py-4" v-show="form.tipo == 3">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Formulas</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <!-- boton para agregar procesos -->
                            <div class="tw-flex tw-justify-center">
                                <button type="button" class="btn btn-primary tw-w-1/3" @click="addForRow()">Agregar proceso</button>
                            </div>
                            <!-- div de los difierentes procesos -->
                            <div class="overflow-auto row" style="height: 22rem">
                                <div v-for="(f, index) in form.formulas" :key="f.id" class="m-3 mx-auto col-md-5">
                                    <!-- <select class="InputSelect" v-model="f.val">
                                        <option value="">Selecciona un proceso</option>
                                        <option v-for="proceso in opcFP" :key="proceso.id" :value="proceso.id">{{proceso.text}}</option>
                                    </select> -->

                                    <Select2 v-model="f.val" class="form-select" :settings="{width: '100%', allowClear: true}" :options="opcFP" />

                                    <div v-for="proceso in procesos" :key="proceso.id">
                                        <div v-if="proceso.id == f.val & proceso.maq_pros.length != 0" class="overflow-auto tw-text-center" style="height: 10rem">
                                            <label v-for="mp in proceso.maq_pros" :key="mp.id" class="m-2 w-100">
                                                <input type="checkbox" :value="f.val+'-'+mp.id" v-model="form.for_maq" checked>
                                                {{mp.maquinas.Nombre}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="gap-2 d-grid tw-mt-2" v-show="!editMode">
                                        <button type="button" class="btn btn-primary" @click="removeForRow(index)">Quitar proceso</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="ModalFooter">
                    <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                    <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
                    <jet-CancelButton @click="chageClose()">Cerrar</jet-CancelButton>
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
    import Select2 from 'vue3-select2-component';
    import Modal from '@/Jetstream/Modal';
    import JetLabel from '@/Jetstream/Label';

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
            'procesos',
            'depa',
            'maquinas',
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
            Select2,
            JetLabel
        },
        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                x: 1,
                showModal: false,
                editMode: false,
                form: {
                    nompro: null,
                    departamento_id: this.S_Area,
                    tipo: '',
                    tipo_carga: '',
                    operacion: '',
                    descripcion: null,
                    proceso_id: '',
                    maquinas: [
                        {value: ""}
                    ],
                    formulas: [
                        {val: ""}
                    ],
                    for_maq: [],
                }

            }
        },
        mounted() {
            this.globales();
            /* this.tabla(); */
        },
        methods: {
            /* Globales */
            globales() {
                if (this.usuario.dep_pers.length != 0) {
                    this.S_Area = this.usuario.dep_pers[0].departamento_id;
                }else{
                    this.S_Area = 7;
                }
            },
            //reset table
            verTabla(){
                $('#t_pro').DataTable().clear();
            },
            /************************** agrega inputs a formulas  ************************/
            addForRow: function () {
                this.form.formulas.push({val: ""});
            },
            removeForRow: function (row) {
                this.form.formulas.splice(row,1);
            },
            /************************** agregar inputs a maquinas ************************/
            addRow: function () {
                this.form.maquinas.push({value: ""});
            },
            removeRow: function (row) {
                //console.log(row);
                this.form.maquinas.splice(row,1);
            },
            /****************************** Alertas *******************************************************/
            tipoProce(data){
                switch (data) {
                    case '0':
                        return 'Proceso Principal';
                        break;
                    case '1':
                        return 'Carga de Operador';
                        break;
                    case '2':
                        return 'Carga de Coordinador';
                        break;
                    case '3':
                        return 'Operaciones';
                        break;
                    case '4':
                        return 'Entregas';
                        break;
                    case '5':
                        return 'Merma';
                        break;
                }
            },
            /******************************* opciones de data table ****************************************/
            //datatable
            tabla() {
                this.$nextTick(() => {
                    $('#t_pro').DataTable({
                        "language": this.español,
                        stateSave: true,
                        "scrollX": true,
                        "order": [2, 'desc'],
                        "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        buttons: [
                            {
                                extend: 'copyHtml5',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            'colvis'
                        ]
                    });
                })
            },
            /******************************* Alertas *******************************************************/
            //alerta
            alertArea(){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    title: 'Se tiene que cambiar el valor de la area',
                    // background: '#99F6E4',
                })
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
                    nompro: null,
                    departamento_id: this.S_Area,
                    tipo: '',
                    tipo_carga: '',
                    operacion: '',
                    descripcion: null,
                    proceso_id: '',
                    maquinas: [
                        {value: ""}
                    ],
                    formulas: [
                        {val: ""}
                    ],
                    for_maq: [],

                }
            },
            //limpia tipo
            limpTipo(){
                if (this.editMode == false) {
                    this.form.proceso_id= '';
                    this.form.operacion= '';
                    this.form.tipo_carga= '';
                    this.form.maquinas= [{value: ""}];
                    this.form.formulas= [{val: ""}];
                    this.form.for_maq= [];
                }
            },
            /******************************** Acciones insert update y delet *************************************/
            //guardar información de procesos
            save(form) {
                //console.log(form)
                $('#t_pro').DataTable().destroy();
                this.$inertia.post('/Produccion/Procesos', form, {
                    onSuccess: () => { this.alertSucces(), this.tabla(), this.reset(), this.chageClose()}, onError: () => {this.tabla()}
                });
            },
            //manda datos de la tabla al modal
            edit: function (data) {
                //console.log(data);
                this.form.id = data.id;
                this.form.departamento_id = data.departamento_id;
                this.form.nompro = data.nompro;
                this.form.tipo = data.tipo;
                this.form.tipo_carga = data.tipo_carga;
                this.form.operacion = data.operacion;
                this.form.proceso_id = data.proceso_id;
                this.form.descripcion = data.descripcion;
                this.form.maquinas = [];
                this.form.formulas = [];
                this.form.for_maq = [];
                this.form.Nfor_maq = [];
                this.form.Nformulas = [];
                data.maq_pros.forEach(mp => {
                    this.form.maquinas.push({value: mp.maquina_id});
                })

                var forml = '';
                data.formulas.forEach(fo => {
                    forml = this.form.formulas.find(ele => ele.val== fo.proc_relas.id)
                    this.form.for_maq.push(fo.proc_rela+'-'+fo.maq_pros_id)
                    this.form.Nfor_maq.push(fo.proc_rela+'-'+fo.maq_pros_id)
                    if (!forml) {
                        this.form.formulas.push({val: fo.proc_rela})
                        this.form.Nformulas.push({val: fo.proc_rela})
                    }
                })
                this.editMode = true;
                this.chageClose();
            },
            //actualiza información de los procesos
            update(data) {
                data._method = 'PUT';
                this.$inertia.post('/Produccion/Procesos/' + data.id, data, {
                    onSuccess: () => {this.reset(), this.chageClose()},
                });
            },
            deleteRow: function (data) {
                Swal.fire({
                    title: '¿Estás seguro de querer eliminar este Proceso?',
                    text: "¡Si se elimina no se podrá revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                        'Eliminadó!',
                        '¡El registro se eliminó correctamente!',
                        'success'
                        )
                        $('#t_pro').DataTable().destroy()
                        data._method = 'DELETE';
                        this.$inertia.post('/Produccion/Procesos/' + data.id, data, {onSuccess: () => { this.alertDelete(), this.tabla() }, onError: () => {this.tabla()}});
                    }
                })

            },
        },
        computed:{
            noCor: function() {
                if (this.usuario.dep_pers.length != 0) {
                    return this.usuario.dep_pers[0].ope_puesto;
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
            //Opciones Maquinas
            opcMaq: function() {
                const mq = [];
                var mar = '';
                this.maquinas.forEach(r => {
                    mar = r.marca == null ? 'N/A' : r.marca.Nombre;
                    mq.push({id: r.id, text: r.Nombre+' - '+mar});
                })
                return mq;
            },
            //Opciones Procesos principales
            opcPP: function() {
                const pp = [];
                this.procesos.forEach(element => {
                    if (element.tipo == 0 & element.tipo_carga != 'ent') {
                        pp.push({id: element.id, text: element.nompro});
                    }
                })
                return pp;
            },
            //Opciones de formulas procesos
            opcFP: function() {
                const fp = [];
                this.procesos.forEach(e => {
                    if ((e.tipo != 0 & e.tipo != 3) | e.tipo_carga == 'ent') {
                        fp.push({id: e.id, text: e.nompro})
                    }
                })
                return fp;
            }
        },
        watch: {
            S_Area: function(b){
                $('#t_pro').DataTable().destroy();
                this.$inertia.get('/Produccion/Procesos',{ busca: b }, {
                    onSuccess: () => { this.tabla() }, onError: () => {this.tabla()}, preserveState: true
                });
            },
        },
    }
</script>
