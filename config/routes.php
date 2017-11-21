<?php

route()->group(['prefix' => '/class', 'middleware' => 'dispatch'],function(){
    route()->get("/list","ClassController@listClass");
    route()->get("/info","ClassController@getClass");
    route()->get("/try","ClassController@getClassTry");
    route()->get("/chapter","ClassController@getClassChapter");
});

route()->group("/banner",function(){
    route()->get("/list","BannerController@listBanner");
});

route()->group("/order",function(){
    route()->post("/buyClass","OrderController@createOrder")->withMiddleware("login");
    route()->get("/notify","OrderController@notifyOrder");
});

route()->group(['prefix' => '/user', 'middleware' => 'dispatch'],function(){
    route()->get("/login","UserController@login");
    route()->get("/class","UserController@listUserClass");
});