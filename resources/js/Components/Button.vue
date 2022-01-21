<template>
    <button :type="type" class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-blue-600 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest active:tw-bg-blue-700 focus:tw-outline-none disabled:tw-opacity-25 tw-transition">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    }
</script>
