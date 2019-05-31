<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        body, body *:not(html):not(style):not(br):not(tr):not(code) {
            font-family: "Avenir Next", Helvetica, sans-serif;
            box-sizing: border-box;
            text-align: left;
        }

        body {
            font-size: 0.8rem;
            background-color: #f5f8fa;
            color: black;
            height: 100%;
            hyphens: auto;
            line-height: 1.4;
            margin: 0;
            -moz-hyphens: auto;
            -ms-word-break: break-all;
            width: 100% !important;
            -webkit-hyphens: auto;
            -webkit-text-size-adjust: none;
            word-break: break-all;
            word-break: break-word;
        }

        h1, h2, h3, h4, p {
            margin: 0;
        }

        .panel {
            background-color: #FF6259;
            padding: 0.8rem;
            font-weight: bold;
        }

        .sub-panel {
            background-color: #ececec;
            padding: 0.5rem 0.8rem;
            font-weight: bold;
        }

        .no-wrap {
            white-space: nowrap;
            word-break: normal
        }

        .inner-body {
            background-color: #FFFFFF;
            margin: 0 auto;
            padding: 0;
            width: 80%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 80%;
        }

        code {
            background-color: #cccccc;
        }

        .table table {
            margin: 10px auto;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .table th {
            padding: 1px 0.8rem;
        }

        .table td {
            padding: 1px 0.8rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .m-0 {
            margin: 0 !important;
        }

        .p-0 {
            padding: 0 !important;
        }

        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
<table class="inner-body table">
    <tr>
        <td>
            @yield('content')
        </td>
    </tr>
</table>
</body>
</html>
