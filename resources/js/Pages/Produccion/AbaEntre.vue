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
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" @click="ConAba()">Abastos</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Entregas</button>
            </div>
        </nav>
        <div class="tab-content tw-m-5" id="nav-tabContent">
            <!-- Abastos -->
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="overflow-auto tw-gap-3 tw-flex tw-flex-wrap tw-justify-center" style="height: 25rem">
                    <!-- cuerpo tarjeta -->
                    <div class="card tw-w-11/12 md:tw-w-9/12 lg:tw-w-5/12 tw-shadow-xl" v-for="ae in abaentre" :key="ae">
                        <!-- info tarjeta -->
                        <div class="card-body">
                            <!-- <h5 class="card-title tw-text-2xl"></h5> -->
                            <table>
                                <tr>
                                    <th>{{ ae.folio }} - {{ ae.banco }}</th>
                                    <td> <button class="btn btn-success" @click="ediAbas(ae)">Actualizar</button> </td>
                                </tr>
                                <tr>
                                    <th>Estatus de entrega:</th>
                                    <td>{{ ae.esta_inicio }}</td>
                                </tr>
                                <tr>
                                    <th>Estatus producción:</th>
                                    <td>{{ ae.esta_final }}</td>
                                </tr>
                                <tr>
                                    <th>Total enviado:</th>
                                    <td>{{ ae.total }}</td>
                                </tr>
                                <tr>
                                    <th>Norma:</th>
                                    <td> {{ ae.norma_id ? ae.norma.materiales.nommat : '--' }}</td>
                                </tr>
                                <tr>
                                    <th>Clave:</th>
                                    <td>{{ ae.clave_id ? ae.clave.DESCR : '--' }}</td>
                                </tr>
                                <tr>
                                    <th>Partida:</th>
                                    <td>{{ ae.partida }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- Acordion -->
                        <div class="accordion accordion-flush" :id="'accordion'+ae.id">
                            <div class="accordion-item">
                                <h2 class="accordion-header" :id="'open'+ae.id">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#flushOne'+ae.id" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Abasto
                                </button>
                                </h2>
                                <div :id="'flushOne'+ae.id" class="accordion-collapse collapse" :aria-labelledby="'open'+ae.id" :data-bs-parent="'#accordion'+ae.id">
                                    <div class="accordion-body overflow-auto" style="height: 10rem">
                                        Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta quaerat rem sapiente, placeat dolorum ut repellendus obcaecati! Repellat eius voluptatum dolores hic minima distinctio commodi est voluptatibus, unde, optio dolorem?
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet provident sed corporis eligendi voluptate molestias, pariatur aliquid natus repudiandae libero? Eligendi dolorum qui quas magnam tempora excepturi quisquam fuga assumenda?
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" :id="'open2'+ae.id">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#flushTwo'+ae.id" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    Producción
                                </button>
                                </h2>
                                <div :id="'flushTwo'+ae.id" class="accordion-collapse collapse" :aria-labelledby="'open2'+ae.id" :data-bs-parent="'#accordion'+ae.id">
                                <div class="accordion-body overflow-auto" style="height: 10rem">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Entregas -->
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <!-- Proceso proncipal, sub procesos, operador -->
                <div class="tw-p-6 lg:tw-flex">
                    <!-- Select Area -->
                    <div class="tw-px-3 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Departamento para entregar</jet-label>
                        <select class="InputSelect" v-model="formAba.depa_entrega">
                            <option value="">SELECCIONA</option>
                            <option v-for="dep in opcDep" :key="dep" :value="dep.id">{{ dep.text }}</option>
                        </select>
                        <small v-if="errors.depa_entrega" class="validation-alert">{{errors.depa_entrega}}</small>
                    </div>
                    <!-- input Folio -->
                    <div class="tw-px-3 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Folio</jet-label>
                        <jet-input class="InputSelect" v-model="formAba.folio" @input="(val) => (formAba.folio = formAba.folio.toUpperCase())"></jet-input>
                        <small v-if="errors.folio" class="validation-alert">{{errors.folio}}</small>
                    </div>
                    <!-- input Banco -->
                    <div class="tw-px-3 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Banco</jet-label>
                        <jet-input class="InputSelect" v-model="formAba.banco" @input="(val) => (formAba.banco = formAba.banco.toUpperCase())"></jet-input>
                        <small v-if="errors.banco" class="validation-alert">{{errors.banco}}</small>
                    </div>
                    <!-- input total -->
                    <div class="tw-px-3 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label>Total</jet-label>
                        <jet-input type="number" class="InputSelect" v-model="formAba.total"></jet-input>
                        <small v-if="errors.total" class="validation-alert">{{errors.total}}</small>
                    </div>
                </div>
                <div class="lg:tw-flex tw-justify-center" v-if="S_Area != ''">
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0 d-grid gap-2">
                        <button type="button" class="btn btn-success" @click="saveEntre(formAba)">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal actualizar abastos -->
        <modal :show="showModal" @close="chageClose">
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Abastos</h3>
                    </div>
                </div>
            </div>
            <div class="tw-mt-4">
                <div class="ModalForm">
                    <!-- Formulas -->
                    <div class="tw-mb-6 lg:tw-flex">
                        <!-- estatus -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                            <jet-label class=""><span class="required">*</span>Estatus</jet-label>
                            <select class="InputSelect" v-model="formAba.esta_final">
                                <option value="" disabled>SELECCIONA</option>
                                <option value="Activo">Activar</option>
                                <option value="En espera">En espera</option>
                                <option value="Fin">Finalizar</option>
                                <option value="Desactivado">Desactivado</option>
                            </select>
                            <small v-if="errors.esta_final" class="validation-alert">{{errors.esta_final}}</small>
                        </div>
                        <!-- Norma -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                            <jet-label class=""><span class="required">*</span>Norma</jet-label>
                            <select class="InputSelect" v-model="formAba.norma" :disabled="formAba.norma" :disable="vrNor">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="nm in opcNM" :key="nm" :value="nm.value">{{nm.text}}</option>
                            </select>
                            <small v-if="errors.norma" class="validation-alert">{{errors.norma}}</small>
                        </div>
                        <!-- Partida -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                            <jet-label>Partida</jet-label>
                            <jet-input class="InputSelect" v-model="formAba.partida"  @input="(val) => (formAba.partida = formAba.partida.toUpperCase())" :disabled="vrPar"></jet-input>
                            <small v-if="errors.partida" class="validation-alert">{{errors.partida}}</small>
                        </div>
                    </div>
                    <div class="tw-mb-6 lg:tw-flex">
                        <!-- Clave -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                            <jet-label class="tw-text-white"><span class="required">*</span>Clave</jet-label>
                            <Select2 v-model="formAba.clave" class="InputSelect tw-w-full" style="z-index: 1500" :settings="{width: '100%', allowClear: true, disabled: vrCla}" :options="opcCL"/>
                            <small v-if="errors.clave" class="validation-alert">{{errors.clave}}</small>
                        </div>
                        <!-- boton -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                            <button class="btn btn-success m-auto" @click="updaAbas(formAba)">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </modal>

    </app-layout>
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header';
    import Accions from '@/Components/Accions';
    import Table from '@/Components/Table';
    import JetLabel from '@/Jetstream/Label';
    import JetInput from '@/Components/Input';
    import Select2 from 'vue3-select2-component';
    import Modal from '@/Jetstream/Modal';
    import axios from 'axios';

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
            Table,
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
                errors: [],
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
                }
            }
        },

        methods: {
            /************************************* Entregas guardar y pasar a otro departamento */
            async saveEntre(data){
                data.depa_recibe = this.S_Area;
                data.esta_inicio = 'Revisando';
                data.esta_final = 'Desactivado';
                await axios.post('AbaEntre/entIns', data)
                .then(dat => {this.resetEntr(), this.alertSucces()})
                .catch(err => {this.errors = err.response.data.errors, this.alertWarning()})
                //console.log(data)
            },
            resetEntr(){
                this.errors = [];
                this.vrNor = false;
                this.vrCla = false;
                this.vrPar = false;
                this.formAba.id = '';
                this.formAba.partida = '';
                this.formAba.folio = '';
                this.formAba.folio2 = '';
                this.formAba.banco = '';
                this.formAba.total = 0;
                this.formAba.norma = '';
                this.formAba.clave = null;
                this.formAba.esta_inicio = '';
                this.formAba.esta_final = '';
                this.formAba.depa_entrega = '';
                this.formAba.depa_recibe = null;
            },
            /************************************ Abastos guardar consulta **********************/
            //Consulta de abastos
            async ConAba(){
                var datos = {'departamento_id': this.S_Area, 'modulo': 'abaEntre'};
                //abasto entregas
                let aba = await axios.post('AbaEntre/conabaent', datos);
                this.abaentre = aba.data;
            },
            //editar formulario
            ediAbas(data){
                this.openModal()
                this.vrNor = data.norma ? true : false;
                this.vrCla = data.clave_id ? true : false;
                this.vrPar = data.partida ? true : false;
                this.formAba.id = data.id;
                this.formAba.partida = data.partida;
                this.formAba.folio = data.folio;
                this.formAba.folio2 = data.folio2;
                this.formAba.banco = data.banco;
                this.formAba.total = data.total;
                this.formAba.norma = data.norma_id;
                this.formAba.clave = data.clave_id;
                this.formAba.esta_final = data.esta_final;
            },
            //abrir modal
            openModal(){
                this.chageClose();
                this.resetEntr();
            },
            chageClose(){
                this.showModal = !this.showModal;
            },
            //actualizar información
            async updaAbas(data){
                await axios.post('AbaEntre/updeAbas', data)
                .then(eve => {this.ConAba(), this.openModal(), this.ConAba(), this.alertSucces()})
                .catch(err => {this.errors = err.response.data.errors, this.alertWarning()})
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
                if (this.formAba.norma != '') {
                    this.materiales.forEach(cl => {
                        if (this.formAba.norma == cl.id) {
                            //console.log(cl.claves)
                            cl.claves.forEach(c => {
                                scl.push({id: c.id, text: c.CVE_ART+ ' - ' + c.DESCR})
                            })
                        }
                    })
                }
                return scl;
            },
            opcDep: function() {
                const dep = [];
                this.depaT.forEach(val => {
                    dep.push({id: val.id, text: val.Nombre})
                })
                return dep;
            }
        },

        watch: {
            S_Area: async function(b){

                var datos = {'departamento_id': this.S_Area, 'modulo': 'abaEntre'};

                //Produccion
                let car = await axios.post('AbaEntre/Carga', datos)
                this.carga = car.data;

                //Materiales
                let mate = await axios.post('General/ConMateriales', datos)
                this.materiales = mate.data

                //abasto entregas
                let aba = await axios.post('AbaEntre/conabaent', datos);
                this.abaentre = aba.data;
            },
        }
    }
</script>
