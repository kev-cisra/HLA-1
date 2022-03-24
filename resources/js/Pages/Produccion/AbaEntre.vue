<template>
    <app-layout>
        <Header :class="['tw-bg-blue-600', 'tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl']">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-folder-open"></i>
                        Abastos y Entregas
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <div class="sm:tw-flex tw-gap-3">
                    <select class="InputSelect sm:tw-w-full" v-model="S_Area">
                        <option value="" disabled>Selecciona un departamento</option>
                        <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                    </select>
                </div>
            </template>
        </Accions>

    </app-layout>
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header';
    import Accions from '@/Components/Accions';
    import TableGreen from '@/Components/TableTeal';
    import JetLabel from '@/Jetstream/Label';
    import JetInput from '@/Components/Input';
    import Select2 from 'vue3-select2-component';
    import Modal from '@/Jetstream/Modal';
    import axios from 'axios';
    import moment from 'moment';
    import 'moment/locale/es';
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

    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    window.JSZip = jszip;

    export default {
        props: [
            'usuario',
            'depa',
            'depaT'
        ],
        components: {
            AppLayout,
            Header,
            Accions,
            TableGreen,
            JetLabel,
            JetInput,
            Select2,
            Modal
        },

        data() {
            return {
                S_Area: '',
                carga: [],
                materiales: [],
                abaentre: [],
                departamento: [],
                abaPro: [],
                errors: [],
                abafin: [],
                showModal: false,
                vrNor: false,
                vrCla: false,
                vrPar: false,
                formAba: {
                    id: '',
                    partida: '',
                    folio: '',
                    folio2: '',
                    banco: '',
                    total: 0,
                    norma: '',
                    clave: null,
                    esta_inicio: '',
                    esta_final: '',
                    depa_entrega: '',
                    depa_recibe: null
                },
                formBus:{
                    fechaini: '',
                    fechafin: '',
                    departamento: ''
                }
            }
        },

        mounted() {
        },

        methods: {
        },

        computed: {
            //Opciones departamento
            opc: function() {
                const ar = [];
                this.depa.forEach(r => {
                    if (r.departamentos) {
                        ar.push({text: r.departamentos.Nombre, value: r.departamentos.id});
                    }else{
                        ar.push({text: r.Nombre, value: r.id});
                        r.sub__departamentos.forEach(rr => {
                            ar.push({text: rr.Nombre, value: rr.id});
                            //console.log(rr.Nombre);
                        })
                    }
                })
                return ar;
            }
        },

        watch: {
            S_Area: async function(b){

                var datos = {'departamento_id': this.S_Area, 'modulo': 'abaEntre'};
                $('#abfin').DataTable().clear();
                $('#abfin').DataTable().destroy();
                this.tabla()
                this.abafin = []

                //Produccion
                let car = await axios.post('AbaEntre/Carga', datos)
                this.carga = car.data;

                //Materiales
                let mate = await axios.post('General/ConMateriales', datos)
                this.materiales = mate.data

                //abasto entregas
                /* let aba = await axios.post('AbaEntre/conabaent', datos);
                this.abaentre = aba.data; */
            },
        }
    }
</script>
