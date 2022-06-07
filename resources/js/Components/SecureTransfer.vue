<template>
    <div class="bg-white p-5 w-full shadow">
        <div v-if="isAuthorized">
            <h1 class="font-bold text-lg shadow">Transfer plików</h1>
            <div>
                <div v-for="file in transfer.files" class="p-3">
                    <a :href="file.url +'?code='+this.code " class="hover:text-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ file.name }}
                    </a>
                </div>
            </div>
        </div>
        <div v-if="!isAuthorized">
            <div class="flex items-center border-b border-teal-500 py-2">
                <input
                    class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text"
                    placeholder="Kod dostępu"
                    aria-label="Kod dostępu"
                    v-model="code"
                    v-on:keyup.enter="checkCode"
                >
                <button
                    class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
                    type="button"
                    @click="checkCode"
                >
                    Dalej
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SecureTransfer",

    props: {
        transfer: Object
    },

    data() {
        return {
            code: null,
            isAuthorized: false
        }
    },

    methods: {
        checkCode() {
            axios.post(window.location.href + '/verify', {
                code: this.code
            }).then(r => {
                this.isAuthorized = r.data.is_authorized;
            });
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
