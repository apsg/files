<template>
    <div>
        <file-pond
            name="file"
            ref="pond"
            label-idle="Kliknij lub przeciągnij pliku tutaj"
            :server="`/transfers/${transfer.id}/upload`"
            @processfile="refreshFiles"
            :allowMultiple="true"
        ></file-pond>
        <div v-if="files.length > 0">
            <div v-for="file in files" class="mt-3 mb-3 p-3 rounded bg-gray-100 flex justify-between">
                <div>{{ file.name }}</div>
                <button class="bg-red-200 hover:bg-red-400 rounded p-1 px-2" @click="deleteFile(file)">
                    X
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import vueFilePond, {setOptions} from 'vue-filepond';
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';

const FilePond = vueFilePond(FilePondPluginFileValidateType);

export default {
    name: "FileUpload",

    components: {
        'file-pond': FilePond,
    },

    props: {
        transfer: Object,
        token: String,
    },

    data() {
        return {
            files: []
        }
    },

    mounted() {
        setOptions({
            server: {
                process: {
                    url: `/transfers/${this.transfer.id}/upload`,
                    headers: {
                        'X-CSRF-TOKEN': this.token,
                    }
                }
            }
        });
        this.refreshFiles();
    },

    methods: {
        refreshFiles() {
            axios.get(`/transfers/${this.transfer.id}/files`)
                .then(r => {
                    this.files = r.data;
                })
                .catch(err => {
                    console.error(err);
                });
        },

        deleteFile(file) {
            axios.delete(`/files/${file.id}`)
                .then(r => {
                    this.refreshFiles();
                })
                .catch(err => {
                    console.error(err);
                })
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
