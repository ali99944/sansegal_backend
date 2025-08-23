<!DOCTYPE html>
<html lang="ar" dir="rtl" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <title>طلبك من San Segal تم تأكيده</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Your existing base styles can go here if needed */
        .hover-underline:hover { text-decoration: underline !important; }
        @media (max-width: 600px) {
            .sm-w-full { width: 100% !important; }
            .sm-px-24 { padding-left: 24px !important; padding-right: 24px !important; }
            .sm-py-32 { padding-top: 32px !important; padding-bottom: 32px !important; }
        }
    </style>
</head>
<body style="margin: 0; width: 100%; padding: 0; word-break: break-word; -webkit-font-smoothing: antialiased; background-color: #F5F5F5;">
    <div style="display: none;">شكرًا جزيلًا لطلبك من San Segal! طلبك قيد التنفيذ الآن.</div>
    <div role="article" aria-roledescription="email" aria-label="Order Confirmation" lang="ar">
        <table style="width: 100%; font-family: 'Cairo', sans-serif; " cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td align="center" style="background-color: #F5F5F5; padding-top: 24px; padding-bottom: 24px;">
                    <table class="sm-w-full" style="width: 600px;" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <td class="sm-py-32 sm-px-24" style="padding: 48px; text-align: center;">
                                <a href="{{ $settings['general.app_url'] ?? 'https://sansegal.com' }}">
                                    <img src="{{ $settings['general.logo_url'] ?? 'https://your-domain.com/assets/images/logo-dark.svg' }}" width="160" alt="San Segal" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle;">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="sm-px-24">
                                <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td class="sm-px-24" style="background-color: #ffffff; border-radius: 8px; padding: 48px; text-align: right;">
                                            <h1 style="font-family: 'Georgia', serif; font-size: 28px; font-weight: 700; line-height: 1.2; margin: 0 0 20px; color: #000000;">
                                                شكرًا لثقتك في San Segal
                                            </h1>
                                            <p style="margin: 0 0 24px; font-size: 16px; line-height: 1.6; color: #555555;">
                                                مرحبًا {{ $order->first_name }}، يسعدنا إعلامك بأننا قد استلمنا طلبك رقم <strong>{{ $order->order_code }}</strong> بنجاح. فريقنا بدأ في تجهيزه بكل حب وعناية، وسنقوم بإعلامك فور شحنه.
                                            </p>

                                            <a href="{{ url('/track-order?code=' . $order->order_code) }}" style="display: inline-block; text-decoration: none; background-color: #000000; border-radius: 6px; padding: 12px 20px; font-size: 14px; font-weight: 700; color: #ffffff;">
                                                عرض تفاصيل الطلب
                                            </a>

                                            <div style="line-height: 32px;">&zwnj;</div>

                                            <hr style="border: 0; height: 1px; background-color: #E0E0E0;">

                                            <div style="line-height: 32px;">&zwnj;</div>

                                            <h2 style="font-family: 'Georgia', serif; font-size: 22px; font-weight: 700; margin: 0 0 20px; color: #000000;">ملخص الطلب</h2>

                                            <!-- Order Items Loop -->
                                            @foreach($order->items as $item)
                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 16px;">
                                                <tr>
                                                    <td style="width: 72px; padding-right: 16px; vertical-align: top;">
                                                        <img src="{{ Storage::url($item->product_image) }}" alt="{{ $item->product_name }}" style="width: 72px; height: 72px; object-fit: cover; border-radius: 6px; border: 1px solid #E0E0E0;">
                                                    </td>
                                                    <td style="vertical-align: top;">
                                                        <p style="font-size: 16px; font-weight: 600; margin: 0 0 4px; color: #000000;">{{ $item->product_name }}</p>
                                                        <p style="font-size: 14px; margin: 0; color: #777;">الكمية: {{ $item->quantity }}</p>
                                                    </td>
                                                    <td style="text-align: left; vertical-align: top; font-weight: 600; font-size: 16px; color: #000000;">
                                                        {{ number_format($item->price * $item->quantity, 2) }} ج.م.
                                                    </td>
                                                </tr>
                                            </table>
                                            @endforeach
                                            <!-- End Loop -->

                                            <hr style="border: 0; height: 1px; background-color: #E0E0E0; margin-top: 24px;">

                                            <!-- Totals -->
                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top: 16px;">
                                                <tr>
                                                    <td style="padding: 4px 0; font-size: 14px; color: #555555;">المجموع الفرعي</td>
                                                    <td style="text-align: left; padding: 4px 0; font-size: 14px; color: #555555;">{{ number_format($order->subtotal, 2) }} ج.م.</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 4px 0; font-size: 14px; color: #555555;">الشحن</td>
                                                    <td style="text-align: left; padding: 4px 0; font-size: 14px; color: #555555;">{{ number_format($order->shipping_cost, 2) }} ج.م.</td>
                                                </tr>
                                                @if($order->promo_discount > 0)
                                                <tr>
                                                    <td style="padding: 4px 0; font-size: 14px; color: #1E88E5;">خصم ({{ $order->promo_code }})</td>
                                                    <td style="text-align: left; padding: 4px 0; font-size: 14px; color: #1E88E5;">-{{ number_format($order->promo_discount, 2) }} ج.م.</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td style="padding-top: 12px; font-size: 18px; font-weight: 700; color: #000000;">الإجمالي</td>
                                                    <td style="text-align: left; padding-top: 12px; font-size: 18px; font-weight: 700; color: #000000;">{{ number_format($order->grand_total, 2) }} ج.م.</td>
                                                </tr>
                                            </table>

                                            <div style="line-height: 32px;">&zwnj;</div>

                                            <hr style="border: 0; height: 1px; background-color: #E0E0E0;">

                                            <div style="line-height: 32px;">&zwnj;</div>

                                            <!-- Customer & Shipping Info -->
                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td style="vertical-align: top; padding-right: 16px; width: 50%;">
                                                        <h3 style="font-family: 'Georgia', serif; font-size: 18px; font-weight: 700; margin: 0 0 12px; color: #000000;">بيانات العميل</h3>
                                                        <p style="font-size: 14px; line-height: 1.6; margin: 0; color: #555555;">
                                                            {{ $order->first_name }} {{ $order->last_name }}<br>
                                                            {{ $order->email }}<br>
                                                            {{ $order->phone }}
                                                        </p>
                                                    </td>
                                                    <td style="vertical-align: top; width: 50%;">
                                                        <h3 style="font-family: 'Georgia', serif; font-size: 18px; font-weight: 700; margin: 0 0 12px; color: #000000;">عنوان الشحن</h3>
                                                        <p style="font-size: 14px; line-height: 1.6; margin: 0; color: #555555;">
                                                            {{ $order->address }}<br>
                                                            {{ $order->city }}, مصر
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 48px;"></td>
                                    </tr>
                                    <!-- Footer -->
                                    <tr>
                                        <td style="padding: 24px; text-align: center; font-size: 12px; color: #777777;">
                                            <p style="margin: 0 0 8px;">
                                                تابعنا على
                                                <a href="{{ $settings['social.instagram_url'] ?? '#' }}" class="hover-underline" style="color: #000000; text-decoration: none;">Instagram</a> &bull;
                                                <a href="{{ $settings['social.facebook_url'] ?? '#' }}" class="hover-underline" style="color: #000000; text-decoration: none;">Facebook</a>
                                            </p>
                                            <p style="margin: 0;">
                                                {{ str_replace('{year}', date('Y'), $settings['general.copyright_text'] ?? '© ' . date('Y') . ' San Segal. All Rights Reserved.') }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
