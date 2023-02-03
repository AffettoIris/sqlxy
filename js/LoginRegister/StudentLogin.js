(function () {
  window.addEventListener('load', function () {
    // 切换注册和登录界面
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
    });

    // 在输入时就检查输入是否合规，ajax异步
    let studentID = document.querySelector('#studentID');
    let studentPwd = document.querySelector('#studentPwd');
    let numberError = document.querySelector('#numberError');
    let pwdError = document.querySelector('#pwdError');
    addEventListene(studentID, 'change', ()=>{
      const xhr = new XMLHttpRequest();
      xhr.open('POST', '../../php/LoginRegister/ajaxjudge.php');
      xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xhr.send('studentNumber=' + studentID.value);
      addEventListene(xhr, 'readystatechange', ()=>{
        if (xhr.readyState === 4) {
          if (xhr.status >= 200 && xhr.status < 300) {
            numberError.innerHTML = xhr.response;
          }
        }
      })
    });

    addEventListene(studentPwd, 'change', ()=>{
      const xhr = new XMLHttpRequest();
      xhr.open('POST', '../../php/LoginRegister/ajaxjudge.php');
      xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xhr.send('studentPwd=' + studentPwd.value);
      addEventListene(xhr, 'readystatechange', ()=>{
        if (xhr.readyState === 4) {
          if (xhr.status >= 200 && xhr.status < 300) {
            pwdError.innerHTML = xhr.response;
          }
        }
      })
    });
  })
}());