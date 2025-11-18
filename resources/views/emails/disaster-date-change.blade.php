<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urgent Travel Advisory: Schedule Change Required</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: 700;
        }
        .header p {
            font-size: 14px;
            opacity: 0.95;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            margin-bottom: 20px;
            font-size: 16px;
            color: #1f2937;
        }
        .intro-text {
            margin-bottom: 20px;
            font-size: 14px;
            color: #374151;
            line-height: 1.8;
        }
        .alert-box {
            background-color: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .alert-box strong {
            color: #991b1b;
            display: block;
            margin-bottom: 8px;
        }
        .alert-box p {
            font-size: 14px;
            color: #7f1d1d;
        }
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .booking-details {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #e5e7eb;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
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
        .reason-section {
            background-color: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
        }
        .reason-section strong {
            color: #1f2937;
            display: block;
            margin-bottom: 10px;
        }
        .reason-section p {
            color: #374151;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        .safety-notice {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .safety-notice strong {
            color: #92400e;
            display: block;
            margin-bottom: 8px;
        }
        .safety-notice p {
            font-size: 14px;
            color: #b45309;
        }
        .action-section {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .action-section h3 {
            color: #1e40af;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 600;
        }
        .contact-info {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            font-size: 14px;
        }
        .contact-info p {
            margin-bottom: 8px;
            color: #374151;
        }
        .contact-info strong {
            color: #1f2937;
            font-weight: 600;
        }
        .contact-line {
            margin-bottom: 10px;
        }
        .contact-line:last-child {
            margin-bottom: 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        .footer p {
            margin-bottom: 8px;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 20px 0;
        }
        .closing-text {
            margin-bottom: 15px;
            font-size: 14px;
            color: #1f2937;
            line-height: 1.8;
        }
        .highlight {
            color: #dc2626;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Urgent Travel Advisory</h1>
            <p>Schedule Change Required</p>
        </div>

        <div class="content">
            <div class="greeting">
                <p>Dear <strong>{{ $customerName }},</strong></p>
            </div>

            <div class="intro-text">
                <p>We are writing to inform you that due to <span class="highlight">unforeseen circumstances affecting the safety and feasibility of your travel route</span>, we are unable to proceed with your tour on the originally scheduled date.</p>
                <p style="margin-top: 10px;"><strong>Your safety is our top priority.</strong> As per our safety protocols and government advisories, we must postpone the trip to a later date.</p>
            </div>

            <div class="alert-box">
                <strong>⚠️ Booking Status: Date Reschedule Required</strong>
                <p>Your booking remains valid, and your payment has been secured as a travel credit that can be applied to your new travel date.</p>
            </div>

            <h2 class="section-title">Booking Information</h2>
            <div class="booking-details">
                <div class="detail-row">
                    <span class="detail-label">Booking Reference</span>
                    <span class="detail-value">#{{ $bookingId }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Package Destination</span>
                    <span class="detail-value">{{ $packageName }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tour Type</span>
                    <span class="detail-value">{{ $booking->tour_type ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Original Travel Date</span>
                    <span class="detail-value">{{ $currentDate }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Number of Travelers</span>
                    <span class="detail-value">{{ $booking->total_quantity ?? 0 }} Person(s)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount</span>
                    <span class="detail-value">₱{{ number_format($booking->original_amount ?? 0, 2) }}</span>
                </div>
            </div>

            <h2 class="section-title">Reason for Schedule Change</h2>
            <div class="reason-section">
                <strong>Unforeseen Environmental or Safety Conditions:</strong>
                <p>To ensure the safety and well-being of all passengers and staff, this tour has been flagged for rescheduling due to <span class="highlight">Force Majeure</span> (e.g., inclement weather, natural disturbances, or urgent safety advisories).</p>
                @if($reason)
                    <p><strong>Additional Details:</strong> {{ $reason }}</p>
                @endif
            </div>

            <div class="safety-notice">
                <strong>✓ Your Payment is Protected</strong>
                <p>Your booking remains valid, and your payment has been secured as a travel credit. This credit can be used for your rescheduled travel date with no additional fees.</p>
            </div>

            <h2 class="section-title">Action Required: Contact Us Immediately</h2>
            <div class="action-section">
                <h3>We are currently prioritizing affected guests for re-booking.</h3>
                <p style="font-size: 14px; color: #1e40af; margin-bottom: 15px;">Please contact our support team as soon as possible to select your new travel date.</p>
                
                <div class="contact-info">
                    <div class="contact-line">
                        <strong>📧 Email:</strong>
                    </div>
                    <div class="contact-line" style="margin-left: 20px; margin-bottom: 15px;">
                        traveller.laguna@gmail.com<br>
                        jetravelandtours@gmail.com
                    </div>
                    <div class="contact-line">
                        <strong>📞 Phone:</strong>
                    </div>
                    <div class="contact-line" style="margin-left: 20px; margin-bottom: 15px;">
                        +63 939 521 8437
                    </div>
                    <div class="contact-line">
                        <strong>🕐 Hours of Operation:</strong>
                    </div>
                    <div class="contact-line" style="margin-left: 20px;">
                        8:00 AM - 5:00 PM (Monday - Friday)
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="closing-text">
                <p>We sincerely apologize for this inconvenience. We appreciate your understanding that this decision was made strictly for your safety and in compliance with government advisories.</p>
                <p style="margin-top: 10px;">If you have any questions or concerns, please don't hesitate to reach out to our customer support team immediately.</p>
            </div>

            <p style="font-size: 14px; color: #1f2937; font-weight: 600;">
                We look forward to rescheduling your memorable travel experience with us.
            </p>
        </div>

        <div class="footer">
            <p><strong>JE Travel & Tours</strong></p>
            <p>Providing Safe and Memorable Travel Experiences</p>
            <p style="margin-top: 15px; color: #9ca3af;">This is an automated notification. Please do not reply to this email.</p>
            <p style="color: #9ca3af;">© 2024 JE Travel & Tours. All Rights Reserved</p>
        </div>
    </div>
</body>
</html>