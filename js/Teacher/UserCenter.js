(function (){
    window.addEventListener('load', ()=>{
// 输完学号就提示姓名
        let newstuID = document.querySelector('#newstuID');
        let nameHint = document.querySelector('.nameHint');
        addEventListene(newstuID, 'change', ()=>{
            if (newstuID.value === '') {
                nameHint.style.display = 'none';
            } else {
                nameHint.style.display = 'block';
            }
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'UserCenterJudge.php');
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.timeout = 2000;
            xhr.send('number=' + newstuID.value + '&type=search');
            addEventListene(xhr, 'readystatechange', ()=>{
               if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        nameHint.value = xhr.response;
                    }
               }
            });

            addEventListene(xhr, 'timeout', ()=>{
                nameHint.value = '网络异常，请稍后重试！';
            });

            addEventListene(xhr, 'error', ()=>{
                nameHint.value = '您的网络似乎出了一些问题！';
            });
        });

//  输完密码，检测长度
        let changeHisPwd = document.querySelector('#changehispwd');
        let pwdError = document.querySelector('#pwdError');
        addEventListene(changeHisPwd, 'change', ()=>{
            if (changeHisPwd.value.length > 16 || ((changeHisPwd.value.length < 6) && (changeHisPwd.value.length > 0))) {
                pwdError.style.display = 'block';!important
            } else {
                pwdError.style.display = 'none';!important
            }
        });
    })
}());