<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trasfer: {{ transfer.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="bg-white rounded shadow-xl">
                    <div class="mb-4">
                        <a class="p-3 rounded m-3 bg-blue-300 border border-blue-700"
                           :href="transfer.url" target="_blank">{{ transfer.url }}</a>
                    </div>
                    <div class="mb-4 p-3">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="code">
                            Kod
                        </label>
                        <div class="flex">
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="code"
                                type="text"
                                placeholder="Wpisz nowy kod, jeśli chcesz go zmienić"
                                v-model="code"
                            >
                            <button class="rounded mx-3 p-3 bg-purple-200 hover:bg-purple-400" @click="randomize">
                                losowy
                            </button>
                            <button class="rounded mx-3 p-3 bg-green-200 hover:bg-green-400" @click="saveCode">Zapisz&nbsp;kod</button>
                        </div>
                        <div class="mt-3" v-if="isCodeSaved">
                            <p class="bg-blue-100 p-3">
                                Kod został ustawiony. Zapisz sobie powyższy kod, ponieważ nigdzie nie zostanie on
                                zapisany i nie będzie możliwości jego odzyskania.
                            </p>
                        </div>
                    </div>

                    <div class="mb-4 p-3">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="time">
                            Dostęp do plików w godzinach (zostaw puste jeśli bez limitu)
                        </label>
                        <div class="flex">
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                :class="isTimeSaved? 'border-green-300' : ''"
                                id="time"
                                type="number"
                                min="0"
                                placeholder=""
                                v-model="hours"
                                @change="saveTime"
                            >
                        </div>
                        <div class="mt-3" v-if="expiresAt">
                            <p class="bg-blue-100 p-3">
                                Dostęp wygasa: {{ expirationFormatted }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <FileUpload :transfer="transfer" :token="token"></FileUpload>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import FileUpload from "@/Components/FileUpload";
import moment from 'moment';

export default {
    props: {
        transfer: Object,
        token: String,
    },

    components: {
        AppLayout,
        FileUpload
    },

    data() {
        return {
            code: null,
            isCodeSaved: false,
            hours: null,
            isTimeSaved: false,
            expiresAt: null,
        }
    },

    mounted() {
        this.expiresAt = this.transfer.expires_at;
        this.hours = this.transfer.hours;
        console.log(this.token);
    },

    methods: {
        randomize() {
            this.code = (Math.random() + 1).toString(36).substring(7);
        },

        saveCode() {
            if (!this.code)
                return;

            this.isCodeSaved = false;
            axios.patch('/transfers/' + this.transfer.id, {
                code: this.code
            }).then((r) => {
                this.isCodeSaved = true;
            });
        },

        saveTime() {
            this.isTimeSaved = false;
            axios.patch('/transfers/' + this.transfer.id, {
                hours: this.hours
            }).then((r) => {
                this.isTimeSaved = true;
                this.expiresAt = r.data.expires_at;
            });
        }
    },

    computed: {
        expirationFormatted() {
            return moment(this.expiresAt).format('YYYY-MM-DD HH:mm');
        }
    }
}

</script>
