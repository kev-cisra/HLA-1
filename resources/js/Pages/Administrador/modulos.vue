<template>
    <app-layout>
        <div>
            <Header>
                <slot>Módulos del Sistema</slot>
            </Header>

            <Accions>
                <template v-slot:SelectB>
                    <select class="InputSelectFilter" v-model="Filter">
                        <option value="id" selected>Id</option>
                        <option value="Nombre">Nombre</option>
                        <option value="Area">Area</option>
                    </select>
                </template>
                <template v-slot:InputBusqueda>
                    <input type="text" :placeholder="'Filtro por '+Filter" class="InputSearch" v-model="search">
                </template>
                <template v-slot:BtnNuevo>
                    <jet-button @click="openModal" class="BtnNuevo">Nuevo Módulo </jet-button>
                </template>
            </Accions>

            <Table>
                <template v-slot:TableHeader>
                    <th class="columna">Nombre</th>
                    <th class="columna">Area</th>
                    <th class="columna">Icono</th>
                    <th class="columna">Ruta</th>
                    <th class="columna tw-text-center">Acciones</th>
                </template>

                <template v-slot:TableFooter>
                    <tr v-for="modulo in modulos" :key="modulo.id">
                        <td class="fila">{{ modulo.NombreModulo }}</td>
                        <td class="fila">{{ modulo.Area }}</td>
                        <td class="fila">{{ modulo.Ruta }}</td>
                        <td class="fila">{{ modulo.Ruta }}</td>
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

            <!-- <pagination class="mt-10" :links="modulos.links"/> -->
        </div>


        <modal :show="showModal" @close="chageClose">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Alta de Modulo</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Nombre Modulo</jet-label>
                                    <jet-input type="text" v-model="form.NombreModulo"></jet-input>
                                    <small v-if="errors.NombreModulo" class="validation-alert">{{errors.NombreModulo}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Icono</jet-label>
                                    <jet-input type="text" v-model="form.Icono"></jet-input>
                                    <small v-if="errors.Icono" class="validation-alert">{{errors.Icono}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Ruta</jet-label>
                                    <jet-input type="text" v-model="form.Ruta"></jet-input>
                                    <small v-if="errors.Ruta" class="validation-alert">{{errors.Ruta}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Area</jet-label>
                                    <select id="Area" v-model="form.Area" class="InputSelect">
                                        <option v-for="areaMo in areaM" :key="areaMo.id" :value="areaMo.id">{{ areaMo.NombreArea }}</option>
                                    </select>
                                    <small v-if="errors.Area" class="validation-alert">{{errors.Area}}</small>
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
            </form>
        </modal>
    </app-layout>

</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    // import Pagination from '@/Components/Pagination'
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table'
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetSelect from '@/Components/Select';
    import Modal from '@/Jetstream/Modal';

    export default {
        props: [
            'usuario',
            'modulos',
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
        },
        data() {
            return {
                showModal: false,
                editMode: false,
                Filter: 'Id',
                search: null,
                form: {
                    IdUser: this.usuario.id,
                    NombreModulo: null,
                    Icono: null,
                    Ruta: null,
                    Area: null,
                },
            }
        },
        methods: {
            alertSucces(){
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
                    icon: 'success',
                    title: 'Registro Insertado',
                    // background: '#99F6E4',
                })
            },

            alertDelete(){
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
                    icon: 'success',
                    title: 'Registro Eliminado Correctamente',
                    // background: '#99F6E4',
                })
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
                    IdUser: this.usuario.id,
                    NombreModulo: null,
                    Icono: null,
                    Ruta: null,
                    Area: null,
                }
            },

            save(data) {
                this.$inertia.post('/Admin/Modulos', data, {
                    onSuccess: () => {
                        this.reset(),
                        this.chageClose(),
                        this.alertSucces()
                        },
                });
            },
            edit: function (data) {
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
                this.$inertia.post('/Admin/Modulos/' + data.id, data, {
                    onSuccess: () => {
                        this.alertDelete()
                        },
                });
            }
        }
    }
</script>
