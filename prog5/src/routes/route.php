<?php

return [
        "GET"   => [
            ""          => "AuthController@getLogin",
            "login"     => "AuthController@getLogin",
            "register"  => "AuthContoller@getRegister"
        ],
        "POST"  => [
            ""          => "AuthController@postLogin",
            "login"     => "AuthController@postLogin",
            "register"  => "AuthController@postRegister"
        ] 
];
