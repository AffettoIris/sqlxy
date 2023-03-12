(function () {
    window.addEventListener("load", function () {
        let deleteMsg = document.querySelector('.deleteMsg');
        //      刚加载出网页，先初始化页面。
        let dPage = 1;
        let firstPage = document.querySelector('#firstPage');
        let prePage = document.querySelector('#prePage');
        let lastPage = document.querySelector('#lastPage');
        let endPage = document.querySelector('#endPage');
        let dPageElement = document.querySelector('#dPage');
        let countPage = document.querySelector('#countPage');
        let countData = document.querySelector('#countData');
        show(dPage);

        // 悬浮面板
        let question_info_left_ul = document.querySelector('.question_info_left_ul');
        let q_form = document.querySelector('#q_form');
        let inps = q_form.querySelectorAll("input");
        let teatareas = q_form.querySelectorAll("textarea")
        let q_field__native = document.querySelector(".q_field__native");
        let mask = document.querySelector(".mask");
        let tail_cancel = document.querySelector("#tail_cancel");
        let q_table = document.querySelector(".q_table");
        let q_table_btns = q_table.querySelectorAll("button");
        let q_table_trs = q_table.querySelectorAll("tr");
        let tbody = q_table.querySelector("tbody");
        let qDetail = document.querySelector('#q_detail');
        let qKeys = document.querySelector('.q-keys');
        let qSort = document.querySelector('.qSort');
        let score = document.querySelector('.score');
        let qAnswer = document.querySelector('#q_answer');
        let hiddenId = document.querySelector('#hiddenId');
        let init = document.querySelector('.q_init');
        let submit = document.querySelector('.submit');
        let x = this.document.querySelector('.x');
        // 当点击左边第N个li时，显示右白边框
        for (let i = 0; i < question_info_left_ul.children.length; i++) {
            question_info_left_ul.children[i].addEventListener('click', function () {
                for (i = 0; i < question_info_left_ul.children.length; i++) {
                    question_info_left_ul.children[i].className = '';
                }
                this.className = 'question_info_current';
            })
        }
        // 首先右边都是display: none;当页面刚加载的时候，第一个框block，
        // 然后每点击左侧第几个li就block右边第几个框，其他框none
        q_form.children[0].style.display = 'block';
        inps[0].style.borderColor = "#1976D2"
        for (let i = 0; i < question_info_left_ul.children.length; i++) {
            question_info_left_ul.children[i].setAttribute('data-index', i);
            question_info_left_ul.children[i].addEventListener('click', function () {
                for (let i = 0; i < question_info_left_ul.children.length; i++) {
                    q_form.children[i].style.display = 'none';
                }
                q_form.children[this.getAttribute('data-index')].style.display = 'block';
            })
        }
        // 让第一个input加载进来就选中
        q_field__native.focus();
        // 选中所有的input和textarea，focus时变蓝色
        for (let i = 0; i < inps.length; i++) {
            inps[i].addEventListener("focus", function () {
                this.style.borderBottomColor = "#1976D2"
            })
        }
        for (let i = 0; i < teatareas.length; i++) {
            teatareas[i].addEventListener("focus", function () {
                this.style.borderColor = "#1976D2"
            })
        }
        for (let i = 0; i < inps.length; i++) {
            inps[i].addEventListener("blur", function () {
                this.style.borderBottomColor = "#fff"
            })
        }
        for (let i = 0; i < teatareas.length; i++) {
            teatareas[i].addEventListener("blur", function () {
                this.style.borderColor = "#fff"
            })
        }
        // 尾巴，点取消就不显示遮罩
        tail_cancel.addEventListener("click", function () {
            mask.style.display = "none";
        })

        // 点击题目非按钮的任意位置即可开启圆饼图
        function statistics(id) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'ExerciseJudge.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("operation=statistics&id=" + id);
            addEventListene(xhr, 'readystatechange', () => {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        temp = JSON.parse(xhr.response);
                        let full = temp.full;
                        let zero = temp.zero;
                        let myChart = echarts.init(document.querySelector('.statistics'));
                        let option = {
                            title: {
                                text: '本题的答题情况'
                              },
                            xAxis: {
                                type: 'category',
                                data: ['0分人数', '满分人数', '已答题总人数']
                            },
                            yAxis: {
                                type: 'value'
                            },
                            series: [
                                {
                                    data: [zero, full, full + zero],
                                    type: 'bar',
                                    showBackground: true,
                                    backgroundStyle: {
                                        color: 'rgba(180, 180, 180, 0.2)'
                                    }
                                }
                            ]
                        };
                        myChart.setOption(option);
                        document.querySelector('.statistics').style.display = 'block';
                        let xCopy  = x.cloneNode(true);
                        xCopy.style.display = 'block';
                        addEventListene(xCopy, 'click', ()=>{
                            document.querySelector('.statistics').style.display = 'none';
                            xCopy.style.display = 'none';
                        })
                        document.querySelector('.statistics').append(xCopy);
                    }
                }
            })
        }

        // 查询题目，显示。show()内部调用了一次divide()
        function show(dPage) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'ExerciseJudge.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // 分页查询思想
            xhr.send("dPage=" + dPage + "&option=show");
            addEventListene(xhr, 'readystatechange', () => {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        tbody.innerHTML = xhr.response;
                        // 调用显示圆饼图方法statistics(id)
                        let tbody_trs = tbody.querySelectorAll('tr');
                        for (let k = 0; k < tbody_trs.length; k++) {
                            addEventListene(tbody_trs[k], 'click', () => {
                                let id = tbody_trs[k].getAttribute('data-id');
                                statistics(id);
                            });
                        }
                        // 下面分别是前端删除和后端删除
                        q_table_btns = q_table.querySelectorAll(".del");
                        q_table_trs = q_table.querySelectorAll("tr");
                        for (let i = 0; i < q_table_btns.length; i++) {
                            q_table_btns[i].setAttribute("data-index", String(i));
                            addEventListene(q_table_btns[i].parentElement, 'click', () => {
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', 'ExerciseJudge.php?t=' + new Date().getTime());
                                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                // delete表示删第几个按钮,值是该题目在数据库中的id，该id已提前设在tr的data-id属性上
                                xhr.send('delete=' + q_table_btns[i].parentElement.parentElement.getAttribute("data-id"));
                                addEventListene(xhr, 'readystatechange', () => {
                                    if (xhr.status >= 200 && xhr.status < 300) {
                                        q_table_trs[q_table_btns[i].getAttribute("data-index") - 0 + 1].parentNode.removeChild(q_table_trs[q_table_btns[i].getAttribute("data-index") - 0 + 1]);
                                        countData.innerHTML = String(parseInt(countData.innerHTML) - 1);
                                        deleteMsg.innerHTML = '删除成功~';
                                        deleteMsg.style.display = 'block';
                                        let timer = setTimeout(() => {
                                            deleteMsg.style.display = 'none';
                                            clearTimeout(timer);
                                        }, 1500);
                                    } else {
                                        deleteMsg.innerHTML = '删除失败~';
                                        deleteMsg.style.display = 'block';
                                        let timer = setTimeout(() => {
                                            deleteMsg.style.display = 'none';
                                            clearTimeout(timer);
                                        }, 1500);
                                    }
                                });
                            });
                        }
                        divide(dPage);

                        // 编辑按钮
                        let edits = document.querySelectorAll('.edit');
                        for (let i = 0; i < edits.length; i++) {
                            addEventListene(edits[i], 'click', () => {
                                // 当点击编辑就显示遮罩，就给input:hidden赋题目的id值
                                mask.style.display = "block";
                                hiddenId.value = edits[i].parentNode.parentNode.getAttribute("data-id");
                                const xhr = new XMLHttpRequest();
                                xhr.responseType = 'json';
                                xhr.open('POST', 'ExerciseJudge.php?t=' + new Date().getTime());
                                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                xhr.send("display=true&exerciseId=" + hiddenId.value);
                                addEventListene(xhr, 'readystatechange', () => {
                                    if (xhr.readyState === 4) {
                                        if (xhr.status >= 200 && xhr.status < 300) {
                                            q_field__native.value = xhr.response.title;
                                            qDetail.value = xhr.response.description;
                                            qKeys.value = xhr.response.keyword;
                                            qSort.selectedIndex = xhr.response.typeid - 1;
                                            score.value = xhr.response.score;
                                            init.value = xhr.response.init;
                                            qAnswer.value = xhr.response.answer;
                                            if (edits[i].innerHTML === '查看') {
                                                q_field__native.disabled = true;
                                                qDetail.disabled = true;
                                                qKeys.disabled = true;
                                                qSort.disabled = true;
                                                score.disabled = true;
                                                init.disabled = true;
                                                qAnswer.disabled = true;
                                                submit.style.display = 'none';
                                            } else { // 一定要加，不然当老师先点查看，导致按钮禁用了，然后点编辑，按钮还是禁用的
                                                q_field__native.disabled = false;
                                                qDetail.disabled = false;
                                                qKeys.disabled = false;
                                                qKeys.style.color = 'black';
                                                qSort.disabled = false;
                                                score.disabled = false;
                                                score.style.color = 'black';
                                                init.disabled = false;
                                                qAnswer.disabled = false;
                                                submit.style.display = 'block';
                                            }
                                        }
                                    }
                                });
                            });
                        }
                    }
                }
            });
        }

        //  查询当前第？页/共？页/共？条数据，显示
        function divide(dPage) {
            const xhr = new XMLHttpRequest();
            xhr.responseType = 'json';
            xhr.open('POST', 'ExerciseJudge.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // 分页查询思想
            xhr.send("dPage=" + dPage + "&option=divide");
            addEventListene(xhr, 'readystatechange', () => {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        dPageElement.innerHTML = dPage;
                        countPage.innerHTML = xhr.response.countPage;
                        countData.innerHTML = xhr.response.countData;
                    }
                }
            });
        }

        // 给首页 上一页 下一页 尾页 按钮注入灵魂
        addEventListene(firstPage, 'click', () => {
            dPage = 1;
            show(dPage);
        })

        addEventListene(prePage, 'click', () => {
            if (dPage > 1) {
                dPage -= 1;
                show(dPage);
            } else {
                dPage = 1;
                show(dPage);
            }
        })

        addEventListene(lastPage, 'click', () => {
            let temp = parseInt(countPage.innerHTML);
            if (dPage < temp) {
                dPage += 1;
                show(dPage);
            } else {
                dPage = temp;
            }
        })

        addEventListene(endPage, 'click', () => {
            dPage = parseInt(countPage.innerHTML)
            show(dPage);
        })

        //  为题目建表
        let exec = document.querySelector('.exec');
        let result = document.querySelector('.result');
        addEventListene(exec, 'click', () => {
            if (init.value !== '') {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'ExerciseJudge.php?t=' + new Date().getTime());
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("init=" + init.value);
                addEventListene(xhr, 'readystatechange', () => {
                    if (xhr.readyState === 4) {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            let time = new Date();
                            result.value = time.getFullYear() + "-" + (time.getMonth() + 1) + "-" + time.getDate() + " " + time.getHours() + ":" + time.getMinutes() + ":" + time.getSeconds() + "\n" + xhr.response;
                        }
                    }
                });
            }
        });
    })
})();