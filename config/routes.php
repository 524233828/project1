<?php

route()->group("/v1",function(){
    route()->get("/welcome","WelcomeController@welcome");
});
