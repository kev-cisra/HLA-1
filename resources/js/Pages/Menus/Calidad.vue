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
                    <th>Maquina</th>
                    <th>Proceso</th>
                    <th>Partida</th>
                    <th>Norma</th>
                    <th>Clave</th>
                    <th>Descripción</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="ae in abaentre" :key="ae">
                        <td> {{ae.departamento.Nombre}} </td>
                        <td>
                            <select v-model="ae.maquina" class="InputSelect tw-w-full">
                                <option value="1">Algo M1</option>
                                <option value="2">Algo M2</option>
                                <option value="3">Algo M3</option>
                            </select>
                        </td>
                        <td> {{ ae.total }} </td>
                        <td> {{ ae.partida }} </td>
                        <td> <label v-show="false"> {{ ae.norma = Norma(ae.proc_final_aba, ae.clave, 0) }} </label> {{ Norma(ae.proc_final_aba, ae.clave, 1) }} </td>
                        <td>
                            <select v-model="ae.clave" class=" tw-bg-transparent tw-border-0 tw-w-full">
                                <option v-for="nc in opcNC(ae.proc_final_aba)" :key="nc" :value="nc.id">{{nc.text}}</option>
                            </select>
                        </td>
                        <td> {{ Norma(ae.proc_final_aba, ae.clave, 2) }} </td>
                        <td></td>
                    </tr>
                </template>
                <template v-slot:Foother>
                    <th>Departamento</th>
                    <th>Maquina</th>
                    <th>Proceso</th>
                    <th>Partida</th>
                    <th>Norma</th>
                    <th>Clave</th>
                    <th>Descripción</th>
                    <th></th>
                </template>
            </Table>
        </div>
        <!-- <pre>
            {{ abaentre }}
        </pre> -->
        <section id="menu" class="tw-flex tw-justify-center tw-min-h-screen tw-mt-8 tw-min-w-screen">

        </section>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import { Link } from '@inertiajs/inertia-vue3';
    import Table from '@/Components/Table';
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

    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    window.JSZip = jszip;

    export default {
        props: [
            'usuario'
        ],
        components: {
            AppLayout,
            Link,
            Table,
        },

        data() {
            return {
                abaentre: []
            }
        },

        mounted() {
            this.conAbas();
        },

        methods:{
            /****************************** datatables ********************************************************/
            //datatable de carga
            tabla() {
                this.$nextTick(() => {
                    // Setup - add a text input to each footer cell
                    $('#t_cali tfoot th').each( function () {
                        var title = $(this).text();
                        $(this).html( '<input type="text" class="InputSelect tw-text-gray-900" placeholder="'+title+'" />' );
                    } );
                    $('#t_cali').DataTable({
                        "language": this.español,
                        "scrollX": true,
                        "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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
                        initComplete: function () {
                            // Apply the search
                            this.api().columns().every( function () {
                                var that = this;

                                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                                    if ( that.search() !== this.value ) {
                                        that
                                            .search( this.value )
                                            .draw();
                                    }
                                } );
                            } );
                        },
                    })
                })
            },
            /****************************** Consultas ****************************************************/
            async conAbas(){
                var datos = {'modulo': 'repoPro'};

                //abasto entregas
                let aba = await axios.post('Calidad/ConAbast', datos);
                this.abaentre = aba.data;
                this.tabla();
            },
            /****************************** Recorridos Para tabla *******************************************/
            //Normas
            Norma(paqCL, cla, NorDes){
                let resu = "";
                if (cla) {
                    console.log(paqCL.find(ele => {return ele.clave_id == cla}))
                    resu = paqCL.find(ele => {return ele.clave_id == cla})
                    if (NorDes == "1") {
                        return resu.norma.materiales.nommat;
                    } /* else if(NorDes == 0){
                        return resu.norma_id;
                    } */
                    else {
                        return resu.clave.DESCR;
                    }
                }else {
                    return "";
                }

            },
            //opciones de claves
            opcNC(NoCl){
                const nc = [];
                NoCl.forEach(el => {
                    nc.push({id: el.clave.id, text: el.clave.CVE_ART})
                });
                return nc;
            }
        },

        computed: {},

        watch: {}
    }
</script>
