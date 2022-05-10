<template>
    <div class="fixed w-full h-full p-4 flex justify-center font-press-start">
        <div class="p-4 w-2/4 relative container bg-white login opacity-0 transition duration-200 transform -translate-y-12 border border-gray-200 shadow-md">
            <div class="mx-auto text-center font-bold text-lg">Iniciar sesión</div>
            <div class="mt-12 text-center mx-auto space-y-8">
                <div class="space-y-2 text-center">
                    <label for="email">
                        Email
                    </label>
                    <div class="w-full">
                        <input v-model="form.email" id="email" type="email" class="text-center rounded-md shadow-sm border border-gray-100 focus:ring focus:ring-blue-500 transition duration-200 p-2 w-full">
                    </div>
                </div>
                <div class="space-y-2 text-center">
                    <label for="password">
                        Contraseña
                    </label>
                    <div class="w-full">
                        <input v-model="form.password" id="password" type="password" class="text-center rounded-md shadow-sm border border-gray-100 focus:ring focus:ring-blue-500 transition duration-200 p-2 w-full">
                    </div>

                </div>
                <div class="flex mx-auto justify-center">
                    <button @click="login" :disabled="is_processing" :class="is_processing ? 'bg-gray-200 text-white hover:bg-gray-200' : 'bg-blue-500  hover:bg-blue-600'"  class=" mt-12 active:mt-14  relative transition duration-200 px-4 py-2 text-white">
                        <div class="absolute top-0 left-0">
                            <div class="flex">
                                <div class="h-1 w-1 bg-white"></div>
                                <div class="h-1 w-1 bg-white"></div>
                            </div>
                            <div class="h-1 w-1 bg-white"></div>
                        </div>
                        <div class="absolute top-0 right-0">
                            <div class="flex">
                                <div class="h-1 w-1 bg-white"></div>
                                <div class="h-1 w-1 bg-white"></div>
                            </div>
                            <div class="flex justify-end">
                                <div class="h-1 w-1 bg-white"></div>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0">
                            <div class="h-1 w-1 bg-white"></div>
                            <div class="flex">
                                <div class="h-1 w-1 bg-white"></div>
                                <div class="h-1 w-1 bg-white"></div>
                            </div>
                        </div>
                        <div class="absolute bottom-0 right-0">
                            <div class="flex justify-end">
                                <div class="h-1 w-1 bg-white"></div>
                            </div>
                            <div class="flex">
                                <div class="h-1 w-1 bg-white"></div>
                                <div class="h-1 w-1 bg-white"></div>
                            </div>
                        </div>
                        <div>
                            Iniciar sesión
                        </div>
                    </button>
                </div>
            </div>
            <div class="absolute bottom-4 right-4 text-xs text-blue-500 underline">
                <button @click="$emit('register')">¿Aún no tienes una cuenta? Regístrate.</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoginComponent",
    mounted() {
        setTimeout(() => {
            document.querySelector('.login').classList.replace('opacity-0', 'opacity-100')
            document.querySelector('.login').classList.replace('-translate-y-12', 'translate-y-0')
        }, 10)
    },
    beforeUnmount() {
        document.querySelector('.login').classList.replace('opacity-100', 'opacity-0')
        document.querySelector('.login').classList.replace('translate-y-0', '-translate-y-12')
    },
    data(){
        return{
            is_processing: false,
            form: {
                email: '',
                password: ''
            }
        }
    },
    methods: {
        login(){
            this.is_processing = true
            axios.post(this.route('login'), this.form)
                .then(response => {
                    window.location = this.route('participation', response.data.participation)
                })
                .catch((err) => {
                    console.log(err.response.data.error)
                    this.is_processing = false
                })
        }
    }
}
</script>

<style scoped>

</style>
