<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index(){
//        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Admin模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    //用户注册账户
    public function account(){
        $response=array();
        if(!empty($_POST)){
            $user=D("User");//实例化User对象
            //type=0,检测该号码是否已经注册过
            if($_POST['type']==0){
                $back=$user->checkUser($_POST['phoneNumber']);
                if($back==NULL){
                    $response['status']=0;
                    $response['error']="该号码已经注册";
                }else{
                    $response['status']=1;
                }
            }else if($_POST['type']==1){//type=1,提交数据
                if($user->create()){
                    $result=$user->add();//写入数据到数据库
                    if($result){
                        $response['status']=1;
                    }else{
                        $response['status']=0;
                        $response['error']="注册失败，请重新尝试";
                    }
                }
            }

            echo json_encode($response);
        }
    }

    //用户登录
    public function login(){
        if(!empty($_POST)){
            $response=array();

            $phoneNumber=$_POST['phoneNumber'];
            $pwd=$_POST['passWord'];
            $captcha=$_POST['captcha'];

            $user=D("User");//实例化User对象
//            $back=$user->checkUser($_POST['phoneNumber']);//由于检测用户名时，若用户名存在，则会返回用户的其他相关信息
            //验证码校验
            $verify=new \Think\Verify();
            if(!$this->check_verify($captcha)){//表示验证码正确
                $response['status']=0;
                $response['error']="验证码输入错误";
            }else{
                //验证用户登录账号和密码
                $result=$user->CheckAccountPwd($phoneNumber,$pwd);
                if($result==false){
                    $response['status']=0;
                    $response['error']="用户名或密码错误";
                }else{
                    session('UserName',$result['userName']);
                    session('UserId',$result['id']);
                }
            }
        }
    }
}