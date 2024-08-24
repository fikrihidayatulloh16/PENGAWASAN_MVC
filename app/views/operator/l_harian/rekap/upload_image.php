<?php
if (isset($_POST['image']) && isset($_POST['filename'])) {
    $dataURL = $_POST['image'];
    $filename = $_POST['filename'];

    // Menghapus awalan data URL (data:image/png;base64,)
    $data = explode(',', $dataURL);
    $imageData = base64_decode($data[1]);

    // Tentukan path penyimpanan gambar
    $uploadDir = 'uploads/'; // Pastikan folder ini sudah ada dan writable
    $filePath = $uploadDir . $filename;

    // Simpan file gambar
    if (file_put_contents($filePath, $imageData)) {
        echo 'Image saved as ' . $filename;
    } else {
        echo 'Failed to save image.';
    }
} else {
    echo 'No image data received.';
}
?>
