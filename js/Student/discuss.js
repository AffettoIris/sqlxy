(()=>{
    window.addEventListener('load', ()=>{
        let issue = document.querySelector(".issue");
        let edit = document.querySelector(".edit");
        let editFlag = true; // true时表示issue在影藏，false时表示issue在显现
        let sendDiscuss = document.querySelector('.send-discuss');
        let issueTextarea = document.querySelector('.issue-textarea');
        let welcomeYou = document.querySelector('.welcomeYou');
        let name = welcomeYou.children[0].innerHTML;

        // 让发表评论框显示或隐藏
        addEventListene(edit, 'click', ()=>{
            if (editFlag) {
                issue.style.left = "50%";
                issue.style.transform = "translateX(-50%)"; 
                editFlag = false;
            } else {
                issue.style.left = "0";
                issue.style.transform = "translateX(-100%)"; 
                editFlag = true;
            }
        })

        // 刚加载页面时刷新讨论区
        addEventListene(sendDiscuss, 'click', ()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('POST', "张的后端文件地址?t=" + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('opration=load');
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        console.log(xhr.response); // 在控制台查看张发送的json
                    }
                }
            })
        })

        // 发送评论给后端
        addEventListene(sendDiscuss, 'click', ()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('POST', "张的后端文件地址?t=" + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('name=' + name + '&comment=' + issueTextarea.value);
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        console.log(xhr.response); // 在控制台查看张发送的json
                    }
                }
            })
        })
    });
})();