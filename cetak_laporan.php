<?php
require('fpdf/fpdf.php');
include "config/db.php";

// 1. Inisialisasi FPDF (P = Portrait, mm = milimeter, A4 = ukuran kertas)
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// 2. Header Laporan
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'LAPORAN BARANG HILANG & TEMUAN', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(190, 10, 'Dicetak pada: ' . date('d-m-Y H:i'), 0, 1, 'C');
$pdf->Ln(10);

// 3. Header Tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 200, 200); // Warna abu-abu untuk header
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Nama Barang', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Kategori', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Lokasi', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Status', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Pelapor', 1, 1, 'C', true);

// 4. Ambil Data dari Database (JOIN 3 Tabel)
$pdf->SetFont('Arial', '', 9);
$query = "SELECT items.*, categories.nama_kategori, users.nama 
          FROM items 
          JOIN categories ON items.category_id = categories.id 
          JOIN users ON items.user_id = users.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$no = 1;
foreach ($data as $row) {
    $pdf->Cell(10, 8, $no++, 1, 0, 'C');
    $pdf->Cell(50, 8, $row['judul_laporan'], 1);
    $pdf->Cell(35, 8, $row['nama_kategori'], 1);
    $pdf->Cell(40, 8, $row['lokasi'], 1);
    $pdf->Cell(25, 8, ucfirst($row['status']), 1, 0, 'C');
    $pdf->Cell(30, 8, $row['nama'], 1, 1);
}

// 5. Output PDF (I = Preview di browser)
$pdf->Output('I', 'Laporan_Lost_Found.pdf');
?>