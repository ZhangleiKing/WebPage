var mb=document.getElementsByClassName('MenuBar');
var len=mb.length;//获取侧侧栏小滑块的个数
var s_height=document.body.clientHeight;//网页可见区域高
var s_top=document.documentElement.scrollTop||document.body.scrollTop;//代表滚动条离顶部的高度
var ini_order=s_top/s_height;
var cur_order;//代表现在滑块处于第几个area
//使得所有的边栏menu小滑块的透明度减小
function showMenuOpacity(){
    for(var i=0;i<len;i++)
    {
        mb[i].style.opacity='0.6';
    }
}

//滚动条滚动时改变menubar的状态
function ScrollEvent()
{
    //判断初始页面是在第几个area，这样可以确定应该让第几个menubar的opacity值为1
    var s_top=document.documentElement.scrollTop||document.body.scrollTop;//代表滚动条离顶部的高度
    var order=s_top/s_height;
    var new_order=Math.round(order);
    showMenuOpacity();
    mb[new_order].style.opacity='1';
}
//
//鼠标移动到menubar上时的状态改变
//function HoverEvent()
//{
//    for(var i=1;i<=len;i++)
//    {
//        $('#menu'+i).css("opacity",0.6).hover(function(){
//            $(this).stop(true,false).animate({
//                "opacity":"1"
//            },300);
//        },function(){
//            $(this).stop(true,false).animate({
//                "opacity":"0.6"
//            },300);
//        });
//    }
//}

//使得当前点击的滑块的透明度增加，并且跳到指定area
function skip()
{
    //判断初始页面是在第几个area，这样可以确定应该让第几个menubar的opacity值为1
    cur_order=Math.round(ini_order);
    mb[cur_order].style.opacity='1';

    mb[0].addEventListener('click',function(){
        showMenuOpacity();
        mb[0].style.opacity='1';
        scroller('FirstArea', 650);
    },true);
    mb[1].addEventListener('click',function(){
        showMenuOpacity();
        mb[1].style.opacity='1';
        scroller('SecondArea', 650);

    },true);
    mb[2].addEventListener('click',function(){
        showMenuOpacity();
        mb[2].style.opacity='1';
        scroller('ThirdArea', 650);
    },true);
    mb[3].addEventListener('click',function(){
        showMenuOpacity();
        mb[3].style.opacity='1';
        scroller('ForthArea', 650);
    },true);
    mb[4].addEventListener('click',function(){
        showMenuOpacity();
        mb[4].style.opacity='1';
        scroller('FifthArea', 650);
    },true);

}

/*
*实现锚点跳转的平滑效果------begin--------
**/
// 转换为数字
function intval(v)
{
    v = parseInt(v);
    return isNaN(v) ? 0 : v;
}

// 获取元素信息
function getPos(e)
{
    var l = 0;
    var t  = 0;
    var w = intval(e.style.width);
    var h = intval(e.style.height);
    var wb = e.offsetWidth;
    var hb = e.offsetHeight;
    while (e.offsetParent){
        l += e.offsetLeft + (e.currentStyle?intval(e.currentStyle.borderLeftWidth):0);
        t += e.offsetTop  + (e.currentStyle?intval(e.currentStyle.borderTopWidth):0);
        e = e.offsetParent;
    }
    l += e.offsetLeft + (e.currentStyle?intval(e.currentStyle.borderLeftWidth):0);
    t  += e.offsetTop  + (e.currentStyle?intval(e.currentStyle.borderTopWidth):0);
    return {x:l, y:t, w:w, h:h, wb:wb, hb:hb};
}

// 获取滚动条信息
function getScroll()
{
    var t, l, w, h;

    if (document.documentElement && document.documentElement.scrollTop) {
        t = document.documentElement.scrollTop;
        l = document.documentElement.scrollLeft;
        w = document.documentElement.scrollWidth;
        h = document.documentElement.scrollHeight;
    } else if (document.body) {
        t = document.body.scrollTop;
        l = document.body.scrollLeft;
        w = document.body.scrollWidth;
        h = document.body.scrollHeight;
    }
    return { t: t, l: l, w: w, h: h };
}

// 锚点(Anchor)间平滑跳转
function scroller(el, duration)
{
    if(typeof el != 'object') { el = document.getElementById(el); }

    if(!el) return;

    var z = this;
    z.el = el;
    z.p = getPos(el);
    z.s = getScroll();
    z.clear = function(){window.clearInterval(z.timer);z.timer=null};
    z.t=(new Date).getTime();

    z.step = function(){
        var t = (new Date).getTime();
        var p = (t - z.t) / duration;
        if (t >= duration + z.t) {
            z.clear();
            window.setTimeout(function(){z.scroll(z.p.y, z.p.x)},13);
        } else {
            st = ((-Math.cos(p*Math.PI)/2) + 0.5) * (z.p.y-z.s.t) + z.s.t;
            sl = ((-Math.cos(p*Math.PI)/2) + 0.5) * (z.p.x-z.s.l) + z.s.l;
            z.scroll(st, sl);
        }
    };
    z.scroll = function (t, l){window.scrollTo(l, t)};
    z.timer = window.setInterval(function(){z.step();},13);
}

/*
 *实现锚点跳转的平滑效果------end--------
 **/