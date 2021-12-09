<template>
    <table class='table table-striped tw-text-xxs tw-w-full tw-overflow-hidden tw-uppercase tw-bg-white tw-divide-y tw-divide-gray-300 tw-rounded'>
        <thead :class="[color, font]">
            <tr class="uppercase tw-font-black tw-text-center tw-text-white ">
                <slot name="TableEncabezado">

                </slot>
            </tr>
            <tr class="uppercase tw-font-black tw-text-left tw-text-white ">
                <slot name="TableHeader">

                </slot>
            </tr>
        </thead>
        <tbody class="uppercase tw-divide-y tw-divide-gray-200 tw-text-xxs">
            <slot name="TableFooter">

            </slot>
        </tbody>
        <tfoot >
            <tr class="uppercase tw-divide-y tw-divide-gray-200 tw-text-xxs">
                <slot name="Foother">

                </slot>
            </tr>
        </tfoot>
    </table>
</template>

<script>

export default {
  data: function () {
    return {
      color: 'tw-bg-blue-600',
      font: 'tw-text-xs',
    }
  },
}
</script>
