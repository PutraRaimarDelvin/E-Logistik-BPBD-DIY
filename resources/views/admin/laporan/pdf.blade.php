<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BAST BPBD DIY</title>

    <style>

    @font-face {
        font-family: 'NotoSansJavanese';
        src: url('{{ public_path("fonts/NotoSansJavanese-Regular.ttf") }}') format('truetype');
    }

    @font-face {
        font-family: 'NotoSansJavanese';
        src: url('{{ public_path("fonts/NotoSansJavanese-Bold.ttf") }}') format('truetype');
        font-weight: bold;
    }

    body {
        font-family: "Times New Roman", serif;
        font-size: 11pt;
        margin: 25px 40px;
    }

    table { border-collapse: collapse; width: 100%; }

    .title {
        text-align: center;
        margin-top: 18px;
        margin-bottom: 15px;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
    }

    table.info td:first-child { width: 130px; font-weight: bold; }
    table.info td { padding: 2px 0; }

    table.barang th, table.barang td {
        border: 1px solid #000;
        padding: 4px;
        font-size: 10.5pt;
    }

    .ttd td {
        text-align: center;
    }
    </style>
</head>

<body>

@php
use Carbon\Carbon;
Carbon::setLocale('id');

$today = Carbon::now();
$hari = $today->translatedFormat('l');
$tanggal = intval($today->translatedFormat('d'));
$bulan = $today->translatedFormat('F');
$tahun = intval($today->translatedFormat('Y'));

// --- Fungsi konversi angka ke huruf ---
function terbilang($angka) {
    $huruf = [
        "", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam",
        "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
    ];

    if ($angka < 12) {
        return $huruf[$angka];
    } elseif ($angka < 20) {
        return terbilang($angka - 10) . " Belas";
    } elseif ($angka < 100) {
        return terbilang(intval($angka / 10)) . " Puluh " . terbilang($angka % 10);
    } elseif ($angka < 200) {
        return "Seratus " . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return terbilang(intval($angka / 100)) . " Ratus " . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return "Seribu " . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang(intval($angka / 1000)) . " Ribu " . terbilang($angka % 1000);
    }
}

// ============================
// VARIABEL FIX UNTUK DOMPDF
// ============================

$tanggalHuruf = terbilang((int)$tanggal);
$tahunHuruf = terbilang((int)$tahun);

$logoPath = public_path('images/icons/logopemda.png');
$logo = base64_encode(file_get_contents($logoPath));

$grandTotal = $laporan->items->sum(function ($i) {
    return ($i->total_harga ?? ($i->harga * $i->jumlah));
});
@endphp


<!-- ========================== KOP SURAT ========================== -->
<table border="0">
    <tr>
        <td width="3%"></td>

        <td width="15%" valign="middle">
            <img src="data:image/png;base64,{{ $logo }}" width="105">
        </td>

        <td width="78%" align="center">
            <div style="font-size:12pt;">PEMERINTAH DAERAH DAERAH ISTIMEWA YOGYAKARTA</div>
            <div style="font-size:15pt; font-weight:bold; margin-top:-3px;">
                BADAN PENANGGULANGAN BENCANA DAERAH
            </div>

            <div style="margin-top:-5px; margin-bottom:2px;">
                <img src="{{ public_path('images/icons/aksara.png') }}" style="width:500px;">
            </div>

            <div style="font-size:9pt; margin-top:-3px; line-height:1; text-align:center;">
                Alamat Jalan Kenari 14a Yogyakarta 55166;Telepon (0274) 555836; Faksimile (0274) 554206<br>
                Pos-el: bpbd@jogjaprov.go.id; Laman https://bpbd.jogjaprov.go.id/
            </div>

        </td>
    </tr>
</table>

<hr style="border:0; border-top:3px solid black; margin-top:1px; margin-bottom:20px;">


<!-- ========================== JUDUL ========================== -->
<div class="title">BERITA ACARA SERAH TERIMA</div>

<p style="text-align:center; margin-top:-10px; font-size:12pt;">
    <strong>Nomor : {{ $laporan->nomor_surat ?? '.......................................' }}</strong>
</p>


<!-- ========================== TANGGAL ========================== -->
<p style="text-align: justify;">
    Pada hari <strong>{{ $hari }}</strong> tanggal 
    <strong>{{ $tanggalHuruf }}</strong> 
    bulan <strong>{{ $bulan }}</strong> 
    Tahun <strong>{{ $tahunHuruf }}</strong>,
    yang bertanda tangan di bawah ini:
