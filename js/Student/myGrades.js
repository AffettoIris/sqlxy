(function (){
    window.addEventListener("load", function () {
//      刚加载出网页，先初始化页面。
        let dPage = 1;
        let firstPage = document.querySelector('#firstPage');
        let prePage = document.querySelector('#prePage');
        let lastPage = document.querySelector('#lastPage');
        let endPage = document.querySelector('#endPage');
        let dPageElement = document.querySelector('#dPage');
        let countPage = document.querySelector('#countPage');
        let countData = document.querySelector('#countData');
        let tbody = document.querySelector('.tbody');
        show(dPage);

//  悬浮面板的元素
        let exerciseId = 0;
        let examMain = document.querySelector('.exam_main');
        let title = document.querySelector('.title');
        let description = document.querySelector('.description');
        let env = document.querySelector('.env');
        let keySon2 = document.querySelector('.key-son2');
        let receiveCode = document.querySelector('.receive_code');
        let zhixingBtn = document.querySelector('.zhixingBtn');
        let submit = document.querySelector('.submit');
        let resultContent = document.querySelector('.result_content');
        let x = document.querySelector('.X');
        let query = document.querySelector('.query');
        let querySubmit = document.querySelector('.query-submit');
        let queryCancel = document.querySelector('.query-cancel');
        let teaAnswer = document.querySelector('.tea-answer');

// 给首页 上一页 下一页 尾页 按钮注入灵魂
        addEventListene(firstPage, 'click', ()=>{
            dPage = 1;
            show(dPage);
        });

        addEventListene(prePage, 'click', ()=>{
            if (dPage > 1) {
                dPage -= 1;
                show(dPage);
            } else {
                dPage = 1;
                show(dPage);
            }
        });

        addEventListene(lastPage, 'click', ()=>{
            let temp = parseInt(countPage.innerHTML);
            if (dPage < temp) {
                dPage += 1;
                show(dPage);
            } else {
                dPage = temp;
            }
        });

        addEventListene(endPage, 'click', ()=>{
            dPage = parseInt(countPage.innerHTML)
            show(dPage);
        });

// 查询题目，显示。show()内部调用了一次divide()
        function show(dPage) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'MyGradeJudge.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            // 分页查询思想
            xhr.send("dPage=" + dPage + "&option=show");
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        let objs = JSON.parse(xhr.response);
                        // console.log(objs.length); // 这个legnth属性是log(objs)时发现objs自带的，咱自定义的变量可没这属性呦
                        tbody.innerHTML = '';
                        for (let i = 0; i < objs.length; i++) {
                            let tr = document.createElement('tr');
                            tr.setAttribute('data-id', objs[i].id); // 把exercise表的id标记在tr上
                            let tds = new Array();
                            for (let j = 0; j < 6; j++) {
                                let td = document.createElement('td');
                                tds.push(td);
                            }
                            tds[0].innerHTML = objs[i].title;
                            tds[1].innerHTML = objs[i].typename;
                            tds[2].innerHTML = objs[i].name;
                            tds[3].innerHTML = objs[i].score;
                            tds[4].innerHTML = objs[i].reg_time;
                            tds[5].innerHTML = objs[i].date;
                            for (let j = 0; j < 6; j++) {
                                tr.append(tds[j]);
                            }
                            // 给tr们添加点击后打开悬浮面板的事件
                            addEventListene(tr, 'click', ()=>{
                                exerciseId = tr.getAttribute('data-id');
                                exhibit(exerciseId);
                            });
                            tbody.append(tr);
                        }
                        divide(dPage);
                    }
                }
            });
            xhrTimeoutError(xhr, 'tbody');
        }

//  查询当前第？页/共？页/共？条数据，显示
        function divide(dPage) {
            const xhr = new XMLHttpRequest();
            xhr.responseType = 'json';
            xhr.open('POST', 'MyGradeJudge.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            // 分页查询思想
            xhr.send("dPage=" + dPage +"&option=divide");
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        dPageElement.innerHTML = dPage;
                        countPage.innerHTML = xhr.response.countPage;
                        countData.innerHTML = xhr.response.countData;
                    }
                }
            });
        }

//  用户点击题目的tr的任意区域，打开面板，请求该题数据
        function exhibit(exerciseId) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'MyGradeJudge.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send("operation=exhibit" + '&exerciseId=' + exerciseId);
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        examMain.style.display = 'block';
                        let obj = JSON.parse(xhr.response);
                        title.innerHTML = obj.title;
                        description.innerHTML = obj.description;
                        env.innerHTML = obj.init;
                        keySon2.innerHTML = obj.keyword;
                        receiveCode.value = obj.solution;
                        teaAnswer.innerHTML = obj['answer'];
                    }
                }
            });
        }

//  用户点击面板上的X就关闭面板
        addEventListene(x, 'click', ()=>{
            examMain.style.display = 'none';
        });

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

// 执行时，向后端传递学生答案，再传个时间戳，用于表取随机名字，php不方便获取毫秒级时间戳
        addEventListene(zhixingBtn, 'click', ()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'MyGradeJudge.php?t=' + new Date().valueOf());
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

//  询问的提交
        addEventListene(submit, 'click', ()=>{
            query.style.display = 'block';
        });

//  模态框的提交提交和取消
        addEventListene(querySubmit, 'click', ()=>{
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'MyGradeJudge.php?t=' + new Date().valueOf());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send("operation=submit&sAnswer=" + receiveCode.value + '&exerciseId=' + exerciseId + '&timestamp=' + new Date().valueOf());
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        let response = JSON.parse(xhr.response);
                        alert(response.msg + response.score);
                        examMain.style.display = 'none';
                        query.style.display = 'none';
                        show(dPage);
                    }
                }
            });
            xhrTimeoutError(xhr, resultContent);
        });
        addEventListene(queryCancel, 'click', ()=>{
            query.style.display = 'none';
        });
    })
})();