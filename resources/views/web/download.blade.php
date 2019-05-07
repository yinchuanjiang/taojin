<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script>
        (function(doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function() {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    // 默认设计图为640的情况下1rem=100px；根据自己需求修改
                    if (clientWidth >= 750) {
                        docEl.style.fontSize = '100px';
                    } else {
                        docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
                    }
                };

            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css">
    <style type="text/css">
        .store_login {
            margin-top: 2rem;
        }
        .text-h2{
            font-size: .6rem;
            text-align: center;
            color: #00C34E;
        }
        .text-h3 {
            margin-top: .2rem;
            margin-bottom: 1rem;
            font-size: .36rem;
            text-align: center;
            color: #979797;
        }
        .btn-box {
            padding: .5rem 2rem;
        }
    </style>
</head>
<body>
<div class="store_login">
    <h2 class="text-h2">欢迎下载淘金</h2>
    <h3 class="text-h3">开始淘您的第一桶金吧</h3>
</div>
<div class="btn-box">
    <a href="javascript:;" class="weui-btn weui-btn_primary">安卓 APP下载</a>
    <a href="javascript:;" class="weui-btn weui-btn_primary">IOS APP下载</a>
</div>
</body>
</html>