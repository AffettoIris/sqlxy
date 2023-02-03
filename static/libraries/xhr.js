function xhrTimeoutError(xhr, element, input=false) {
    if(!input) {
        addEventListene(xhr, 'timeout', ()=>{
            element.innerHTML = '网络异常，请稍后重试！';
        });
        addEventListene(xhr, 'error', ()=>{
            element.innerHTML = '您的网络似乎出了一些问题！';
        });
    } else {
        addEventListene(xhr, 'timeout', ()=>{
            element.value = '网络异常，请稍后重试！';
        });
        addEventListene(xhr, 'error', ()=>{
            element.value = '您的网络似乎出了一些问题！';
        });
    }
}