<?php

//	Instruksi Kerja Nomor 1.
//	Variabel $mobil berisi data jenis mobil yang dipesan dalam bentuk array satu dimensi.
//  ....
$mobil = array(
	"Toyota",
	"Honda",
	"Nissan"
);

//	Instruksi Kerja Nomor 2.
//	Mengurutkan array $mobil secara Ascending.
//  ....
sort($mobil);

//	Instruksi Kerja Nomor 5.
//	Baris Komentar: ......
//Alessandro Pramudhita Putra Setyawan - Universitas Gunadarma
?>

<!DOCTYPE html>
<html>

<head>
	<title>Pemesanan Taxi Online</title>
	<!-- Instruksi Kerja Nomor 3. -->
	<!-- Menghubungkan dengan library/bserkas CSS. -->
	<link rel="stylesheet" href="assets/bootstrap.css">
</head>

<body class="bg-primary">
	<div class="card container border bg-warning">
		<!-- Instruksi Kerja Nomor 4. -->
		<div class="row align-items-center mb-5">
			<div class="col-lg-6 d-flex mt-4">
				<!-- Menampilkan logo Taxi Online -->
				<img src="assets/logo.png" alt="logo" class="img-thumbnail mx-3" style="width:150px; height:100px">
				<h3 class="text-center mt-4">Pemesanan Taxi Online</h3>
			</div>
		</div>

		<!-- Form untuk memasukkan data pemesanan. -->
		<form action="index.php" method="post" id="formPemesanan">
			<div class="row form-group align-items-center">
				<!-- Masukan data nama pelanggan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Nama Pelanggan:</label></div>
				<div class="col-lg-2"><input class="form-control" type="text" id="nama" name="nama"></div>
			</div>
			<div class="row form-group align-items-center">
				<!-- Masukan data nomor HP pelanggan. Tipe data number. -->
				<div class="col-lg-2"><label for="nomor">Nomor HP:</label></div>
				<div class="col-lg-2"><input class="form-control" type="number" id="noHP" name="noHP" maxlength="16"></div>
			</div>
			<div class="row form-group align-items-center">
				<!-- Masukan pilihan jenis mobil. -->
				<div class="col-lg-2"><label for="tipe">Jenis Mobil:</label></div>
				<div class="col-lg-2">
					<select class="form-control" id="mobil" name="mobil">
						<option value="">- Jenis mobil -</option>
						<?php
						//	Instruksi Kerja Nomor 6.
						//	Menampilkan dropdown pilihan jenis mobil Taxi Online berdasarkan data pada array $mobil menggunakan perulangan.
						foreach ($mobil as $jenis) {
							echo "<option value='" . $jenis . "'>" . $jenis . "</option>";
						}
						?>
					</select>
				</div>
			</div>

			<div class="row form-group align-items-center">
				<!-- Masukan data Jarak Tempuh. Tipe data number. -->
				<div class="col-lg-2"><label for="nomor">Jarak:</label></div>
				<div class="col-lg-2"><input class="form-control" type="number" id="jarak" name="jarak" maxlength="4"></div>
			</div>
			<div class="row form-group align-items-center">
				<!-- Tombol Submit -->
				<div class="col-lg-2 col-lg-12 d-flex justify-content-center"><button class="btn btn-primary mt-4 px-5" type="submit" form="formPemesanan" value="Pesan" name="Pesan">Pesan</button></div>
			</div>
		</form>
	</div>
	<?php
	//	Kode berikut dieksekusi setelah tombol Hitung ditekan.
	if (isset($_POST['Pesan'])) {
		//	Variabel $dataPesanan berisi data-data pemesanan dari form dalam bentuk array.
		global $biaya;
		$dataPesanan = array(
			'nama' => $_POST['nama'],
			'noHP' => $_POST['noHP'],
			'mobil' => $_POST['mobil'],
			'jarak' => $_POST['jarak']
		);
		$jarak_tempuh = $_POST['jarak'];

		// Instruksi Kerja Nomor 7 (Percabangan)
		// Gunakan pencabangan untuk menghitung biaya sewa taksi berdasarkan $jarak_tempuh
		// Gunakan fungsi hitung_sewa untuk menghitung biaya sewa taksi sesuai INSTRUKSI KERJA #8
		// Simpan hasil penghitungan biaya sewa dalam variabel $tagihan sesuai INSTRUKSI KERJA #9
		function hitung_sewa($jarak_tempuh, $biaya)
		{
			if ($jarak_tempuh <= 10) {
				$biaya = 1000 * $jarak_tempuh;
			} elseif ($jarak_tempuh > 10) {
				$biaya = 10000 + ($jarak_tempuh - 10) * 5000;
			}
			return $biaya;
		}
		$tagihan = hitung_sewa($jarak_tempuh, $biaya);


		//	Variabel berisi path file data.json yang digunakan untuk menyimpan data pemesanan.
		$berkas = "data.json";

		//	Mengubah data pemesanan yang berbentuk array PHP menjadi bentuk JSON.
		$dataJson = json_encode($dataPesanan, JSON_PRETTY_PRINT);

		//	Instruksi Kerja Nomor 10.
		//	Menyimpan data pemesanan yang berbentuk JSON ke dalam file JSON
		file_put_contents($berkas, $dataJson);
		$dataJson = file_get_contents($berkas, JSON_PRETTY_PRINT);

		//	Mengubah data pemesanan dalam format JSON ke dalam format array PHP.
		$dataPesanan = json_decode($dataJson, true);


		//	Menampilkan data pemesanan dan total biaya sewa.
		//  KODE DI BAWAH INI TIDAK PERLU DIMODIFIKASI!!!
		echo "
				<br/>
				<div class='container bg-success'>
			<table class='table text-white'>
				<thead class=''>
				<tr>
						<th scope='row'>Nama Pelanggan:</th>
						<th scope='row'>Nomor Hp:</th>
						<th scope='row'>Jenis Mobil:</th>
						<th scope='row'>Jarak(Km):</th>
						<th scope='row'>Total:</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td>" . $dataPesanan['nama'] . "</td>
						<td>" . $dataPesanan['noHP'] . "</td>
						<td>" . $dataPesanan['mobil'] . "</td>
						<td>" . $dataPesanan['jarak'] . " km</td>								
						<td>Rp" . number_format($tagihan, 0, ".", ".") . ",-</td>
					</tr>
				</tbody>
			</table>
		</div>
			";
	}

	?>
</body>

</html>