<template>
    <teleport to="body">
        <transition leave-active-class="tw-duration-200">
            <div v-show="show" class="tw-fixed tw-inset-0 tw-overflow-y-auto tw-px-4 tw-py-6 tw-sm:px-0 tw-z-50" scroll-region>
                <transition enter-active-class="tw-ease-out tw-duration-300"
                        enter-from-class="tw-opacity-0"
                        enter-to-class="tw-opacity-100"
                        leave-active-class="tw-ease-in tw-duration-200"
                        leave-from-class="tw-opacity-100"
                        leave-to-class="tw-opacity-0">
                    <div v-show="show" class="tw-fixed tw-inset-0 tw-transform tw-transition-all" @click="close">
                        <div class="tw-absolute tw-inset-0 tw-bg-gray-500 tw-opacity-75"></div>
                    </div>
                </transition>

                <transition enter-active-class="tw-ease-out tw-duration-300"
                        enter-from-class="tw-opacity-0 tw-translate-y-4 sm:tw-translate-y-0 sm:tw-scale-95"
                        enter-to-class="tw-opacity-100 tw-translate-y-0 sm:tw-scale-100"
                        leave-active-class="tw-ease-in tw-duration-200"
                        leave-from-class="tw-opacity-100 tw-translate-y-0 sm:tw-scale-100"
                        leave-to-class="tw-opacity-0 tw-translate-y-4 sm:tw-translate-y-0 sm:tw-scale-95">
                    <div v-show="show" class="tw-mb-6 tw-bg-white tw-rounded-lg tw-overflow-hidden tw-shadow-xl tw-transform tw-transition-all sm:tw-w-full sm:tw-mx-auto" :class="maxWidthClass">
                        <slot v-if="show"></slot>
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>

<script>
import { onMounted, onUnmounted } from "vue";

export default {
        emits: ['close'],

        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: '3xl'
            },
            closeable: {
                default: true
            },
        },

        watch: {
            show: {
                immediate: true,
                handler: (show) => {
                    if (show) {
                        document.body.style.overflow = 'hidden'
                    } else {
                        document.body.style.overflow = null
                    }
                }
            }
        },

        setup(props, {emit}) {
            const close = () => {
                if (props.closeable) {
                    emit('close')
                }
            }

            const closeOnEscape = (e) => {
                if (e.key === 'Escape' && props.show) {
                    close()
                }
            }

            onMounted(() => document.addEventListener('keydown', closeOnEscape))
            onUnmounted(() => {
                document.removeEventListener('keydown', closeOnEscape)
                document.body.style.overflow = null
            })

            return {
                close,
            }
        },

        computed: {
            maxWidthClass() {
                return {
                    'sm': 'sm:tw-max-w-sm',
                    'md': 'sm:tw-max-w-md',
                    'lg': 'sm:tw-max-w-lg',
                    'xl': 'sm:tw-max-w-xl',
                    '2xl': 'sm:tw-max-w-2xl',
                    '3xl': 'sm:tw-max-w-3xl',
                    '4xl': 'sm:tw-max-w-4xl',
                    '5xl': 'sm:tw-max-w-5xl',
                    '7xl': 'sm:tw-max-w-7xl',
                }[this.maxWidth]
            }
        }
    }
</script>
