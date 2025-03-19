<?php

return [
        "GET"   => [
            "/"          => "AuthController@getLogin",
            "/login"     => "AuthController@getLogin",
            "/register"  => "AuthController@getRegister"
        ],
        "POST"  => [
            "/"          => "AuthController@postLogin",
            "/login"     => "AuthController@postLogin",
            "/register"  => "AuthController@postRegister"
        ] 
];
