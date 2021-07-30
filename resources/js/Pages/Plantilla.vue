<template>
    <app-layout>
        <div>
            <Header>
                <slot>#</slot>
            </Header>

            <Accions>
                <template v-slot:InputBusqueda>
                    <input type="text" wire:model="search" placeholder="Busqueda por Id" class="InputSearch focus:tw-outline-none focus:tw-shadow-outline focus:tw-placeholder-gray-600 focus:tw-text-gray-700">
                </template>
                <template v-slot:NombreBoton>
                    Guardar
                </template>
            </Accions>

            <Table>
                <template v-slot:TableHeader>
                    <th class="tw-px-4 tw-py-2">Columna</th>
                    <th class="tw-px-4 tw-py-2">Acciones</th>
                </template>

                <template v-slot:TableFooter>
                    <tr>
                        <td class="tw-border tw-px-4 tw-py-2"></td>
                        <td class="tw-border tw-px-4 tw-py-2">
                            <div class="tw-flex tw-justify-center tw-item-center">
                                <div class="tw-w-4 tw-mr-2 tw-transform hover:tw-text-green-500 hover:tw-scale-110">
                                    <span tooltip="Detalles" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="tw-w-4 tw-mr-2 tw-transform hover:tw-text-blue-500 hover:tw-scale-110">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="tw-w-4 tw-mr-2 tw-transform hover:tw-text-red-500 hover:tw-scale-110">
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
        </div>
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

