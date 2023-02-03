(()=>{
    window.addEventListener('load', ()=>{
        window.onbeforeunload = function(e) {
            return false && null; // onbeforeunload 钩子中如果返回null的话，就不会弹出对话框（"系统可能不会保存您所做的更改"）。
            // 暂时没找到可以改变弹出框文案的方法，应该是不可以的。
            // 以下代码没有效果
            // var dialogText = "Dialog text here";
            // e.returnValue = dialogText;
            // return dialogText;
        };
    });
})();