</p>


<!-- ========================== PIHAK KESATU ========================== -->
<table class="info">
    <tr><td>Nama</td><td>: AGUSTINUS RURUH HARYATA, S.H., S.T., M.Kes</td></tr>
    <tr><td>NIP</td><td>: 19720528 199003 1 003</td></tr>
    <tr><td>Jabatan</td><td>: KEPALA PELAKSANA BPBD DIY</td></tr>
    <tr><td>Alamat</td><td>: JL. KENARI NO. 14.A, YOGYAKARTA</td></tr>
    <tr><td>Telepon</td><td>: (0274) 555585</td></tr>
</table>

<p>Selanjutnya disebut sebagai <strong>PIHAK KESATU</strong>.</p>


<!-- ========================== PIHAK KEDUA ========================== -->
<table class="info">
    <tr><td>Nama</td><td>: {{ $laporan->nama }}</td></tr>
    <tr><td>NIK</td><td>: {{ $laporan->nik }}</td></tr>
    <tr><td>Jabatan</td><td>: {{ $laporan->jabatan }}</td></tr>
    <tr><td>Instansi</td><td>: {{ $laporan->instansi }}</td></tr>
    <tr><td>Telepon</td><td>: {{ $laporan->no_hp }}</td></tr>
</table>

<p style="text-align: justify; margin-bottom:3px;">
    Selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong>.
</p>


<!-- ========================== TABEL BARANG ========================== -->
<table class="barang">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Volume</th>
            <th>Harga (Rp)</th>
            <th>Jumlah Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan->items as $item)
        @php
            $jumlah = $item->jumlah ?? 0;
            $harga  = $item->harga ? intval($item->harga) : 0;
            $total  = $item->total_harga ? intval($item->total_harga) : ($jumlah * $harga);
        @endphp

        <tr>
            <td>{{ $loop->iteration }}</td>
<td>{{ $item->barang->kode_barang ?? '-' }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td>{{ $jumlah ?: '-' }}</td>
            <td>{{ $harga ? 'Rp '.number_format($harga,0,',','.') : '-' }}</td>
            <td>{{ $total ? 'Rp '.number_format($total,0,',','.') : '-' }}</td>
        </tr>
        @endforeach

        <tr>
            <td colspan="5" align="right"><strong>Total</strong></td>
            <td><strong>{{ $grandTotal ? 'Rp '.number_format($grandTotal,0,',','.') : '-' }}</strong></td>
        </tr>
    </tbody>
</table>


<p style="margin-top:10px; margin-bottom:4px; text-align: justify;">
    Dengan ditandatanganinya berita acara ini, pengelolaan, penggunaan, dan pendistribusian barang
    selanjutnya menjadi tanggung jawab <strong>PIHAK KEDUA</strong>.
</p>

<p style="margin-top:0; text-align: justify;">
    Demikian Berita Acara Serah Terima ini dibuat dan ditandatangani kedua belah pihak untuk digunakan sebagaimana mestinya.
</p>


<!-- ========================== TANDA TANGAN (TELAH DIPERBAIKI) ========================== -->
<div style="margin-top:40px;">
    <table width="100%" style="text-align:center;">
        <tr>

            <!-- PIHAK KEDUA -->
            <td width="50%" style="vertical-align:top;">
                <div style="font-size:10pt;">PIHAK KEDUA</div>

                <div style="height:55px;"></div>

                <div style="font-size:10pt;">
                    {{ $laporan->nama }}
                </div>
            </td>

            <!-- PIHAK KESATU -->
            <td width="50%" style="vertical-align:top;">

                <!-- ⚠️ BAGIAN INI SUDAH DIGANTI MENJADI ANGKA -->
                <div style="font-size:11pt; font-weight:bold; margin-top:-25px;">
                    Yogyakarta, {{ $tanggal }} {{ $bulan }} {{ $tahun }}
                </div>

                <div style="font-size:10pt; margin-top:5px;">PIHAK KESATU</div>

                <div style="height:55px;"></div>

                <div style="font-size:10pt;">
                    AGUSTINUS RURUH HARYATA, S.H., S.T., M.Kes
                </div>

            </td>

        </tr>
    </table>
</div>

</body>
</html>
