/**
 * Created by xielei on 2015/7/30.
 */
function inspect(option){
    $(option).each(function(){
        var txt = $(this).val();
        var reg = /^\s*$/ ;
        $(this).focus(function(){
            if( $(this).val() == txt ){
                $(this).val("");
            }
        }).blur(function(){
            if( reg.test( $(this).val() ) ){
                $(this).val(txt);
            }
        });
    });
}

function Go(u) {
    location.href='/index.php/' + u;
}

$(function(){
    // 登陆页 begin
    function setLandHeight() {
        $(".land_bg").height($(window).height()/2) ;
    }

    setLandHeight() ;
    $(window).resize(function() {
        setLandHeight() ;
    }) ;

    inspect("#username") ;

    if(0) {
        $("#password").focus(function() {
            $(this).hide() ;
            $("#password2").show().focus() ;
        }) ;

        $("#password2").blur(function() {
            if ( $(this).val() === "") {
                $(this).hide() ;
                $("#password").val($("#password2").val()).show() ;
            }
        }) ;
    }

    // 登陆页 end

    function setHeight() {
        $(".admin_left, .admin_left_children, .admin_right").height($(window).height());
    }

    setHeight() ;
    $(window).resize(function() {
        setHeight() ;
    }) ;

    var subcur = $(".submenu .cur").index();
    $(".submenu").hover(function(){
        $(this).find(".cur").removeClass("cur") ;
    },function(){
        $(this).find("li").eq(subcur).addClass("cur") ;
    });

    function checkOldPassword() { // 检查是否输入原密码
        if ( $("#old_password").val() ==="" ) {
            $(".error").eq(0).show();
            return false ;
        } else {
            $(".error").eq(0).hide();
            return true ;
        }
    }

    function checkNewPassword() { // 检查是否输入6-14位的新密码
        var reg = /^.{6,14}$/ ;
        if ( !reg.test($("#new_password").val()) ) {
            $(".error").eq(1).show();
            return false ;
        } else {
            $(".error").eq(1).hide();
            return true ;
        }
    }

    function checkIsSame() { // 检查两次密码是否一致
        if ( $("#new_password").val() !== $("#confirm_password").val() ) {
            $(".error").eq(2).show() ;
            return false ;
        } else {
            $(".error").eq(2).hide() ;
            return true ;
        }
    }

    $("#old_password").blur(function() {
        checkOldPassword() ;
    }) ;

    $("#new_password").focus(function() {
        checkOldPassword() ;
    }).blur(function() {
        checkNewPassword() ;
    }) ;

    $("#confirm_password").focus(function() {
        checkNewPassword() ;
    }).blur(function() {
        checkIsSame() ;
    }) ;

    $("#password_sure").click(function() {
        if ( checkOldPassword() && checkNewPassword() && checkIsSame() ) {
            alert("success") ;
        } else {
            return false ;
        }
    });


    function setTdWidth() {
        $(".issue_td").width( ($(".issue_tab").width() - 335) / 2 ) ;
    }

    setTdWidth() ;
    $(window).resize(function(){
       setTdWidth() ;
    });

    $(".permission > li").click(function(){
        $(this).addClass("selected").siblings().removeClass("selected") ;
    });

    function pages() { //分页
        var len = $(".pages > a").size() ;
        var cur = $(".pages > a.current").index() ;

        if ( cur===1 ) {
            $(".pages .pages_prev").addClass("unclick") ;
        }

        if ( cur === len - 2 ) {
            $(".pages .pages_next").addClass("unclick") ;
        }

        $(".unclick").click(function() {
            return false;
        });
    }

    pages() ;
}) ;

function checkNull(obj,err) { //检查是否为空
    if ( $(obj).val() === '' ) {
        alert(err);
        return false;
    } else {
        return true ;
    }
}
