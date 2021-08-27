require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import 'bootstrap';

const el = document.getElementById('app');



createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: {
            route,
            hasAnyPermission: function (permissions) {
                var allPermissions = this.$page.props.auth.can;
                var hasPermission = false;
                //console.log(allPermissions)
                permissions.forEach(function(item){
                    if(allPermissions[item]) hasPermission = true;
                });
                return hasPermission;
            },
        }
    })
    .use(InertiaPlugin)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
