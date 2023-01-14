window.addEventListener('load', function() {
    // 在个人信息面板和安全面板切换
    var personalInfo_nav = document.querySelector('#personalInfo_nav');
    var safety_nav = document.querySelector('#safety_nav');
    var personalInfo = document.querySelector('.personalInfo');
    var safety = document.querySelector('.safety');
    personalInfo_nav.addEventListener('click', function() {
        safety.style.display = 'none';
        personalInfo.style.display = 'block';
    })
    safety_nav.addEventListener('click', function() {
        personalInfo.style.display = 'none';
        safety.style.display = 'block';
    })
    //  暂没想好怎么在原密码不正确时候提示密码不对，先不管
    // 新密码keyup时，判断6~16位，确认密码时判断与新密码一致吗
    // 当新密码和确认密码不合规时，保存按钮disable=true并弹窗提示检查一遍
    var newpwd = document.querySelector('#newpwd');
    var newpwd_check = document.querySelector('#newpwd_check');
    var surepwd = document.querySelector('#surepwd');
    var surepwd_check = document.querySelector('#surepwd_check');
    var submit_safety = document.querySelector('#submit_safety');
    // 定义一个flag，当flag==0,不能保存，提示检查一遍
    // submit_safety.disabled = true;
    newpwd.addEventListener('keyup', function() {
        if (newpwd.value.length < 6 || newpwd.value.length > 16) {
            newpwd_check.style.display = 'block';
        } else {
            newpwd_check.style.display = 'none';
        }
        if (newpwd.value != surepwd.value) {
            surepwd_check.style.display = 'block';
        } else {
            surepwd_check.style.display = 'none';
        }
    })
    surepwd.addEventListener('keyup', function() {
        if (newpwd.value != surepwd.value) {
            surepwd_check.style.display = 'block';
        } else {
            surepwd_check.style.display = 'none';
        }
    })
    submit_safety.addEventListener('click', function(e) {
        if (newpwd.value.length >= 6 && newpwd.value.length <= 16 && newpwd.value == surepwd.value) {
            // 什么都不做
        } else {
            e.preventDefault();
            // submit_safety.disabled = true;
            alert('请检查密码是否合规');
        }
    })
})