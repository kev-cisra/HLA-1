<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-toolbox"></i>
                        Carga de datos
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <select @change="verTabla" class="InputSelect" v-model="S_Area" v-html="opc">
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer">Cargar datos</jet-button>
                <jet-button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Agregar Reporte</jet-button>
            </template>
        </Accions>
        <!------------------------------------ carga de datos de personal y areas ---------------------------------------->
        <div class="collapse m-5 tw-p-6 tw-bg-blue-300 tw-rounded-3xl" id="agPer">
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Proceso proncipal</jet-label>
                    <select class="InputSelect" @change="seleSP" v-model="proc_prin" v-html="opcPP"></select>
                    <small v-if="errors.proc_prin" class="validation-alert">{{errors.proc_prin}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="opcSP">
                    <jet-label><span class="required">*</span>Sub proceso </jet-label>
                    <select class="InputSelect" v-model="form.proceso_id" v-html="opcSP"></select>
                    <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                </div><!---->
                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="ocuPE"> <!-- v-show="ocuPE" -->
                    <jet-label><span class="required">*</span>Operador</jet-label>
                    <select class="InputSelect" v-model="form.dep_perf_id" v-html="opcPE"></select>
                    <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                </div>
            </div>
            <div class="w-100 tw-mx-auto" align="center">
                <jet-button type="button" class="tw-mx-auto" @click="saveDM(form)">Guardar</jet-button>
            </div>
        </div>
        <pre>
            {{personal}}
        </pre>
        <!------------------------------------ Data table de carga ------------------------------------------------------->
        <div class="table-responsive">
            <Table id="">
                <template v-slot:TableHeader>
                    <th class="columna">Clave de maquina</th>
                    <th class="columna">Nombre de la máquina</th>
                    <th class="columna">Departamento</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter>
                    <td></td>
                </template>
            </Table>
        </div>
        <!--------------------------------------- Carga de reportes y datatable ------------------------------------------->
        <div class="offcanvas offcanvas-bottom tw-h-5/6" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Reportes</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="tw-p-6 tw-bg-blue-300 tw-rounded-3xl">
                    <div class="tw-mb-6 md:tw-flex">
                        <!--<div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>Departamento </jet-label>
                            <select class="InputSelect" v-model="form.departamento_id" v-html="opc"></select>
                            <small v-if="errors.departamento_id" class="validation-alert">{{errors.departamento_id}}</small>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>Material </jet-label>
                            <jet-input type="text" list="per" v-model="form.material_id"></jet-input>
                            <small v-if="errors.material_id" class="validation-alert">{{errors.material_id}}</small>
                            <datalist id="per">
                                <option v-for="material in materiales" :key="material" :value="material.id">{{ material.idmat }} - {{ material.nommat }}</option>
                            </datalist>
                        </div>-->
                    </div>
                    <div class="w-100 tw-mx-auto" align="center">
                        <jet-button type="button" class="tw-mx-auto" @click="saveDM(form)">Guardar</jet-button>
                    </div>
                </div>
                <table id="t_rep" >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Shad Decker</td>
                            <td>Regional Director</td>
                            <td>Edinburgh</td>
                            <td>51</td>
                            <td>2008/11/13</td>
                            <td>$183,000</td>
                        </tr>
                        <tr>
                            <td>Michael Bruce</td>
                            <td>Javascript Developer</td>
                            <td>Singapore</td>
                            <td>29</td>
                            <td>2011/06/27</td>
                            <td>$183,000</td>
                        </tr>
                        <tr>
                            <td>Donna Snider</td>
                            <td>Customer Support</td>
                            <td>New York</td>
                            <td>27</td>
                            <td>2011/01/25</td>
                            <td>$112,000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
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
            'depa',
            'cargas',
            'procesos',
            'personal',
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
            JetLabel
        },
        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                ocuPE: true,
                opc: '<option value="" disabled>Selecciona</option>',
                opcPP: '',
                opcSP: '',
                opcPE: '',
                proc_prin: '',
                form: {
                    proceso_id: '',
                    dep_perf_id: '',
                }
            }
        },
        mounted() {
            this.mostSelect();
            this.tabla();
            this.tablaRep();
            this.selePP();
            this.selePE();
        },
        methods: {
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
            },
            //consulta para generar datos de la tabla
            verTabla(event){
                this.$inertia.get('/Produccion/Carga',{ busca: event.target.value }, {
                    onSuccess: () => {  }, preserveState: true
                });
            },
            /****************************** Selects de muestra ************************************************/
            //select para proceso principal
            selePP(){
                this.opcPP= '<option value="" disabled>Selecciona</option>'
                this.procesos.forEach(pp =>{
                    if (pp.tipo == 0) {
                        this.opcPP += `<option value="${pp.id}">${pp.nompro}</option>`
                    }
                })
            },
            //select para sub proceso
            seleSP(event){
                //console.log(event.target.value)
                this.form.proceso_id = '';
                this.opcSP= '<option value="" disabled>Selecciona</option>';
                this.procesos.forEach(sp =>{
                    if (sp.tipo == 1 & sp.proceso_id == event.target.value ) {
                        console.log(sp)
                        this.opcSP += `<option value="${sp.id}">${sp.nompro}</option>`
                    }
                })
            },
            //select para personal
            selePE(){
                //console.log(this.usuario.dep_pers.length);
                if (this.usuario.dep_pers.length == 1) {
                    this.usuario.dep_pers.forEach(pe =>{
                        //console.log(pe.ope_puesto)
                        if (pe.ope_puesto == 'ope') {
                            this.ocuPE = false;
                            this.form.dep_perf_id = pe.id;
                        }
                    })
                }
                this.opcPE= '<option value="" disabled>Selecciona</option>';
                this.personal.forEach(pe => {
                    //console.log(pe.id+' '+pe.perfiles.Nombre)
                    if (pe.ope_puesto == 'ope' & pe.ope_puesto == 'lid') {
                        this.opcPE += `<option value="${pe.id}">${pe.perfiles.Nombre} ${pe.perfiles.ApPat} ${pe.perfiles.ApMat}</option>`;
                    }
                })
            },
            /****************************** datatables ********************************************************/
            //datatable de carga
            tabla() {

            },
            //datatable de paros
            tablaRep() {
                this.$nextTick(() => {
                    $('#t_rep').DataTable({
                        "language": this.español,
                        "scrollY":        "30vh",
                        "scrollCollapse": true,
                        "paging":         false,
                        "dom": '<"row"<"col-sm-12"f>>'+
                                "<'row'<'col-sm-12'tr>>",
                    });

                })
            },
        }
    }
</script>
