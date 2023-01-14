// 在</body>的上一行、在程序员自己写的html代码之后引用。引用后在网页上自动出现自动打字特效
// 需要在html代码里，在你想显示文案的地方加入下行代码
/* <div id="typeJs"></div> */
// 文案在下面，可以自行修改文案内容、增删文案个数。
// 下下下下行的236和92分别代表打/删一个字用的毫秒数，时间越短越快，1s等于1000毫秒。可自行修改打字/删字速度。一般不用改。
// 我只管打字效果，文字的样式（比如颜色，比如居中对齐）需要根据你的需求单独通过css设置啊。
var typeJs = document.getElementById('typeJs');
var poems = ["最近开心嘛 顺利嘛 有想我嘛", "鸿是江边鸟 您是心上人", "欲买桂花同载酒 终不似 少年游",
            "世界上最好看的人就在我眼睛里 不信你看", "种自己的花 爱自己的宇宙", "风华正茂 当然要落落大方"];
var writeTime = 236;
var deleteTime = 92;
type(typeJs, poems, writeTime, deleteTime);
function type(obj, poems, writeTime, deleteTime) {
    var len = 0;
    var flag = 0;
    var count = 0;
    // 睡眠函数，不建议用进循环里，会显示拖慢网页速度，参数毫秒
    function sleep(numberMillis) {
        var now = new Date();
        var exitTime = now.getTime() + numberMillis;
        while (true) {
            now = new Date();
            if (now.getTime() > exitTime) {
                return;
            }
        }
    }

    var fn = function () {
        if (flag) {
            obj.innerHTML = poems[count].substring(0, len);
            len--;
            if (len == 0) {
                flag = 0;
                clearInterval(timer);
                timer = setInterval(fn, writeTime);
                count++;
                if (count == poems.length) {
                    count = 0;
                }
            }
        } else {
            obj.innerHTML = poems[count].substring(0, len);
            len++;
            if (len == poems[count].length + 2) {
                flag = 1;
                clearInterval(timer);
                sleep(1500);
                timer = setInterval(fn, deleteTime);
            }
        }
    }
    // 先执行一次，因为定时器第一次启动也要等时间间隔
    obj.innerHTML = poems[count].substring(0, len);
    len++;
    var timer = setInterval(fn, writeTime);
}