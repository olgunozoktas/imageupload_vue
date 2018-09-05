<template>
    <!-- <form action="{{route('upload')}}" enctype="multipart/form-data" method="post">
        @csrf -->
    <div>
        <input type="file" name="image">
        <img src="" alt="Image">
        <a href="#" class="btn btn-success" @click.prevent="upload">Upload</a>
    </div>
    <!-- </form> -->
</template>

<script>
    export default {
        methods: {
            upload() {
                axios.post('/upload');
            }
        }
    }
</script>