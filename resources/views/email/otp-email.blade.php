<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <title>تأكيد البريد الإلكترني</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif,
                'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            background-color: #edf2f7;
            color: #718096;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #3d4852;
            font-size: 24px;
            font-weight: bold;
            margin-top: 0;
            text-align: center;
        }

        p {
            font-size: 16px;
            line-height: 1.5em;
            text-align: center;
        }

        .otp {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 20px;
            border-radius: 4px;
            text-align: center;
            font-size: 18px;
            color: #4a5568;
            margin: 0 auto;
            max-width: 300px;
        }

        table {
            margin: 0 auto;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper" style="max-width: 600px; margin: 0 auto;">
        <h1>تأكيد البريد الإلكتروني</h1>
        <p>يرجى تأكيد البريد الإلكتروني الخاص بك عن طريق الرمز التالي:</p>

        <div class="otp">{{ $otp }}</div>

        <p>شكراً لاستخدامك منصتنا,  ستتمكن الآن من تأكيد البريد الإلكتروني الخاص بك.</p>

        <p class="footer">مع أطيب التحيات،<br>منصة سياحة وسفر</p>
    </div>
</body>

</html>
