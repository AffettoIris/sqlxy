window.addEventListener('load', function () {
    var tishu = document.querySelector('.tishu');
    // 当点击"第几题"时，显示右白边框
    for (var i = 0; i < tishu.children.length; i++) {
        tishu.children[i].addEventListener('click', function () {
            for (i = 0; i < tishu.children.length; i++) {
                tishu.children[i].className = '';
            }
            this.className = 'current_exam';
        })
    }
    // 当SQL执行框的内容不为空，显示执行按钮，即button的display：block；
    // 当失去焦点了，内容为空再隐藏
    var zhixingBtn = document.querySelectorAll('.zhixingBtn');
    for (var i = 0; i < zhixingBtn.length; i++) {
        zhixingBtn[i].previousElementSibling.addEventListener('keyup', function () {
            // this是<textarea>
            console.log(this);
            if (this.value != '') {
                this.nextElementSibling.style.display = 'block';
            }
        })
        zhixingBtn[i].previousElementSibling.addEventListener('blur', function () {
            if (this.value == '') {
                this.nextElementSibling.style.display = 'none';
            }
        })
    }
    // 首先每一题都是display: none;当页面刚加载的时候，第一题block，
    // 然后每点击左侧第几题就block第几题，其他题none
    var exam_content = document.querySelector('#exam_content');
    exam_content.children[0].style.display = 'block';
    for (var i = 0; i < tishu.children.length; i++) {
        tishu.children[i].setAttribute('data-index', i);
        tishu.children[i].addEventListener('click', function () {
            for (var i = 0; i < tishu.children.length; i++) {
                exam_content.children[i].style.display = 'none';
            }
            exam_content.children[this.getAttribute('data-index')].style.display = 'block';
        })
    }
})