<head>
    <link rel="stylesheet" href="{{asset('css/variable.css')}}">
    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .mail-container {
            background-color: rgba(8,49,94, 0.3);
            width: 100%;
            height: 100%;
        }

        .cancel-bill-container {
            width: 50%;
            margin: 0 auto;
            padding: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }

        .cancel-bill-container .logo {
            background-color: rgba(8,49,94, 1);
            padding: 10px;
        }

        .cancel-bill-container .logo h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .main-content {
            background-color: white;
            padding: 80px 60px;
            margin: 0px;
        }

        .cancel-bill-container .cancel-bill {
        }

        .cancel-bill-container .cancel-bill h1 {
            color: #393333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .cancel-bill-container .cancel-bill p {
            color: #3869D4;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .cancel-bill-container .cancel-bill-info {
            color: #393333;
        }

        footer {
            color: white;
            font-size: 14px;
            background-color: rgba(8,49,94, 1);
            padding: 4px 10px;
        }

    </style>
</head>
<body>
<div class="mail-container">
    <div class="cancel-bill-container">
        <header class="logo">
            <h1>
                ICHST-2023
            </h1>
        </header>
        <div class="main-content">
            <div class="cancel-bill">
                <h1>Your bill was cancel successfully:</h1>
                <p>Total Price: {{$total}}</p>
                <p>This code was be canceled: {{$cancel_code}}</p>
            </div>
            <div class="cancel-bill-info">
                <p style="color: red;">Thank you. Please contact to our email ichst-2023@hust.edu.vn to confirm refun method.</p>
                <p>Best regards,</p>
                <p>ICHST-2023</p>
            </div>
        </div>
        <footer>
            <p>© ICHST-2023. All rights reserved.</p>
        </footer>
    </div>
</div>
</body>
