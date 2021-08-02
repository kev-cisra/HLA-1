<template>
    <div class="tw-relative">
        <div @click="open = ! open">
            <slot name="trigger"></slot>
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="tw-fixed tw-inset-0 tw-z-40" @click="open = false">
        </div>

        <transition
            enter-active-class="tw-transition tw-ease-out tw-duration-200"
            enter-from-class="tw-transform tw-opacity-0 tw-scale-95"
            enter-to-class="tw-transform tw-opacity-100 tw-scale-100"
            leave-active-class="tw-transition tw-ease-in tw-duration-75"
            leave-from-class="tw-transform tw-opacity-100 tw-scale-100"
            leave-to-class="tw-transform tw-opacity-0 tw-scale-95">
            <div v-show="open"
                    class="tw-absolute tw-z-50 tw-mt-2 tw-rounded-md tw-shadow-lg"
                    :class="[widthClass, alignmentClasses]"
                    style="display: none;"
                    @click="open = false">
                <div class="tw-rounded-md tw-ring-1 tw-ring-black tw-ring-opacity-5" :class="contentClasses">
                    <slot name="content"></slot>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import { onMounted, onUnmounted, ref } from "vue";

export default {
    props: {
        align: {
            default: 'tw-left'
        },
        width: {
            default: '48'
        },
        contentClasses: {
            default: () => ['tw-py-1', 'tw-bg-white']
        }
    },

    setup() {
        let open = ref(false)

        const closeOnEscape = (e) => {
            if (open.value && e.keyCode === 27) {
                open.value = false
            }
        }

        onMounted(() => document.addEventListener('keydown', closeOnEscape))
        onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))

        return {
            open,
        }
    },

    computed: {
        widthClass() {
            return {
                '48': 'tw-w-48',
            }[this.width.toString()]
        },

        alignmentClasses() {
            if (this.align === 'tw-right') {
                return 'tw-origin-top-right tw-right-0'
            } else if (this.align === 'tw-right') {
                return 'tw-origin-top-right tw-right-0'
            } else {
                return 'tw-origin-top'
            }
        },
    }
}
</script>
