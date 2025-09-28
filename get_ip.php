<?php
// إعدادات البوت - استبدل "YOUR_BOT_TOKEN" و "YOUR_CHAT_ID" بقيمك الخاصة
$botToken = '8129945765:AAGBdahD8dxp591kbYxupCJyOpo02b5YGKE';
$chatId = '-1003118945681'; // معرف الدردشة الخاص بك على Telegram

// الحصول على عنوان IP الزائر
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

// معلومات إضافية عن الزائر
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$time = date('Y-m-d H:i:s');
$message = "🆕 زائر جديد للموقع!\n"
         . "⏰ الوقت: $time\n"
         . "🌐 عنوان IP: $ip\n"
         . "🔍 المتصفح: $userAgent";

// إرسال الرسالة إلى Telegram باستخدام واجهة برمجة التطبيقات (API)
$telegramApiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";
$data = http_build_query([
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'HTML' // اختياري لتنسيق النص
]);

// تهيئة طلب cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $telegramApiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// تنفيذ الطلب
$response = curl_exec($ch);
curl_close($ch);

// إرجاع صورة شفافة (1x1 pixel) لتجنب ظهور أخطاء في الصفحة
header('Content-Type: image/png');
echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=');
?>
