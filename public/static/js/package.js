$(document).ready(function(){


    // $.ajax({
    //     url:"/examination/public/order",
    //     dataType:"json",
    //     type:"POST",
    //     contentType:"application/json",
    //     success:function(result){
    //         result = JSON.parse(result);
    //         if(result.state == 1) {
    //
    //         }
    //     },
    //     error:function(error){
    //     }
    // });

});

function checkBig()
{
    var package_num = $('#quantity').val();
    var package_id = $('#package_id').val();
   if(package_num > 999 || package_num < 1){
       alert('请选择数量大于1或者小于1000');
       return false;
   }
   $('#order_form').submit();
}