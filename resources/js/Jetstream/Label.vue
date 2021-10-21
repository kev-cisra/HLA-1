<template>
    <label class="tw-block tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot></slot></span>
    </label>
</template>

<script>
    export default {
        props: ['value']
    }
</script>
