<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Account Status Updated</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
        <tr>
            <td style="background: linear-gradient(to right, #2563eb, #1d4ed8); padding: 16px 24px; color: #ffffff;">
                <h1 style="margin: 0; font-size: 20px;">{{ config('app.name') }} &mdash; Staff Account Status</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 24px;">
                <p style="font-size: 14px; color: #111827; margin-bottom: 16px;">
                    Hi {{ $user->name }},
                </p>

                @if($isActive)
                    <p style="font-size: 14px; color: #111827; margin-bottom: 12px;">
                        Your staff account has been <strong style="color: #16a34a;">activated</strong> by the administrator.
                    </p>
                    <p style="font-size: 14px; color: #4b5563; margin-bottom: 12px;">
                        You can now sign in and access your staff dashboard.
                    </p>
                @else
                    <p style="font-size: 14px; color: #111827; margin-bottom: 12px;">
                        Your staff account has been <strong style="color: #b91c1c;">deactivated</strong> by the administrator.
                    </p>
                    <p style="font-size: 14px; color: #4b5563; margin-bottom: 12px;">
                        You will not be able to sign in until your account is reactivated. If you believe this is a mistake, please contact the administrator.
                    </p>
                @endif

                <p style="font-size: 13px; color: #6b7280; margin-top: 24px;">
                    Regards,<br>
                    {{ config('app.name') }} Team
                </p>
            </td>
        </tr>
    </table>
</body>
</html>


