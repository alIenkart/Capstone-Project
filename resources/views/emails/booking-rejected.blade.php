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

        .detail-value.price {
            color: #1E71B8;
            font-weight: 700;
            font-size: 15px;
        }

        /* Rejection Reason */
        .rejection-reason {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 2px solid #fecaca;
            border-radius: 12px;
            padding: 24px;
            margin: 25px 0;
        }

        .rejection-reason h3 {
            margin: 0 0 16px 0;
            color: #dc2626;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rejection-category {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            display: inline-block;
        }

        .rejection-category-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #991b1b;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .rejection-category-value {
            font-size: 14px;
            font-weight: 600;
            color: #7f1d1d;
        }

        .rejection-reason p {
            margin: 0;
            color: #7f1d1d;
            line-height: 1.7;
            font-size: 14px;
        }

        .rejection-reason .additional-notes-label {
            font-size: 12px;
            font-weight: 600;
            color: #991b1b;
            margin-bottom: 8px;
            display: block;
        }

        /* Remarks Section */
        .remarks-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 24px;
            margin: 20px 0;
        }

        .remarks-section h3 {
            margin: 0 0 12px 0;
            color: #0369a1;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remarks-section p {
            margin: 0;
            color: #164e63;
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

        .help-button {
            display: inline-block;
            background: linear-gradient(135deg, #1E71B8 0%, #1557a0 100%);
            color: #ffffff;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(30, 113, 184, 0.2);
        }

        .help-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 113, 184, 0.3);
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <h1>Booking Rejected</h1>
                    <p>Your booking application has been reviewed</p>
                </div>
            </div>

            <!-- Body -->
            <div class="email-body">
                <div class="greeting">
                    <p>Dear <strong>{{ $booking->customer_name }}</strong>,</p>
                    <p>Thank you for your interest in our tour packages. Unfortunately, after careful review, your
                        booking
                        application has been <strong>rejected</strong>. Please see the details and reason below.</p>
                </div>

                <!-- Booking Details -->
                <div class="section-title">Booking Information</div>
                <div class="booking-details">
                    <div class="detail-row">
                        <span class="detail-label">Booking Reference</span>
                        <span class="detail-value">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Package Destination</span>
                        <span class="detail-value">{{ $booking->package_destination ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Tour Type</span>
                        <span class="detail-value">{{ $booking->tour_type ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Duration</span>
                        <span class="detail-value">{{ $booking->duration ?? 'N/A' }} Days</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Number of Travelers</span>
                        <span class="detail-value">{{ $booking->total_quantity }} Person(s)</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Travel Date</span>
                        <span class="detail-value">{{ $booking->travel_date?->format('F d, Y') ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Total Amount</span>
                        <span class="detail-value price">₱{{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>

                <!-- Rejection Reason -->
                <div class="rejection-reason">
                    <h3>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        Rejection Reason
                    </h3>
                    
                    @if($booking->rejection_category)
                        <div class="rejection-category">
                            <div class="rejection-category-label">Category</div>
                            <div class="rejection-category-value">{{ $booking->rejection_category }}</div>
                        </div>
                    @endif

                    @if($booking->rejection_reason || $booking->rejection_category === 'Past Due Payment')
                        <span class="additional-notes-label">Additional Details:</span>
                        <p>
                            @if($booking->rejection_category === 'Past Due Payment')
                                Your reservation has been automatically cancelled as the required payment was not received by the deadline.
                            @else
                                {{ $booking->rejection_reason }}
                            @endif
                        </p>
                    @endif
                </div>

                <!-- Remarks (if any) -->
                @if($booking->remarks && $booking->rejection_category !== 'Past Due Payment')
                    <div class="remarks-section">
                        <h3>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Additional Notes
                        </h3>
                        <p>{{ $booking->remarks }}</p>
                    </div>
                @endif

                <!-- Contact Information -->
                <div class="contact-info">
                    <h3>Need Assistance?</h3>
                    <p>If you have any questions about this rejection or would like to book another tour, our support
                        team is here to help:</p>
                    <p style="margin-top: 16px;">
                        <strong>Email:</strong> traveller.laguna@gmail.com | jetravelandtours@gmail.com<br>
                        <strong>Phone:</strong> +63 939 521 8437<br>
                        <strong>Hours:</strong> 8:00 AM - 5:00 PM (Mon-Fri)
                    </p>
                </div>

                <!-- CTA Section -->
                <div class="cta-section">
                    <p class="cta-text">We appreciate your interest and hope to welcome you on a future tour. Feel free
                        to explore our other available packages!</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <div class="footer-content">
                    <strong>JE Travel & Tours</strong>
                    <span class="footer-divider">•</span>
                    <span>© 2025 All Rights Reserved</span>
                    <br>
                    <span style="color: #9ca3af; font-size: 12px;">This is an automated message, please do not reply
                        directly to this email.</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>