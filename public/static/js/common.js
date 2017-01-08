
$(document).ready(function() {

//        三角样式
    var hrefSp = window.location.href.split("/");
    if (hrefSp.length > 0) {
        var pathName = window.location.pathname.toString().toLowerCase();
        if (pathName.indexOf('package_list') > -1) {
            $(".nav_tc").siblings().removeClass('nav-on');
            $(".nav_tc").addClass('nav_tc nav-on');
        } else if (pathName.indexOf('hospital_list') > -1) {
            $(".nav_jg").siblings().removeClass('nav-on');
            $(".nav_jg").addClass('nav_jg nav-on');
        }else if (pathName.indexOf('hospital_detail') > -1) {
            $(".nav_jg").siblings().removeClass('nav-on');
            $(".nav_jg").addClass('nav_jg nav-on');
        } else if (pathName.indexOf('package_detail') > -1) {
            $(".nav_tc").siblings().removeClass('nav-on');
            $(".nav_tc").addClass('nav_jg nav-on');
        } else {
            $(".nav_index").siblings().removeClass('nav-on');
            $(".nav_index").addClass('nav_index nav-on');
        }

    }

    //判断登录
    $.ajax({
        url:"/examination/public/getUser",
        dataType:"json",
        type:"GET",
        contentType:"application/json",
        success:function(result){
            result = JSON.parse(result);
            if(result.state == 1) {
                $("#login").hide();
                $("#register").hide();
                var doc = document.getElementById('userInfo');
                doc.innerHTML="&nbsp;<a>欢迎！" + result.data.userName + "</a>";

            }
        },
        error:function(error){
        }
    });

});