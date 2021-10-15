<template>

    <table class='table'>
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
        <tbody class="uppercase tw-divide-y tw-divide-gray-200 tw-text-xs">
            <slot name="TableFooter">

            </slot>
        </tbody>
    </table>
</template>

<script>

export default {
  data: function () {
    return {
      color: 'tw-bg-green-600',
      font: 'tw-text-xs',
    }
  },
}
</script>
