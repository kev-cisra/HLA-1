<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-digital-tachograph"></i>
                    Máquinas
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <select @change="verTabla" class="InputSelect" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button class="BtnNuevo" @click="openModal">Agregar Máquina</jet-button>
            </template>
        </Accions>
        <div class="table-responsive">
            <Table id="t_maq">
                <template v-slot:TableHeader>
                    <th class="columna">Clave de maquina</th>
                    <th class="columna">Nombre de la máquina</th>
                    <th class="columna">Marca</th>
                    <th class="columna">Departamento</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="mq in maquinas" :key="mq.id">
                        <td class="fila">{{ mq.id }}</td>
                        <td class="fila">{{ mq.Nombre }}</td>
                        <td class="fila">{{mq.marca.Nombre}}</td>
                        <td class="fila">{{ mq.departamentos.Nombre }}</td>
                        <td class="fila">
                            <div class="columnaIconos">
                                <div class="iconoEdit" @click="edit(mq)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="deleteRow(mq)">
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
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Máquinas</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="!editMode">
                                    <jet-label><span class="required">*</span>Departamento</jet-label>
                                    <select class="InputSelect" v-model="form.departamento_id" v-html="opc">
                                    </select>
                                    <small v-if="errors.departamento_id" class="validation-alert">{{errors.departamento_id}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Nombre</jet-label>
                                    <jet-input type="text" class="tw-uppercase" v-model="form.Nombre"></jet-input>
                                    <small v-if="errors.Nombre" class="validation-alert">{{errors.Nombre}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Marca</jet-label>
                                    <jet-input type="text" v-model="form.marca" @input="(val) => (form.marca = form.marca.toUpperCase())">{{departamento_id}}</jet-input>
                                    <small v-if="errors.marca" class="validation-alert">{{errors.marca}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" hidden>
                                    <jet-input type="text" v-model="form.Departamento">{{departamento_id}}</jet-input>
                                    <small v-if="errors.Departamento" class="validation-alert">{{errors.Departamento}}</small>
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
        props: {
            usuario: Object,
            depa: Object,
            personal: Object,
            maquinas: Object,
            errors: Object
        },
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
                showModal: false,
                editMode: false,
                search: null,
                form: {
                    IdUser: this.usuario.id,
                    departamento_id: '',
                    Nombre: '',
                    Departamento: 'PRODUCCION',
                    marca: ''
                }
            }
        },
        mounted() {
            this.mostSelect();
            this.tabla();
        },
        methods: {
            /****************************** Alertas *******************************************************/
            alertSucces(){
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
                    icon: 'success',
                    title: 'Registro Insertado',
                    // background: '#99F6E4',
                })
            },
            alertDelete(){
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
                    icon: 'success',
                    title: 'Registro Eliminado Correctamente',
                    // background: '#99F6E4',
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
                var limp = '';
                if (this.maquinas) {
                    this.maquinas.forEach(v => {
                        limp = v.departamentos.id;
                    })
                }
                event.target.value == limp ? '' : $('#t_maq').DataTable().clear();
                $('#t_maq').DataTable().destroy()
                this.$inertia.get('/Produccion/Maquinas',{ busca: event.target.value }, {
                    onSuccess: () => { this.tabla(); }, preserveState: true
                });
            },
            /******************************* opciones de data table ****************************************/
            //datatable
            tabla() {
                this.$nextTick(() => {
                    $('#t_maq').DataTable({
                        "language": this.español,
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
            alertSucces(){
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
                    icon: 'success',
                    title: 'Registro Insertado',
                    // background: '#99F6E4',
                })
            },
            alertDelete(){
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
                    icon: 'success',
                    title: 'Registro Eliminado Correctamente',
                    // background: '#99F6E4',
                })
            },
            /******************************* opciones de modal funciones basicas *******************************************/
            //abrir y reset del modal
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
                    IdUser: this.usuario.id,
                    departamento_id: '',
                    Nombre: '',
                    Departamento: 'PRODUCCION',
                    marca: ''
                }
            },
            /******************************** Acciones insert update y delet *************************************/
            //guardar información
            save(form) {
                //console.log(form)
                $('#t_maq').DataTable().destroy();
                this.$inertia.post('/Produccion/Maquinas', form, {
                    onSuccess: () => { this.alertSucces(), this.tabla(), this.reset(), this.chageClose()},
                });
                //$('#t_pro').DataTable();

            },
            //manda datos de la tabla al modal
            edit: function (data) {
                /* console.log(data); */
                /* this.form = Object.assign({}, data); */
                this.form.IdUser = data.IdUser;
                this.form.departamento_id = data.departamento_id;
                this.form.Nombre = data.Nombre;
                this.form.Departamento = data.departamentos.Nombre;
                this.form.id = data.id;
                this.form.marca = data.marca.Nombre;
                //this.vari = data.id;
                this.editMode = true;
                this.chageClose();
            },
            //actualiza información de las maquinas
            update(data) {
                console.log(data);
                this.$inertia.put('/Produccion/Maquinas/' + data.id, data, {
                    onSuccess: () => {this.reset(), this.chageClose()},
                });
            },
            deleteRow: function (data) {
                if (!confirm('¿Estás seguro de querer eliminar esta Máquina?')) return;
                this.maquinas.length == 1 ? $('#t_maq').DataTable().clear() : '';
                $('#t_maq').DataTable().destroy()
                data._method = 'DELETE';
                this.$inertia.post('/Produccion/Maquinas/' + data.id, data, {onSuccess: () => { this.alertDelete(), this.tabla() }});
            }
        }
    }
</script>
