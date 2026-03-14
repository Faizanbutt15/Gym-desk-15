<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #D90429; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #D90429; }
        .footer { text-align: center; font-size: 0.8rem; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Message from Gymdesk15</h1>
        </div>
        <div class="content">
            <div class="field">
                <span class="label">Name:</span> {{ $name }}
            </div>
            <div class="field">
                <span class="label">Email:</span> {{ $email }}
            </div>
            <div class="field">
                <span class="label">Message:</span><br>
                <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 5px;">
                    {{ $userMessage }}
                </div>
            </div>
        </div>
        <div class="footer">
            Sent via Gymdesk15 Landing Page
        </div>
    </div>
</body>
</html>
