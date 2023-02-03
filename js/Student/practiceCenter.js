(function() {
    window.addEventListener('load', function () {
        let dPage = 1;
        let firstPage = document.querySelector('#firstPage');
        let prePage = document.querySelector('#prePage');
        let lastPage = document.querySelector('#lastPage');
        let endPage = document.querySelector('#endPage');
        let dPageElement = document.querySelector('#dPage');
        let countPage = document.querySelector('#countPage');
        let countData = document.querySelector('#countData');
        let typeid = 1;
// 筋斗云
        let cloud = document.querySelector(".cloud");
        // cloudCurrent是Create Delete Read Update四个li
        let cloudCurrent = cloud.nextElementSibling.children;
        for (let i = 0; i < cloudCurrent.length; i++) {
            cloudCurrent[i].setAttribute("data-index", i + 1);
            cloudCurrent[i].addEventListener('click', function () {
                animate(cloud, this.offsetLeft + 45);
                typeid = this.getAttribute('data-index');
                dPage = 1;
                show (this.getAttribute('data-index'), dPage);
            })
        }

        let tbody = document.querySelector('.tbody');
// 刚加载页面就调用show()
        show(1, 1);

//  显示题目的函数
        function show(index, dPage) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'PraCenJud.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('typeid=' + index + "&dPage=" + dPage + '&option=show');
            addEventListene(xhr, 'readystatechange', ()=>{
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        tbody.innerHTML = xhr.response;
                        let trs = tbody.querySelectorAll('tr');
                        for (let j = 0; j < trs.length; j++) {
                            trs[j].addEventListener('click', ()=>{
                                let xhr = new XMLHttpRequest();
                                xhr.open('POST', 'PraCenJud.php?t=' + new Date().getTime());
                                xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                                xhr.send('option=answer&exerciseId=' + trs[j].getAttribute('data-id') + '&timestamp=' + new Date().valueOf());
                                addEventListene(xhr, 'readystatechange', ()=>{
                                    if (xhr.readyState === 4) {
                                        if (xhr.status >= 200 && xhr.status < 300) {
                                            if (xhr.response === 'failed') {
                                                alert('加载答题页面失败了！，请联系管理员！');
                                            } else {
                                                location.href = (JSON.parse('[' + xhr.response + ']')[0].href + '?exerciseId=' + trs[j].getAttribute('data-id'));
                                            }
                                        }
                                    }
                                });
                            });
                        }
                    }
                }
            });

            addEventListene(xhr, 'error', ()=>{
                tbody.innerHTML = '您的网络似乎出了一些问题！';
            });

            addEventListene(xhr, 'timeout', ()=>{
                tbody.innerHTML = "网络异常，请稍后重试！";
            });
            divide(index, dPage);
        }

        //  查询当前第？页/共？页/共？条数据，显示
        function divide(index, dPage) {
            const xhr = new XMLHttpRequest();
            xhr.responseType = 'json';
            xhr.open('POST', 'PraCenJud.php?t=' + new Date().getTime());
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            // 分页查询思想
            xhr.send('typeid=' + index + "&dPage=" + dPage +"&option=divide");
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

// 给首页 上一页 下一页 尾页 按钮注入灵魂
        addEventListene(firstPage, 'click', ()=>{
            dPage = 1;
            show(typeid, dPage);
        })

        addEventListene(prePage, 'click', ()=>{
            if (dPage > 1) {
                dPage -= 1;
                show(typeid, dPage);
            } else {
                dPage = 1;
                show(typeid, dPage);
            }
        })

        addEventListene(lastPage, 'click', ()=>{
            let temp = parseInt(countPage.innerHTML);
            if (dPage < temp) {
                dPage += 1;
                show(typeid, dPage);
            } else {
                show(typeid, dPage);
            }
        })

        addEventListene(endPage, 'click', ()=>{
            dPage = parseInt(countPage.innerHTML)
            show(typeid, dPage);
        })
    })
})();