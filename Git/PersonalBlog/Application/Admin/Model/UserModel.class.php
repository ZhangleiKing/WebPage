<?php
namespace Admin\Model;
use Think\Model;

class UserModel extends Model{
    protected $tableName = 'manage'; //当表的名字和当前模型类名称不相同的时候需要定义
    //验证账户和密码
    public function CheckAccountPwd($acc,$p){
        $info=$this->getByaccount($acc);
        //$info为null，说明不存在该账户
        //$info=一维数组，说明存在
        if($info!=null)
        {
            if($info['password']==$p)
            {
                return $info;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}