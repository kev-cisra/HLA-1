<template>
    <app-layout>
        <div class="uppercase tw-mx-4">
            <Header>
                <slot>Perfiles de Usuarios</slot>
            </Header>

            <div class="tw-mt-8">
                <div class="tw-flex tw-justify-end">
                    <div><jet-button @click="openModal" class="BtnNuevo">Nueva Información </jet-button></div>
                </div>
                <div class="tw-overflow-x-auto">
                <TableGreen class="tw-overflow-hidden tw-uppercase tw-bg-white tw-divide-y tw-divide-gray-300 tw-rounded" id="perfiles">
                    <template v-slot:TableHeader>
                        <th class="columna">Núm. Empleado</th>
                        <th class="columna">Empresa</th>
                        <th class="columna">Nombre</th>
                        <th class="columna">Paterno</th>
                        <th class="columna">Materno</th>
                        <th class="columna">Curp</th>
                        <th class="columna">RFC</th>
                        <th class="columna">NSS</th>
                        <th class="columna">Direccion</th>
                        <th class="columna">Telefono</th>
                        <th class="columna">Cumpleaños</th>
                        <th class="columna">Fecha Ingreso</th>
                        <th class="columna">Antiguedad </th>
                        <th class="columna">Dias Vac.</th>
                        <th class="columna">Puesto</th>
                        <th class="columna">Departamento</th>
                        <th class="columna">Jefe</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in PerfilesUsuarios" :key="datos.id">
                            <td class="tw-p-2">{{ datos.IdEmp }}</td>
                            <td class="tw-p-2">{{ datos.Empresa }}</td>
                            <td class="tw-p-2">{{ datos.Nombre }}</td>
                            <td class="tw-p-2">{{ datos.ApPat }}</td>
                            <td class="tw-p-2">{{ datos.ApMat }}</td>
                            <td class="tw-p-2">{{ datos.Curp  }}</td>
                            <td class="tw-p-2">{{ datos.Rfc}}</td>
                            <td class="tw-p-2">{{ datos.Nss  }}</td>
                            <td class="tw-p-2">{{ datos.Direccion }}</td>
                            <td class="tw-p-2">{{ datos.Telefono }}</td>
                            <td class="tw-p-2">{{ datos.Cumpleaños }}</td>
                            <td class="tw-p-2">{{ datos.FecIng }}</td>
                            <td class="tw-p-2">{{ datos.Antiguedad }}</td>
                            <td class="tw-p-2">{{ datos.DiasVac }}</td>
                            <td class="tw-p-2">{{ datos.perfil_puesto.Nombre}}</td>
                            <td class="tw-p-2">{{ datos.perfil_departamento.Nombre}}</td>
                            <td class="tw-p-2">{{ datos.perfil_jefe.Nombre}}</td>
                        </tr>
                    </template>
                </TableGreen>
                </div>

            </div>
        </div>

        <modal :show="showModal" @close="chageClose">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Modulo</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">

                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">

                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">

                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">

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
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import TableGreen from '@/Components/TableGreen'
    import Table from '@/Components/Table'
    import JetButton from '@/Components/Button'
    import JetCancelButton from '@/Components/CancelButton'
    import Modal from '@/Jetstream/Modal';
    import Pagination from '@/Components/pagination'
    import pickBy from 'lodash/pickBy'
    import throttle from 'lodash/throttle'
    //imports de datatables
    import datatable from 'datatables.net-bs5';
    import $ from 'jquery';

    export default {
        components: {
            AppLayout,
            Welcome,
            Header,
            Accions,
            TableGreen,
            Table,
            JetButton,
            JetCancelButton,
            Modal,
            Pagination,
        },
        props: {
            PerfilesUsuarios: Object,
        },
        data(){
            return{
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
            };
        },
        mounted() {
            this.tabla();
        },
        methods:{
            //datatable
            tabla() {
                this.$nextTick(() => {
                    $('#perfiles').DataTable({
                    "language": this.español,
                    });
                })
            },
            //consulta para generar datos de la tabla
            verTabla(event){
                $('#perfiles').DataTable().destroy();
                this.$inertia.get('/RecursosHumanos/PerfilesUsuarios',{ busca: event.target.value }, {onSuccess: () => { this.tabla() }} )
            },
            openModal() {
                this.chageClose();
                this.reset();
                this.editMode = false;

            },
            chageClose(){
                this.showModal = !this.showModal
            },
        },
    };
</script>
