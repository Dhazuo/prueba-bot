<template>
    <div v-if="answer === null" class="fixed w-full h-full flex justify-center top-20  font-press-start">
        <div  class="text-center space-y-4">
            <div class="welcome transition duration-200 opacity-0 text-xl">
                Bienvenido al Bot Botsin
            </div>
            <div class="question transition duration-200 opacity-0 space-y-4">
                <div class="grid grid-cols-1 gap-y-12">
                    <div class="text-xl mt-12">
                        Para continuar al bot, necesitas una cuenta
                    </div>
                    <div class="text-xl">
                        ¿Ya tienes una?
                    </div>
                    <div class="flex space-x-4 items-center justify-center">
                        <button @click="response('yes')"
                                class="bg-blue-500 hover:bg-blue-400 focus:bg-blue-600 transition duration-200 shadow-md text-white rounded-md relative active:top-2 px-4 py-2">
                            Sí
                        </button>
                        <button @click="response('no')"
                                class="bg-red-500 hover:bg-red-400 focus:bg-red-600 transition duration-200 shadow-md text-white rounded-md relative active:top-2 px-4 py-2">
                            No
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <login-component v-on:register="response('no')" v-if="answer == 'yes'"></login-component>
    <register-component v-on:login="response('yes')" v-if="answer == 'no'"></register-component>
</template>

<script>
import LoginComponent from "../Components/LoginComponent";
import RegisterComponent from "../Components/RegisterComponent";
export default {
    name: "Index",
    components: {RegisterComponent, LoginComponent},
    data() {
        return {
            answer: null,
        }
    },
    mounted() {
        setTimeout(() => {
            document.querySelector('.welcome').classList.replace('opacity-0', 'opacity-100')
        }, 2000)
        setTimeout(() => {
            document.querySelector('.question').classList.replace('opacity-0', 'opacity-100')
        }, 4000)
    },
    methods: {
        response(res){
            if (res == 'yes') {
                this.answer = 'yes'
            } else {
                this.answer = 'no'
            }
        }
    }
}
</script>

<style scoped>

</style>
