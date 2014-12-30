<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="/Blog/Public/css/bootstrap.min.css"/>
    <script type="text/javascript" src="/Blog/Public/js/jquery.min.js"></script>

<title>文章删除</title>
<link rel="stylesheet" type="text/css" href="/Blog/Public/css/release_article.css"/>
<link rel="stylesheet" type="text/css" href="/Blog/Public/css/warning.css"/>
<script type="text/javascript" src="/Blog/Public/js/release_article.js"></script>
<script type="text/javascript" src="/Blog/Public/js/warning.js"></script>
<script type="text/javascript">
    var DeletePageInfoUrl='<?php echo U("Admin/Release/Article/DeletePageInfo",'','');?>';
    var exitUrl='<?php echo U("Admin/Release/User/logOff",'','');?>';
</script>
<head>
<body>
    <div class="container">
        <div class="row header">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 log">
                    <span><?php echo (session('name')); ?></span>
                    <span>|</span>
                    <span><a href="../../../Home/Index/index.html" target="_blank">打开博客</a></span>
                    <span>|</span>
                    <button id="exit">注销</button>
                </div>
                <div class="TitleName">
                    <center>
                        <h1>Vincent博客管理系统</h1>
                    </center>
                </div>
            </div>
        </div>

        <div class="row content">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 menu">
                <ul>
                    <li><span class="glyphicon glyphicon-list-alt"></span><a href="http://localhost/Blog/index.php/Admin/Release/Article/add.html">添加文章</a></li>
                    <li><span class="glyphicon glyphicon-trash"></span><a href="http://localhost/Blog/index.php/Admin/Release/Article/delete.html">删除文章</a></li>
                    <li><span class="glyphicon glyphicon-picture"></span><a href="http://localhost/Blog/index.php/Admin/Release/Article/addPicture.html">添加图片</a></li>
                </ul>
            </div>
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 main">
                <div class="DataMain">
                    <table border="0">
                        <thead>
                        <tr>
                            <th>文章编号</th>
                            <th>文章题目</th>
                            <th>文章作者</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                <th><?php echo ($vo["id"]); ?></th>
                                <th><?php echo ($vo["title"]); ?></th>
                                <th><?php echo ($vo["author"]); ?></th>
                                <th>
                                    <button type="button" class="btn btn-danger" id="<?php echo ($vo["id"]); ?>">
                                        删除
                                    </button>
                                </th>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="page">
                    <?php echo ($page); ?>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        menu_show();
        DeleteArticle();
        exit();
    </script>
</body>
</html>