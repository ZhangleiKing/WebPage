//点击menu之后设置当前的menu块的状态为active
function active_menu(){
    var which=$(".menu_index div:first-child").attr('id');
    var select_part=which.split('_');
    //$(select_part).addClass('active_menu');
    $("#"+select_part[0]).addClass('menu_active');
}

//功能同上，但是是在文章页面实现
function article_active_menu(){
    var href=$(".path a:last-child").attr('href');
    var select_parts=href.split('/');
    var mean=select_parts[2].split('.');
    var class_name=mean[0];//即为当前该文章的所属分类，分别为software、life、english、read
    $("#"+class_name).addClass('menu_active');
    //现在要将刚才获得的所属分类真正对应其数据库里的分类方法
    //switch(class_name)
    //{
    //    case 'software':
    //}
}