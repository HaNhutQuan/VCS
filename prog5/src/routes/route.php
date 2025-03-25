<?php

return [
    "GET"   => [
        "/"                         => "AuthController@getLogin",
        "/login"                    => "AuthController@getLogin",
        "/register"                 => "AuthController@getRegister",
        "/logout"                   => "AuthController@getLogout",
        "/404"                      => "AuthController@notFound",

        "/student/home"             => "StudentController@home",

        "/teacher/home"             => "TeacherController@home",
        "/teacher/assignment"       => "TeacherController@getAssignment",
        "/teacher/deleteAssignment" => "TeacherController@deleteAssignment",
        "/teacher/getSubmission"    => "TeacherController@getSubmission",

        "/profile"                  => "UserController@getProfile",
        "/deleteUser"               => "UserController@getDeleteUser",

        "/chat"                     => "ChatController@getMessages"
    ],
    "POST"  => [
        "/login"                    => "AuthController@postLogin",
        "/register"                 => "AuthController@postRegister",

        "/student/submitSubmission" => "StudentController@postSubmission",
        "/student/submitAnswer"     => "StudentController@postAnswer",

        "/profile"                  => "UserController@updateProfile",

        "/teacher/createAssignment" => "TeacherController@createAssignment",
        "/teacher/updateAssignment" => "TeacherController@updateAssignment",
        "/teacher/createChallenge"  => "TeacherController@createChallenge",

        "/chat/send"                => "ChatController@sendMessage"
    ]
];
