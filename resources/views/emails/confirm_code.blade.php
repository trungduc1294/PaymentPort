<head>
    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .mail-container {
            background-color: #F2F4F6;
            width: 100%;
            height: 100%;
        }

        .confirm-code-container {
            width: 50%;
            margin: 0 auto;
            padding: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }

        .confirm-code-container .logo {
            background-color: #000;
            padding: 10px;
        }

        .confirm-code-container .logo h1 {
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

        .confirm-code-container .confirm-code {
         }

        .confirm-code-container .confirm-code h1 {
            color: #393333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .confirm-code-container .confirm-code p {
            color: #3869D4;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .confirm-code-container .confirm-code-info {
            color: #393333;
        }

        footer {
            color: white;
            font-size: 14px;
            background-color: #000;
            padding: 4px 10px;
        }

    </style>
</head>
<body>
    <div class="mail-container">
        <div class="confirm-code-container">
            <header class="logo">
                <h1>
                    RIVF'23
                </h1>
            </header>
            <div class="main-content">
                <div class="confirm-code">
                    <h1>This is confirm code:</h1>
                    <p>{{$code}}</p>
                </div>
                <div class="confirm-code-info">
                    <p>Thank you. Please use this code to confirm in payment website.</p>
                    <p>Best regards,</p>
                    <p>RIVF'23</p>
                </div>
            </div>
            <footer>
                <p>© 2021 RIVF'23. All rights reserved.</p>
            </footer>
        </div>
    </div>
</body>
