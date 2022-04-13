<template>
    <app-layout>
        <div class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                            Reporte Incidencias
                    </h3>
                </slot>
            </Header>

            <div class="tw-mt-8">
                <div class="tw-flex tw-justify-center tw-gap-4 tw-border-b-2 tw-pb-2 tw-mb-2">
                    <div>
                        <jet-label>Fecha Inicio</jet-label>
                        <jet-input type="date" v-model="params.ini"></jet-input>
                    </div>
                    <div>
                        <jet-label>Fecha Fin</jet-label>
                        <jet-input type="date" v-model="params.fin"></jet-input>
                    </div>
                    <div class="tw-mt-6">
                        <jet-button type="button" @click="reset()">Limpiar Filtros</jet-button>
                    </div>
                </div>

                <div class="tw-overflow-x-auto tw-mx-2">
                    <Table id="incidencias">
                        <template v-slot:TableHeader>
                            <th class="columna">Núm. Empleado</th>
                            <th class="columna">Empresa</th>
                            <th class="columna">Nombre</th>
                            <th class="columna">Paterno</th>
                            <th class="columna">Materno</th>
                            <th class="columna">Motivo</th>
                            <th class="columna">Fecha</th>
                            <th class="columna">Comentarios</th>
                        </template>

                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="datos in Incidencias" :key="datos.id">
                                <td class="tw-p-2">{{ datos.IdEmp }}</td>
                                <td class="tw-p-2">{{ datos.incidencia_perfil.Empresa }}</td>
                                <td class="tw-p-2">{{ datos.incidencia_perfil.Nombre }}</td>
                                <td class="tw-p-2">{{ datos.incidencia_perfil.ApPat }}</td>
                                <td class="tw-p-2">{{ datos.incidencia_perfil.ApMat }}</td>
                                <td class="tw-p-2">{{ datos.TipoMotivo }}</td>
                                <td class="tw-p-2">{{ datos.Fecha }}</td>
                                <td class="tw-p-2">{{ datos.Comentarios }}</td>
                            </tr>
                        </template>
                    </Table>
                </div>
            </div>

            <modal :show="showModal" @close="chageClose" :maxWidth="tam">
                <form>
                    <div class="tw-px-4 tw-py-4">
                        <div class="tw-text-lg">
                            <div class="ModalHeader">
                                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Reporte Vacaciones</h3>
                            </div>
                        </div>

                        <div class="tw-mt-4">
                            <div class="ModalForm">
                                <div class="tw-mb-6 md:tw-flex">
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                        <jet-label><span class="required">*</span>Empresa</jet-label>
                                        <select id="Empresa" v-model="form.Empresa" class="InputSelect">
                                            <option value="HILATURAS">HILATURAS</option>
                                            <option value="SERGES">SERGES</option>
                                        </select>
                                    </div>
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                        <jet-label><span class="required">*</span>Departamento</jet-label>
                                        <select id="Jefe" v-model="form.Departamento_id" class="InputSelect">
                                            <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ModalFooter">
                        <jet-button type="button" @click="save(form)" v-show="!editMode">Genera Reporte</jet-button>
                        <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
                        <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
                    </div>
                </form>
            </modal>

        </div>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableGreen";
import JetButton from "@/Components/Button";
import JetTextArea from "@/Components/Textarea";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetLabel from '@/Jetstream/Label';
import JetSelect from "@/Components/Select";
import Alert from "@/Components/Alert";
import throttle from 'lodash/throttle'
//imports de datatables
import datatable from 'datatables.net-bs5';
import print from 'datatables.net-buttons/js/buttons.print';
import jszip from 'jszip/dist/jszip';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
import $ from 'jquery';

require( 'datatables.net-buttons-bs5/js/buttons.bootstrap5' );
require( 'datatables.net-buttons/js/buttons.html5' );
require ( 'datatables.net-buttons/js/buttons.colVis' );

pdfMake.vfs = pdfFonts.pdfMake.vfs;
window.JSZip = jszip

import moment from 'moment';
import 'moment/locale/es';

