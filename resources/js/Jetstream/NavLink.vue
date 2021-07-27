<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<script>
    export default {
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                            ? 'tw-bg-gray-50 tw-text-blue-500 tw-inline-block tw-border-l tw-border-t tw-border-r tw-rounded-t tw-px-4 tw-py-2 tw-mt-4 tw-font-semibold'
                            : 'tw-inline-flex tw-items-center tw-px-1 tw-pt-4 tw-border-b-2 tw-border-transparent tw-text-sm tw-font-medium tw-leading-5 tw-text-gray-500 hover:tw-text-gray-700 hover:tw-border-gray-400 focus:tw-outline-none focus:tw-text-gray-700 focus:tw-border-gray-300 tw-transition'
            }
        }
    }
</script>
