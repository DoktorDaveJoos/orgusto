<template>
    <div class="flex flex-col px-4 pb-4 pt-4">
        <span class="uppercase font-medium text-xs text-gray-800 leading-tight mb-2">Who are you?</span>
        <div class="flex justify-between">
            <div class="flex space-x-4">
                <div v-if="errors" class="text-red-400 flex items-center leading-tight">
                    <i class="fas fa-times"></i>
                </div>

                <button
                    v-for="_user in maxFiveUsers"
                    :key="_user.id"
                    class="h-10 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                    :class="user && _user.id === user.id  ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
                    @click="handle( {user: _user})">
                    {{ _user.name }}
                </button>

            </div>
            <popper v-if="users.length > 5" trigger="clickToOpen" :options="{placement: 'bottom-start'}">
                <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
                    <div class="flex justify-center mb-1">
                        <span
                            class="text-center text-xs text-gray-500 uppercase font-light leading-tight">Employees</span>
                    </div>
                    <hr/>
                    <div class="flex flex-wrap w-40 text-gray-800 p-1">
                        <span
                            v-for="_user in users.slice(4)"
                            :key="_user.id"
                            @click="handle( {user: _user})"
                            class="flex-1 px-3 py-1 mt-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
                            :class="_user.id === user.id ? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
                        >{{ _user.name }}</span>
                    </div>
                </div>

                <button
                    slot="reference"
                    class="h-10 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                    :class="users.slice(4).find(_user => _user.id === user.id) ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
                >
                    {{ users.slice(4).find(_user => _user.id === user.id) ? user.name : 'Other' }}
                    <i class="fas fa-address-book ml-2"></i>
                </button>
            </popper>
        </div>
    </div>
</template>

<script>
import store from '../../store';
import {mapState} from 'vuex';
import Popper from "vue-popperjs";

export default {
    components: {
        popper: Popper,
    },
    store,
    props: ["user"],
    data() {
        return {}
    },
    methods: {
        handle(value) {
            this.$emit("value:changed", value);
        }
    },
    computed: {
        maxFiveUsers() {
            return this.users.slice(0, 4);
        },
        ...mapState({
            users: state => state.restaurant.users,
            errors: state => state.reservations.errors
        }),
    }
}
</script>

<!--suppress CssUnusedSymbol -->
<style>
.popper .popper__arrow {
    width: 0;
    height: 0;
    border-style: solid;
    position: absolute;
}

.popper[x-placement^="bottom"] {
    margin-top: 10px;
}

.popper[x-placement^="bottom"] .popper__arrow {
    top: 0;
    left: 20px !important;
    margin-top: 0;
    content: "";
    position: absolute;
    display: block;
    width: 12px;
    height: 12px;
    border-top: inherit;
    border-left: inherit;
    background: inherit;
    z-index: -1;
    transform: translateY(-50%) rotate(45deg);
}
</style>
