(function () {
    window.addEventListener('load',()=>{
        let teaName = document.querySelector('.teaName');
        let teaPwd = document.querySelector('.teaPwd');
        let numberError = document.querySelector('#numberError');
        let pwdError = document.querySelector('#pwdError');
        addEventListene(teaName, 'change', ()=>{
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'SetJudge.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send("teaName=" + teaName.value + "&option=judgeName");
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        numberError.innerHTML = xhr.response;
                    }
                }
            });
        });

        addEventListene(teaPwd, 'change', ()=>{
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'SetJudge.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send("teaPwd=" + teaPwd.value + "&option=judgePwd");
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        pwdError.innerHTML = xhr.response;
                    }
                }
            });
        });
    });
})();