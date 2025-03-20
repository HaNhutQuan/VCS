<?php

return [
    "GET"   => [
        "/"             => "AuthController@getLogin",
        "/login"        => "AuthController@getLogin",
        "/register"     => "AuthController@getRegister",
        "/logout"       => "AuthController@getLogout",
        "/student/home" => "StudentController@home",
        "/teacher/home" => "TeacherController@home",
        "/404"          => "AuthController@notFound"
    ],
    "POST"  => [
        "/login"        => "AuthController@postLogin",
        "/register"     => "AuthController@postRegister"
    ] 
];
