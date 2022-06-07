<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import SecureTransfer from "@/Components/SecureTransfer";

defineProps({
    transfer: Object,
});
</script>

<template>
    <Head title="Bezpieczny transfer plików"/>

    <div class="flex w-full h-full bg-mountain justify-center">
        <div class="lg:w-1/2 w-full flex flex-row items-center min-h-1/2">
            <SecureTransfer :transfer="transfer"/>
        </div>
    </div>
</template>

<style scoped lang="scss">
.bg-mountain {
    background-image: url("https://wzmocnienie.pl/images/bg.webp");
    background-position: center center;
    background-size: cover;
}
</style>
