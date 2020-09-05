<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
    <style>
        ::selection { background-color: #f07746; color: #fff; }
        ::-moz-selection { background-color: #f07746; color: #fff; }

        body {
            background-color: #ffffff;
            margin: 40px auto;
            max-width: 1024px;
            font-size: 16px;
            font-weight: normal;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #808080;
        }
        a {
            color: #dd4814;
            background-color: transparent;
            font-weight: normal;
            text-decoration: none;
        }
        a:hover { color: #97310e; }
        h1 {
            color: #fff;
            background-color: #dd4814;
            font-size: 22px;
            font-weight: bold;
            margin: 0 0 14px 0;
            padding: 5px 15px;
            line-height: 40px;
        }
        h2 {
            color:#404040;
            margin:0;
            padding:0 0 10px 0;
        }
        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 13px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }
        .container {
            margin: 10px;
            border: 1px solid #d0d0d0;
            box-shadow: 0 0 8px #d0d0d0;
            border-radius: 4px;
        }
        .header {
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            border-bottom: 1px solid #d1d1d1;
        }
        p {
            margin: 0 0 10px;
            padding:0;
        }
        .message {
            margin: 0 15px 0 15px;
            min-height: 96px;
        }
    </style>
</head>
    <body>
        <div class="container">
            <h1 class="header"><?= $heading ?></h1>

            <div class="message"><?= $message; ?></div>
        </div>
    </body>
</html>
