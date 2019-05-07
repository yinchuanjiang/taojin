<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
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
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css">
    <style>
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
        .view-input {
            font-size: .3rem;
        }
        .flex-box {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 1.5rem;
        }
        .btn-box {
            padding: .5rem 1rem;
        }
        .form-box {
            padding: .5rem 0.2rem;
        }
        input {
            -web-kit-appearance:none;
            -moz-appearance: none;
            border: none;
            outline:0;
        }
        .weui-vcode-btn {
            width: 2.4rem;
            background: transparent;
        }
    </style>
</head>
<body>
<div class="store_login">
    <h2 class="text-h2">欢迎进入淘金</h2>
    <h3 class="text-h3">请填写注册基本信息</h3>
</div>
<div class="form-box">
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="tel" maxlength="11" placeholder="请输入手机号">
        </div>
    </div>
    <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
            <label class="weui-label">验证码</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" maxlength="6" type="number" placeholder="请输入验证码">
        </div>
        <div class="weui-cell__ft">
            <input class="weui-vcode-btn" type="button" id="btn" value="获取验证码" onclick="settime(this)" />
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">设置密码</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="请输入密码">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">邀请码</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="请输入邀请码">
        </div>
    </div>
</div>
<div class="btn-box">
    <a href="javascript:;" class="weui-btn weui-btn_primary">立即注册</a>
</div>


<script type="text/javascript">
    var countdown = 60;
    function settime(val) {
        if (countdown == 0) {
            val.removeAttribute("disabled");
            val.value = "免费获取验证码";
            countdown = 60;
        } else {
            val.setAttribute("disabled", true);
            val.value = "重新发送(" + countdown + ")";
            countdown--;
            setTimeout(function() {
                settime(val)
            }, 1000)
        }

    }
</script>


<script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js"></script>
</body>
</html>