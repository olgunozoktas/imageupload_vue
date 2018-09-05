# How To Install Requirements

Step 1: 

Install all required npm packages

~~~~

npm install 

~~~~

Step 2:

Run npm watcher to compile sass to javacripts

~~~~

npm run watch

~~~~

Step 3:

Go to the app.blade.php to customize it
I will put the customized file link as below and you can check the differences if you would like to do.
[Link](../resources/views/app.blade.php)

Step 4:

Add the route of the app.blade.php to the web.php

~~~~

Route::get('/', function() {
    return view('app');
})

~~~~