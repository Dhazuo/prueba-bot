<template>
    <div class="fixed w-full font-press-start h-full p-4 flex items-center justify-center">
        <div class="w-2/4 h-full relative rounded-md border border-gray-200 shadow-md">
            <div class="w-full h-full">
                <div style="height: 90%" class="bg-orange-50 grid grid-cols-2 p-4 gap-x-12 overflow-y-auto">
                    <div v-html="bot_texts" class="space-y-4">

                    </div>
                    <div v-html="user_texts" class="space-y-4">

                    </div>
                </div>
                <div style="height: 10%" class="w-full bg-gray-200 p-2 flex items-center">
                    <div class="flex space-x-4 w-full items-center">
                        <input @keyup.enter.prevent="sendData" v-model="answer" type="text" class="text-xs w-full rounded-md bg-white border border-gray-400">
                        <div>
                            <button :disabled="is_processing" @click="sendData"
                                    class="rounded-full h-8 w-8 bg-green-600 flex items-center justify-center content-center">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send"
                                         width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="white"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <desc>Download more icon variants from https://tabler-icons.io/i/send</desc>
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                        <path
                                            d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['participation'],
    created() {
        axios.post(this.route('interact'), {
            participation: this.participation
        })
            .then(response => {
                this.initial_response = response.data.response
                this.bot_texts += `
                <div style="word-wrap: break-word" id="bot${this.bot_counter}" class="max-w-full">
                    <div class="bg-gray-50 p-2 text-black text-xs inline-block align-top whitespace-pre-line rounded-md border border-gray-200 max-w-full  shadow-sm">${this.initial_response}</div>
                </div> `

            })
    },
    data() {
        return {
            is_processing: false,
            initial_response: null,
            bot_texts: ``,
            bot_counter: 1,
            user_texts: ``,
            responseA: null,
            user_counter: 0,
            answer: '',
        }
    },
    methods: {
        sendData() {
            this.is_processing = true
            this.user_counter++
            let spacing = this.calculateUser()
            this.user_texts += `
            <div style="margin-top: ${spacing}px; word-wrap: break-word;" id="user${this.user_counter}" class="flex max-w-full  justify-end ">
                    <div class="bg-green-50 p-2 text-black text-xs rounded-md border whitespace-pre-line border-gray-200 shadow-sm max-w-full ">${this.answer}</div>
                </div>
            `
            let ans = this.answer
            this.answer = ''
            axios.post(this.route('conversation'), {
                participation: this.participation,
                answer: ans
            })
                .then(response => {
                    this.bot_counter++
                    this.answer = ''
                    let spacing = this.calculateBot()
                    this.bot_texts += `
                    <div style="margin-top: ${spacing}px; word-wrap: break-word;" id="bot${this.bot_counter}" class="max-w-full flex justify-start">
                        <div class="bg-gray-50 p-2 text-black text-xs rounded-md border whitespace-pre-line border-gray-200 shadow-sm max-w-full ">${response.data.bot_response}</div>
                    </div> `

                })
                .then(() => {
                    this.is_processing = false
                })
        },
        calculateUser() {
            let box = document.getElementById(`bot${this.bot_counter}`).offsetHeight
            let calc = box + 50;
            return calc
        },
        calculateBot() {
            let box = document.getElementById(`user${this.user_counter}`).offsetHeight
            let calc = box + 50;
            return calc
        }
    }
}
</script>

<style scoped>
.word {
    word-wrap: break-word;
}
</style>
