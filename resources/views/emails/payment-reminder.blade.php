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
            background: linear-gradient(135deg, #217093 0%, #1a5a78 100%);
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

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header-icon {
            display: inline-block;
            width: 80px;
            height: 80px;
            line-height: 80px;
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .header-icon img {
            width: 40px;
            height: 40px;
            vertical-align: middle;
            display: inline-block;
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
            color: #217093;
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
            background: linear-gradient(135deg, #217093 0%, #73BE5D 100%);
            border-radius: 2px;
        }

        /* Booking Details Card */
        .booking-details {
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

        /* Due Date Section */
        .due-date-box {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 2px solid #fcd34d;
            border-radius: 12px;
            padding: 24px;
            margin: 25px 0;
            text-align: center;
        }

        .due-date-box h3 {
            margin: 0 0 12px 0;
            color: #92400e;
            font-size: 18px;
            font-weight: 700;
        }

        .due-date-value {
            font-size: 24px;
            font-weight: 800;
            color: #b45309;
            margin-bottom: 8px;
        }

        .status-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            border: 1px solid #fcd34d;
        }

        /* CTA Section */
        .cta-section {
            text-align: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
        }

        .help-button {
            display: inline-block;
            background: linear-gradient(135deg, #217093 0%, #1a5a78 100%);
            color: #ffffff;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(33, 112, 147, 0.2);
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
            color: #217093;
            font-weight: 600;
        }

        @media (max-width: 600px) {
            .email-body { padding: 24px 16px; }
            .email-header { padding: 30px 20px; }
            .detail-row { flex-direction: column; gap: 6px; }
            .detail-value { text-align: left; }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Logo Section -->
            <div class="logo-section">
                @if(isset($logoPath) && $logoPath)
                    <img src="{{ $message->embed($logoPath) }}" alt="JE Travel & Tours Logo">
                @else
                    <h2 style="color: #217093;">JE Travel & Tours</h2>
                @endif
            </div>

            <!-- Header -->
            <div class="email-header">
                <div class="header-content">
                    <div class="header-icon">
                        @if(isset($iconPath) && $iconPath)
                            <img src="{{ $message->embed($iconPath) }}" width="40" height="40" alt="Reminder">
                        @endif
                    </div>
                    <h1>Payment Reminder</h1>
                    <p>Action required to confirm your reservation</p>
                </div>
            </div>

            <!-- Body -->
            <div class="email-body">
                <div class="greeting">
                    <p>Dear <strong>{{ $booking->customer_name }}</strong>,</p>
                    <p>This is a reminder that the payment for your <span style="color: #217093; font-weight: 600;">{{ $packageName }} - {{ $duration }} Day/s</span> tour on <strong>{{ $travelDate }}</strong> is due in <strong>{{ $cancellationDays }} days</strong>.</p>
                </div>

                <!-- Due Date Box -->
                <div class="due-date-box">
                    <h3>Payment Due Date</h3>
                    <div class="due-date-value">{{ $dueDate }}</div>
                    <div class="status-badge">Awaiting Final Payment</div>
                </div>

                <p style="font-size: 14px; color: #4b5563; margin-bottom: 20px;">To ensure your reservation remains confirmed and to avoid automatic cancellation, please settle your balance by the due date. If payment is not received, your slots will be released.</p>

                <!-- Booking Information -->
                <div class="section-title">Booking Details</div>
                <div class="booking-details">
                    <div class="detail-row">
                        <span class="detail-label">Booking Reference</span>
                        <span class="detail-value">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Travel Date</span>
                        <span class="detail-value">{{ $travelDate }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Amount</span>
                        <span class="detail-value" style="color: #217093; font-weight: 700;">₱{{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="contact-info">
                    <h3>Need Assistance?</h3>
                    <p>If you have any questions about this reminder or your reservation, our support team is here to help:</p>
                    <p style="margin-top: 16px;">
                        <strong>Email:</strong> traveller.laguna@gmail.com | jetravelandtours@gmail.com<br>
                        <strong>Phone:</strong> +63 939 521 8437<br>
                        <strong>Hours:</strong> 8:00 AM - 5:00 PM (Mon-Fri)
                    </p>
                </div>

                <!-- CTA Section -->
                <div class="cta-section">
                    <p style="font-size: 12px; color: #9ca3af;">If you have already settled your payment, please ignore this email.</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <div class="footer-content">
                    <strong>JE Travel & Tours</strong><br>
                    <span>© 2025 All Rights Reserved</span><br>
                    <span style="color: #9ca3af; font-size: 11px;">traveller.laguna@gmail.com | +63 939 521 8437</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
