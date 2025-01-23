<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 20px; margin: 0;">
    <!-- Container -->
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <!-- Header -->
        <div style="background-color: #4f46e5; color: #ffffff; text-align: center; padding: 20px;">
            <h1 style="margin: 0; font-size: 24px; font-weight: bold;">New Contact Message</h1>
        </div>

        <!-- Content -->
        <div style="padding: 20px; color: #374151;">
            <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">
                <strong>Name:</strong> <span style="color: #4f46e5;">{{ $name }}</span>
            </p>
            <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">
                <strong>Email:</strong> <a href="mailto:{{ $email }}" style="color: #4f46e5; text-decoration: none;">{{ $email }}</a>
            </p>
            <p style="font-size: 16px; line-height: 1.5; margin-bottom: 10px;">
                <strong>Message:</strong>
            </p>
            <p style="font-size: 16px; line-height: 1.5; background-color: #f9fafb; padding: 15px; border-left: 4px solid #4f46e5; border-radius: 4px; margin: 0;">
                {{ $text }}
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f3f4f6; text-align: center; padding: 10px; font-size: 14px; color: #6b7280;">
            <p style="margin: 0;">&copy; 2025 Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
