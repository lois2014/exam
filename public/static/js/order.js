$(document).ready(function(){
    //下单样式显示
    var hrefSp = window.location.href.split("/");
    if (hrefSp.length > 0) {
        var pathName = window.location.pathname.toString().toLowerCase();
        if (pathName.indexOf('pay') > -1) {
            $(".shopping_nav>li").siblings().removeClass('shopping_nav_on');
            $("#3").addClass('shopping_nav_on');
        } else if (pathName.indexOf('ordertime') > -1) {
            $(".shopping_nav>li").siblings().removeClass('shopping_nav_on');
            $("#2").addClass('shopping_nav_on');
        } else {
            $(".shopping_nav>li").siblings().removeClass('shopping_nav_on');
            $("#1").addClass('shopping_nav_on');
        }
    }
});

function submitOrder()
{

    var user = $.trim($('#personalName').val());
    var mobile = $.trim($('#personalTel').val());
    if(!user || !mobile){
        alert('请填写姓名和手机号码');
        return false;
    }

    if(!mobile.match( /^1[34578]\d{9}$/)){
        alert('请填写正确的手机号码');
        return false;
    }

    var price = $('.realmoney').data('price');
    var num = $('.number').data('num');
    var pack_id = $('#pack').data('package_id');
    $('#num').val(num);
    $('#price').val(price);
    $('#package_id').val(pack_id);
    $('#order_form').submit();
}