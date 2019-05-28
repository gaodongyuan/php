<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/27
 * Time: 15:16
 */
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
class TestController extends BaseController
{
   public function test1(){
      $id= Input::get('id',33);
      echo $id;
   }
}