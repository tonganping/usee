/**
 * Created by very80 on 2015-08-10.
 */

$(function () {
    // 提交，处理密码，处理验证结果
    $('#btn_login').click(function() {
        var pass = hex_sha1($('#password').val() + '_80_80_');
        $.post('/index.php/Index/login/', {
            'user':$('#username').val(),
            'pass':pass
        }, function(data) {
            if(data.code=='0') {
                location.href='/index.php/User/index';
            } else {
                alert(data.msg);
            }
        });
    });
});

function Poster(act) {
    $('#btn_submit').click(function () {
        var dataString = $('#editForm').formSerialize();

        $.post('/index.php/' + act + '/editSave', dataString, function(d) {
            if(d.code=='0') {
                alert('保存成功');
                Go(act + '/index');
            } else {
                alert(d.msg);
            }
        });
    });
}

function PosterDo(act,todo) {
    $('#btn_submit').click(function () {
        var dataString = $('#editForm').formSerialize();

        $.post('/index.php/' + act + '/'+todo, dataString, function(d) {
            
            if(d.code =='0') {
                alert('保存成功');
                Go(act + '/index');
            } else {
                alert(d.msg);
            }
        });
    });
}


function Deleter(act, id) {
    if(!confirm('删除操作，请确认')) {
        return false;
    }

    var url = '/index.php/' + act + '/del/id/' + id;
    $.get(url, function(d) {console.log(d);
        if(d.code=='0') {
            alert('删除成功');
            Go(act + '/index');
        } else {
            alert(d.msg);
        }
    });
}
