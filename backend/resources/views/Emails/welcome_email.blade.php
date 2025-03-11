<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to MochiPals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .email-body {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }
        .email-body h2 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #007bff;
        }
        .email-body p {
            margin: 0 0 15px;
        }
        .email-footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #666666;
        }
        .email-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .email-footer a:hover {
            text-decoration: underline;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Welcome to MochiPals!</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Hello {{ $username }},</h2>
            <p>Thank you for creating an account with us at <strong>MochiPals</strong> – we’re thrilled to have you on board!</p>
            <p>With your new account, you can:</p>
            <ul>
                <li>View your order history</li>
                <li>Create wishlists (oh, yes!)</li>
                <li>Save your details for faster checkout</li>
            </ul>
            <a href="{{ env('FRONTEND_URL') }}" class="button">Start Shopping Now</a>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>You're receiving this email because you signed up for an account at <a href="{{ env('FRONTEND_URL') }}">MochiPals</a>.</p>
            <p>&copy; {{ date('Y') }} MochiPals. All rights reserved.</p>
        </div>
    </div>
</body>
</html>