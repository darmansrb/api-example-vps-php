<?php
// 1. Atur Timezone ke Asia/Makassar (WITA)
date_default_timezone_set('Asia/Makassar');

// Set header agar response dibaca sebagai JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// 2. Fungsi untuk mencatat log
function writeLog($message)
{
  // Menggunakan __DIR__ agar file access.log berada di dalam folder 'samsat'
  $logFile = __DIR__ . '/access.log';
  $timestamp = date('Y-m-d H:i:s');
  $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

  // Format log: [2026-06-01 22:15:30] [IP: 192.168.1.5] Pesan Log
  $logData = sprintf("[%s] [IP: %s] %s\n", $timestamp, $ipAddress, $message);

  // Tulis ke file (APPEND jika file sudah ada)
  file_put_contents($logFile, $logData, FILE_APPEND);
}

try {
  // Data yang akan dikirim ke Jetpack Compose
  $responseData = [
    "url_live" => "https://dash.bpad.nttprov.go.id",
    // "url_live" => "https://bepungsekolahdev.dthrees.my.id/samsatproxy.php",
    "saldo_reward" => 1
  ];

  // Encode array menjadi JSON string
  $jsonResponse = json_encode($responseData);

  // Catat log sukses akses beserta isi JSON response
  writeLog("SUCCESS: Cek URL. Response: " . $jsonResponse);

  // Kirim response ke Android
  http_response_code(200);
  echo $jsonResponse;

} catch (Exception $e) {
  // Susun response error
  $errorResponse = [
    "status" => false,
    "message" => "Internal Server Error"
  ];

  // Encode array error menjadi JSON string
  $jsonError = json_encode($errorResponse);

  // Catat log error dari Exception beserta isi JSON error yang dikirim
  writeLog("ERROR: " . $e->getMessage() . " | Response: " . $jsonError);

  http_response_code(500);
  echo $jsonError;
}