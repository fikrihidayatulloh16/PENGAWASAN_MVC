<?php
// Path folder penyimpanan
$folderPath = '../public/assets/img/operator/laporan_mingguan/';

// Mengambil data POST
$postData = file_get_contents("php://input");
$request = json_decode($postData);

// Mengambil data gambar dari base64
$image_parts = explode(";base64,", $request->image);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);

// Menyimpan gambar ke dalam file dengan nama unik
$fileName = uniqid() . '.png';
$file = $folderPath . $fileName;

file_put_contents($file, $image_base64);

echo json_encode([
    "success" => true,
    "message" => "Gambar berhasil disimpan.",
    "file" => $file
]);
?>