<template>
    <div @keydown.esc="handleClose">
        <div
            v-show="isOpen"
            class="z-40 fixed bottom-0 inset-x-0 px-4 pb-4 lg:inset-0 lg:flex lg:items-center lg:justify-center"
        >
            <!-- Gray background -->
            <transition name="fade">
                <div v-show="isOpen" @click="handleClose" class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
            </transition>

            <!-- Modal -->
            <transition name="scale">
                <div v-show="isOpen" class="z-50 w-full lg:w-2/3 xl:1/3 max-w-5xl">
                    <slot></slot>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>

import store from '../../store';
import {mapState} from 'vuex';

export default {
    name: "orgusto-modal-wrapper",
    store,
    methods: {
        handleClose() {
            this.$store.commit('closeModal');
        }
    },
    computed: mapState({
        isOpen: state => state.modal.isOpen
    })
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.scale-enter-active,
.scale-leave-active {
    transition: all 0.3s ease-out;
}

.scale-enter,
.scale-leave-to {
    opacity: 0;
    transform: translate(0, 20px);
}
</style>
