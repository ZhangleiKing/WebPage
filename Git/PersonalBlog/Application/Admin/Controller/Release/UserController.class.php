<?php
namespace Admin\Controller\Release;
use Think\Controller;

class UserController extends Controller{
    public function login(){
        $this->display();
    }

    public function loginSubmit(){
        $response=array();
        if(!empty($_POST))
        {
            $account=$_POST['Account'];
            $pwd=$_POST['PassWord'];

            $user=D('User');
//            $user=new \Admin\Model\Release\UserModel();
            $rst=$user->CheckAccountPwd($account,$pwd);
            if($rst!=false)
            {
                $response['status']=1;
                session('name',$account);
                session('isLogin',true);
//                $url='/Admin/Release/Article/add';
//                $this->redirect($url);
            }
            else
            {
                $response['error']="用户名或密码错误";
                $response['status']=0;
            }
        }
        else
        {
            $response['error']="用户名或密码错误";
            $response['status']=0;
        }

        echo json_encode($response);
    }

    //注销
    public function logOff(){
        unset($_SESSION['isLogin']);
        unset($_SESSION['name']);
        session_destroy();
        $response=array();
        $response['status']=1;
        echo json_encode($response);
        //$this->redirect('Release/User/login');
    }

    public function test()
    {
        $response=array();
        $htmlPath=dirname(dirname(dirname(__FILE__))).'\View\articles\\'.'it'.'\\';
        $response['test']=$htmlPath;
        echo json_encode($response);
    }

}