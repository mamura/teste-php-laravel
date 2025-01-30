<template>
    <div class="container file-upload">
        <div class="large-12 medium-12 small-12 filezone">
            <input type="file" id="files" ref="files" multiple v-on:change="handleFiles()"/>
            <p>
                Arraste seus arquivos aqui<br>ou clique para procurar
            </p>
        </div>

        <div v-for="(file, key) in files" class="file-listing">
            <img class="preview" v-bind:ref="'preview'+parseInt(key)"/>
            {{ file.name }}
            <div class="success-container" v-if="file.id > 0">
                Success
                <input type="hidden" :name="input_name" :value="file.id"/>
            </div>
            <div class="remove-container" v-else>
                <a class="remove" v-on:click="removeFile(key)">Remove</a>
            </div>
        </div>

        <a class="submit-button" v-on:click="submitFiles()" v-show="files.length > 0">Submit</a>
    </div>
</template>

<script>
    export default {
        props: ['input_name', 'post_url'],

        data() {
            return {
                files: []
            }
        },

        methods: {
            handleFiles() {
                let uploadedFiles = this.$refs.files.files;
                
                for (let i = 0; i< uploadedFiles.length; i++) {
                    this.files.push(uploadedFiles[i]);
                }
            },

            removeFile(key) {
                this.files.splice( key, 1 );
                this.getImagePreviews();
            },

            getImagePreviews() {
                for( let i = 0; i < this.files.length; i++ ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.files[i].name ) ) {
                        let reader = new FileReader();
                        reader.addEventListener("load", function(){
                            this.$refs['preview'+parseInt(i)][0].src = reader.result;
                        }.bind(this), false);
                        reader.readAsDataURL( this.files[i] );
                    }else{
                        this.$nextTick(function(){
                            this.$refs['preview'+parseInt(i)][0].src = '/img/generic.png';
                        });
                    }
                }
            },

            submitFiles() {
                console.log(this.post_url);
                for( let i = 0; i < this.files.length; i++ ){
                    if(this.files[i].id) {
                        continue;
                    }
                    let formData = new FormData();
                    formData.append('file', this.files[i]);

                    axios.post('/' + this.post_url,
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function(data) {
                        this.files[i].id = data['data']['id'];
                        this.files.splice(i, 1, this.files[i]);
                        console.log('success');
                    }.bind(this)).catch(function(data) {
                        console.log('error');
                    });
                }
            }
        }
    }
</script>