(function() {
    window.addEventListener('load', function () {
        let title = document.querySelector('.title');
        let description = document.querySelector('.description');
        let keySon2 = document.querySelector('.key-son2');
        let resultContent = document.querySelector('.result_content');
        let query = document.querySelector('.query');
        let querySubmit = document.querySelector('.query-submit');
        let queryCancel = document.querySelector('.query-cancel');
// 当SQL执行框的内容不为空，显示执行按钮，即button的display：block；当失去焦点了，内容为空再隐藏
        let receiveCode = document.querySelector('.receive_code');
        let zhixingBtn = document.querySelector('.zhixingBtn');
        let submit = document.querySelector('.submit');
        let env = document.querySelector('.env');
        let x = document.querySelector('.X');
        // 正则表达式，匹配exerciseId=数字的字符串，由match写入结果数组的第0位，再替换提取出的字符串的‘exerciseId=’为空，剩下就是纯数字的字符串了
        let exerciseId = parseInt(location.search.match(/exerciseId=\d+/)[0].replace(/exerciseId=/, ''))
        // 当SQL执行框的内容不为空，显示执行按钮，即button的display：block；当失去焦点了，内容为空再隐藏
        receiveCode.addEventListener('keyup', function () {
            if (this.value != '') {
                zhixingBtn.style.display = 'block';
                submit.style.display = 'block';
            }
        })
        receiveCode.addEventListener('blur', function () {
            if (this.value == '') {
                zhixingBtn.style.display = 'none';
                submit.style.display = 'none';
            }
        })

// 函数，刚加载页面时调用，可以从数据库查数据，显示到桌面上
        show();
        function show() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/Student/ExamJud.php?t=' + new Date().valueOf());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send("operation=load" + '&exerciseId=' + exerciseId);
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        let obj = JSON.parse('[' + xhr.response + ']')[0];
                        title.innerHTML = obj.title;
                        description.innerHTML = obj.description;
                        env.innerHTML = obj.init;
                        keySon2.innerHTML = obj.keyword;
                    }
                }
            });
        }

// 执行时，向后端传递学生答案，再传个时间戳，用于表取随机名字，php不方便获取毫秒级时间戳
        addEventListene(zhixingBtn, 'click', ()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/Student/ExamJud.php?t=' + new Date().valueOf());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send("operation=answer&sAnswer=" + receiveCode.value + '&exerciseId=' + exerciseId + '&timestamp=' + new Date().valueOf());
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        resultContent.innerHTML = xhr.response;
                    }
                }
            });
            xhrTimeoutError(xhr, resultContent);
        });

//  询问的提交
        addEventListene(submit, 'click', ()=>{
            query.style.display = 'block';
        });

//  模态框的提交提交和取消
        addEventListene(querySubmit, 'click', ()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/Student/ExamJud.php?t=' + new Date().valueOf());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send("operation=submit&sAnswer=" + receiveCode.value + '&exerciseId=' + exerciseId + '&timestamp=' + new Date().valueOf());
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        let response = JSON.parse(xhr.response);
                        alert(response.msg + response.score);
                        window.onbeforeunload = null; // 清除离开网页时的弹窗提示
                        location.href = "../../php/Student/PracticeCenter.php";
                    }
                }
            });
            xhrTimeoutError(xhr, resultContent);
        });
        addEventListene(queryCancel, 'click', ()=>{
            query.style.display = 'none';
        });

//  点X按钮可以关闭题目页，实际上是跳转至练习中心
        addEventListene(x, 'click', ()=>{
           location.href = "../../php/Student/PracticeCenter.php";
        });

//  模态框可以拖动
        query.children[0].addEventListener('mousedown', function(e) {
            let x = e.pageX - query.children[0].offsetLeft;
            let y = e.pageY - query.children[0].offsetTop;
            // (2) 鼠标移动的时候，把鼠标在页面中的坐标，减去 鼠标在盒子内的坐标就是模态框的left和top值
            document.addEventListener('mousemove', move);
            function move(e) {
                query.children[0].style.left = e.pageX - x + 'px';
                query.children[0].style.top = e.pageY - y + 'px';
            }
            // (3) 鼠标弹起，就让鼠标移动事件移除
            document.addEventListener('mouseup', function() {
                document.removeEventListener('mousemove', move);
            })
        })
    })
})();