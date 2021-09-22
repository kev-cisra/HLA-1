
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
                <select @change="verTabla" class="InputSelect" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button @click="openModal" class="BtnNuevo">Nuevo Proceso </jet-button>
            </template>
        </Accions>
        <!-- datatables de los procesos -->
        <div class="table-responsive">
            <Table id="t_pro">
                <template v-slot:TableHeader>
                    <th class="columna tw-text-center">Nombre</th>
                    <th class="columna tw-text-center">Tipo</th>
                    <th class="columna tw-text-center">Descripción</th>
                    <th class="columna tw-text-center">Departamento</th>
                    <th class="columna tw-text-center tw-w-2/12">Máquinas</th>
                    <th class="columna tw-text-center">Sub procesos</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="proceso in procesos" :key="proceso.id">
                        <td class="fila">{{ proceso.nompro }}</td>
                        <td class="fila">{{ this.tipoProce(proceso.tipo) }}</td>
                        <td class="fila">{{ proceso.descripcion }}</td>
                        <td class="fila">{{ proceso.departamentos.Nombre }}</td>
                        <td class="fila" >
                            <tr class="fila" v-for="mp in proceso.maq_pros" :key="mp.id">
                               - {{mp.maquinas.Nombre}} -
                            </tr>
                        </td>
                        <td class="fila ">
                            <tr class="fila" v-for="sub_proce in proceso.sub_proceso" :key="sub_proce">
                                - {{sub_proce.nompro}} -
                            </tr>
                        </td>
                        <td class="fila">
                            <div class="columnaIconos">
                                <div class="iconoEdit" @click="edit(proceso)" v-show="(puesCor == 'cor' & (proceso.tipo == 1 | proceso.tipo == 4 | proceso.tipo == 5)) | usuario.dep_pers.length == 0">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="deleteRow(proceso)" v-show="puesCor != 'cor' | usuario.dep_pers.length == 0">
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
                                    <select class="InputSelect" v-model="form.departamento_id" v-html="opc" :disabled="S_Area != '' ? 1 : 0">
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
                                    <select v-model="form.tipo" class="InputSelect">
                                        <option value="" disabled>Seleccione</option>
                                        <option value="0">Proceso principal</option>
                                        <option value="1">Produccion Lider / Operador</option>
                                        <option value="5">Merma</option>
                                        <option value="4">Entregas</option>
                                        <option value="2" v-show="usuario.dep_pers.length == 0">Produccion Coordinador</option>
                                        <option value="3" v-show="puesCor != 'cor' | usuario.dep_pers.length == 0">Formulas</option>
                                    </select>
                                    <small v-if="errors.tipo" class="validation-alert">{{errors.tipo}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="form.tipo == 0 & form.tipo != ''">
                                    <jet-label><span class="required">*</span>Tipo de Carga</jet-label>
                                    <select class="InputSelect" v-model="form.tipo_carga">
                                        <option value="">Selecciona</option>
                                        <option value="ent">Entregas</option>
                                        <option value="pro">Producción Lider/Operador</option>
                                        <option value="pro-cor">Producción Coordinador/Encargado</option>
                                        <!-- <option value="for">Formulas</option> -->
                                    </select>
                                    <small v-if="errors.tipo_carga" class="validation-alert">{{errors.tipo_carga}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="form.tipo == 3">
                                    <jet-label><span class="required">*</span>Tipo de formula</jet-label>
                                    <select class="InputSelect" v-model="form.operacion">
                                        <option value="">Selecciona una operación</option>
                                        <option value="sm_d">SUMA DIARIA</option>
                                    </select>
                                    <small v-if="errors.operacion" class="validation-alert">{{errors.operacion}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="form.tipo != 0">
                                    <jet-label><span class="required">*</span>Proceso principal</jet-label>
                                    <select class="InputSelect" v-model="form.proceso_id" v-html="options">
                                    </select>
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
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de máquinas para el proceso</h3>
                        </div>
                    </div>
                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <button type="button" class="btn btn-primary" @click="addRow()">Agregar proceso</button>
                            <div class="overflow-auto row" style="height: 22rem">
                                <div class="tw-m-5 col-md-5 tw-mx-auto" v-for="(row, index) in form.maquinas" :key="row.id">
                                    <div>
                                        <select class="InputSelect" v-model="row.value" v-html="opcMaq" >
                                        </select>
                                        <div class="gap-2 d-grid tw-mt-2">
                                            <button type="button" class="btn btn-primary" @click="removeRow(index)">Quitar proceso</button>
                                        </div>
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
                            <button type="button" class="btn btn-primary" @click="addForRow()">Agregar proceso</button>
                            <div class="overflow-auto row" style="height: 22rem">
                                <div v-for="(f, index) in form.formulas" :key="f.id" class="m-3 mx-auto col-md-5">
                                    <select class="InputSelect" v-model="f.val">
                                        <option value="">Selecciona un proceso</option>
                                        <option v-for="proceso in procesos" :key="proceso.id" :value="proceso.id">{{proceso.nompro}}</option>
                                    </select>
                                    <div v-for="proceso in procesos" :key="proceso.id">
                                        <div v-if="proceso.id == f.val && proceso.tipo == 1" class="overflow-auto tw-text-center" style="height: 10rem">
                                            <label v-for="mp in proceso.maq_pros" :key="mp.id" class="m-2 w-100">
                                                <input type="checkbox" :value="f.val+'-'+mp.id" v-model="form.for_maq" checked>
                                                {{mp.maquinas.Nombre}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="gap-2 d-grid tw-mt-2">
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
            JetLabel
        },
        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                opc: '<option value="" disabled>Selecciona un departamento </option>',
                opcMaq: '<option value="" disabled>Selecciona una máquina</option>',
                options: '<option value="" disabled>Selecciona un proceso</option>',
                campo_max: 10,
                x: 1,
                showModal: false,
                editMode: false,
                puesCor: '',
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
            this.mostSelect();
            this.mostTipo()
            this.tabla();
        },
        methods: {
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
            limpiar(event){
                var limp = '';
                if (this.procesos) {
                    this.procesos.forEach(v => {
                        limp = v.departamentos.id;
                    })
                }
                event.target.value == limp ? '' : $('#t_pro').DataTable().clear();
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
            princiProcesos(){
                /* this.options = '<option value="" disabled>Selecciona un proceso</option>';
                this.procesos.forEach(element => {
                    if (element.tipo == 0) {
                        this.options += `<option value="${element.id}">${element.nompro}</option>`
                    }
                }) */
            },
            /****************************** opnciones de seect de maquinas ********************************/
            mostTipo() {
                const valores = window.location.search;
                const urlParams = new URLSearchParams(valores);
                var prod = urlParams.get('busca');
                this.puesCor = prod == null ? 'cor' : '';
                //console.log(this.puesCor)
                this.usuario.dep_pers.forEach(r => {
                    if (r.departamento_id == prod & r.ope_puesto == 'cor') {
                        this.puesCor = r.ope_puesto;
                    }
                })
            },
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
                //console.log(this.areas)
            },
            //consulta para generar datos de la tabla
            verTabla(event){
                this.limpiar(event);
                $('#t_pro').DataTable().destroy();
                this.$inertia.get('/Produccion/Procesos',{ busca: event.target.value }, {
                    onSuccess: () => { this.tabla(), this.mostTipo(), this.princiProcesos() }, preserveState: true
                });
                //select
            },
            /******************************* opciones de data table ****************************************/
            //datatable
            tabla() {
                this.$nextTick(() => {
                    $('#t_pro').DataTable({
                        "language": this.español,
                        "order": [1, 'desc'],
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
            /******************************** Acciones insert update y delet *************************************/
            //guardar información de procesos
            save(form) {
                //console.log(form)
                $('#t_pro').DataTable().destroy();
                this.$inertia.post('/Produccion/Procesos', form, {
                    onSuccess: () => { this.alertSucces(), this.tabla(), this.reset(), this.chageClose()},
                });

            },
            //manda datos de la tabla al modal
            edit: function (data) {
                console.log(data);
                this.form.id = data.id;
                this.form.departamento_id = data.departamento_id;
                this.form.nompro = data.nompro;
                this.form.tipo = data.tipo;
                this.form.tipo_carga = data.tipo_carga;
                this.form.operacion = data.operacion;
                this.form.proceso_id = data.proceso_id;
                this.form.descripcion = data.descripcion;
                this.form.maquinas = [];
                data.maq_pros.forEach(mp => {
                    this.form.maquinas.push({value: mp.maquina_id});
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
                if (!confirm('¿Estás seguro de querer eliminar este Proceso?')) return;
                $('#t_pro').DataTable().destroy()
                data._method = 'DELETE';
                this.$inertia.post('/Produccion/Procesos/' + data.id, data, {onSuccess: () => { this.alertDelete(), this.tabla() }});
            },
        },
        watch: {
            form: {
                deep: true,
                handler: function(f) {
                    //dependiendo del departamento
                    if (f.departamento_id != '') {
                        //console.log(f)
                        //select de maquinas
                        this.opcMaq = '<option value="" disabled>Selecciona una máquina</option>';
                        this.maquinas.forEach(r => {
                            this.opcMaq += `<option value="${r.id}"> ${r.Nombre} - ${r.marca.Nombre} </option>`;
                        })
                        //select proceso principal
                        this.options = '<option value="" disabled>Selecciona un proceso</option>';
                        this.procesos.forEach(element => {
                            if (element.tipo == 0) {
                                this.options += `<option value="${element.id}">${element.nompro}</option>`;
                            }
                        })
                    }
                    if (f.tipo != 0){
                        this.form.tipo_carga = '';
                    }
                }
            },
        },
    }
</script>
