<template>
    <table class='tw-text-xs tw-w-full tw-overflow-hidden tw-uppercase tw-bg-white tw-divide-y tw-divide-gray-300 tw-rounded'>
        <thead :class="[color]">
            <tr class="tw-font-semibold tw-text-left tw-text-white">
                <slot name="TableEncabezado">

                </slot>
            </tr>
            <tr class="tw-font-semibold tw-text-left tw-text-white">
                <slot name="TableHeader">

                </slot>
            </tr>
        </thead>
        <tbody class="tw-divide-y tw-divide-gray-200">
            <slot name="TableFooter">

            </slot>
        </tbody>
    </table>
</template>

<script>

export default {
  data: function () {
    return {
      color: 'tw-bg-sky-600'
    }
  },
}
</script>
