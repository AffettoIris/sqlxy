(function () {
    window.addEventListener('load', function () {
        let teacherName = document.querySelector('#studentID');
        let tNameError = document.querySelector('.number-error');
        let teacherPwd = document.querySelector('#studentPwd');
        let tPwdError = document.querySelector('#tPwdError');
        addEventListene(teacherName, 'change', ()=>{
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/LoginRegister/ajaxjudge.php');
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('teacherName=' + teacherName.value);
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        tNameError.innerHTML = xhr.response;
                    }
                }
            })
        });

        addEventListene(teacherPwd, 'change', ()=>{
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/LoginRegister/ajaxjudge.php');
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('teacherPwd=' + teacherPwd.value);
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        tPwdError.innerHTML = xhr.response;
                    }
                }
            })
        });
    })
})();