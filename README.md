<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
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
            There is some unit testing created on folder: 
                test/Feature/PostsCreateTest.php
                test/Feature/PostsDeleteTest.php
                test/Feature/PostsDetailTest.php
                test/Feature/PostsListTest.php
                test/Feature/PostsUpdateTest.php<br>
            You can run unit test with command: ".\vendor\bin\phpunit"
        </pre>
    </li>
    <li>Use a linter for code conventions and code quality verification<br>
        <pre>
            use this command to run linter: "./vendor/bin/pint"
        </pre>
    </li>
    <li>Migrate table into database with "php artisan migrate"
    </li>
</ol>
