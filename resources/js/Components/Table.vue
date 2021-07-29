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

                    </slot>
                </tbody>
            </table>
        </div>
    </div>
</template>
