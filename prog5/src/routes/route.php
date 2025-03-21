<?php

return [
    "GET"   => [
        "/"             => "AuthController@getLogin",
        "/login"        => "AuthController@getLogin",
        "/register"     => "AuthController@getRegister",
        "/logout"       => "AuthController@getLogout",
        "/404"          => "AuthController@notFound",

        "/student/home" => "StudentController@home",
        "/teacher/home" => "TeacherController@home",
        

        "/profile"      => "UserController@getProfile"
    ],
    "POST"  => [
        "/login"        => "AuthController@postLogin",
        "/register"     => "AuthController@postRegister",


        "/profile"      => "UserController@updateProfile"
    ] 
];
