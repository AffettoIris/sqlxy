// 本脚本作用是在用户切换网页时改变网页标题

// (function () {
//     window.addEventListener('load', function () {
//         // var title = '(*^ω^*)欢迎光临';
//         var flag = true;
//         window.addEventListener('blur', function () {
//             // title = document.title;
//             if (flag) {
//                 document.title = 'Σ(ŎдŎ|||)ﾉﾉ不要走！再看看吧';
//                 flag = false;
//             } else {
//                 document.title = '( ๑ŏ ﹏ ŏ๑ )哎呀，404了';
//                 flag = true;
//             }
//         })
//         window.addEventListener('focus', function () {
//             if (flag) {
//                 document.title = 'ヾ(^▽^*)))哈哈骗你哒';
//             } else {
//                 document.title = '(*^ω^*)欢迎光临';
//             }
//         })
//     })
// }())

// 上述方法不推荐，刷新网页也会触发window.onblur，推荐下法。

(function () {
    window.addEventListener('load', function () {
        var flag = true;
        document.addEventListener('visibilitychange', function () {
            const title = '(*^ω^*)欢迎光临';
            if (document.visibilityState === 'hidden') {
                if (flag) {
                    document.title = 'Σ(ŎдŎ|||)ﾉﾉ不要走！再看看吧';
                    flag = false;
                } else {
                    document.title = '( ๑ŏ ﹏ ŏ๑ )哎呀，404了';
                    flag = true;
                }
            } else {
                if (flag) {
                    document.title = 'ヾ(^▽^*)))哈哈骗你哒';
                } else {
                    document.title = title;
                }
            }
        })
    })
}())