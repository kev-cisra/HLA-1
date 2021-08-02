<template>
    <app-layout>
        <div>
            <Header>
                <slot>Módulos del Sistema</slot>
            </Header>

            <Accions>
                <template v-slot:SelectB>
                    <select class="InputSelect">
                        <option>xxx</option>
                    </select>
                </template>
                <template v-slot:InputBusqueda>
                    <input type="text" placeholder="Busqueda por Id" class="InputSearch" v-model="search">
                </template>
                <template v-slot:BtnNuevo>
                    <jet-button @click="openModal" class="BtnNuevo">Nuevo </jet-button>
                </template>
            </Accions>
            <Table>
                <template v-slot:TableHeader>
                    <th class="columna">Columna</th>
                    <th class="columna">Acciones</th>
                </template>

                <template v-slot:TableFooter>
                    <tr>
                        <td class="fila"></td>
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
                                <div class="iconoEdit">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete">
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
                                    <jet-label><span class="required">*</span>XXX</jet-label>
                                    <jet-input type="text"></jet-input>
                                    <small  class="validation-alert">XXX</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>XXX</jet-label>
                                    <jet-input type="text"></jet-input>
                                    <small  class="validation-alert">XXX</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="ModalFooter">
                    <jet-button type="button">Guardar</jet-button>
                    <jet-button type="button">Actualizar</jet-button>
                    <jet-CancelButton>Cerrar</jet-CancelButton>
                </div>
            </form>
        </modal>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import comDangerButton from '@/Components/DangerButton'
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table'

    export default {
        components: {
            AppLayout,
            Welcome,
            comDangerButton,
            Header,
            Accions,
            Table
        },
    }
</script>

