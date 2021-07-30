<template>
    <div class="tw-px-2 tw-py-4 tw-text-xs">
        <div class='tw-w-full tw-overflow-x-auto'>
            <table class='tw-w-full tw-overflow-hidden tw-uppercase tw-bg-white tw-divide-y tw-divide-gray-300 tw-rounded'>
                <thead :class="[color]">
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
