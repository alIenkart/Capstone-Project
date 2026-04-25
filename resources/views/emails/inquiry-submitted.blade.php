<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background: linear-gradient(135deg, #1E71B8 0%, #008DDA 100%);
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
        }

        .greeting {
            margin-bottom: 30px;
        }

        .greeting p {
            font-size: 15px;
            margin-bottom: 12px;
            color: #374151;
        }

        .greeting strong {
            color: #1E71B8;
            font-weight: 600;
        }

        /* Section Title */
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-top: 30px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #1E71B8 0%, #73BE5D 100%);
            border-radius: 2px;
        }

        /* Inquiry Details Card */
        .inquiry-details {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            margin: 20px 0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .detail-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
        }

        .detail-value {
            color: #1f2937;
            font-weight: 500;
            text-align: right;
        }

        /* Message Section */
        .message-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 24px;
            margin: 20px 0;
        }

        .message-section h3 {
            margin: 0 0 12px 0;
            color: #0369a1;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .message-section p {
            margin: 0;
            color: #164e63;
            line-height: 1.7;
            font-size: 14px;
            white-space: pre-line;
        }

        /* Confirmation Notice */
        .confirmation-notice {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px solid #bbf7d0;
            border-radius: 12px;
            padding: 24px;
            margin: 25px 0;
        }

        .confirmation-notice h3 {
            margin: 0 0 12px 0;
            color: #15803d;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .confirmation-notice p {
            margin: 0;
            color: #166534;
            line-height: 1.7;
            font-size: 14px;
        }

        /* Contact Section */
        .contact-info {
            background: linear-gradient(135deg, #f0fdf4 0%, #f1f5f9 100%);
            border: 1px solid #bbf7d0;
            border-left: 4px solid #73BE5D;
            border-radius: 12px;
            padding: 24px;
            margin: 25px 0;
        }

        .contact-info h3 {
            margin: 0 0 12px 0;
            color: #15803d;
            font-size: 16px;
            font-weight: 700;
        }

        .contact-info p {
            margin: 8px 0;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.6;
        }

        .contact-info strong {
            color: #1E71B8;
            font-weight: 600;
        }

        /* CTA Section */
        .cta-section {
            text-align: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
        }

        .cta-text {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 20px;
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

        /* Utility */
        .text-center {
            text-align: center;
        }

        .mt-20 {
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 24px 16px;
            }

            .email-header {
                padding: 30px 20px;
            }

            .logo-section {
                padding: 16px;
            }

            .logo-section img {
                max-width: 150px;
            }

            .detail-row {
                flex-direction: column;
                gap: 6px;
            }

            .detail-value {
                text-align: left;
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
            <!-- Logo Section -->
            <div class="logo-section">
                <img src="data:image/png;base64,{{ $logoBase64 }}" alt="JE Travel & Tours Logo" style="display: block; margin: 0 auto; max-width: 180px; height: auto;">
            </div>

            <!-- Header -->
            <div class="email-header">
                <div class="header-content">
                    <div class="header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <h1>Inquiry Received</h1>
                    <p>We have received your inquiry and will get back to you shortly</p>
                </div>
            </div>

            <!-- Body -->
            <div class="email-body">
                <div class="greeting">
                    <p>Dear <strong>{{ $inquiry->name }}</strong>,</p>
                    <p>Thank you for reaching out to <strong>JE Travel & Tours</strong>! We have successfully received
                        your inquiry and our team is reviewing it. We will get back to you as soon as possible.</p>
                </div>

                <!-- Confirmation Notice -->
                <div class="confirmation-notice">
                    <h3>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        Inquiry Submitted Successfully
                    </h3>
                    <p>Your inquiry has been logged in our system. A member of our team will review your request and
                        respond within <strong>24-48 hours</strong> during business days.</p>
                </div>

                <!-- Inquiry Details -->
                <div class="section-title">Inquiry Details</div>
                <div class="inquiry-details">
                    <div class="detail-row">
                        <span class="detail-label">Name: </span>
                        <span class="detail-value">{{ $inquiry->name }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Email: </span>
                        <span class="detail-value">{{ $inquiry->email }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Contact Number: </span>
                        <span class="detail-value">{{ $inquiry->contact_number ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Destination / Trip: </span>
                        <span class="detail-value">{{ $inquiry->destination ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Subject: </span>
                        <span class="detail-value">{{ $inquiry->subject ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Adults: </span>
                        <span class="detail-value">{{ $inquiry->adults ?? 0 }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Children: </span>
                        <span class="detail-value">{{ $inquiry->children ?? 0 }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Seniors: </span>
                        <span class="detail-value">{{ $inquiry->seniors ?? 0 }}</span>
                    </div>
                </div>

                <!-- Message -->
                @if($inquiry->message)
                    <div class="message-section">
                        <h3>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Your Message
                        </h3>
                        <p>{{ $inquiry->message }}</p>
                    </div>
                @endif

                <!-- Contact Information -->
                <div class="contact-info">
                    <h3>Need Immediate Assistance?</h3>
                    <p>If you need urgent help or have additional information to share, feel free to contact us
                        directly:</p>
                    <p style="margin-top: 16px;">
                        <strong>Email:</strong> traveller.laguna@gmail.com | jetravelandtours@gmail.com<br>
                        <strong>Phone:</strong> +63 939 521 8437<br>
                        <strong>Hours:</strong> 8:00 AM - 5:00 PM (Mon-Fri)
                    </p>
                </div>

                <!-- CTA Section -->
                <div class="cta-section">
                    <p class="cta-text">Thank you for choosing JE Travel & Tours. We look forward to helping you plan
                        your perfect trip!</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <div class="footer-content">
                    <strong>JE Travel & Tours</strong>
                    <span class="footer-divider">•</span>
                    <span>© {{ date('Y') }} All Rights Reserved</span>
                    <br>
                    <span style="color: #9ca3af; font-size: 12px;">This is an automated message, please do not reply
                        directly to this email.</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
