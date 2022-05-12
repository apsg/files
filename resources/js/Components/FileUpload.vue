<template>
    <div>
        <file-pond
            name="file"
            ref="pond"
            label-idle="Kliknij lub przeciągnij pliku tutaj"
            :server="`/transfers/${transfer.id}/upload`"
        ></file-pond>
    </div>
</template>

<script>
import vueFilePond from 'vue-filepond';
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';

const FilePond = vueFilePond(FilePondPluginFileValidateType);

export default {
    name: "FileUpload",

    components: {
        'file-pond': FilePond,
    },

    props: {
        transfer: Object
    }

}
</script>

<style lang="scss" scoped>

</style>
