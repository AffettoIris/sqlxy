(() => {
    window.addEventListener('load', () => {
        // 四种题型占比量                                                
        let typeChart = echarts.init(document.querySelector('.type'));
        let xhr = new XMLHttpRequest();
        xhr.open('POST', './message_jud.php?t=' + new Date().getTime());
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('operation=getType');
        xhr.addEventListener('readystatechange', ()=>{
            if (xhr.readyState === 4) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    let response = JSON.parse(xhr.response);
                    typeOption = {
                        color: ['blue', 'red', 'yellow', 'pink'], 
                        title: {
                            text: '四种题型占比量',
                            left: 'center'
                        },
                        tooltip: {
                            trigger: 'item'
                        },
                        legend: {
                            orient: 'vertical',
                            left: 'left'
                        },
                        series: [
                            {
                                name: 'Access From',
                                type: 'pie',
                                radius: '50%',
                                data: [
                                    { value: response.insert, name: 'INSERT' },
                                    { value: response.delete, name: 'DELETE' },
                                    { value: response.select, name: 'SELECT' },
                                    { value: response.update, name: 'UPDATE' }
                                ],
                                emphasis: {
                                    itemStyle: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
                            }
                        ]
                    };
                    typeChart.setOption(typeOption)
                }
            }
        })
    });
})();