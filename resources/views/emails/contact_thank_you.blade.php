@php
    /** @var \App\Models\ContactMessage $contactMessage */
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank you for contacting {{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 10px 25px rgba(15,23,42,0.08);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#2563eb,#4f46e5);padding:24px 32px;color:#ffffff;">
                            <h1 style="margin:0;font-size:24px;font-weight:700;">
                                Thank you for contacting {{ config('app.name') }}
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 32px;color:#111827;font-size:14px;line-height:1.6;">
                            <p style="margin-top:0;">
                                Hi {{ $contactMessage->name }},
                            </p>
                            <p>
                                We’ve received your message and our support team will review it shortly. You can expect a response at
                                <strong>{{ $contactMessage->email }}</strong> as soon as possible.
                            </p>

                            <p style="margin-top:16px;margin-bottom:8px;font-weight:600;">Here’s a copy of what you sent:</p>
                            <p style="margin:0 0 4px 0;"><strong>Subject:</strong> {{ $contactMessage->subject }}</p>
                            @if($contactMessage->order_id)
                                <p style="margin:0 0 4px 0;"><strong>Order ID:</strong> {{ $contactMessage->order_id }}</p>
                            @endif
                            <p style="white-space:pre-line;border-left:3px solid #e5e7eb;padding-left:12px;margin-top:8px;">
                                {{ $contactMessage->message }}
                            </p>

                            <p style="margin-top:24px;">
                                If you have any additional details to add, you can simply reply to this email.
                            </p>

                            <p style="margin-top:24px;margin-bottom:0;">
                                Best regards,<br>
                                The {{ config('app.name') }} Team
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 32px;background-color:#f9fafb;color:#6b7280;font-size:12px;text-align:center;">
                            This is an automated message from {{ config('app.name') }}. Please do not share sensitive information such as passwords.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>


