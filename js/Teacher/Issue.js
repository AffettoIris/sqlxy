window.addEventListener("load", function () {
    var question_info_left_ul = document.querySelector('.question_info_left_ul');
    var q_form = document.querySelector('#q_form');
    var inps = q_form.querySelectorAll("input");
    var teatareas = q_form.querySelectorAll("textarea")
    var q_field__native = document.querySelector(".q_field__native");
    var btn_jiahao = document.querySelector(".jiahao");
    var mask = document.querySelector(".mask");
    var tail_cancel = document.querySelector("#tail_cancel");
    var q_table = document.querySelector(".q_table");
    var q_table_btns = q_table.querySelectorAll("button");
    var q_table_trs = q_table.querySelectorAll("tr");
    var tbody = q_table.querySelector("tbody");
    // 当点击左边第N个li时，显示右白边框
    for (var i = 0; i < question_info_left_ul.children.length; i++) {
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
    for (var i = 0; i < question_info_left_ul.children.length; i++) {
        question_info_left_ul.children[i].setAttribute('data-index', i);
        question_info_left_ul.children[i].addEventListener('click', function () {
            for (var i = 0; i < question_info_left_ul.children.length; i++) {
                q_form.children[i].style.display = 'none';
            }
            q_form.children[this.getAttribute('data-index')].style.display = 'block';
        })
    }
    // 让第一个input加载进来就选中
    q_field__native.focus();
    // 选中所有的input和textarea，focus时变蓝色
    for (var i = 0; i < inps.length; i++) {
        inps[i].addEventListener("focus", function () {
            this.style.borderBottomColor = "#1976D2"
        })
    }
    for (var i = 0; i < teatareas.length; i++) {
        teatareas[i].addEventListener("focus", function () {
            this.style.borderColor = "#1976D2"
        })
    }
    for (var i = 0; i < inps.length; i++) {
        inps[i].addEventListener("blur", function () {
            this.style.borderBottomColor = "#fff"
        })
    }
    for (var i = 0; i < teatareas.length; i++) {
        teatareas[i].addEventListener("blur", function () {
            this.style.borderColor = "#fff"
        })
    }
    // 当点击新增题目就显示遮罩
    btn_jiahao.addEventListener("click", function () {
        mask.style.display = "block";
    })
    // 尾巴，点取消就不显示遮罩
    tail_cancel.addEventListener("click", function () {
        mask.style.display = "none";
    })
    // 实现删除功能（仅页面得元素被删除，数据库里被删除是后端的事）
    for (var i = 0; i < q_table_btns.length; i++) {
        q_table_btns[i].setAttribute("data-index", i);
        q_table_btns[i].addEventListener("click", function () {
            // 经测试发现this.getAttribute("data-index")返回字符型，我借助减0转成数字型
            // 哎，为什么我第一处索引号不直接用1呢？因为我发现删除节点只是在显示中的网页删除，实际上的html文件结构没变
            q_table_trs[this.getAttribute("data-index") - 0 + 1].parentNode.removeChild(q_table_trs[this.getAttribute("data-index") - 0 + 1]);
        })
    }
})