<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed & Paid - Rescheduling Notice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            line-height: 1.6;
            color: #2d3748;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 620px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }
        .header p {
            font-size: 14px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
            font-weight: 300;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            margin-bottom: 25px;
            font-size: 16px;
            color: #2d3748;
        }
        .greeting strong {
            color: #10b981;
        }
        .intro-text {
            margin-bottom: 30px;
            font-size: 15px;
            color: #4a5568;
            line-height: 1.8;
        }
        .status-badge {
            display: inline-block;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 4px solid #10b981;
            padding: 16px 20px;
            margin: 25px 0;
            border-radius: 8px;
            font-size: 14px;
            color: #065f46;
            font-weight: 500;
        }
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a202c;
            margin-top: 35px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
        }
        .section-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 24px;
            background: #10b981;
            border-radius: 2px;
            margin-right: 12px;
        }
        .booking-details {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            padding: 24px;
            border-radius: 12px;
            margin: 20px 0;
            border: 1px solid #e2e8f0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid #cbd5e0;
            font-size: 14px;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .detail-label {
            font-weight: 600;
            color: #718096;
        }
        .detail-value {
            color: #2d3748;
            font-weight: 500;
            text-align: right;
        }
        .reason-section {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 24px;
            border-radius: 12px;
            margin: 25px 0;
            border: 1px solid #bbf7d0;
            font-size: 14px;
        }
        .reason-section strong {
            color: #166534;
            display: block;
            margin-bottom: 12px;
            font-size: 15px;
        }
        .reason-section p {
            color: #15803d;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        .payment-protection {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 4px solid #3b82f6;
            padding: 18px 20px;
            margin: 25px 0;
            border-radius: 8px;
            font-size: 14px;
        }
        .payment-protection strong {
            color: #1e40af;
            font-weight: 600;
        }
        .payment-protection p {
            color: #1e3a8a;
            line-height: 1.7;
        }
        .action-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #7dd3fc;
            padding: 28px;
            border-radius: 12px;
            margin: 25px 0;
        }
        .action-section h3 {
            color: #0369a1;
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 600;
        }
        .action-section > p {
            font-size: 14px;
            color: #0c4a6e;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .contact-info {
            background: #ffffff;
            border: 1px solid #e0f2fe;
            padding: 18px;
            border-radius: 10px;
            margin: 15px 0;
            font-size: 14px;
        }
        .contact-info p {
            margin-bottom: 10px;
            color: #2d3748;
        }
        .contact-info strong {
            color: #1a202c;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 6px;
        }
        .contact-info .info-item {
            margin-bottom: 14px;
        }
        .contact-info .info-item:last-child {
            margin-bottom: 0;
        }
        .footer {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            padding: 25px;
            border-top: 1px solid #e2e8f0;
            font-size: 13px;
            color: #718096;
            text-align: center;
        }
        .footer p {
            margin-bottom: 6px;
        }
        .footer strong {
            color: #2d3748;
            font-weight: 600;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #cbd5e0, transparent);
            margin: 25px 0;
        }
        .closing-text {
            margin-bottom: 20px;
            font-size: 14px;
            color: #4a5568;
            line-height: 1.8;
        }
        .highlight {
            color: #10b981;
            font-weight: 700;
        }
        .checkmark {
            display: inline-block;
            width: 20px;
            height: 20px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
            margin-right: 8px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Confirmed & Paid</h1>
            <p>Rescheduling notice due to safety concerns</p>
        </div>

        <div class="content">
            <div class="greeting">
                <p>Dear <strong>{{ $customerName }},</strong></p>
            </div>

            <div class="intro-text">
                <p>We're pleased to confirm that your booking with <strong>JE Travel & Tours</strong> remains <span class="highlight">fully secured and paid</span>. Due to impending natural disasters or severe weather conditions, we're rescheduling your trip to ensure everyone's safety.</p>
                <p style="margin-top: 12px;"><strong>Your safety is our priority.</strong> Your payment is protected and will be applied to your new travel date at no additional cost.</p>
            </div>

            <div class="status-badge">
                <span class="checkmark">✓</span>Booking Status: <strong>CONFIRMED & FULLY PAID</strong>
            </div>

            <h2 class="section-title">Booking Details</h2>
            <div class="booking-details">
                <div class="detail-row">
                    <span class="detail-label">Booking Reference</span>
                    <span class="detail-value">#{{ $bookingId }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Destination</span>
                    <span class="detail-value">{{ $packageName }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tour Type</span>
                    <span class="detail-value">{{ $booking->tour_type ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Original Date</span>
                    <span class="detail-value">{{ $currentDate }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Travelers</span>
                    <span class="detail-value">{{ $booking->total_quantity ?? 0 }} Person(s)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount</span>
                    <span class="detail-value">₱{{ number_format($booking->original_amount ?? 0, 2) }}</span>
                </div>
            </div>

            <h2 class="section-title">Why We're Rescheduling</h2>
            <div class="reason-section">
                <strong>Natural Disaster / Force Majeure</strong>
                <p>Your safety and the safety of our team is non-negotiable. This tour has been rescheduled due to natural disaster risks including typhoon signals, flooding, and landslide warnings.</p>
                @if($reason)
                    <p><strong>Additional Details:</strong> {{ $reason }}</p>
                @endif
            </div>

            <div class="payment-protection">
                <strong>✓ Your Payment is Protected</strong>
                <p>Your booking is <strong>not cancelled</strong>—your <strong>full payment remains valid</strong> as a travel credit for your new date. <strong>No additional fees required.</strong></p>
            </div>

            <h2 class="section-title">Next Steps</h2>
            <div class="action-section">
                <h3>Let's Find Your Perfect Travel Date</h3>
                <p>Please contact us soon to select your new travel date. We're prioritizing your group for re-booking.</p>
                
                <div class="contact-info">
                    <div class="info-item">
                        <strong>📧 Email</strong>
                        <p>traveller.laguna@gmail.com<br>jetravelandtours@gmail.com</p>
                    </div>
                    <div class="info-item">
                        <strong>📞 Phone</strong>
                        <p>+63 939 521 8437</p>
                    </div>
                    <div class="info-item">
                        <strong>🕐 Business Hours</strong>
                        <p>Monday – Friday, 8:00 AM – 5:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="closing-text">
                <p>We sincerely apologize for this inconvenience. Your understanding means everything to us, and we're committed to making your rescheduled journey unforgettable.</p>
                <p style="margin-top: 12px;"><strong>Thank you for choosing JE Travel & Tours.</strong></p>
            </div>
        </div>

        <div class="footer">
            <p><strong>JE Travel & Tours</strong></p>
            <p>Crafting Safe & Memorable Travel Experiences</p>
            <p style="margin-top: 12px; color: #a0aec0;">This is an automated notification. Please do not reply to this email.</p>
            <p style="color: #a0aec0;">© 2024 JE Travel & Tours. All rights reserved.</p>
        </div>
    </div>
</body>
</html>