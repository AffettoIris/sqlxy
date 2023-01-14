const express = require('express');
const app = express();
app.get('/server', (request, response)=>{
    response.setHeader('Access-Control-Allow-Origin', '*');
    response.send('HELLO get');
});
app.all('/server', (request, response)=>{
    response.setHeader('Access-Control-Allow-Origin', '*');
    response.setHeader('Access-Control-Allow-Headers', '*');
    response.send('HELLO');
});

app.all('/json-server', (request, response)=>{
    response.setHeader('Access-Control-Allow-Origin', '*');
    response.setHeader('Access-Control-Allow-Headers', '*');
    const data = {
        name:'iris',
        age:20
    }
    // server准备发送json
    // 但是你不能直接send(data)，因为参数只能是string | buffer。-ify后缀表示使什么什么化
    let str = JSON.stringify(data);
    response.send(str);
});

app.all('/ie', (request, response)=>{
    response.setHeader('Access-Control-Allow-Origin', '*');
    response.send('HELLO ie 2');
});

app.get('/delay', (request, response)=>{
    response.setHeader('Access-Control-Allow-Origin', '*');
    // 当访客很多时，来不及处理，就有顾客超时了。用定时器模拟超时
    setTimeout(()=>{
        response.send('延时响应');
    }, 2000);
});

app.listen(8000, ()=>{
    console.log('8000端口监听中');
});