window.addEventListener('load', function () {
    // 筋斗云
    var cloud = document.querySelector(".cloud");
    // cloudCurrent是Create Delete Read Update四个li
    var cloudCurrent = cloud.nextElementSibling.children;
    var crud = document.querySelector(".crud");
    var crudCurrent = crud.firstElementChild.children;
    for (var i = 0; i < cloudCurrent.length; i++) {
        cloudCurrent[i].setAttribute("data-index", i);
        cloudCurrent[i].addEventListener('click', function () {
            animate(cloud, this.offsetLeft + 45)
            // 设置crud的display: block;要先清除所有id="current"
            for (var i = 0; i < crudCurrent.length; i++) {
                crudCurrent[i].className = "";
            }
            crudCurrent[this.getAttribute("data-index")].className = "current";
        })
    }


})