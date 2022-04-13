<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-users"></i>
                    Personal
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB>
                <select @change="verTabla" class="InputSelect" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer">Asignar departamento a personal </jet-button>
            </template>
        </Accions>
        <!------------------------------------ carga de datos de personal y areas ------------------------------------>
        <div class="collapse m-5 tw-p-6 tw-bg-blue-300 tw-rounded-3xl" id="agPer">
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Departamento </jet-label>
                    <select class="InputSelect" v-model="form.departamento_id" v-html="opc"></select>
                    <small v-if="errors.departamento_id" class="validation-alert">{{errors.departamento_id}}</small>
                </div>

                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Puesto </jet-label>
                    <select class="InputSelect" v-model="form.ope_puesto">
                        <option value="" disabled>Selecciona un puesto</option>
                        <option value="cor">Coordinador</option>
                        <option value="enc">Encargado</option>
                        <option value="lid">Lider</option>
                        <option value="ope">Operador</option>
                    </select>
                    <small v-if="errors.ope_puesto" class="validation-alert">{{errors.ope_puesto}}</small>
                </div>

                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Personal </jet-label>
                    <Select2 v-model="form.perfiles_usuarios_id" class="InputSelect" :options="optionPer"  :settings="{width: '100%'}" />
                    <small v-if="errors.perfiles_usuarios_id" class="validation-alert">{{errors.perfiles_usuarios_id}}</small>
                    <!-- <jet-input type="text" list="per" v-model="form.perfiles_usuarios_id"></jet-input>
                    <small v-if="errors.perfiles_usuarios_id" class="validation-alert">{{errors.perfiles_usuarios_id}}</small>
                    <datalist id="per">
                        <option v-for="persona in personal" :key="persona" :value="persona.id">{{ persona.IdEmp }} {{ persona.Nombre }} {{ persona.ApPat }} {{ persona.ApMat }}</option>
                    </datalist> -->
                </div>
            </div>
            <div class="w-100 tw-mx-auto" align="center">
                <jet-button type="button" class="tw-mx-auto" @click="save(form)">Guardar</jet-button>
            </div>
        </div>
        <!----------------------------------- tabla de datos -------------------------------------------------------->
        <div class="tw-m-auto" style="width: 98%">
            <Table id="t_per">
                <template v-slot:TableHeader>
                    <th class="columna">Número de empleado</th>
                    <th class="columna">Puesto</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Departamento</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="ap in areper" :key="ap.id" class="fila">
                        <td>{{ ap.perfiles.IdEmp }}</td>
                        <td>{{ puesto(ap.ope_puesto) }}</td>
                        <td>{{ ap.perfiles.Nombre }} {{ ap.perfiles.ApPat }} {{ ap.perfiles.ApMat }}</td>
                        <td>{{ ap.departamentos.Nombre }}</td>
                        <td>
                            <div class="columnaIconos">
                                <div class="iconoDelete" @click="deleteRow(ap)">
                                    <span tooltip="Eliminar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoAcept" @click="updateUser(ap)" v-if="ap.ope_puesto == 'lid' | ap.ope_puesto == 'ope'">
                                    <span tooltip="Usuario activo" flow="left">
                                        <svg class="tw-h-5 tw-w-5"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="3" y="3" width="6" height="6" rx="1" />  <rect x="15" y="15" width="6" height="6" rx="1" />  <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3" />  <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3" />
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
    import JetSelect from '@/Components/Select';
    import Modal from '@/Jetstream/Modal';
    import JetLabel from '@/Jetstream/Label';
    import Select2 from 'vue3-select2-component';
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
        props: {
            usuario: Object,
            areas: Object,
            personal: Object,
            areper: Object,
            are_perfs: Object,
            errors: Object
        },
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
        },data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                opc: '<option value="" disabled>Selecciona un departamento </option>',
                form: {
                    perfiles_usuarios_id: '',
                    ope_puesto: '',
                    departamento_id: '',
                }
            }
        },
        mounted() {
            this.mostSelect();
            this.tabla();
        },
        methods: {
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
            puesto(data){
                switch (data) {
                    case 'cor':
                        return 'COORDINADOR';
                        break;
                    case 'enc':
                        return 'ENCARGADO';
                        break;
                    case 'lid':
                        return 'LIDER';
                        break;
                    case 'ope':
                        return 'OPERADOR';
                        break;
                }
            },
            //datatable
            tabla() {
                this.$nextTick(() => {
                    $('#t_per').DataTable({
                        "language": this.español,
                        "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "columnDefs": [
                            { "width": "10%", "targets": [0,4] },
                            { "width": "30%", "targets": [1,2,3] }
                        ],
                        "scrollX": true,
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
            //información del select area
            mostSelect() {
                this.$nextTick(() => {
                    this.areas.forEach(r => {
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
                $('#t_per').DataTable().clear();
                $('#t_per').DataTable().destroy();
                this.$inertia.get('/Produccion/Personal',{ busca: event.target.value }, {
                    onSuccess: () => { this.tabla(); }, onError: () => {this.tabla()}, preserveState: true
                });
            },
            //reset de modal
            reset(val){
                this.form = {
                    perfiles_usuarios_id: '',
                    //ope_puesto: '',
                    departamento_id: val,
                }
            },
            //guardar información de
            save(form) {
                //console.log(form)
                $('#t_per').DataTable().destroy();
                this.$inertia.post('/Produccion/Personal', form, {
                    onSuccess: () => { this.tabla(), this.reset(form.departamento_id),this.alertSucces()}, onError: () => {this.tabla()}, preserveState: true
                });
                //$('#t_mat').DataTable();
            },
            deleteRow: function (data) {
                Swal.fire({
                    title: '¿Estás seguro de querer eliminar este Registro?',
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
                        this.areper.length == 1 ? $('#t_per').DataTable().clear() : '' ;
                        $('#t_per').DataTable().destroy()
                        data._method = 'DELETE';
                        this.$inertia.post('/Produccion/Personal/' + data.id, data, {
                            onSuccess: () => { this.tabla(), this.alertDelete() }, onError: () => {this.tabla()}, preserveState: true
                        });
                    }
                })

            },
            updateUser(data) {
                //console.log(data)
                data._method = 'PUT';
                this.$inertia.post('/Produccion/Personal/' + data.id, data, {
                    onSuccess: () => {this.reset(), this.alertSucces()},
                });
            }

        },
        computed: {
            optionPer: function() {
                const per = [];
                this.personal.forEach(p => {
                    per.push({id: p.id, text: p.IdEmp + ' - ' + p.Nombre + ' ' + p.ApPat + ' ' + p.ApMat})
                })
                return per;
            }
        }
    }
</script>
