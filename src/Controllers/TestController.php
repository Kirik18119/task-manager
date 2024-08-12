<?php

namespace App\Controllers;
use App\Models\Task;
use App\Models\User;

class TestController
{
    public function homePage()
    {
        $user = new User;
        $user->first_name = 'Kolya';
        $user->last_name = 'Mataras';
        $user->email = 'kolyaPidor@gmail.com';
        $user->password = 'ya_petuh228';


    }
    public function aboutUs ()
    {
        $user = new User;
        print_r($user->delete(3));
    }

}
