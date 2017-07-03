<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="UTF-8">
        <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="msapplication-tap-highlight" content="no"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700" rel="stylesheet">
        <style>
            main {
                position: absolute;
                width: 404px;
                height: 404px;
                top: 50%;
                left: 50%;
                margin-top: -202px;
                margin-left: -202px;
                font-family: 'Roboto Mono', monospace;
            }
            .wrapper {
                width: 100%;
                float: left;
            }
            .wrapper img {
                width: 100%;
                float: left;
            }
            .sorry {
                width: 100%;
                float: left;
                margin-top: 20px;
                text-align: center;
                font-size: 17px;
                line-height: 25px;
                text-transform: uppercase;
                color: #333;
            }
            .gotohomepage-btn {
                padding: 13px 25px;
                background-color: #333;
                color: #fff;
                border-radius: 2px;
                -webkit-border-radius: 2px;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="wrapper">
                <img src="{{ asset('packages/king/frontend/images/404.png') }}" />
                <div class="sorry">
                    <p>{{ _t('notfoundmsg') }}</p>
                    <br/>
                    <a href="/" class="gotohomepage-btn">{{ _t('notfoundbtn') }}</a>
                </div>
            </div>
        </main>
    </body>
</html>
