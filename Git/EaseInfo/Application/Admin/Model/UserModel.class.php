<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model {
    //检测用户号码是否已经注册过了
    public function CheckUser($data){
        $query='phoneNumber="'.$data.'"';
        $result=$this->where($query)->find();
        return $result;//如果查询出错，find方法返回false，如果查询结果为空返回NULL，查询成功则返回一个关联数组.
    }

    public function CheckAccountPwd($account,$pwd){
        $tmp_result=$this->CheckUser($account);
        if($tmp_result==NULL || $tmp_result==false){//未找到该用户或过程出错
            return false;
        }else{
            //提交的用户账号是正确的，需继续验证密码
            if($pwd==$tmp_result['passWord']){//用户数据库里的密码和提交的密码一致，正确
                return $tmp_result;
            }else{
                return false;
            }
        }
    }
}