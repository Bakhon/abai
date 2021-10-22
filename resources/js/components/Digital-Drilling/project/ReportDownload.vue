<template>
    <div class="report__download">
        <div class="report__download-header">

        </div>
    </div>
</template>

<script>
    export default {
        name: "ReportDownload",
        mounted() {
            document.body.style.overflow = "hidden"
        }
    }
</script>

<style scoped>
.report__download{
    position: fixed;
    left: 64px;
    top: 86px;
    right: 0;
    bottom: 0;
    background-color: #272953;

}
</style>