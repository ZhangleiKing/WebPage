//初始化发布日期为当前日期,可不知道为何,这个功能不起作用？？？？？？
function initial_time()
{
    var date=new Date();
    var year=date.getFullYear();
    var month=date.getMonth()+1;//getMonth()获得0-11,0代表1月
    var day=date.getDate();
    $("#ReleaseDate").val(year+'/'+month+'/'+day);
    //alert(year+'/'+month+'/'+day);
}

//生成管理系统menu效果
function menu_show()
{
    $(".menu ul li").css({"opacity":"1","padding-left":"0"}).hover(function(){
        $(this).stop(true,false).animate({
            "opacity":"0.5",
            "padding-left":"5%"
        },300);
    },function(){
        $(this).stop(true,false).animate({
            "opacity":"1",
            "padding-left":"0"
        },300);
    });
}

//发布管理页面信息发布的判断
//维护四个值用来判断页面上的信息是否完整填写
var check_title=false;
var check_author=false;
var check_date=false;
var check_content=false;
function tell_info()
{
    $("#Title").blur(function(){
        var title=$("#Title").val();
        if(title=="")
        {
            $("#title_status").html("请输入文章题目");
            check_title=false;
        }
        else
        {
            $("#title_status").html("");
            check_title=true;
        }

    });
    $("#Author").blur(function(){
        var title=$("#Author").val();
        if(title=="")
        {
            $("#author_status").html("请输入作者名称");
            check_author=false;
        }
        else
        {
            $("#author_status").html("");
            check_author=true;
        }

    });
    $("#ReleaseDate").blur(function(){
        var title=$("#ReleaseDate").val();
        if(title=="")
        {
            $("#date_status").html("请选择发布日期");
            check_date=false;
        }
        else
        {
            $("#date_status").html("");
            check_date=true;
        }

    });
    $("#ArticleContent").blur(function(){
        var title=$("#ArticleContent").val();
        if(title=="")
        {
            $("#content_status").html("请输入文章内容");
            check_content=false;
        }
        else
        {
            $("#content_status").html("");
            check_content=true;
        }

    });
}

//点击提交按钮时检查文章发布信息是否填写完整
function before_submit_check_article() {
    if (!check_title) {
        $("#Title").focus();
        return false;
    }
    else if (!check_author) {
        $("#Author").focus();
        return false;
    }
    else if (!check_date) {
        $("#ReleaseDate").focus();
        return false;
    }
    else if (!check_content)
    {
        $("#ArticleContent").focus();
        return false;
    }

    return true;
}

//文章发布提交
function submit()
{
    $("#Firm").click(function(){
        if(before_submit_check_article())
        {
            var article_name=$("#Title").val();
            var author_name=$("#Author").val();
            var classification=$("#Class").val();
            var datetime=$("#ReleaseDate").val();
            var article_content=$("#ArticleContent").val();

            //正则表达式对输入的内容进行处理，将换行符处理成<br>
            var reg=new RegExp("\n","g");
            article_content= article_content.replace(reg,"<br>");

            $.ajax({
                url:AddPageInfoUrl,
                type:'POST',
                dataType:'json',
                data:{
                    title:article_name,
                    class:classification,
                    date:datetime,
                    author:author_name,
                    content:article_content
                },
                success: function(data){
                    if(data.status==1)
                    {
                        if(data.file==1)
                        {
                            alert("文章发布成功");
                            $("#Title").val('');
                            $("#Author").val('');
                            $("#ReleaseDate").val('');
                            $("#ArticleContent").val('');
                        }
                        else
                        {
                            alert("文章创建失败");
                        }
                    }
                    else if(data.status==0)
                    {
                        alert("文章信息插入数据库失败");
                    }
                }
            });
        }
    })
}


