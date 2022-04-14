<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-sky-800 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Calidad</h3>
            </div>
        </template>
        <div class="tw-m-auto tw-my-8" style="width: 98vw">
            <Table id="t_cali">
                <template v-slot:TableHeader>
                    <th>Departamento</th>
                    <th>Partida</th>
                    <th>Maquina</th>
                    <th>Proceso</th>
                    <th>Clave</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="ae in abaentre" :key="ae">
                        <td> {{ae.departamento.Nombre}} </td>
                        <td> {{ ae.partida }} </td>
                        <td style="width: 25vw">
                            <Select2 v-model="ae.maquinas"  class="InputSelect" :options="seleMaq(ae.departamento_id)"  :settings="{width: '100%', multiple: true, allowClear: true}"/>
                        </td>
                        <td style="width: 25vw">
                            <Select2 v-model="ae.procesos"  class="InputSelect" :options="selePro(ae.departamento_id)"  :settings="{width: '100%', multiple: true, allowClear: true}"/>
                        </td>
                        <td style="width: 25vw">
                            <Select2 v-model="ae.clave"  class="InputSelect" :options="opcNC(ae.proc_final_aba)"  :settings="{width: '100%', multiple: true, allowClear: true}"/>
                        </td>
                        <td class="tw-flex">
                            <div tooltip="Guardar" flow="left">
                                <button class="btn btn-outline-success" @click="save(ae)"><i class="far fa-save"></i></button>
                            </div>
                            <div tooltip="Ver procesos guardados" flow="left">
                                <button class="btn btn-outline-warning" @click="conProCali(ae)"><i class="fas fa-eye"></i></button>
                            </div>
                        </td>
                    </tr>
                </template>
                <template v-slot:Foother>
                    <th>Departamento</th>
                    <th>Maquina</th>
                    <th>Proceso</th>
                    <th>Partida</th>
                    <th>Clave</th>
                    <th></th>
                </template>
            </Table>
        </div>

        <ag-grid-vue
            style="width: 100%; height: 200px"
            class="ag-theme-alpine"
            :columnDefs="columnDefs"
            :rowData="rowData"
        >
        </ag-grid-vue>

        <!-- <pre>
            {{columnDefs}}
        </pre> -->

        <!------------------ Modal ------------------------->
        <modal :show="showModal" @close="chageClose">
            <div class="tw-px-4 tw-py-4">
                <ag-grid-vue
                    style="width: 100%; height: 50vh"
                    class="ag-theme-alpine"
                    :columnDefs="columnProcFin"
                    :rowData="caliProce"
                >
                </ag-grid-vue>
                <!-- <table class="table">
                    <thead>
                        <th>Proceso</th>
                        <th>Maquina</th>
                        <th>Partida</th>
                        <th>Estatus</th>
                        <th>Norma</th>
                        <th>Clave</th>
                        <th>Descripción</th>
                    </thead>
                    <tbody>
                        <tr v-for="cp in caliProce" :key="cp">
                            <td> {{ cp.cat_proce_cali.nombre }} </td>
                            <td> {{ cp.maquina.Nombre }} {{ cp.maquina.marca.Nombre }} </td>
                            <td> {{ cp.partida }} </td>
                            <td>
                                <div v-if="cp.estatus == 1">Activo</div>
                                <div v-else>Finalizado</div>
                            </td>
                            <td> {{ cp.dep_mat.materiales.idmat }} - {{ cp.dep_mat.materiales.nommat }} </td>
                            <td> {{ cp.clave.CVE_ART }} </td>
                            <td> {{ cp.clave.DESCR }} </td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
        </modal>

        <section id="menu" class="tw-flex tw-justify-center tw-min-h-screen tw-mt-8 tw-min-w-screen">

        </section>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import { Link } from '@inertiajs/inertia-vue3';
    import Table from '@/Components/Table';
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
    import axios from 'axios';
    import Modal from '@/Jetstream/Modal';

    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    window.JSZip = jszip;

    import { AgGridVue } from "ag-grid-vue3";

    import "ag-grid-community/dist/styles/ag-grid.css";
    import "ag-grid-community/dist/styles/ag-theme-alpine.css";

    export default {
        props: [
            'usuario',
            'abaentre',
            'maquinas',
            'catproce'
        ],
        components: {
            AppLayout,
            Link,
            Table,
            Modal,
            Select2,
            AgGridVue
        },

        data() {
            return {
                showModal: false,
                caliProce: [],
                //abaentre: []
            }
        },

        mounted() {
            this.tabla();
        },

        setup() {
            return {
                columnProcFin: [
                    {
                        headerName: "Proceso",
                        field: "cat_proce_cali.nombre",
                        editable: true,
                        cellEditorSelector: function (params) {
                            console.log(params.data)
                        }
                    },
                    { headerName: "Maquina", field: "maquina.Nombre" },
                    { headerName: "Partida", field: "partida" },
                    {
                        headerName: "Estatus",
                        field: "estatus",
                        editable: true,
                        ver: function (params){
                            if (params.data.estatus == 1) {
                                console.log("Activo");
                            }else{
                                console.log("no")
                            }
                        }
                    },
                    { headerName: "Norma", field: "dep_mat.materiales.idmat" },
                    { headerName: "Clave", field: "clave.CVE_ART" },
                    { headerName: "Descripción", field: "clave.DESCR" },
                ],
            };
        },

        methods:{
            /****************************** datatables ********************************************************/
            //datatable de carga
            tabla() {
                this.$nextTick(() => {
                    $('#t_cali').DataTable({
                        "language": this.español,
                        "scrollX": true,
                        "columnDefs": [
                            { "width": "10%", "targets": [0,1,5] },
                            { "width": "25%", "targets": [2,3,4] }
                        ],
                        "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "stateSave": true,
                        scrollY:        '30vh',
                        scrollCollapse: true,
                        paging:         false,
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
                        ],
                    })
                })
            },
            /****************************** Consultas ****************************************************/
            //Consultas de procesos
            async conProCali(dat){
                await axios.post('Calidad/ConProCali', dat)
                .then(ele => {this.caliProce = ele.data, this.chageClose()})
            },
            async save(form){
                await axios.post('Calidad/CaliPro', form)
                .then(ele => {form.procesos = [], form.maquinas = [], form.clave = [], this.alertSucces()})
                .catch(err => {this.alertWarning()})
            },
            /****************************** Recorridos Para tabla *******************************************/
            //opciones de select de procesos
            selePro(dep){
                let pr = [];
                let fin = [];
                //console.log(this.catproce)
                switch (dep) {
                    case 4:
                        pr = this.catproce.filter(eve => {return eve.aplicacion.includes("Hilaturas")})
                        break;
                    case 5:
                        pr = this.catproce.filter(eve => {return eve.aplicacion.includes("Hilaturas")})
                        break;
                    case 6:
                        pr = this.catproce.filter(eve => {return eve.aplicacion.includes("Hilaturas")})
                        break;
                    case 7:
                        pr = this.catproce.filter(eve => {return eve.aplicacion.includes("Apertura")})
                        //console.log(pr)
                        break;
                    case 8:
                        pr = this.catproce.filter(eve => {return eve.aplicacion.includes("Hilaturas")})
                        break;
                    case 18:
                        pr = this.catproce.filter(eve => {return eve.aplicacion.includes("preparación")})
                        //console.log(pr)
                        break;
                    case 19:
                        pr = this.catproce.filter(eve => {return eve.aplicacion.includes("preparación")})
                        //console.log(pr)
                        break;
                }

                pr.forEach(ele => {
                    fin.push({id: ele.id, text: ele.nombre})
                });
                return fin;
            },
            //opciones del select de maquinas
            seleMaq(dep){
                let pr = [];
                switch (dep) {
                    case 4:
                        pr = this.opcMH1;
                        break;
                    case 5:
                        pr = this.opcMH2;
                        break;
                    case 6:
                        pr = this.opcMH3;
                        break;
                    case 7:
                        pr = this.opcMA;
                        break;
                    case 8:
                        pr = this.opcMHA;
                        break;
                    case 18:
                        pr = this.opcMPOE;
                        break;
                    case 19:
                        pr = this.opcMPA;
                        break;
                }
                return pr;
            },
            //opciones de claves
            opcNC(NoCl){
                const nc = [];
                NoCl.forEach(el => {
                    nc.push({id: el.clave.id, text: el.norma.materiales.nommat+' - '+el.clave.CVE_ART+' - '+el.clave.DESCR})
                });
                return nc;
            },
            //abrir o cerrar modal procesos
            chageClose(){
                this.showModal = !this.showModal
            },
        },

        computed: {
            //opciones Apertura
            opcMA: function (){
                let ma = []
                return ma = this.maquinas.filter(ele => { return ele.departamento_id == 7})
            },
            //opciones H1
            opcMH1: function (){
                let m1 = []
                return m1 = this.maquinas.filter(ele => { return ele.departamento_id == 4})
            },
            //opciones H2
            opcMH2: function (){
                let m1 = []
                return m1 = this.maquinas.filter(ele => { return ele.departamento_id == 5})
            },
            //opciones H3
            opcMH3: function (){
                let m1 = []
                return m1 = this.maquinas.filter(ele => { return ele.departamento_id == 6})
            },
            //opciones anillo
            opcMHA: function (){
                let m1 = []
                return m1 = this.maquinas.filter(ele => { return ele.departamento_id == 8})
            },
            //opciones preparación open-end
            opcMPOE: function (){
                let m1 = []
                return m1 = this.maquinas.filter(ele => { return ele.departamento_id == 18})
            },
            //opciones preparación anillo
            opcMPA: function (){
                let m1 = []
                return m1 = this.maquinas.filter(ele => { return ele.departamento_id == 19})
            }
        },

        watch: {}
    }
</script>
