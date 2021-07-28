<template>
    <div class="tw-px-2 tw-py-4 tw-text-xs">
        <div class='tw-w-full tw-overflow-x-auto'>
            <table class='tw-w-full tw-overflow-hidden tw-uppercase tw-bg-white tw-divide-y tw-divide-gray-300 tw-rounded'>
                <thead class="tw-bg-gray-600">
                    <tr class="tw-font-semibold tw-text-left tw-text-white">
                        <slot name="thead">
                                                    <th class="tw-p-2"> Nombre Columna </th>
                        <th class="tw-p-2"> Acciones </th>
                        </slot>

                    </tr>
                </thead>
                <tbody class="tw-divide-y tw-divide-gray-200">
                        <slot name="tbody">
                                                  <td class="tw-p-2">lorem </td>
                        <td class="tw-p-2">
                            <div class="tw-flex tw-justify-center tw-item-center">
                                <div class="tw-w-4 tw-mr-2 tw-transform hover:tw-text-green-500 hover:tw-scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <div class="tw-w-4 tw-mr-2 tw-transform hover:tw-text-blue-500 hover:tw-scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                                <div class="tw-w-4 tw-mr-2 tw-transform hover:tw-text-red-500 hover:tw-scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                        </slot>
                </tbody>
            </table>
        </div>
    </div>
</template>
