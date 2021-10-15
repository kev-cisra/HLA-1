<template>
    <div class="tw-mx-auto tw-max-w-7xl sm:tw-px-6 lg:tw-px-8">
        <slot :class="[color, style]">
        </slot>
    </div>
</template>

<script>

export default {
        props: {
            color: {
                default: 'tw-bg-gray-600'
            },
            style:{
                default: 'tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl'
            },
        },
        computed: {
        }
    }
</script>
