<?php

//route()->group("/banner",function(){
//    route()->get("/list","BannerController@listBanner");
//});
//
//route()->group(['prefix' => '/user', 'middleware' => 'dispatch'],function(){
//    route()->get("/login","UserController@login");
//    route()->get("/class","UserController@listUserClass");
//    route()->get("/chapter","UserController@getClassChapter");
//    route()->get("/article","UserController@getArticle");
//});
//
//route()->group(['prefix' => '/admin', 'middleware' => 'dispatch'],function(){
//    route()->post("/login","AdminController@login");
//    route()->post("/class/add","ClassController@addClass");
//    route()->delete("/class/delete","ClassController@deleteClass");
//    route()->put("/class/update","ClassController@updateClass");
//    route()->post("/banner/add","BannerController@addBanner");
//    route()->put("/banner/update","BannerController@updateBanner");
//    route()->delete("/banner/delete","BannerController@deleteBanner");
//});

//route()->group(['prefix' => '/upload', 'middleware' => 'dispatch'],function(){
//    route()->post("/image","CommonController@uploadImage");
//    route()->post("/video","CommonController@uploadVideo");
//});

//首页
route()->group(['prefix' => '/index', 'middleware' => 'dispatch'],function(){
    route()->get("/class","IndexController@listClass");
    route()->get("/banner","IndexController@listBanner");
});

//文章详情页
route()->group(['prefix' => '/article', 'middleware' => 'dispatch'],function(){
    route()->get("/info","ArticleController@getArticle");
});

//课程详情页
route()->group(['prefix' => '/class', 'middleware' => 'dispatch'],function(){
    route()->get("/info","ClassController@getClass");
    route()->get("/try","ClassController@getClassTry");
    route()->get("/chapter","ClassController@getClassChapter");
    route()->post("/buyClass","ClassController@createOrder")->withMiddleware("login");
});

//个人中心首页
route()->group(['prefix' => '/me', 'middleware' => 'dispatch'],function(){
    route()->get("/info","MeController@getUser");
});

//我的课程列表
route()->group(['prefix' => '/my_class_list', 'middleware' => 'dispatch'],function(){
    route()->get("/list","MyClassListController@listUserClass");
});

//我的课程详情
route()->group(['prefix' => '/my_class', 'middleware' => 'dispatch'],function(){
    route()->get("/info","MyClassController@getClassChapter");
});

//公用接口
route()->group(['prefix' => '/common', 'middleware' => 'dispatch'],function(){
    route()->get("/login","CommonController@login");
    route()->post("/order_notify","CommonController@notifyOrder");
});

//后台
route()->group("/admin",function(){

    //公用接口
    route()->group(['prefix' => '/common', 'middleware' => 'dispatch'],function(){
        route()->get("/login","AdminCommonController@login");
        route()->post("/upload_image","CommonController@uploadImage");
        route()->post("/upload_video","CommonController@uploadVideo");
    });

    //用户管理
    route()->group(['prefix' => '/user', 'middleware' => 'dispatch'],function(){
        route()->get("/list","AdminUserController@listUser");
    });

    //课程管理
    route()->group(['prefix' => '/class', 'middleware' => 'dispatch'],function(){
        route()->get("/list","AdminClassController@listClass");
        route()->post("/add","AdminClassController@addClass");
        route()->get("/get","AdminClassController@getClass");
        route()->post("/update","AdminClassController@updateClass");
        route()->post("/delete","AdminClassController@deleteClass");
    });

    //轮播图管理
    route()->group(['prefix' => '/banner', 'middleware' => 'dispatch'],function(){
        route()->get("/list","AdminBannerController@listBanner");
        route()->post("/add","AdminBannerController@addBanner");
//        route()->get("/get","AdminBannerController@getClass");
        route()->post("/update","AdminBannerController@updateBanner");
        route()->post("/delete","AdminBannerController@deleteBanner");
    });
});




