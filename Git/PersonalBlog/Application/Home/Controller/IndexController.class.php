<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }

    public function Article(){
        $this->display();
    }
    //测试发布文章的页面效果
    public function test(){
//        $this->display("Article/it/it201412182");
        $this->display("Article/english/english201412198");
    }
}