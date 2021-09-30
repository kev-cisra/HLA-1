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
        <!-- fomulario  -->
        <div class="collapse m-5 tw-p-6 tw-bg-green-600 tw-rounded-3xl tw-shadow-xl" id="agPer">
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Proceso proncipal</jet-label>
                    <select class="InputSelect" v-model="proc_prin" v-html="opcPP" :disabled="editMode"></select>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="opcSP">
                    <jet-label><span class="required">*</span>Sub proceso </jet-label>
                    <select class="InputSelect" v-model="form.proceso_id" v-html="opcSP" :disabled="editMode"></select>
                    <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Maquinas</jet-label>
                    <select class="InputSelect" v-model="form.maq_pro_id" v-html="opcMQ" :disabled="editMode"></select>
                    <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Tipo de paro</jet-label>
                    <select class="InputSelect" v-model="form.paro_id" v-html="opcPR" :disabled="editMode"></select>
                    <small v-if="errors.paro_id" class="validation-alert">{{errors.paro_id}}</small>
                </div>
            </div>
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 tw-text-center tw-mx-auto md:tw-mb-0">
                    <jet-label>Orden</jet-label>
                    <jet-input type="text" v-model="form.orden" @input="(val) => (form.orden = form.orden.toUpperCase())"></jet-input>
                    <small v-if="errors.orden" class="validation-alert">{{errors.orden}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 tw-text-center tw-mx-auto md:tw-mb-0">
                    <jet-label>Descripción</jet-label>
                    <textarea class="InputSelect" v-model="form.descri" maxlength="250" @input="(val) => (form.descri = form.descri.toUpperCase())" placeholder="Máximo 250 caracteres"></textarea>
                    <small v-if="errors.descri" class="validation-alert">{{errors.descri}}</small>
                </div>
            </div>
            <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
               <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="!editMode" @click="save(form)">Guardar</jet-button>
               </div>
               <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="editMode" @click="updateCA(form)">Actualizar</jet-button>
               </div>
                <div>
                    <jet-button class="tw-bg-red-700 hover:tw-bg-red-500" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="resetCA()" v-if="editMode">CANCELAR</jet-button>
                </div>
            </div>
        </div>
        <!-- Data table de las entregas -->
        <div class="table-responsive">
            <TableSky id="t_entregas">
                <template v-slot:TableHeader>
                    <th class="columna tw-text-center">1</th>
                    <th class="columna tw-text-center">1</th>
                    <th class="columna tw-text-center">1</th>
                    <th class="columna tw-text-center">1</th>
                </template>
                <template v-slot:TableFooter>
                    <tr v-for="ca in cargas" :key="ca.id">
                        <td class="fila tw-text-center">2</td>
                        <td class="fila tw-text-center">2</td>
                        <td class="fila tw-text-center">2</td>
                        <td class="fila tw-text-center">2</td>
                    </tr>
                </template>
            </TableSky>
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
                    onSuccess: () => { this.tabla() }, onError: () => {this.tabla()}, preserveState: true
                });
            },
        }
    }
</script>
