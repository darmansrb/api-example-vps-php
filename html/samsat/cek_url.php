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
  $logFile = dirname(__DIR__) . '/access.log';
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
    "url_live" => "https://bepungsekolahdev.dthrees.my.id/samsatproxy.php",
    "saldo_reward" => 1
  ];

  // Catat log sukses akses
  writeLog("SUCCESS: Jetpack Compose melakukan pengecekan URL.");

  // Kirim response ke Android
  http_response_code(200);
  echo json_encode($responseData);

} catch (Exception $e) {
  // Catat log jika terjadi error
  writeLog("ERROR: " . $e->getMessage());

  http_response_code(500);
  echo json_encode([
    "status" => false,
    "message" => "Internal Server Error"
  ]);
}