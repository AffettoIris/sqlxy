(function () {
  window.addEventListener('load', function () {
    var flag = true;
    var switchBtn = document.querySelector('.switch-btn');
    var agree = document.querySelector('.agree');
    var loginRegisterButton = document.querySelector('.login-register-button');
    var loginAreaSiblingP = document.querySelector('.login_area-sibling-p');
    var loginForm = document.querySelector('.login_form');
    addEventListene(switchBtn, 'click', function () {
      if (flag) {
        flag = false;
        agree.innerHTML = '同意注册';
        loginRegisterButton.innerHTML = '注册';
        switchBtn.innerHTML = '登录';
        loginAreaSiblingP.innerHTML = '已有账号？点击登录~';
        loginForm.action = '../../php/LoginRegister/StuLogRegJudeg.php?choose=register';
      } else {
        flag = true;
        agree.innerHTML = '同意登录';
        loginRegisterButton.innerHTML = '登录';
        switchBtn.innerHTML = '注册';
        loginAreaSiblingP.innerHTML = '如果您没有账号，您现在想要注册一个吗？';
        loginForm.action = '../../php/LoginRegister/StuLogRegJudeg.php?choose=login';
      }
    })
  })
}());

