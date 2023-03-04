(()=>{
    window.addEventListener('load', ()=>{
        let issue = document.querySelector(".issue");
        let edit = document.querySelector(".edit");
        let editFlag = true; // true时表示issue在影藏，false时表示issue在显现
        let sendDiscuss = document.querySelector('.send-discuss');
        let issueTextarea = document.querySelector('.issue-textarea');
        let welcomeYou = document.querySelector('.welcomeYou');
        let name = welcomeYou.children[0].innerHTML;
        let response = null;
        let main = document.querySelector('.main');
        let template = document.querySelector('.template');

        load();

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
        function load() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', "discuss_judge.php?t=" + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('operation=load');
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        response = JSON.parse(xhr.response);
                        if (response.code == '1') {
                            let len = response.length - 2; // 减去code和length
                            for (let i = 0; i < len; i ++) {
                                let copy = template.cloneNode(true);
                                copy.className = "discuss clearfix";
                                copy.style = "";
                                copy.querySelector('.user-name').innerHTML = response[i].name;
                                copy.querySelector('.discuss-date').innerHTML = response[i].create_time;
                                copy.querySelector('.discuss-text').innerHTML = response[i].content;
                                main.appendChild(copy);
                            }
                        } else {
                            alert("刷新失败，请稍后重试！");
                        }
                    }
                }
            })
        }

        // 发送评论给后端
        addEventListene(sendDiscuss, 'click', ()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('POST', "discuss_judge.php?t=" + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('name=' + name + '&comment=' + issueTextarea.value);
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        response = JSON.parse(xhr.response);
                        if (response.code === 1) {
                            alert("评论成功！");
                            location.reload(); // 不要用load()，直接刷新网页即可，因为load()里每次load（）都会main.appendChild(copy);
                            // 会造成同一条评论同时显示两次。
                        } else {
                            alert("评论失败！");
                        }
                    }
                }
            })
        })
    });
})();