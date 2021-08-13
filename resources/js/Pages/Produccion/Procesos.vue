
<template>
    <app-layout>
        <Header>
            Procesos
        </Header>

        <Accions>
            <template  v-slot:SelectB>
                <select @change="verTabla" class="InputSelect" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button @click="openModal" class="BtnNuevo">Nuevo Proceso </jet-button>
            </template>
        </Accions>
        <div class="table-responsive">
            <Table id="t_pro">
                <template v-slot:TableHeader>
                    <th class="columna">Nombre</th>
                    <th class="columna">Tipo</th>
                    <th class="columna">Descripción</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Máquinas</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="proceso in procesos" :key="proceso.id">
                        <td class="fila">{{ proceso.nompro }}</td>
                        <td class="fila">{{ proceso.tipo }}</td>
                        <td class="fila">{{ proceso.descripcion }}</td>
                        <td class="fila">{{ proceso.departamentos.Nombre }}</td>
                        <td class="fila" >
                            <tr v-for="mp in proceso.maq_pros" :key="mp.id">
                                {{' - '+mp.maquinas.Nombre+' - '}}
                            </tr>

                        </td>
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
                                    <select class="InputSelect" @change="verMaqui" v-model="form.departamento_id" v-html="opc">
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
                                        <option value="">Seleccione</option>
                                        <option value="1">Encargado</option>
                                        <option value="2">Coordinador</option>
                                        <option value="3">Formulas</option>
                                    </select>
                                    <small v-if="errors.tipo" class="validation-alert">{{errors.tipo}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="form.tipo == 3">
                                    <jet-label><span class="required">*</span>Tipo de formula</jet-label>
                                    <jet-input type="text" v-model="form.operacion" @input="(val) => (form.operacion = form.operacion.toUpperCase())"></jet-input>
                                    <small v-if="errors.operacion" class="validation-alert">{{errors.operacion}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label>Descripción</jet-label>
                                    <textarea v-model="form.descripcion" class="InputSelect" @input="(val) => (form.descripcion = form.descripcion.toUpperCase())"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------------------------- ENCARGADO --------------------------------------->
                <div class="tw-px-4 tw-py-4" v-show="form.tipo == 1 & !editMode">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de máquinas para el proceso</h3>
                        </div>
                    </div>
                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <button type="button" class="btn btn-primary" @click="addRow()">Add</button>
                            <div class="tw-m-5" v-for="(row, index) in form.maquinas" :key="row.id">
                                <div>
                                    <select class="InputSelect" v-model="row.value" v-html="opcMaq">
                                    </select>
                                    <button type="button" class="btn btn-primary" @click="removeRow(index)">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------------------------- FORMULAS --------------------------------------->
                <div class="tw-px-4 tw-py-4" v-show="form.tipo == 3 & !editMode">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Formulas</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <button type="button" class="btn btn-primary" @click="addForRow()">Add</button>
                            <div v-for="(f, index) in form.formulas" :key="f.id" class="m-3">
                                <select class="InputSelect" v-model="f.val">
                                    <option value="">Selecciona un proceso</option>
                                    <option v-for="proceso in procesos" :key="proceso.id" :value="proceso.id">{{proceso.nompro}}</option>
                                </select>
                                <div v-for="proceso in procesos" :key="proceso.id">
                                    <div v-if="proceso.id == f.val && proceso.tipo == 1" >
                                        <label v-for="mp in proceso.maq_pros" :key="mp.id" class="m-3">
                                            <input type="checkbox" :value="f.val+'-'+mp.id" v-model="form.for_maq" checked>
                                            {{mp.maquinas.Nombre}}
                                        </label>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" @click="removeForRow(index)">Remove</button>
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
                S_Area: '',
                opc: '<option value="" disabled>Selecciona un departamento </option>',
                opcMaq: '<option value="" disabled>Selecciona una máquina</option>',
                campo_max: 10,
                x: 1,
                español: {
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "info": "Registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "infoThousands": ",",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad",
                        "collection": "Colección",
                        "colvisRestore": "Restaurar visibilidad",
                        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                        "copySuccess": {
                            "1": "Copiada 1 fila al portapapeles",
                            "_": "Copiadas %d fila al portapapeles"
                        },
                        "copyTitle": "Copiar al portapapeles",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "Mostrar todas las filas",
                            "1": "Mostrar 1 fila",
                            "_": "Mostrar %d filas"
                        },
                        "pdf": "PDF",
                        "print": "Imprimir"
                    },
                    "autoFill": {
                        "cancel": "Cancelar",
                        "fill": "Rellene todas las celdas con <i>%d<\/i>",
                        "fillHorizontal": "Rellenar celdas horizontalmente",
                        "fillVertical": "Rellenar celdas verticalmentemente"
                    },
                    "decimal": ",",
                    "searchBuilder": {
                        "add": "Añadir condición",
                        "button": {
                            "0": "Constructor de búsqueda",
                            "_": "Constructor de búsqueda (%d)"
                        },
                        "clearAll": "Borrar todo",
                        "condition": "Condición",
                        "conditions": {
                            "date": {
                                "after": "Despues",
                                "before": "Antes",
                                "between": "Entre",
                                "empty": "Vacío",
                                "equals": "Igual a",
                                "not": "No",
                                "notBetween": "No entre",
                                "notEmpty": "No Vacio"
                            },
                            "moment": {
                                "after": "Despues",
                                "before": "Antes",
                                "between": "Entre",
                                "empty": "Vacío",
                                "equals": "Igual a",
                                "not": "No",
                                "notBetween": "No entre",
                                "notEmpty": "No vacio"
                            },
                            "number": {
                                "between": "Entre",
                                "empty": "Vacio",
                                "equals": "Igual a",
                                "gt": "Mayor a",
                                "gte": "Mayor o igual a",
                                "lt": "Menor que",
                                "lte": "Menor o igual que",
                                "not": "No",
                                "notBetween": "No entre",
                                "notEmpty": "No vacío"
                            },
                            "string": {
                                "contains": "Contiene",
                                "empty": "Vacío",
                                "endsWith": "Termina en",
                                "equals": "Igual a",
                                "not": "No",
                                "notEmpty": "No Vacio",
                                "startsWith": "Empieza con"
                            }
                        },
                        "data": "Data",
                        "deleteTitle": "Eliminar regla de filtrado",
                        "leftTitle": "Criterios anulados",
                        "logicAnd": "Y",
                        "logicOr": "O",
                        "rightTitle": "Criterios de sangría",
                        "title": {
                            "0": "Constructor de búsqueda",
                            "_": "Constructor de búsqueda (%d)"
                        },
                        "value": "Valor"
                    },
                    "searchPanes": {
                        "clearMessage": "Borrar todo",
                        "collapse": {
                            "0": "Paneles de búsqueda",
                            "_": "Paneles de búsqueda (%d)"
                        },
                        "count": "{total}",
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Sin paneles de búsqueda",
                        "loadMessage": "Cargando paneles de búsqueda",
                        "title": "Filtros Activos - %d"
                    },
                    "select": {
                        "1": "%d fila seleccionada",
                        "_": "%d filas seleccionadas",
                        "cells": {
                            "1": "1 celda seleccionada",
                            "_": "$d celdas seleccionadas"
                        },
                        "columns": {
                            "1": "1 columna seleccionada",
                            "_": "%d columnas seleccionadas"
                        }
                    },
                    "thousands": "."
                },
                showModal: false,
                editMode: false,


                form: {
                    nompro: null,
                    departamento_id: '',
                    tipo: '',
                    operacion: '',
                    descripcion: null,
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
            //$('#t_pro').DataTable().destroy();
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
                console.log(row);
                this.form.maquinas.splice(row,1);
            },
            limpiar(event){
                var limp = '';
                if (this.procesos) {
                    this.procesos.forEach(v => {
                        limp = v.departamentos.id;
                    })
                }
                event.target.value == limp ? '' : $('#t_maq').DataTable().clear();
            },
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
            /****************************** opnciones de seect de maquinas ********************************/
            verMaqui(event) {
                this.opcMaq = '<option value="" disabled>Selecciona una máquina</option>';
                this.limpiar(event);
                $('#t_pro').DataTable().destroy();
                this.$inertia.get('/Produccion/Procesos',{ busca: event.target.value ,maq: event.target.value }, {
                    onSuccess: () => { this.tabla(), this.mostMaqui() }, preserveState: true
                });
            },
            mostMaqui() {
                this.maquinas == null ? "" : this.maquinas.forEach(r => {
                    this.opcMaq += `<option value="${r.id}"> ${r.Nombre} </option>`;
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
                    onSuccess: () => { this.tabla(); }, preserveState: true
                });
            },
            /******************************* opciones de data table ****************************************/
            //datatable
            tabla() {
                this.$nextTick(() => {
                    $('#t_pro').DataTable({
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
                    departamento_id: '',
                    tipo: '',
                    operacion: '',
                    descripcion: null,
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
                console.log(form)
                $('#t_pro').DataTable().destroy();
                this.$inertia.post('/Produccion/Procesos', form, {
                    onSuccess: () => { this.alertSucces(), this.tabla(), this.reset(), this.chageClose()},
                });

            },
            //manda datos de la tabla al modal
            edit: function (data) {
                console.log(data);
                this.form = Object.assign({}, data);
                //this.vari = data.id;
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
            }

        }
    }
</script>
