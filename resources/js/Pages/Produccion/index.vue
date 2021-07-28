<template>
    <app-layout>
        {{ usuario.Area }}
    </app-layout>

</template>

<script>

    import AppLayout from '../../Layouts/AppLayout.vue'

    export default {
        props: [
            'usuario',
        ],
        components: {
            AppLayout,
        },
    }
</script>

