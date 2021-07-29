<template>
    <app-layout>
        <div class="tw-px-2 tw-py-4 tw-text-xs">
            <div class='tw-w-full tw-overflow-x-auto'>
                <jet-button @click="openModal" class="tw-bg-green-500 tw-m-5 tw-rounded focus:tw-outline-none hover:tw-bg-green-300">Agregar</jet-button>
                <!----------------- Tabla de muestra ---------->
                <table class='tw-w-full tw-overflow-hidden tw-uppercase tw-bg-white tw-divide-y tw-divide-gray-300 tw-rounded'>
                    <thead class="tw-bg-gray-600">
                        <tr class="tw-font-semibold tw-text-left tw-text-white">
                            <th class="tw-px-4 tw-py-2">Nombre</th>
                            <th class="tw-px-4 tw-py-2">Ruta</th>
                            <th class="tw-px-4 tw-py-2">Área</th>
                            <th class="tw-px-4 tw-py-2"></th>
                        </tr>

                    </thead>
                    <tbody class="tw-divide-y tw-divide-gray-200">
                        <tr v-for="modulo in modulos" :key="modulo.id">
                            <td class="tw-border tw-px-4 tw-py-2">{{ modulo.NombreModulo }}</td>
                            <td class="tw-border tw-px-4 tw-py-2">{{ modulo.Ruta }}</td>
                            <td class="tw-border tw-px-4 tw-py-2"> {{ modulo.Area }} </td>
                            <td class="tw-border tw-px-4 tw-py-2">
                                <div class="tw-flex tw-justify-center tw-item-center">
                                    <div class="tw-w-4 tw-mr-2 tw-transform hover:tw-text-blue-500 hover:tw-scale-110" @click="edit(modulo)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </div>
                                    <div class="tw-w-4 tw-mr-2 tw-transform hover:tw-text-red-500 hover:tw-scale-110" @click="deleteRow(modulo)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </div>
                                </div>


                                <!--<jet-button @click="edit(modulo)" class="tw-bg-blue-500 hover:tw-bg-blue-700 tw-text-white tw-font-bold tw-py-2 tw-px-4 tw-rounded">
                                    Editar
                                </jet-button>
                                <jet-button @click="deleteRow(modulo)" class="tw-bg-red-500 hover:tw-bg-red-700 tw-text-white tw-font-bold tw-py-2 tw-px-4 tw-rounded">
                                    Borrar
                                </jet-button>-->
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        
        

        <modal :show="showModal" @close="chageClose">
            <form>
                <div class="tw-bg-white tw-px-4 tw-pt-5 tw-pb-4 sm:tw-p-6 sm:tw-pb-4">
                    <div class="tw-mb-4">
                        <label for="NombreModulo" class="tw-block tw-text-gray-700 tw-text-sm tw-font-bold tw-mb-2">Nombre:</label>
                        <jet-input id="NombreModulo" class="tw-shadow tw-appearance-none tw-border tw-rounded tw-w-full tw-py-2 tw-px-3 tw-text-gray-700 tw-leading-tight focus:tw-outline-none focus:tw-shadow-outline" v-model="form.NombreModulo" />
                        <div v-if="errors.NombreModulo">{{errors.NombreModulo}}</div>
                    </div>
                    <div class="tw-mb-4">
                        <label for="Icono" class="tw-block tw-text-gray-700 tw-text-sm tw-font-bold tw-mb-2">Icono:</label>
                        <jet-input id="Icono" class="tw-shadow tw-appearance-none tw-border tw-rounded tw-w-full tw-py-2 tw-px-3 tw-text-gray-700 tw-leading-tight focus:tw-outline-none focus:tw-shadow-outline" v-model="form.Icono" />
                        <div v-if="errors.Icono">{{errors.Icono}}</div>
                    </div>
                    <div class="tw-mb-4">
                        <label for="Ruta" class="tw-block tw-text-gray-700 tw-text-sm tw-font-bold tw-mb-2">Ruta:</label>
                        <jet-input id="Ruta" class="tw-shadow tw-appearance-none tw-border tw-rounded tw-w-full tw-py-2 tw-px-3 tw-text-gray-700 tw-leading-tight focus:tw-outline-none focus:tw-shadow-outline" v-model="form.Ruta" />
                        <div v-if="errors.Ruta">{{errors.Ruta}}</div>
                    </div>
                    <div class="tw-mb-4">
                        <label for="Area" class="tw-block tw-text-gray-700 tw-text-sm tw-font-bold tw-mb-2">Área:</label>
                        <!--<jet-input id="Area" class="tw-shadow tw-appearance-none tw-border tw-rounded tw-w-full tw-py-2 tw-px-3 tw-text-gray-700 tw-leading-tight focus:tw-outline-none focus:tw-shadow-outline" v-model="form.Area" />-->
                        <select id="Area" v-model="form.Area" placeholder="klasdjlij">
                            <option v-for="areaMo in areaM" :key="areaMo.id" :value="areaMo.id">{{ areaMo.NombreArea }}</option>
                        </select>
                        <div v-if="errors.Area">{{errors.Area}}</div>
                    </div>
                    <jet-button type="button" @click="save(form)" v-show="!editMode" class="tw-inline-flex tw-justify-center tw-w-full tw-rounded-md tw-border tw-border-transparent tw-px-4 py-2 tw-bg-green-600 tw-text-base tw-leading-6 tw-font-medium tw-text-white tw-shadow-sm hover:tw-bg-green-500 focus:tw-outline-none focus:tw-border-green-700 focus:tw-shadow-outline-green tw-transition tw-ease-in-out tw-duration-150 sm:tw-text-sm sm:tw-leading-5">Guardar</jet-button>
                    <jet-button type="button" @click="update(form)" v-show="editMode" class="tw-inline-flex tw-justify-center tw-w-full tw-rounded-md tw-border tw-border-transparent tw-px-4 py-2 tw-bg-green-600 tw-text-base tw-leading-6 tw-font-medium tw-text-white tw-shadow-sm hover:tw-bg-green-500 focus:tw-outline-none focus:tw-border-green-700 focus:tw-shadow-outline-green tw-transition tw-ease-in-out tw-duration-150 sm:tw-text-sm sm:tw-leading-5">Actualizar</jet-button>
                    <jet-button @click="chageClose">Cerrar</jet-button>
                </div>
            </form>
        </modal>
    </app-layout>

</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import JetButton from '@/Jetstream/Button';
    import JetInput from '@/Jetstream/Input';
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
            JetButton,
            JetInput,
            Modal,
                Modal,
        },
        data() {
            return {
                showModal: false,
                editMode: false,
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
                    onSuccess: () => {this.reset(), this.chageClose()},
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
                this.$inertia.post('/Admin/Modulos/' + data.id, data);
            }

        }
    }
</script>
