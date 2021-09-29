<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-clipboard-list"></i>
                        Entrega de productos terminados
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB >
                <select class="InputSelect" @change="verTabla" v-model="S_Area">
                    <option value="">Selecciona un departamento</option>
                    <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer">Cargar datos</jet-button>
            </template>
        </Accions>
        <!-- Data table de las entregas -->
        <div class="table-responsive">
            <table-sky id="t_entregas">
                <template v-slot:TableHeader>
                    <th class="columna tw-text-center">1</th>
                    <th class="columna tw-text-center">1</th>
                    <th class="columna tw-text-center">1</th>
                    <th class="columna tw-text-center">1</th>
                </template>
            </table-sky>
        </div>
    </app-layout>
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import TableSky from '@/Components/TableSky'
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetSelect from '@/Components/Select';
    import Modal from '@/Jetstream/Modal';
    import JetLabel from '@/Jetstream/Label';
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


    export default {
        props: [
            'usuario',
            'depa',
            'cargas',
            'procesos',
            'materiales',
            'errors'
        ],
        components: {
            AppLayout,
            Header,
            Accions,
            TableSky,
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
            }
        },
        mounted() {
            this.globales();
        },
        methods: {
            globales() {
                this.$nextTick(() => {
                    if (this.usuario.dep_pers.length != 0) {
                        this.S_Area = this.usuario.dep_pers[0].departamento_id;
                    }else{
                        this.S_Area = 7;
                    }
                });
            },
            /****************************** datatables ********************************************************/
            //datatable de carga
            tabla() {
                this.$nextTick(() => {
                    $('#t_entregas').DataTable({
                        "language": this.español,
                        "order": [[3, 'desc']],
                        "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                    })
                })
            },
        },
        computed: {
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
            S_Area: function(b){
                $('#t_entregas').DataTable().clear();
                $('#t_entregas').DataTable().destroy();
                this.$inertia.get('/Produccion/Entregas',{ busca: b }, {
                    onSuccess: () => {
                         this.tabla() }, onError: () => {this.tabla()}, preserveState: true
                });
            },
        }
    }
</script>
