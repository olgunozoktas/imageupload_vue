<template>
    <!-- <form action="{{route('upload')}}" enctype="multipart/form-data" method="post">
        @csrf -->
    <div>
        <input type="file" name="image" @change="GetImage">
        <img :src="avatar" alt="Image" class="img-fluid">
        <a href="#" v-if="loaded" class="btn btn-success" @click.prevent="upload">Upload</a>
        <a href="#" v-if="loaded" class="btn btn-danger" @click.prevent="cancel">Cancel</a>
    </div>
    <!-- </form> -->
</template>

<script>
    export default {
        props: ['user'], //can accept this variable from the component tags <upload-form :user="{{auth()->user()}}">

        data() {
            return {
                avatar: this.user.avatar,
                loaded: false,
            }
        },

        methods: {

            GetImage(e) {
                let image = e.target.files[0];
                this.read(image);
            },

            upload() {
                axios.post('/upload', { 'image': this.avatar }).then(() => {
                    this.$toasted.show('Avatar is Uploaded!', {
                        type: 'success',
                    })
                });
            },

            read(image) {
                let reader = new FileReader();
                reader.readAsDataURL(image);
                console.log("Reader: " + reader);
                reader.onload = (res) => {
                    console.log("Res: " + res);
                    this.avatar = res.target.result
                }
                this.loaded = true;
            },

            cancel() {
                this.avatar = this.user.avatar;
                this.loaded = false;
            }
        }
    }
</script>