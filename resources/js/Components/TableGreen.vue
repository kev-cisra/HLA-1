<template>
<div class="tw-mx-4 ">
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
</div>
</template>

<script>

export default {
  data: function () {
    return {
      color: 'tw-bg-green-600'
    }
  },
}
</script>
