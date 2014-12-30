//从数据库里获取所有相应的文章，添加到页面里去.pid是需要动态修改页面元素的id号，cl是文章分类
function addLink(pid,cl){
    $.ajax({
        url:GetLinkInfoUrl,
        type:'POST',
        dataType:'json',
        data:{
            current_classification:cl
        },
        success:function(data){
            var len=data.all.length;//获取有多少条记录
            var str='';
            var count=0;//计数器，用来判断是否添加空的li
            var re_count=0;
            //alert(data.all[0]['title']);//获取文章题目
            var total=parseInt(len/6)+1+len;
            for(var i=0;i<total;i++)
            {
                if(count%7==0)
                {
                    str+='<li></li>';
                }
                else
                {
                    var ti=data.all[re_count]['title']
                    var htmlName=data.all[re_count]['htmlname'];
                    var href='../'+cl+'/'+htmlName;
                    var tem_str='<li><a href="'+href+'">'+ti+'</a></li>';
                    str+=tem_str;
                    re_count++;
                }
                count++;
            }
            $("#"+pid).html(str);

            //动态修改共有多少记录的显示
            switch(cl){
                case 'it':
                    $('#software_tab').html('分类：软件工程（共'+len+'篇文章）');
                    break;
                case 'english':
                    $('#english_tab').html('分类：英语学习（共'+len+'篇文章）');
                    break;
                case 'masterbook':
                    $('#read_tab').html('分类：阅读感悟（共'+len+'篇文章）');
                    break;
                case 'life':
                    $('#life_tab').html('分类：生活随笔（共'+len+'篇文章）');
                    break;
            }
        }
    });
}