//删除文章信息
function DeleteArticle(){
    $(".btn-danger").click(function(){
        var aid=$(this).attr("id");//点击获取当前button的id值
        warn('warn!','确认删除!','f',true,'确认',function(){
            $.ajax({
                url:DeletePageInfoUrl,
                type:'POST',
                dataType:'json',
                data:{
                    id:aid
                },
                success: function(data){
                    if(data.status==0){
                        alert(data.error);
                    }
                    else{
                        //alert("删除成功");
                        window.location.reload();
                    }
                }
            });
        })

    })
}

//登陆管理系统,'/Blog/index.php/Admin/Release/Article/test'
function login(){
    $("#login_btn").click(function(){
        var account=$("#account").val();
        var pwd=$("#password").val();
        $.ajax({
            url:LoginUrl,
            type:'POST',
            dataType:'json',
            data:{
                Account:account,
                PassWord:pwd
            },
            success: function(data){
                if(data.status==0)
                {
                    console.log(data.test.length);
                    $(".back_info").html(data.error);
                    setTimeout('clearInfo()',3000);
                    $("#password").val('');
                }
                else if(data.status==1)
                {
                    $(".back_info").html('');
                    $("#account").val('');
                    $("#password").val('');
                    //alert('登陆成功');
                    window.location.href=AdminIndexUrl;
                }
            },error:function(data){
                console.log(data);
            }
        });
    })
}

//清除报错信息
function clearInfo(){
    $(".back_info").html('');
}


//退出管理系统
function exit(){
    $('#exit').click(function(){
        $.ajax({
            url:exitUrl,
            type:'POST',
            dataType:'json',
            success:function(data){
                if(data.status==1)
                {
                    window.location.reload();
                }
            }
        })
    })
}


//图片页面信息发布的判断
//维护两个值用来判断图片页面上的信息是否完整填写
var check_img_title=false;
var check_img_file=false;
function tell_img_info()
{
    $("#ImgTitle").blur(function(){
        var title=$("#ImgTitle").val();
        if(title=="")
        {
            $("#img_title_status").html("请输入图片标题");
            check_img_title=false;
        }
        else
        {
            $("#img_title_status").html("");
            check_img_title=true;
        }

    });

    $("#ImgInput").blur(function(){
        var i_title=$(this).val();
        if(i_title=="")
        {
            $("#img_input_status").html("请选择文件");
            check_img_file=false;
        }
        else
        {
            $("#img_input_status").html("");
            check_img_file=true;
        }
    })
}

//点击提交按钮时检查图片发布信息是否填写完整
function before_submit_check_img() {
    if (!check_img_title) {
        $("#ImgTitle").focus();
        return false;
    }
    else if (!check_img_file) {
        $("#ImgInput").focus();
        return false;
    }

    return true;
}

//图片提交

function submitImage() {
    $("#ImgFirm").click(function () {
        if (before_submit_check_img()) {
            //var img_name = $("#ImgTitle").val();
            //var img_classification = $("#ImgClass").val();
            //var img_datetime = $("#ImgReleaseDate").val();
            //var description = $("#ImgDescription").val();
            //var img = $(':file').get(0).files[0];

            //var data = new FormData();
            //data.append('img_title',img_name);
            //data.append('img_class',img_classification);
            //data.append('img_date',img_datetime);
            //data.append('img_des',description);
            //data.append('image',img);

            //$("form").submit();
            var data=new FormData($('#ImgForm')[0]);

            $.ajax({
                url: AddPagePictureUrl,
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                dataType:'json',
                cache:false,
                processData:false,
                contentType:false
            }).done(function(rst){
               if(rst['status']==1){
                   alert('图片上传成功');
                   $("#ImgTitle").val('');
                   $("#ImgClass").val('');
                   $("#ImgReleaseDate").val('');
                   $("#ImgDescription").val('');
                   $("#ImgInput").val('');
                   check_img_title=false;
                   check_img_file=false;
               }
                else
               {
                   alert(rst['error']);
               }
            });
        }

    });
}
