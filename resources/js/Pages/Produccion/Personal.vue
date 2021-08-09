<template>
    <app-layout>
        <Header>
            Personal
        </Header>
        <Accions>
            <template v-slot:InputBusqueda>
                <input type="text" placeholder="Busqueda por Id" class="InputSearch" v-model="search">
            </template>
            <template  v-slot:SelectB>
                <select @change="verTabla" class="InputSelect" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer">Asignar area a personal </jet-button>
            </template>
        </Accions>
        <!------------------------------------ carga de datos de personal y areas ------------------------------------>
        <div class="collapse" id="agPer">
            <form >
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>ÁREA </jet-label>
                        <select class="InputSelect" v-model="form.area_id" v-html="opc"></select>
                        <small v-if="errors.area_id" class="validation-alert">{{errors.area_id}}</small>
                    </div>

                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>Personal </jet-label>
                        <jet-input type="text" list="per" v-model="form.perfiles_usuarios_id"></jet-input>
                        <small v-if="errors.perfiles_usuarios_id" class="validation-alert">{{errors.perfiles_usuarios_id}}</small>
                        <datalist id="per">
                            <option v-for="persona in personal" :key="persona" :value="persona.id">{{ persona.IdEmp }} {{ persona.Nombre }} {{ persona.ApPat }} {{ persona.ApMat }}</option>
                        </datalist>
                    </div>

                    <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>

                </div>
            </form>
        </div>

        <div class="table-responsive">
            <Table id="t_per">
                <template v-slot:TableHeader>
                    <th class="columna">Número de empleado</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Área</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="ap in areper" :key="ap.id">
                        <td class="fila">{{ ap.areperf_perfil.IdEmp }}</td>
                        <td class="fila">{{ ap.areperf_perfil.Nombre }} {{ ap.areperf_perfil.ApPat }} {{ ap.areperf_perfil.ApMat }}</td>
                        <td class="fila">{{ ap.areperf_area.Nombre }}</td>
                        <td class="fila">
                            <div class="columnaIconos">
                                <div class="iconoDelete" @click="deleteRow(ap)">
                                    <span tooltip="Eliminar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoAcept" v-show="ap.id == 1">
                                    <span tooltip="Usuario activo" flow="left">
                                        <svg class="tw-h-5 tw-w-5"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="9" cy="7" r="4" />  <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />  <path d="M16 11l2 2l4 -4" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDetails" v-show="ap.id == 2">
                                    <span tooltip="Cargar nuevo usuario" flow="left">
                                        <svg class="tw-h-5 tw-w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="9" cy="7" r="4" />  <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />  <path d="M16 11h6m-3 -3v6" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
            <pre>
                {{areper}}
            </pre>
        </div>
        <!---------- Modal de acciones -----------
        <modal :show="showModal" @close="chageClose">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Procesos</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Clave del material</jet-label>
                                    <jet-input type="text" v-model="form.idmat"></jet-input>
                                    <small v-if="errors.idmat" class="validation-alert">{{errors.idmat}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Nombre del proceso</jet-label>
                                    <jet-input type="text" v-model="form.nommat"></jet-input>
                                    <small v-if="errors.nommat" class="validation-alert">{{errors.nommat}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Descripción</jet-label>
                                    <textarea v-model="form.descrip" class="InputSelect"></textarea>
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
        </modal>-->
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

    import datatable from 'datatables.net-bs5';
    import $ from 'jquery';

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
                S_Area: '',
                opc: '<option value="">Selecciona una área </option>',
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
                search: null,
                form: {
                    perfiles_usuarios_id: '',
                    area_id: '',
                }
            }
        },
        mounted() {
            this.mostSelect();
            //$('#t_mat').DataTable().destroy();
            this.tabla();
        },
        methods: {
            //datatable
            tabla() {
                this.$nextTick(() => {
                    $('#t_per').DataTable({
                        "language": this.español
                    });
                })
            },
            //información del select area
            mostSelect() {
                this.$nextTick(() => {

                    this.areas.forEach(r => {
                        //var condi = r.sub_areas.id == '' ? 'disabled' : '';
                        //console.log(r.sub_areas);
                        this.opc += `<option value="${r.id}"> ${r.Nombre} </option>`;
                        r.sub_areas.forEach(rr => {
                            this.opc += `<option value="${rr.id}"> ${rr.Nombre} </option>`;
                            //console.log(rr.Nombre);
                        })
                    })
                });
                //console.log(this.areas)
            },
            //consulta para generar datos de la tabla
            verTabla(event){
                $('#t_per').DataTable().clear();
                $('#t_per').DataTable().destroy();
                this.$inertia.get('/Produccion/Personal',{ busca: event.target.value }, {
                    onSuccess: () => { this.tabla(); }, preserveState: true
                });
            },
            //abrir y reset del modal
            openModal() {
                this.chageClose();
                this.reset();
                this.editMode = false;
            },
            //abrir o cerrar modal
            chageClose(){
                this.showModal = !this.showModal
            },
            //reset de modal
            reset(val){
                this.form = {
                    perfiles_usuarios_id: '',
                    area_id: val,
                }
            },
            //guardar información de
            save(form) {
                //console.log(form)
                $('#t_per').DataTable().destroy();
                this.$inertia.post('/Produccion/Personal', form, {
                    onSuccess: () => { this.tabla(), this.reset(form.area_id)}, preserveState: true
                });
                //$('#t_mat').DataTable();
            },
            deleteRow: function (data) {
                if (!confirm('¿Estás  seguro de querer eliminar este Material?')) return;
                    if (this.areper.length == 1) {
                        $('#t_per').DataTable().clear()
                    }
                    $('#t_per').DataTable().destroy()
                    data._method = 'DELETE';
                    this.$inertia.post('/Produccion/Personal/' + data.id, data, {
                        onSuccess: () => { this.tabla() }, preserveState: true
                });
            }

        }
    }
</script>
