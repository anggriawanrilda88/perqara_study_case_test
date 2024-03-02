<p align="center"><a href="https://laravelcom" target="_blank"><img src="https://rawgithubusercontentcom/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-redsvg" width="400"></a></p>

<p align="center">
<a href="https://travis-ciorg/laravel/framework"><img src="https://travis-ciorg/laravel/frameworksvg" alt="Build Status"></a>
<a href="https://packagistorg/packages/laravel/framework"><img src="https://imgshieldsio/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagistorg/packages/laravel/framework"><img src="https://imgshieldsio/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagistorg/packages/laravel/framework"><img src="https://imgshieldsio/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Repo
this is repo for Perqara Company as assessment test

## Feature Implemented
<ol>
    <li>Every incoming and outgoing request must go through payload validation (data type, character length, etc)<br>
        <pre>
            GET             api/posts           postsindex     › Api\PostController@index  
            POST            api/posts           postsstore     › Api\PostController@store  
            GET             api/posts/{post}    postsshow      › Api\PostController@show  
            POST            api/posts/{post}    postsupdate    › Api\PostController@update  
            DELETE          api/posts/{post}    postsdestroy   › Api\PostController@destroy
        </pre>
    </li>
    <li>Create documentation for the API (eg, using Swagger or similar)<br>
        <pre>
            For go to Swagger, access "http://localhost:<your_port>/api/documentation"
        </pre>
    </li>
    <li>Create unit tests for the API<br>
        <pre>
            There is some unit testing created on folder: <br>
            test/Feature/PostsCreateTest.php<br>
            test/Feature/PostsDeleteTest.php<br>
            test/Feature/PostsDetailTest.php<br>
            test/Feature/PostsListTest.php<br>
            test/Feature/PostsUpdateTest.php<br>
            You can run unit test with command: ".\vendor\bin\phpunit"
        </pre>
    </li>
    <li>Use a linter for code conventions and code quality verification<br>
        <pre>
            use this command to run linter: "./vendor/bin/pint"
        </pre>
    </li>
</ol>