export default {
    data() {
        return {
            tam: "4xl",
            showModal: false,
            color: "tw-bg-green-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                IdEmp: null,
                Empresa: null,
                Departamento_id: null,
            },
            rows: [
                {name: ""}
            ],
            params:{
                ini: null,
                fin: null,
            },
        };
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        Table,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetLabel,
        JetSelect,
    },

    props: {
        Session: Object,
        Incidencias: Object,
        Departamentos: Object,
    },

    mounted() {
        this.tabla();
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
            };
            this.$inertia.get("/RecursosHumanos/ReporteIncidencias",{ onSuccess: () => {
                this.params = {
                    ini: null,
                    fin: null,
                },
                this.tabla();
                },});
        },

        openModal() {
            this.chageClose();
            this.reset();
            this.editMode = false;
        },

        chageClose() {
            this.showModal = !this.showModal;
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#incidencias").DataTable({
                language: this.español,
                "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
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
                        },
                        customize: function (doc) {
                            //Remove the title created by datatTables
                            doc.content.splice(0,1);
                            //Create a date string that we use in the footer. Format is dd-mm-yyyy
                            var now = new Date();
                            var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                            // Logo converted to base64
                            // var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
                            // The above call should work, but not when called from codepen.io
                            // So we use a online converter and paste the string in.
                            // Done on http://codebeautify.org/image-to-base64-converter
                            // It's a LONG string scroll down to see the rest of the code !!!
                            var logo = 'data:image/png;base64,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';
                            // A documentation reference can be found at
                            // https://github.com/bpampuch/pdfmake#getting-started
                            // Set page margins [left,top,right,bottom] or [horizontal,vertical]
                            // or one number for equal spread
                            // It's important to create enough space at the top for a header !!!
                            doc.pageMargins = [30,55,25,30];
                            // Set the font size fot the entire document
                            doc.defaultStyle.fontSize = 7;
                            // Set the fontsize for the table header
                            doc.styles.tableHeader.fontSize = 7;
                            // Create a header object with 3 columns
                            // Left side: Logo
                            // Middle: brandname
                            // Right side: A document title
                            doc['header']=(function() {
                                return {
                                    columns: [
                                        {
                                            image: logo,
                                            width: 80
                                        },
                                        {
                                            alignment: 'right',
                                            fontSize: 14,
                                            text: 'Reporte de Vacaciones'
                                        }
                                    ],
                                    margin: 25
                                }
                            });
                            // Create a footer object with 2 columns
                            // Left side: report creation date
                            // Right side: current page and total pages
                            doc['footer']=(function(page, pages) {
                                return {
                                    columns: [
                                        {
                                            alignment: 'left',
                                            text: ['Creado: ', { text: jsDate.toString() }]
                                        },
                                        {
                                            alignment: 'right',
                                            text: ['Página ', { text: page.toString() },	' de ',	{ text: pages.toString() }]
                                        }
                                    ],
                                    margin: 5
                                }
                            });
                            // Change dataTable layout (Table styling)
                            // To use predefined layouts uncomment the line below and comment the custom lines below
                            // doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) { return .5; };
                            objLayout['vLineWidth'] = function(i) { return .5; };
                            objLayout['hLineColor'] = function(i) { return '#aaa'; };
                            objLayout['vLineColor'] = function(i) { return '#aaa'; };
                            objLayout['paddingLeft'] = function(i) { return 4; };
                            objLayout['paddingRight'] = function(i) { return 4; };
                            doc.content[0].layout = objLayout;
				        }
                    },
                    'colvis'
                ]
                });

            });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
        $("#incidencias").DataTable().destroy();
            this.$inertia.get("/RecursosHumanos/ReporteVacaciones",{ busca: event.target.value },
            {
                onSuccess: () => {
                    this.tabla();
                },
            });
        },

        save(data) {
            this.$inertia.post("/RecursosHumanos/ReporteIncidencias", data, {
                onSuccess: () => {
                this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },
    },

    watch: { //Metodo escucha
        params: {  //escucha de arreglo de parametros
        deep: true,
            handler: throttle(function() { //trotle (tiempo en espera para ejecutarse)
                $('#incidencias').DataTable().clear(); //limpio
                $('#incidencias').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/RecursosHumanos/ReporteIncidencias', this.params , { //envio de variables por url
                    onSuccess: () => {
                        this.tabla() //regeneracion de tabla
                        }, preserveState: true})
            }, 150),
        },
    },
};
</script>
