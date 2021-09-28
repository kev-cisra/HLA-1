<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-boxes"></i>
                    Materiales
                </h3>
            </slot>
        </Header>
        <Accions>
            <template v-slot:BtnNuevo>
                <jet-button @click="openModal" class="BtnNuevo">Nuevo Material </jet-button>
            </template>
        </Accions>
        <div class="table-responsive">
            <Table id="t_mat">
                <template v-slot:TableHeader>
                    <th class="columna">Clave del material</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Descripción</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="material in materiales" :key="material.id">
                        <td class="fila">{{ material.idmat }}</td>
                        <td class="fila">{{ material.nommat }}</td>
                        <td class="fila">{{ material.descrip }}</td>
                        <td class="fila">
                            <div class="columnaIconos">
                                <div class="iconoDetails">
                                    <span tooltip="Detalles" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoEdit" @click="edit(material)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="deleteRow(material)">
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

        <!---------- Modal de acciones ------------->
        <modal :show="showModal" @close="chageClose">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de material</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Clave del material</jet-label>
                                    <jet-input type="text" v-model="form.idmat" @input="(val) => (form.idmat = form.idmat.toUpperCase())"></jet-input>
                                    <small v-if="errors.idmat" class="validation-alert">{{errors.idmat}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Nombre del proceso</jet-label>
                                    <jet-input type="text" v-model="form.nommat" @input="(val) => (form.nommat = form.nommat.toUpperCase())"></jet-input>
                                    <small v-if="errors.nommat" class="validation-alert">{{errors.nommat}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Descripción</jet-label>
                                    <textarea v-model="form.descrip" class="InputSelect" @input="(val) => (form.descrip = form.descrip.toUpperCase())"></textarea>
                                    <small v-if="errors.descrip" class="validation-alert">{{errors.descrip}}</small>
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
    window.JSZip = jszip

export default {
    props: [
        'usuario',
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
            showModal: false,
            editMode: false,
            search: null,
            form: {
                idmat: '',
                nommat: '',
                descrip: null
            }
        }
    },
    mounted() {
        this.tabla();
    },
    methods: {
        //datatable
        tabla() {
            this.$nextTick(() => {
                $('#t_mat').DataTable({
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
        //consulta para generar datos de la tabla
        verTabla(event){
            $('#t_mat').DataTable().clear();
            $('#t_mat').DataTable().destroy();
            this.$inertia.get('/Produccion/Materiales',{ busca: event.target.value }, {
                onSuccess: () => { this.tabla() }, onError: () => {this.tabla()}, preserveState: true
            })
        },
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
                idmat: null,
                nommat: null,
                descrip: null,
            }
        },
        //guardar información de procesos
        save(form) {
            $('#t_mat').DataTable().destroy();
            this.$inertia.post('/Produccion/Materiales', form, {
                onSuccess: () => { this.tabla(), this.reset(), this.chageClose()}, onError: () => {this.tabla()}, preserveState: true
            });
        },
        //manda datos de la tabla al modal
        edit: function (data) {
            this.form = Object.assign({}, data);
            //this.vari = data.id;
            this.editMode = true;
            this.chageClose();
        },
        //actualiza información de los procesos
        update(data) {
            data._method = 'PUT';
            this.$inertia.post('/Produccion/Materiales/' + data.id, data, {
                onSuccess: () => {this.reset(), this.chageClose()},
            });
        },
        deleteRow: function (data) {
            if (!confirm('¿Estás  seguro de querer eliminar este Material?')) return;
            this.materiales.length == 1 ? $('#t_mat').DataTable().clear() : '' ;
            $('#t_mat').DataTable().destroy()
            data._method = 'DELETE';
            this.$inertia.post('/Produccion/Materiales/' + data.id, data, {
                onSuccess: () => { this.tabla() }, onError: () => {this.tabla()}, preserveState: true
            });
        }
    }
}
</script>
