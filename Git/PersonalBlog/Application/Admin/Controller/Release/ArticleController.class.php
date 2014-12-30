<?php
namespace Admin\Controller\Release;
use Think\Controller;

class ArticleController extends Controller{
	public function add(){
        if(session('isLogin'))
        {
            $this->display();
        }
		else
        {
            $this->redirect('/Admin/Release/User/login');
        }
	}

    public function delete(){
        if(session('isLogin'))
        {
            $count= D('Article')->count();
            $Page= new \Think\Page($count,9);
            $Page->rollPage=6;// 分页栏每页显示的页数
            $Page->lastSuffix=false;// 最后一页是否显示总页数
            $Page->setConfig('prev','上一页');
            $Page->setConfig('next','下一页');
            $Page->setConfig('first','第一页');
            $Page->setConfig('last','尾页');
            $Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
            $show= $Page->show();
            $list=D('Article')->order('id')->limit($Page->firstRow.','.$Page->listRows)->select();
            $this->page=$show;
            $this->list=$list;//等效于$this->assign('list',$list);
            $this->display();
        }
        else
        {
            $this->redirect('/Admin/Release/User/login');
        }

    }

    public function addPicture(){
        if(session('isLogin'))
        {
            $this->display();
        }
        else
        {
            $this->redirect('/Admin/Release/User/login');
        }
    }

	//添加文章信息
	public function AddPageInfo(){
        $response=array();
        if(!empty($_POST))
        {
            $article=D('Article');
            if($article->create())
            {
                $result=$article->add();
                if($result)//说明插入数据成功
                {
                    //得到该文章的id
                    $article_id=$result;
                    $response['status']=1;
                }
                else
                {
                    $response['status']=0;
                    $response['error']="文章信息插入数据库失败";
                }
            }
            //构造html文件存储路径
            $classification=$_POST['class'];

            //构造对应的分类文件的名称，除了it与software对应不同、read与masterbook对应不同之外，其余的均相同。
            switch($classification)
            {
                case 'it':
                    $true_class='software';
                    break;
                case 'english':
                    $true_class='english';
                    break;
                case 'life':
                    $true_class='life';
                    break;
                case 'masterbook':
                    $true_class='read';
                    break;
                default:
                    $true_class='index';
            }

            //匹配classification对应的中文名称
            switch($classification)
            {
                case 'it':
                    $chinese_classification='软件工程';
                    break;
                case 'english':
                    $chinese_classification='英语学习';
                    break;
                case 'life':
                    $chinese_classification='生活随笔';
                    break;
                case 'masterbook':
                    $chinese_classification='阅读感悟';
                    break;
                default:
                    $chinese_classification='Error';
            }

            //存到Admin模块下的View文件夹里
//            $htmlpath=dirname(dirname(dirname(__FILE__))).'\View\articles\\'.$classification.'\\';

            //存到Home模块下的View文件夹里
            $htmlPath=dirname(dirname(dirname(dirname(__FILE__)))).'\Home\View\\'.$classification.'\\';
            //构造html文件名
            $date=$_POST['date'];
            $date=str_replace("-","",$date);//将日期中的分隔符去掉
            $htmlName=$classification.$date.$article_id.'.html';
            //完整路径名，包括文件名
            $filePath=$htmlPath.$htmlName;
            //生成并打开文件
            $fp=fopen($filePath, "w+");

            if($fp)
            {
                $response['file']=1;//创建文件成功
                $article->htmlname=$htmlName;
                $article->hrefpath=$filePath;
                $article->where('id='.$article_id)->save();

                //接下来就该编辑html文件了
                if (is_writable($filePath) == true)//表示文章允许写入
                {
                    //构造当前文章页面的父页面url
                    $current_parent='../Index/'.$true_class.'.html';
                    $content_data='<include file="Common:header_file" /><title>文章</title><include file="Common:article_header" />'.
                    '<div class="article_content"><div class="path"><span><strong>V</strong>incent博客</span><a href="../Index/index.html">首页</a>>><a href="'.$current_parent.'">'.$chinese_classification.'</a></div>'.
                        '<div class="title"><h1>'.$_POST['title'].'</h1></div><div class="auTI"><span>'.$_POST['author'].'</span><span>'.$_POST['date'].'</span></div>'.
                    '<div class="a_content"><p>'.$_POST['content'].'</p></div><div class="pre_next">'.
                        '</div></div><include file="Common:footer_content" /><include file="Common:footer" />';
                    fwrite($fp,$content_data);
                    fclose($fp);
                }
            }
            else
            {
                $response['file']=0;//创建文件失败
                $article->where('id='.$article_id)->delete();//文件创建失败，则相应的删除数据库里关于该文章的信息
            }
            echo json_encode($response);
        }
	}

    //删除文章信息
    public function DeletePageInfo(){
        if(!empty($_POST)){
            $response=array();
            $article=D('Article');
            /*先删除数据库里的信息，再删除文章*/
            //首先要得到需要删除的文章的地址和文件名，不然把数据库里的信息删除以后就获取不到了
            $back=$article->where('id='.$_POST['id'])->find();
            $file_str=$back['hrefpath'];
            //删除数据库里的信息
            $rst=$article->where('id='.$_POST['id'])->delete();//返回值为false表示SQL出错，为0则表示没有可以删除的数据
            if($rst==false || $rst==0)
            {
                $response['status']=0;
                $response['error']="数据库信息删除出错";
            }
            else
            {
                $response['filepath']=$file_str;
                if(!unlink($file_str))//如果文件删除出错
                {
                    $response['status']=0;
                    $response['error']="文件删除出错";
                }
                else
                {
                    $response['status']=1;
                }
            }

        }
        echo json_encode($response);
    }

    //添加图片
    public function AddPagePicture(){
        $response=array();
        $title=$_POST['ImgTitle'];
        $class=$_POST['ImgClass'];
        $date=$_POST['ImgReleaseDate'];
        $description=$_POST['ImgDescription'];
        $size=$_FILES['photo']['size'];
        $name=$_FILES['photo']['name'];
        $type=$_FILES['photo']['type'];//类型是image/jpeg,image/png之类的

        $MAXSIZE=1000000;
        $photo_path=dirname(dirname(dirname(dirname(dirname(__FILE__))))).'\Public\images\\'.$name;

        if($size>$MAXSIZE)
        {
            $response['status']=0;
            $response['error']='文件过大，请重新选择';
        }
        else
        {
            if($type=='image/jpg' || $type=='image/jpeg' || $type=='image/png' || $type=='image/gif')
            {
                if(move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path))
                {
                    $img=M("Image");
                    $data['img_title']= $title;
                    $data['img_class']=$class;
                    $data['img_date']=$date;
                    $data['img_description']=$description;
                    $data['img_path']=$photo_path;
                    $result=$img->add($data);
                    if($result)
                    {
                        $response['status']=1;
                        $response['data']=$result;
                    }
                }
                else
                {

                    $response['status']=0;
                    $response['error']='文件上传失败';
                }
            }
            else
            {
                $response['status']=0;
                $response['error']='请上传指定格式图片';
            }
        }

        echo json_encode($response);
    }

    //获取同一类型文章的info
    public function GetLinkInfo(){
        if(!empty($_POST))
        {
            $classification=$_POST['current_classification'];
            $response=array();
            $article=D('Article');
            $result=$article->where(array('class'=>$classification))->select();
            $response['all']=$result;
            echo json_encode($response);
        }
    }

    public function test(){
        $response=array();
        $article=D('Article');
        $rst=$article->where('class="life"')->select();
        $response['test']=$rst;
        $response['status']=0;
        echo json_encode($response);
    }

}