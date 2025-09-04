<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
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
        .contact-details {
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
        .message-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
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
            <h1>New Contact Message</h1>
        </div>

        <p>A new contact message has been submitted through the website.</p>

        <div class="contact-details">
            <h3>Contact Details:</h3>
            
            <div class="detail-row">
                <span class="label">Contact ID:</span>
                <span class="value">#{{ $contact->id }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Name:</span>
                <span class="value">{{ $contact->name }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value">{{ $contact->email }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Phone:</span>
                <span class="value">{{ $contact->phone }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Submitted:</span>
                <span class="value">{{ $contact->created_at ? $contact->created_at->format('d/m/Y H:i') : 'N/A' }}</span>
            </div>
        </div>

        <div class="contact-details">
            <h3>Message:</h3>
            <div class="message-box">
                {{ $contact->message }}
            </div>
        </div>

        <p><strong>Please respond to this customer inquiry as soon as possible.</strong></p>

        <div class="footer">
            <p>This email was sent automatically from the Tawasul Limousine contact system.</p>
        </div>
    </div>
</body>
</html>