<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-toolbox"></i>
                        Materiales y claves
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB>
                <select @change="verTabla" class="InputSelect" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer">Asignar departamento a material </jet-button>
            </template>
        </Accions>
        <!------------------------------------ carga de datos de personal y areas ------------------------------------>
        <div class="collapse m-5 tw-p-6 tw-bg-blue-300 tw-rounded-3xl" id="agPer">
            <form >
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
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
                    </div>
                </div>
                <div class="w-100 tw-mx-auto" align="center">
                    <jet-button type="button" class="tw-mx-auto" @click="saveDM(form)">Guardar</jet-button>
                </div>
            </form>
        </div>
        <!----------------------------------- tabla de datos -------------------------------------------------------->
        <div class="table-responsive">
            <Table id="t_clamat">
                <template v-slot:TableHeader>
                    <th class="columna">Clave del material</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Descripción</th>
                    <th class="columna">Departamento</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="cm in clamat" :key="cm">
                        <td class="fila">{{ cm.materiales.idmat }}</td>
                        <td class="fila">{{ cm.materiales.nommat }}</td>
                        <td class="fila">{{ cm.materiales.descrip }}</td>
                        <td class="fila">{{ cm.departamentos.Nombre }}</td>
                        <td class="fila">
                            <div class="columnaIconos">
                                <div class="iconoDetails" data-bs-toggle="modal" data-bs-target="#tabla_clave" @click="show(cm)">
                                    <span tooltip="Detalles" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="destroyDM(cm)">
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

        <!------------------------------------------------ modal de carga de claves -->
        <div class="modal fade" id="tabla_clave" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Claves de Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <Table id="t_clave">
                            <template v-slot:TableHeader>
                                <th class="columna">Clave del material</th>
                                <th class="columna">Nombre</th>
                                <th class="columna">Unidad de medida</th>
                                <th class="columna"></th>
                            </template>
                            <template v-slot:TableFooter >
                                <tr v-for="vi in ncla" :key="vi">
                                    <td class="fila">{{vi.CVE_ART}}</td>
                                    <td class="fila">{{vi.DESCR}}</td>
                                    <td class="fila">{{vi.UNI_MED}}</td>
                                    <td class="fila">
                                        <div class="columnaIconos">
                                            <div class="iconoEdit" @click="editCL(vi)" data-bs-target="#ag_clave" data-bs-toggle="modal" data-bs-dismiss="modal">
                                                <span tooltip="Editar" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="iconoDelete" @click="destroyCL(vi)">
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
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#ag_clave" data-bs-toggle="modal" data-bs-dismiss="modal">Agregar nueva clave</button>
                </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ag_clave" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Agregar nueva clave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>Clave del articulo</jet-label>
                            <jet-input type="text" v-model="formCla.CVE_ART" @input="(val) => (formCla.CVE_ART = formCla.CVE_ART.toUpperCase())"></jet-input>
                            <small v-if="errors.CVE_ART" class="validation-alert">{{errors.CVE_ART}}</small>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>Descripción</jet-label>
                            <jet-input type="text" v-model="formCla.DESCR" @input="(val) => (formCla.DESCR = formCla.DESCR.toUpperCase())"></jet-input>
                            <small v-if="errors.DESCR" class="validation-alert">{{errors.DESCR}}</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="regre(formCla)" data-bs-target="#tabla_clave" data-bs-toggle="modal" data-bs-dismiss="modal">Regresar</button>
                    <jet-button type="button" class="btn btn-primary" @click="updateCL(formCla)" v-show="editMode" data-bs-target="#tabla_clave" data-bs-toggle="modal" data-bs-dismiss="modal">Actualizar</jet-button>
                    <button class="btn btn-primary" @click="saveCL(formCla)" v-show="!editMode" data-bs-target="#tabla_clave" data-bs-toggle="modal" data-bs-dismiss="modal">Agregar</button>
                </div>
                </div>
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
            'clamat',
            'ncla',
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
                opc: '<option value="" disabled>Selecciona un departamento </option>',
                showModal: false,
                editMode: false,
                form: {
                    material_id: '',
                    departamento_id: '',
                },
                formCla: {
                    CVE_ART: '',
                    DESCR: '',
                    UNI_MED: 'KG',
                    dep_mat_id: null
                }
            }
        },
        mounted() {
            this.mostSelect();
            //$('#t_mat').DataTable().destroy();
            this.tabla();
            //this.tablaCL();
        },
        methods: {
            //datatable
            tabla() {
                this.$nextTick(() => {
                    $('#t_clamat').DataTable({
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
                            }
                        ]
                    });

                })
            },
            tablaCL() {
                this.$nextTick(() => {
                    $('#t_clave').DataTable({
                        "language": this.español,
                        scrollY:        '30vh',
                        scrollCollapse: true,
                        paging:         false,
                        "dom": '<"row"<"col-sm-12 mt-3 col-md-9"B><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>",
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
                            }
                        ]
                    });
                })

            },
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
                                rr.departamentos_sub.forEach(rrr => {
                                    this.opc += `<option value="${rrr.id}"> ${rrr.Nombre} </option>`;
                                })
                            })
                        }
                    })
                });
                //console.log(this.areas)
            },
            //consulta para generar datos de la tabla
            verTabla(event){
                $('#t_clamat').DataTable().clear();
                $('#t_clamat').DataTable().destroy();
                this.$inertia.get('/Produccion/Clamat',{ busca: event.target.value }, {
                    onSuccess: () => { this.tabla(); }, preserveState: true
                });
            },
            //reset de modal
            reset(){
                this.form = {
                    material_id: '',
                    departamento_id: '',
                }
            },
            /********************************** Acciones de modal que muestra informacion *****************/
            //guardar información de
            saveDM(form) {
                $('#t_clamat').DataTable().destroy();
                this.$inertia.post('/Produccion/Clamat', form, {
                    onSuccess: () => { this.tabla(), this.reset() ,this.alertSucces()}, preserveState: true
                });
            },
            destroyDM(data){
                //console.log(data)
                if (!confirm('¿Estás seguro de querer eliminar este registro?')) return;
                $('#t_clamat').DataTable().destroy()
                data._method = 'DELETE';
                this.$inertia.post('/Produccion/Clamat/' + data.id, data, {onSuccess: () => { this.alertDelete(), this.tabla() }});
            },
            show(data) {
                this.resetCL(data.id)
                //console.log(data.departamentos.id)
                $('#t_clave').DataTable().clear();
                $('#t_clave').DataTable().destroy();
                this.$inertia.get('/Produccion/Clamat',{ busca: data.departamentos.id, cls: data.id }, {
                    onSuccess: () => { this.tablaCL(); }, preserveState: true
                });
                //this.tablaVi = data.claves;
            },
            /********************************** Accion de modal para agregar claves **********************/
            resetCL(d) {
                this.formCla = {
                    CVE_ART: '',
                    DESCR: '',
                    UNI_MED: 'KG',
                    dep_mat_id: d
                }
            },
            //abrir y reset del modal procesos
            saveCL(form) {
                //console.log(form)
                $('#t_clave').DataTable().clear();
                $('#t_clave').DataTable().destroy();
                this.$inertia.post('/Produccion/Claves', form, {
                    onSuccess: () => { this.tablaCL(), this.alertSucces() }, preserveState: true
                });
                this.resetCL(form.dep_mat_id)
                //console.log(form.dep_mat_id)
            },
            regre(data){
                this.editMode = false;
                this.resetCL(data.dep_mat_id)
            },
            editCL(data){
                this.formCla = Object.assign({}, data);
                this.editMode = true;
            },
            updateCL(data){
                data._method = 'PUT';
                this.$inertia.post('/Produccion/Claves/' + data.id, data, {
                    onSuccess: () => {this.reset()},
                });
                this.editMode = false;
                this.resetCL(data.dep_mat_id)
                //console.log(data.dep_mat_id)
            },
            destroyCL(data){
                //console.log(data)
                if (!confirm('¿Estás seguro de querer eliminar este registro?')) return;
                $('#t_clave').DataTable().clear()
                $('#t_clave').DataTable().destroy()
                data._method = 'DELETE';
                this.$inertia.post('/Produccion/Claves/' + data.id, data, {onSuccess: () => { this.alertDelete(), this.tablaCL() }});
            }

        }
    }
</script>
