# How to Show Toast Message When Image Uploaded?

Step 1:

Go to the UploadFrom.vue component that we created and make a little changes to minimize code confusion

Lets create a function called read() and put all the codes inside that used to bring the selected image to the img tag

~~~~

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
~~~~

And in the GetImage() function make a little change as follows

~~~~

            GetImage(e) {
                let image = e.target.files[0];
                this.read(image);
            },
~~~~

Step 2: Make sure that the upload button is shown when the new image is selected

For this purpose lets add a new variable called loaded and use v-if statement in the button

~~~~

        data() {
            return {
                avatar: this.user.avatar,
                loaded: false,
            }
        },
~~~~

In the button add this code

~~~~
        <a href="#" v-if="loaded" class="btn btn-success" @click.prevent="upload">Upload</a>
~~~~

Bascially that code means whenver loaded variable becomes true than this element will be shown otherwise it will not be there.

Step 3: To show the success toast message whenever the image is uploaded install the vue-toaster

To install this component lets run the following npm command

~~~~

npm install vue-toasted --save

~~~~

Step 4: Register the vue-toasted component to use it in anywhere in the application

To register(import) this component we have to add it in the app.js to make it globa (to use in anywhere in the app)

For this purpose add those lines

~~~~

import saveImage from "./components/SaveImage";

const app = new Vue({
    el: "#app",
    components: { uploadForm, saveImage }
});

~~~~

Step 5: Everything is alright but how can we use this component?

To use this component we have to add it in the our custom component whatever we want to use it.

We want to show toast message when succesfully we uploaded the image. So the component that we will choose to use it of course UploadForm.vue. Add the following lines to the upload function to make sure that it will be shown

~~~~

            upload() {
                axios.post('/upload', { 'image': this.avatar }).then(() => {
                    this.$toasted.show('Avatar is Uploaded!', {
                        type: 'success',
                    })
                });
            },
~~~~


