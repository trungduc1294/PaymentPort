


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

        .reference-code-container {
            width: 50%;
            margin: 0 auto;
            padding: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }

        .reference-code-container .logo {
            background-color: #000;
            padding: 10px;
        }

        .reference-code-container .logo h1 {
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

        .reference-code-container .reference-code {
        }

        .reference-code-container .reference-code h1 {
            color: #393333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .reference-code-container .reference-code p {
            color: #3869D4;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .reference-code-container .reference-code-info {
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
    <div class="reference-code-container">
        <header class="logo">
            <h1>
                RIVF'23
            </h1>
        </header>
        <div class="main-content">
            <div class="reference-code">
                <h1>Thank for your purchase. This is your joining code:</h1>
                <p>{{$join_code}}</p>
            </div>
            <div class="reference-code-info">
                <p>Thank you. Please use this code to join RIVF'23.</p>
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
