window.onload = function() {
    // 注册事件
    var reg = document.getElementById('reg');
    reg.onclick = function(e) {
        document.getElementById('regin').style.display = 'block';
        document.getElementById('blackdiv').style.display = 'block';
        e.preventDefault();
    }

    var close = document.getElementById('close');
    close.onclick = function(e) {
        document.getElementById('login').style.display = 'none';
        document.getElementById('regin').style.display = 'none';
        document.getElementById('blackdiv').style.display = 'none';
        e.preventDefault();
    }

    var toReg = document.getElementById('toReg');
    toReg.onclick = function(e) {
        document.getElementById('login').style.display = 'block';
        document.getElementById('regin').style.display = 'none';
        document.getElementById('blackdiv').style.display = 'block';
        e.preventDefault();
    }



var close2 = document.getElementById('close2');
close2.onclick = function(e) {
    document.getElementById('login').style.display = 'none';
    document.getElementById('regin').style.display = 'none';
    document.getElementById('blackdiv').style.display = 'none';
    e.preventDefault();
}
// 登录事件
var log = document.getElementById('log');
log.onclick = function(e) {
    console.log(1);
    document.getElementById('login').style.display = 'block';
    document.getElementById('blackdiv').style.display = 'block';
    e.preventDefault();
}

}

