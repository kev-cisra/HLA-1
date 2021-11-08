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
            <template v-slot:BtnNuevo>
                <!-- boton de calculos -->
                <div class="tw-flex tw-gap-3 tw-mr-10">
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" @click="openModalC">Carga masiva</jet-button>
                    </div>
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" @click="openModal">Calculos</jet-button>
                    </div>
                    <div>
                        <jet-button class="BtnNuevo" data-bs-toggle="collapse" data-bs-target="#filtro" aria-expanded="false" aria-controls="filtro"><i class="fas fa-filter"> </i> Filtros</jet-button>
                    </div>
                </div>
            </template>
        </Accions>
        <!------------------------------------ Muestra las opciones de filtros ------------------------------------------->
        <div class="collapse md:tw-ml-10 tw-p-6 tw-bg-blue-300 tw-rounded-3xl tw-shadow-xl tw-m-10" id="filtro">
            <div class="tw-mb-6 lg:tw-flex lg:tw-flex-col tw-w-full">
                <div class="tw-mb-6 lg:tw-flex">
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Año</jet-label>
                        <jet-input type="number" class="form-control" v-model="ano" :max="estAño"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Mes</jet-label>
                        <jet-input type="month" class="form-control" @click="limInputs(3)" v-model="FoFiltro.mes"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Semana</jet-label>
                        <jet-input type="week" class="form-control" @click="limInputs(2)" v-model="FoFiltro.semana"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Fecha</jet-label>
                        <jet-input type="date" class="form-control tw-w-2/3" @click="limInputs(1.5)" v-model="FoFiltro.iniDia" :max="hoy"></jet-input>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------ Data table de carga ------------------------------------------------------->
        <div class="table-responsive">
            <Table id="t_repo">
                <template v-slot:TableHeader>
                    <th class="columna">Proceso</th>
                    <th class="columna">Fecha</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Equipo</th>
                    <th class="columna">Turno</th>
                    <th class="columna">Partida</th>
                    <th class="columna">Norma</th>
                    <th class="columna">Clave</th>
                    <th class="columna">Descripción de clave</th>
                    <th class="columna">Maquina</th>
                    <th class="columna">KG</th>
                    <th class="columna">Numero de pacas</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter >
                    <tr class="fila" v-for="ca in recoTabla" :key="ca.id">
                        <td >{{ca.proceso.nompro}}</td>
                        <td >{{ca.fecha}}</td>
                        <td >{{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.Nombre}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApPat}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApMat}}</td>
                        <td >{{ca.dep_perf == null ? 'N/A' : ca.dep_perf.departamentos.Nombre}}</td>
                        <td >{{ca.equipo == null ? 'N/A' : ca.equipo.nombre}}</td>
                        <td >{{ca.turno == null ? 'N/A' : ca.turno.nomtur}}</td>
                        <td >{{ca.partida == null ? 'N/A' : ca.partida}}</td>
                        <td >{{ca.dep_mat == null ? 'N/A' : ca.dep_mat.materiales.idmat+' - '+ca.dep_mat.materiales.nommat}}</td>
                        <td >{{ca.clave == null ? 'N/A' : ca.clave.CVE_ART}}</td>
                        <td >{{ca.clave == null ? 'N/A' : ca.clave.DESCR}}</td>
                        <td >{{ca.maq_pro == null ? 'N/A' : ca.maq_pro.maquinas.Nombre}}</td>
                        <td >{{this.formatoMexico(ca.valor)}}</td>
                        <td > {{ca.VerInv}} </td>
                        <td>
                            <div class="columnaIconos">
                                <div class="iconoEdit" v-if="ca.proceso.tipo == 1" @click="editCar(ca)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" v-if="ca.proceso.tipo == 1" @click="deleteCar(ca)">
                                    <span tooltip="Eliminar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
                <template v-slot:Foother>
                    <th class="columna">Proceso</th>
                    <th class="columna">Fecha</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Equipo</th>
                    <th class="columna">Turno</th>
                    <th class="columna">Partida</th>
                    <th class="columna">Norma</th>
                    <th class="columna">Clave</th>
                    <th class="columna">Descripción de clave</th>
                    <th class="columna">Maquina</th>
                    <th class="columna">KG</th>
                    <th class="columna">Numero de pacas</th>
                    <th></th>
                </template>
            </Table>
        </div>
        <!------------------------------------- Modal para carga de datos masivas ------------------------------------------------>
        <modal :show="showModalC" @close="chageCloseC">
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Carga Masiva</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <a target="_blank" href="../public/FormatosExcel/FileNotFound404.jpg" download="not.jpg">Link de descarga</a>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha de inicio de carga</jet-label>
                                <input type="file" @input="docu.file = $event.target.files[0]" ref="file" accept=".xlsx">
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                                <jet-button class="" @click="carMasi">Guardar</jet-button>
                                <small v-if="errors.file" class="validation-alert">{{errors.file}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
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
                                    <jet-input type="date" v-model="form.fecha" @change="cambioFechas()" :max="hoy"></jet-input>
                                    <small v-if="errors.fecha" class="validation-alert">{{errors.fecha}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fecha de inicio de carga</jet-label>
                                    <jet-input type="datetime-local" v-model="form.hoy" :max="form.mañana" disabled></jet-input>
                                    <small v-if="errors.hoy" class="validation-alert">{{errors.hoy}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fecha final de carga</jet-label>
                                    <jet-input type="datetime-local" v-model="form.mañana" :min="form.hoy" disabled></jet-input>
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
        <!------------------ Modal Editar Carga------------------------->
        <modal :show="showModalCar" @close="changeCloseCar">
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Editar datos cargados</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <!-- Información general -->
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label>Fecha de la carga</jet-label>
                                <p>{{carga.fecha}}</p>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label>Nombre del operador</jet-label>
                                <p>{{carga.nomOpe}}</p>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label>Turno</jet-label>
                                <p>{{carga.turno}}</p>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label>Equipo</jet-label>
                                <p>{{carga.equipo}}</p>
                            </div>
                        </div>
                        <!-- datos para editar  -->
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Norma</jet-label>
                                <select class="InputSelect" v-model="carga.norma">
                                    <option v-for="nm in opcNM" :key="nm" :value="nm.value">{{nm.text}}</option>
                                </select>
                                <small v-if="errors.norma" class="validation-alert">{{errors.norma}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Clave</jet-label>
                                <select class="InputSelect" v-model="carga.clave_id">
                                    <option v-for="cl in opcCL" :key="cl" :value="cl.value">{{cl.text}}</option>
                                </select>
                                <small v-if="errors.clave_id" class="validation-alert">{{errors.clave_id}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Partida</jet-label>
                                <jet-input class="InputSelect" v-model="carga.partida"></jet-input>
                                <small v-if="errors.partida" class="validation-alert">{{errors.partida}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Kg</jet-label>
                                <jet-input class="InputSelect" v-model="carga.valor"></jet-input>
                                <small v-if="errors.valor" class="validation-alert">{{errors.valor}}</small>
                            </div>
                        </div>
                        <!-- notas -->
                        <div class="tw-mb-6 lg:tw-flex">
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 tw-text-center tw-mx-auto lg:tw-mb-0 tw-bg-emerald-700 tw-bg-opacity-50 tw-rounded-lg">
                                <jet-label>Nota anterior</jet-label>
                                <jet-label v-html="nAnte"></jet-label>
                            </div>
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-2/3 tw-text-center tw-mx-auto lg:tw-mb-0">
                                <jet-label><span class="required">*</span>Nota</jet-label>
                                <textarea class="InputSelect" v-model="carga.nota" maxlength="250" @input="(val) => (carga.nota = carga.nota.toUpperCase())" placeholder="Maximo 250 caracteres"></textarea>
                                <small v-if="errors.nota" class="validation-alert">{{errors.nota}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ModalFooter">
                <button class="btn btn-outline-success" type="button" @click="updateCar(carga)">
                    Actualizar
                </button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
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

    import moment from 'moment';
    import 'moment/locale/es';

    export default {
        props: [
            'usuario',
            'depa',
            'cargas',
            'materiales',
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
                docu: {
                    file: null
                },
                nAnte: null,
                hoy: moment().format('YYYY-MM-DD'),
                editMode: false,
                carMode: false,
                showModal: false,
                showModalC: false,
                showModalCar: false,
                vCal: true,
                horas: '07:00',
                estAño: moment().format('Y'),
                ano: moment().format('Y'),
                FoFiltro: {
                    mes: null,
                    semana: null,
                    iniDia: null,
                    finDia: null,
                },
                form: {
                    fecha: null,
                    hoy: null,
                    mañana: null,
                    depa: this.S_Area
                },
                carga: {
                    id: null,
                    noFecha: moment().format('YYYY-MM-DD HH:mm:ss'),
                    usu: this.usuario.id,
                    nomOpe: null,
                    fecha: null,
                    turno: null,
                    equipo: null,
                    norma: null,
                    clave_id: null,
                    partida: null,
                    valor: null,
                    notas: null
                }
            }
        },

        mounted() {
            this.global();
        },

        methods: {
            /***************************** Carga Masiva ************************************/
            carMasi(){
                const form = this.docu;

                this.$inertia.post('/Produccion/CargaExcel', form, {
                    onSuccess: (v) => { this.openModalC(), this.resetC(), this.alertSucces() }, onError: (e) => { }, preserveState: true
                });
            },
            /***************************** Calculos ******************************************/
            calcula(form) {
                if (this.calcu != '' & this.S_Area != '') {
                    this.vCal = false;
                    this.$inertia.post('/Produccion/Calcula', form, {
                        onSuccess: (v) => {
                            this.alertSucces(),
                            this.vCal = true,
                            this.reset(),
                            this.chageClose(),
                            this.limInputs('00')
                        },
                        onError: (e) => {
                            this.vCal = true
                        },
                        preserveState: true
                    });
                }else{
                    this.calcu == '' ? Swal.fire('Por favor selecciona una fecha') : '';
                    this.S_Area == '' ? Swal.fire('Por favor selecciona un departamento') : '';
                }

            },
            cambioFechas() {
                if(this.S_Area == 7){
                    if (moment(this.form.fecha).isDST()) {
                        this.form.hoy = this.form.fecha+'T09:00';
                        this.form.mañana = moment(this.form.hoy).add(1, 'days').format("YYYY-MM-DD[T]HH:mm")
                    }else{
                        this.form.hoy = this.form.fecha+'T08:00';
                        this.form.mañana = moment(this.form.hoy).add(1, 'days').format("YYYY-MM-DD[T]HH:mm")
                    }
                }else{
                    this.form.hoy = this.form.fecha+'T07:00';
                    this.form.mañana = moment(this.form.hoy).add(1, 'days').format("YYYY-MM-DD[T]HH:mm")
                }

            },
            formatoMexico (number){
                const exp = /(\d)(?=(\d{3})+(?!\d))/g;
                const rep = '$1,';
                let arr = number.toString().split('.');
                arr[0] = arr[0].replace(exp,rep);
                return arr[1] ? arr.join('.'): arr[0];
            },
            /****************************** Globales **********************************************************/
            global(){
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
                    $('#t_repo tfoot th').each( function () {
                        var title = $(this).text();
                        $(this).html( '<input type="text" class="InputSelect tw-text-gray-900" placeholder="'+title+'" />' );
                    } );
                    var table = $('#t_repo').DataTable({
                        "language": this.español,
                        "order": [1, 'asc'],
                        "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        scrollY:        '40vh',
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
                        }
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
                    fecha: null,
                    hoy: null,
                    mañana: null,
                    depa: this.S_Area
                }
            },
            //Nuevo es arreglo
            NuArray() {
                const rt = [];
                var inicio = null;
                var fin = null;
                //consulta del dia
                if(this.FoFiltro.iniDia != null){
                    if (this.S_Area == 7){
                        if (moment(this.FoFiltro.iniDia).isDST()) {
                            inicio = this.FoFiltro.iniDia+' 09:00';
                        }else{
                            inicio = this.FoFiltro.iniDia+' 08:00';
                        }
                    }else{
                        inicio = this.FoFiltro.iniDia+' 07:00'
                    }

                    //Asigna el dato para la fecha final
                    fin = moment(inicio).add(24, 'hours');
                    //Limpia el datatables
                    $('#t_repo').DataTable().clear();
                    $('#t_repo').DataTable().destroy();
                    this.tabla();
                    //hace el recorrido y asigna el Array
                    this.cargas.forEach(fec => {
                        //console.log(fec.fecha)
                        if ( moment(fec.fecha).isAfter(inicio, 'minutes') & moment(fec.fecha).isBefore(fin, 'minutes') ) {
                            rt.push(fec);
                        }
                    });
                }
                //consulta de la semana
                if(this.FoFiltro.semana != null){
                    //Limpia el datatables
                    $('#t_repo').DataTable().clear();
                    $('#t_repo').DataTable().destroy();
                    this.tabla();
                    //hace el recorrido y asigna el Array
                    this.cargas.forEach(fec => {
                        //console.log(fec.proceso.operacion)
                        if ( this.FoFiltro.semana == fec.semana & fec.proceso.operacion != null) {
                            if(fec.proceso.operacion.includes("sem_")){
                                rt.push(fec);
                            }
                        }
                    });
                }
                //Consulta del mes
                if(this.FoFiltro.mes != null){
                    //Limpia el datatables
                    $('#t_repo').DataTable().clear();
                    $('#t_repo').DataTable().destroy();
                    this.tabla();
                    //hace el recorrido y asigna el Array
                    this.cargas.forEach(fec => {
                        //console.log(fec.fecha)
                        if ( fec.fecha.includes(this.FoFiltro.mes) & fec.proceso.operacion != null ) {
                            if(fec.proceso.operacion.includes("mes_")){
                                rt.push(fec);
                            }
                        }
                    });
                }
                return rt;
            },
            //Limpia los inputs de fechas
            limInputs(val){
                if(val == 1.5){
                    this.FoFiltro.semana = null;
                    this.FoFiltro.mes = null;
                }else if(val == 2){
                    this.FoFiltro.iniDia = null;
                    this.FoFiltro.finDia = null;
                    this.FoFiltro.mes = null;
                    this.horas = '07:00';
                }else if(val == 3){
                    this.FoFiltro.iniDia = null;
                    this.FoFiltro.finDia = null;
                    this.FoFiltro.semana = null;
                    this.horas = '07:00';
                }
                else{
                    this.FoFiltro.iniDia = null;
                    this.FoFiltro.finDia = null;
                    this.FoFiltro.semana = null;
                    this.FoFiltro.mes = null;
                }
            },
            /***************************** Modal de carga masiva ********************************************/
            //abrir modal carga masiva
            openModalC(){
                this.chageCloseC();
            },
            //abrir o cerrar modal procesos
            chageCloseC(){
                this.showModalC = !this.showModalC
            },
            //reset de file
            resetC(){
                this.$refs.file.type='text';
                this.$refs.file.type='file';
            },
            /**************************** Acciones de la carga ***********************************************/
            //eliminar carga
            deleteCar(data){
                //console.log(data)
                Swal.fire({
                    title: '¿Estás seguro de querer eliminar este Registro?',
                    text: "¡Si se elimina no se podrá revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                        'Eliminadó!',
                        '¡El registro se eliminó correctamente!',
                        'success'
                        )
                        data._method = 'DELETE';
                        this.$inertia.post('/Produccion/Carga/' + data.id, data, {
                            onSuccess: () => { this.alertDelete(), this.limInputs('00') }, onError: () => {}, preserveState: true
                        });
                    }
                })
            },
            //abrir o cerrar modal para carga de datos
            changeCloseCar(){
                this.showModalCar = !this.showModalCar
            },
            //reset de carga
            resetCar(){
                this.carga = {
                    id: null,
                    nomOpe: null,
                    fecha: null,
                    turno: null,
                    equipo: null,
                    norma: null,
                    clave_id: null,
                    partida: null,
                    valor: null,
                    notas: null
                }
            },
            //editar carga
            editCar(data){
                this.changeCloseCar();
                this.carga.id = data.id;
                this.carga.nomOpe = data.dep_perf.perfiles.Nombre+' '+data.dep_perf.perfiles.ApPat+' '+data.dep_perf.perfiles.ApMat;
                this.carga.fecha = moment(data.fecha).format('YYYY-MM-DD');
                this.carga.turno = data.turno.nomtur;
                this.carga.equipo = data.equipo.nombre;
                this.carga.norma = data.norma;
                this.carga.clave_id = data.clave_id;
                this.carga.partida = data.partida;
                this.carga.valor = data.valor;
                this.nAnte = data.notas.length == 0 ? '' : `<label class="tw-text-base tw-w-full tw-text-black">Fecha: ${data.notas[0].fecha}</label><label class="tw-text-base tw-w-full tw-text-black tw-capitalize"> ${data.notas[0].nota}</label>`;
            },
            updateCar(data){
                this.$inertia.put('/Produccion/CarNor/' + data.id, data, {
                    onSuccess: (v) => { this.resetCar(), this.alertSucces(), this.changeCloseCar(), this.limInputs('00') }, onError: (e) => { }, preserveState: true
                });
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
            //Opciones Normas
            opcNM: function() {
                const nm = [];
                this.materiales.forEach(ma => {
                    nm.push({value: ma.id, text: ma.materiales.idmat+' - '+ma.materiales.nommat});
                })
                return nm;
            },
            //Opciones Claves
            opcCL: function() {
                const scl = [];
                /* this.form.clave_id = ''; */
                if (this.carga.norma != '') {
                    this.materiales.forEach(cl => {
                        if (this.carga.norma == cl.id) {
                            //console.log(cl.claves)
                            cl.claves.forEach(c => {
                                scl.push({value: c.id, text: c.CVE_ART+ ' - ' + c.DESCR})
                            })
                        }
                    })
                }
                return scl;
            },
            //recorrido para la tabla
            recoTabla: function() {
                return this.NuArray();
            }
        },

        watch: {
            S_Area: function(b){
                $('#t_repo').DataTable().destroy();
                this.$inertia.get('/Produccion/ReportesPro',{ busca: b, ano: this.ano }, {
                    onSuccess: () => { }, onError: () => { }, preserveState: true
                });
            },
            ano: function(a) {
                this.$inertia.get('/Produccion/ReportesPro',{ busca: this.S_Area, ano: a }, {
                    onSuccess: () => { }, onError: () => { }, preserveState: true
                });

            },
        }
    }
</script>
