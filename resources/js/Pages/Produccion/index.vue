<template>
    <app-layout>
        {{ usuario.Area }}
        @can ('Produccion')
            <div>
                hola
            </div>
        @endcan
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

