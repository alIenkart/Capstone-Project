<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            line-height: 1.6;
            color: #1f2937;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            padding: 20px;
        }

        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
        }

        .email-container {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        }

        /* Logo Section */
        .logo-section {
            background: #ffffff;
            padding: 20px 30px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .logo-section img {
            max-width: 180px;
            height: auto;
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #1E71B8 0%, #1557a0 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .email-header::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .header-icon svg {
            width: 40px;
            height: 40px;
            color: #fff;
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .email-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            margin: 0;
        }

        /* Body */
        .email-body {
            padding: 40px 30px;
            text-align: center;
        }

        .email-body p {
            font-size: 15px;
            color: #374151;
            margin-bottom: 20px;
        }

        .otp-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: 12px;
            display: inline-block;
            padding: 20px 40px;
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 6px;
            color: #1E71B8;
            margin: 20px 0;
        }

        .expiry-text {
            color: #6b7280;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Footer */
        .email-footer {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 13px;
            color: #6b7280;
        }

        .footer-content {
            line-height: 1.8;
        }

        .footer-content strong {
            color: #1f2937;
            font-weight: 600;
        }

        .footer-divider {
            color: #d1d5db;
            margin: 0 6px;
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 30px 16px;
            }

            .otp-box {
                font-size: 30px;
                padding: 16px 32px;
            }

            .email-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Logo -->
            <!-- <div class="logo-section">
                <img src="{{ asset('storage/logo/Logo.png') }}" alt="JE Travel & Tours Logo">
            </div> -->

            <!-- Header -->
            <div class="email-header">
                <div class="header-content">
                    <div class="header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75A2.25 2.25 0 0014.25 4.5h-9A2.25 2.25 0 003 6.75v10.5A2.25 2.25 0 005.25 19.5h9a2.25 2.25 0 002.25-2.25V13.5m4.5-3l-3 3m0 0l3 3m-3-3h-9" />
                        </svg>
                    </div>
                    <h1>OTP Verification</h1>
                    <p>Secure your account verification</p>
                </div>
            </div>

            <!-- Body -->
            <div class="email-body">
                <p>Hello,</p>
                <p>Use the One-Time Password (OTP) below to verify your email address.</p>

                <div class="otp-box">{{ $otp }}</div>

                <p class="expiry-text">This code will expire in <strong>5 minutes</strong>.</p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <div class="footer-content">
                    <strong>JE Travel & Tours</strong>
                    <span class="footer-divider">•</span>
                    <span>© 2025 All Rights Reserved</span>
                    <br>
                    <span style="color: #9ca3af; font-size: 12px;">This is an automated message, please do not reply directly to this email.</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>