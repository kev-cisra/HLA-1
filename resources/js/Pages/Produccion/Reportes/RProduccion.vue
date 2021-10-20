<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-folder-open"></i>
                        Reporte de  Producción
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <div class="sm:tw-flex tw-gap-3">
                    <select class="InputSelect sm:tw-w-full" @change="verTabla()" v-model="S_Area">
                        <option value="" disabled>Selecciona un departamento</option>
                        <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                    </select>
                </div>
            </template>
            <template v-slot:calcula>
                <input type="date" class="form-control tw-rounded-lg" v-model="fechaC" :max="hoy">
            </template>
            <template v-slot:BtnNuevo>
                <!-- boton de calculos -->
                <div class="md:tw-flex tw-gap-3 tw-mr-10">
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="openModal">Calculos</jet-button>
                    </div>
                </div>
            </template>
        </Accions>
        <!------------------------------------ Data table de carga ------------------------------------------------------->
        <div class="tw-overflow-x-auto tw-mx-2">
            <Table id="t_repo">
                <template v-slot:TableHeader>
                    <th class="columna">Fecha</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Proceso</th>
                    <th class="columna">Equipo</th>
                    <th class="columna">Turno</th>
                    <th class="columna">Partida</th>
                    <th class="columna">Norma</th>
                    <th class="columna">Clave</th>
                    <th class="columna">Descripción de clave</th>
                    <th class="columna">Maquina</th>
                    <th class="columna">KG</th>
                    <th class="columna">Numero de pacas</th>
                </template>
                <template v-slot:TableFooter >
                    <tr v-for="ca in recoTabla" :key="ca.id">
                        <td class="fila">{{ca.fecha}}</td>
                        <td class="fila">{{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.Nombre}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApPat}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApMat}}</td>
                        <td class="fila">{{ca.dep_perf == null ? 'N/A' : ca.dep_perf.departamentos.Nombre}}</td>
                        <td class="fila">{{ca.proceso.nompro}}</td>
                        <td class="fila">{{ca.equipo == null ? 'N/A' : ca.equipo.nombre}}</td>
                        <td class="fila">{{ca.turno == null ? 'N/A' : ca.turno.nomtur}}</td>
                        <td class="fila">{{ca.partida == null ? 'N/A' : ca.partida}}</td>
                        <td class="fila">{{ca.dep_mat == null ? 'N/A' : ca.dep_mat.materiales.idmat+' - '+ca.dep_mat.materiales.nommat}}</td>
                        <td class="fila">{{ca.clave == null ? 'N/A' : ca.clave.CVE_ART}}</td>
                        <td class="fila">{{ca.clave == null ? 'N/A' : ca.clave.DESCR}}</td>
                        <td class="fila">{{ca.maq_pro == null ? 'N/A' : ca.maq_pro.maquinas.Nombre}}</td>
                        <td class="fila">{{ca.valor}}</td>
                        <td class="fila"> {{ca.VerInv}} </td>
                    </tr>
                </template>
            </Table>
        </div>
        <!------------------------------------- Modal para carga de datos ------------------------------------------------>
        <!------------------ Modal Turnos------------------------->
        <modal :show="showModal" @close="chageClose">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Calculos</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fecha a guardar</jet-label>
                                    <jet-input type="date" v-model="form.fecha" class="" :max="hoy"></jet-input>
                                    <small v-if="errors.fecha" class="validation-alert">{{errors.fecha}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fecha de inicio de carga</jet-label>
                                    <jet-input type="datetime-local" v-model="form.hoy" class=""></jet-input>
                                    <small v-if="errors.hoy" class="validation-alert">{{errors.hoy}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fecha final de carga</jet-label>
                                    <jet-input type="datetime-local" v-model="form.mañana" class=""></jet-input>
                                    <small v-if="errors.mañana" class="validation-alert">{{errors.mañana}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ModalFooter">
                    <button v-show="vCal" class="btn btn-outline-success" type="button" id="button-addon2" @click="calcula(form)">
                        <i class="fas fa-calculator" ></i> Calcular
                    </button>
                    <button v-show="!vCal" class="btn btn-success" type="button" disabled>
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Calculando...
                    </button>
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
    import Table from '@/Components/Table';
    import Modal from '@/Jetstream/Modal';
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetLabel from '@/Jetstream/Label';
    //datatable
    import datatable from 'datatables.net-bs5';
    import $ from 'jquery';

    import moment from 'moment';
    import 'moment/locale/es';

    export default {
        props: [
            'usuario',
            'depa',
            'cargas',
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
            Modal,
            JetLabel
        },
        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                fechaC: '',
                limp: 1,
                hoy: moment().format('YYYY-MM-DD'),
                recoTabla: [],
                editMode: false,
                showModal: false,
                vCal: true,
                form: {
                    fecha: this.hoy,
                    hoy: null,
                    mañana: null,
                    depa: this.S_Area
                }
            }
        },
        mounted() {
            this.global();
        },
        methods: {
            /***************************** Calculos ******************************************/
            calcula(form) {
                if (this.calcu != '' & this.S_Area != '') {
                    this.verTabla();
                    $('#t_repo').DataTable().destroy();
                    this.vCal = false;
                    //console.log(this.calcu+' '+this.S_Area);
                    this.btnOff = true;
                    this.$inertia.post('/Produccion/Calcula', form, {
                        onSuccess: (v) => {
                            this.btnOff = false,
                            this.alertSucces(),
                            this.vCal = true,
                            this.reset(),
                            this.chageClose(),
                            this.tabla()
                        },
                        onError: (e) => {
                            this.btnOff = false,
                            this.vCal = true,
                            this.tabla()
                        },
                        preserveState: true
                    });
                }else{
                    this.calcu == '' ? Swal.fire('Por favor selecciona una fecha') : '';
                    this.S_Area == '' ? Swal.fire('Por favor selecciona un departamento') : '';
                }

            },
            /****************************** Globales **********************************************************/
            global(){
                this.fechaC = this.hoy;
                if (this.usuario.dep_pers.length == 0) {
                    this.S_Area = 7;
                }else{
                    //Asigna el primer departamento
                    this.S_Area = this.usuario.dep_pers[0].departamento_id;
                    this.usuario.dep_pers.forEach(v => {
                        if (v.departamento_id = this.S_Area) {
                            //asigna
                            this.idDep = v.id;
                        }
                    })

                }
            },
            verTabla() {
                $('#t_repo').DataTable().clear();
            },
            /****************************** datatables ********************************************************/
            //datatable de carga
            tabla() {
                this.$nextTick(() => {
                    $('#t_repo').DataTable({
                        "language": this.español,
                        "order": [[4, 'asc'], [0, 'desc']],
                        "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                    })
                })
            },
            /****************************** Modal y acciones *************************************************/
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
            //reset de imputs
            reset() {
                this.form = {
                    fecha: this.hoy,
                    hoy: null,
                    mañana: null,
                    depa: this.S_Area
                }
            }
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
            },
        },
        watch: {
            S_Area: function(b){
                $('#t_repo').DataTable().destroy();
                this.$inertia.get('/Produccion/ReportesPro',{ busca: b }, {
                    onSuccess: () => { this.tabla(), this.limp = 2 }, onError: () => { this.tabla() }, preserveState: true
                });
            },
            fechaC: function(ver){
                this.verTabla();
                $('#t_repo').DataTable().destroy();
                this.limp != 1 ? this.tabla() : '';
                this.recoTabla = [];
                this.cargas.forEach(v => {
                    if (v.fecha.includes(ver)) {
                        this.recoTabla.push(v);
                    }
                });
            }
        }
    }
</script>
