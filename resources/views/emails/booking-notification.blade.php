<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        h1 {
            color: #000;
            margin-bottom: 20px;
        }
        .booking-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://lh3.googleusercontent.com/d/1mDZyI13k_gSVuBae6JT-P_nN3FBgBxQM" alt="Tawasul Limousine" class="logo">
            <h1>New Booking Request</h1>
        </div>

        <p>A new booking request has been submitted through the website.</p>

        <div class="booking-details">
            <h3>Booking Details:</h3>
            
            <div class="detail-row">
                <span class="label">Booking ID:</span>
                <span class="value">#{{ $booking->id }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Customer Name:</span>
                <span class="value">{{ $booking->customer_name }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value">{{ $booking->customer_email }}</span>
            </div>

            @if($booking->customer_phone)
            <div class="detail-row">
                <span class="label">Phone:</span>
                <span class="value">{{ $booking->customer_phone }}</span>
            </div>
            @endif

            <div class="detail-row">
                <span class="label">City:</span>
                <span class="value">{{ $booking->city }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Date:</span>
                <span class="value">{{ $booking->date->format('d/m/Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Time:</span>
                <span class="value">{{ $booking->time->format('H:i') }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Pickup Location:</span>
                <span class="value">{{ $booking->pickup_location }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Drop-off Location:</span>
                <span class="value">{{ $booking->dropoff_location }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Submitted:</span>
                <span class="value">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <p><strong>Please contact the customer as soon as possible to confirm the booking details and provide pricing information.</strong></p>

        <div class="footer">
            <p>This email was sent automatically from the Tawasul Limousine booking system.</p>
        </div>
    </div>
</body>
</html>