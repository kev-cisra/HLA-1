<template>
    <app-layout>
        <Header>
            Área: {{usuario.perfiles_area.Nombre}}
        </Header>
        <!-------------- Tabla --------------->
        <Accions>
            <template v-slot:InputBusqueda>
                <input type="text" placeholder="Busqueda por Id" class="InputSearch" v-model="search">
            </template>
            <template  v-slot:SelectB>
                <select  v-show="!SM" @change="verTabla" class="InputSelect" v-model="S_Area">
                    <option v-for="area in areas" :key="area" :value="area.id">{{ area.Nombre }}</option>
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <jet-button @click="openModal" class="BtnNuevo">Nuevo Módulo </jet-button>
            </template>
        </Accions>
        <Table>
            <template v-slot:TableHeader>
                <th class="columna">Nombre</th>
                <th class="columna">Tipo</th>
                <th class="columna">Descripción</th>
                <th class="columna">Área</th>
                <th></th>
            </template>
            <template v-slot:TableFooter>
                <tr v-for="proceso in procesos" :key="proceso.id">
                    <td class="fila">{{ proceso.nompro }}</td>
                    <td class="fila">{{ proceso.tipo }}</td>
                    <td class="fila">{{ proceso.descripcion }}</td>
                    <td class="fila">{{ proceso.procesos_area.Nombre }}</td>
                    <td class="fila">
                        <div class="columnaIconos">
                            <div class="iconoDetails">
                                <span tooltip="Detalles" flow="left">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="iconoEdit" @click="edit(modulo)">
                                <span tooltip="Editar" flow="left">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="iconoDelete" @click="deleteRow(modulo)">
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
        </Table>
        <!------------------ Modal ------------------------->
        <modal :show="showModal" @close="chageClose">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Procesos</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div v-show="!SM" class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Área</jet-label>
                                    <select  class="InputSelect" v-model="form.areas_id">
                                        <option v-for="area in areas" :key="area" :value="area.id">{{ area.Nombre }}</option>
                                    </select>
                                    <small v-if="errors.areas_id" class="validation-alert">{{errors.areas_id}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Nombre del proceso</jet-label>
                                    <jet-input type="text" v-model="form.nompro"></jet-input>
                                    <small v-if="errors.nompro" class="validation-alert">{{errors.nompro}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Tipo de proceso</jet-label>
                                    <select v-model="form.tipo" class="InputSelect">
                                        <option value="">Seleccione</option>
                                        <option value="1">Encargado</option>
                                        <option v-show="!SM" value="2">Coordinador</option>
                                        <option v-show="!SM" value="3">Formulas</option>
                                    </select>
                                    <small v-if="errors.tipo" class="validation-alert">{{errors.tipo}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Descripción</jet-label>
                                    <textarea v-model="form.descripcion" class="InputSelect"></textarea>
                                    <small v-if="errors.descripcion" class="validation-alert">{{errors.descripcion}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-------------------- Inicio form 2 ---------------------------------
                <div>
                    <div class="tw-px-4 tw-py-4">
                        <div class="tw-text-lg">
                            <div class="ModalHeader">
                                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Procesos</h3>
                            </div>
                        </div>

                        <div class="tw-mt-4">
                            <div class="ModalForm">
                                <div class="tw-mb-6 md:tw-flex">
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                        <jet-label><span class="required">*</span>Área</jet-label>
                                        <select  v-show="!SM" class="InputSelect" v-model="form.areas_id">
                                            <option v-for="area in areas" :key="area" :value="area.id">{{ area.Nombre }}</option>
                                        </select>
                                        <small v-if="errors.areas_id" class="validation-alert">{{errors.areas_id}}</small>
                                    </div>
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                        <jet-label><span class="required">*</span>Nombre del proceso</jet-label>
                                        <jet-input type="text" v-model="form.nompro"></jet-input>
                                        <small v-if="errors.nompro" class="validation-alert">{{errors.nompro}}</small>
                                    </div>
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                        <jet-label><span class="required">*</span>Tipo de proceso</jet-label>
                                        <select v-model="form.tipo" class="InputSelect">
                                            <option value="">Seleccione</option>
                                            <option value="1">Encargado</option>
                                            <option value="2">Coordinador</option>
                                            <option value="3">Formulas</option>
                                        </select>
                                        <small v-if="errors.tipo" class="validation-alert">{{errors.tipo}}</small>
                                    </div>
                                </div>

                                <div class="tw-mb-6 md:tw-flex">
                                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                        <jet-label><span class="required">*</span>Descripción</jet-label>
                                        <textarea v-model="form.descripcion" class="InputSelect"></textarea>
                                        <small v-if="errors.Ruta" class="validation-alert">{{errors.descripcion}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ModalFooter">
                        <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                        <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
                        <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
                    </div>
                </div>
                ------------------------- Fin form 2 ----------------------------------->

                <div class="ModalFooter">
                    <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                    <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
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
    import Table from '@/Components/Table'
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetSelect from '@/Components/Select';
    import Modal from '@/Jetstream/Modal';
    import JetLabel from '@/Jetstream/Label';
    import Select from '../../Components/Select.vue';

    export default {
        props: [
            'usuario',
            'procesos',
            'areas',
            'areaM',
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
            Modal,
            JetLabel
        },
        data() {
            return {
                S_Area: this.usuario.Areas_id,
                SM: false,
                showModal: false,
                editMode: false,
                search: null,
                form: {
                    nompro: null,
                    areas_id: this.usuario.Areas_id,
                    tipo: '',
                    descripcion: null
                }

            }
        },
        mounted() {
            this.mostSelect();
        },
        methods: {
            alertArea(){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    title: 'Se tiene que cambiar el valor de la área',
                    // background: '#99F6E4',
                })
            },
            mostSelect() {
                this.$nextTick(() => {
                    if(this.usuario.perfiles_area.idArea !== "PRO"){
                        this.SM = true;
                    }
                    //console.log(this.usuario.Areas_id);
                });
            },
            verTabla(event){
                this.$inertia.get('/Produccion/Procesos',{ busca: event.target.value }, { preserveState: true })
            },
            openModal() {
                this.chageClose();
                this.reset();
                this.editMode = false;
            },
            chageClose(){
                this.showModal = !this.showModal
            },
            reset(){
                this.form = {
                    nompro: null,
                    areas_id: this.usuario.Areas_id,
                    tipo: '',
                    descripcion: null
                }
            },
            save(form) {
                if(form.areas_id == this.usuario.perfiles_area.id & this.usuario.perfiles_area.idArea == 'PRO'){
                    this.alertArea();
                }else{
                    console.log(form)
                    this.$inertia.post('/Produccion/Procesos', form, {
                        onSuccess: () => { /*if (form.tipo == 3) {
                            console.log(proceso_id);
                            //this.$inertia.post('/Produccion/Procesos/carform', form)
                        }*/ this.reset(), this.chageClose()},
                    });
                }

            },
            /*edit: function (data) {
                this.form = Object.assign({}, data);
                //this.vari = data.id;
                this.editMode = true;
                this.chageClose();
            },
            update(data) {
                data._method = 'PUT';
                this.$inertia.post('/Admin/Modulos/' + data.id, data, {
                    onSuccess: () => {this.reset(), this.chageClose()},
                });
            },
            deleteRow: function (data) {
                if (!confirm('¿Estas seguro de querer eliminar este Modulo?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/Admin/Modulos/' + data.id, data);
            }*/

        }
    }
</script>
