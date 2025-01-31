<template>
    <div class="container file-upload">
        <button type="button" class="btn btn-success submitData" v-on:click="startProcess()">Processar Fila</button>
    </div>
</template>

<script>
    export default {
        props: ['input_name', 'post_url'],

        methods: {
            startProcess() {
                let formData = new FormData();

                axios
                    .post('/queue/process', formData, {})
                    .then(function(data) {
                        console.log(data);
                        console.log('success');
                    })
                    .catch(function() {
                        console.log('error');
                    });
            }
        }
    }
</script>
