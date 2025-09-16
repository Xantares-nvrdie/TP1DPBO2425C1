<?php
require_once 'Elektronik.php';
session_start();

// Reset SESSION
if (isset($_POST['reset_data'])) {
    session_unset();
    session_destroy();
    header("Location: Main.php");
    exit(); //biar exit langsung page nya
}

// Inisialisasi session
if (!isset($_SESSION['daftarProduk'])) {
    $_SESSION['daftarProduk'] = []; //array
}

$message = '';
$message_type = '';

//helper cek ID
function isIdExists($id, $list) {
    foreach ($list as $item) //looping
    {
        if ($item->getId() === $id) //jika id ditemukan / tidak unik
        {
            return true;
        }
    }
    return false; //jika id unik
}

// Tambah produk
if (isset($_POST['tambah'])) {
    $id_produk = trim($_POST['id_produk']); //input
    $nama_produk = trim($_POST['nama_produk']); //input
    $stok = $_POST['stok']; //input
    $harga = $_POST['harga']; //input

    // Validasi input
    if (empty($id_produk) || empty($nama_produk) || !is_numeric($stok) || !is_numeric($harga) || $stok < 0 || $harga < 0) {
        $message = "❌ Input tidak valid. Pastikan ID dan Nama terisi, serta Stok dan Harga berupa angka positif.";
        $message_type = 'error';
    } elseif (isIdExists($id_produk, $_SESSION['daftarProduk'])) //mengecek id apakah unik atau tidak
    {
        //jika tidak unik
        $message = "❌ ID sudah ada. Gagal menambahkan produk.";
        $message_type = 'error';
    } else {
        //jika id valid
        // Upload gambar
        $gambar = '';
        if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] == 0) //jika gambar tidak error
        {
            $target_dir = "./images/"; //target folder
            if (!is_dir($target_dir)) mkdir($target_dir); //cek jika folder belum ada maka buat folder
            $target_file = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]); //inisialisasi nama gambar
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) //kirim file
            {
                $gambar = $target_file; //inisialisasi file gambar
            }
        }

        $produk_baru = new Elektronik($id_produk, $nama_produk, (int)$stok, (float)$harga, $gambar); //buat objek baru untuk dimasukkan ke array
        $_SESSION['daftarProduk'][] = $produk_baru; //inisialisasi ke array

        $message = "✅ Produk berhasil ditambahkan!"; //success message
        $message_type = 'success';
    }
}

// Hapus produk
if (isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
    $id_hapus = $_GET['id']; //ambil input id
    $_SESSION['daftarProduk'] = array_values(array_filter($_SESSION['daftarProduk'], fn($p) => $p->getId() !== $id_hapus)); //menyimpan array kecuali id yang ingin dihapus
    $message = "🗑️ Produk berhasil dihapus!"; //message success
    $message_type = 'success';
    header("Location: Main.php"); //balik ke page awal
    exit();
}

//function untuk update produk
function updateProduk($id_update) {
    global $message, $message_type;
    foreach ($_SESSION['daftarProduk'] as $produk) //looping ke semua elemen
    {
        if ($produk->getId() === $id_update) //jika id ditemukan
        {
            $id_baru = trim($_POST['id_baru']);
            $nama_baru = trim($_POST['nama_produk']);
            $stok_baru = $_POST['stok'];
            $harga_baru = $_POST['harga'];

            // Validasi input
            if (empty($nama_baru) || !is_numeric($stok_baru) || !is_numeric($harga_baru) || $stok_baru < 0 || $harga_baru < 0) {
                $message = "❌ Input tidak valid. Pastikan Nama terisi, serta Stok dan Harga berupa angka positif.";
                $message_type = 'error';
                return [$message, $message_type];
            }

            // update ID produk
            if (!empty($id_baru) && $id_baru !== $produk->getId())
            {
                if (isIdExists($id_baru, $_SESSION['daftarProduk'])) //jika input tidak valid
                {
                    //error
                    $message = "⚠️ ID baru sudah digunakan, ID tidak diubah.";
                    $message_type = 'warning';
                } else {
                    $produk->setId($id_baru); //jika input valid
                }
            }

            // update nama
            $produk->setNama($nama_baru);

            // update stok
            $produk->setStok((int)$stok_baru);

            // update harga
            $produk->setHarga((float)$harga_baru);

            // update gambar jika ada upload baru
            if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] == 0) {
                $target_dir = "./images/"; //folder yang dituju
                if (!is_dir($target_dir)) mkdir($target_dir); //cek apakah folder sudah ada, jika belum maka buat folder
                $target_file = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]);
                if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file))
                {
                    $produk->setGambar($target_file); //update path gambar
                }
            }
            
            // hanya tampilkan pesan sukses kalau tidak ada warning
            if ($message_type !== 'warning') {
                $message = "✏️ Produk berhasil diupdate!";
                $message_type = 'success';
            }

            return [$message, $message_type]; // langsung keluar dari fungsi
        }
    }
    $message = "Produk tidak ditemukan.";
    $message_type = 'error';
    return [$message, $message_type]; // kalau tidak ketemu produk
}

//eksekusi update
if (isset($_POST['update'])) {
    [$message, $message_type] = updateProduk($_POST['id_produk']); //proses update
}

// Cari produk
$hasil_cari = $_SESSION['daftarProduk'];
if (isset($_GET['cari'])) //cek apakah null atau tidak
{
    $id_cari = trim($_GET['cari_id']); //input
    $hasil_cari = array_values(array_filter($_SESSION['daftarProduk'], fn($p) => $p->getId() === $id_cari)); //cari id didalam array temp
    if (empty($hasil_cari)) {
        $message = "Produk dengan ID '$id_cari' tidak ditemukan.";
        $message_type = 'warning';
    }
}
// Fungsi untuk ambil produk berdasarkan ID
function getProdukById($id) {
    foreach ($_SESSION['daftarProduk'] as $produk) //looping ke semua elemen
    {
        if ($produk->getId() === $id) //jika id produk ditemukan
        {
            return $produk; // langsung kembalikan objek produk
        }
    }
    return null; // kalau tidak ketemu
}

$edit_id = $edit_nama = $edit_stok = $edit_harga = $edit_gambar = ''; //default
if (isset($_GET['edit_id'])) //jika edit id tidak null
{
    $produk = getProdukById($_GET['edit_id']); //cari objek
    if ($produk !== null) {
        $edit_id     = $produk->getId(); //mengambil value atribut
        $edit_nama   = $produk->getNama(); //mengambil value atribut
        $edit_stok   = $produk->getStok(); //mengambil value atribut
        $edit_harga  = $produk->getHarga(); //mengambil value atribut
        $edit_gambar = $produk->getGambar(); //mengambil value atribut
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Produk Elektronik</title>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 20px;
    min-height: 100vh;
    background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

.container {
    width: 100%;
    max-width: 1200px;
    background: rgba(255, 255, 255, 0.9);
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

h1 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 2.2rem;
    letter-spacing: 1px;
}

.message {
    padding: 14px;
    margin-bottom: 18px;
    border-radius: 8px;
    font-weight: bold;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.success {
    background: #d4edda;
    color: #155724;
}

.error {
    background: #f8d7da;
    color: #721c24;
}

.warning {
    background: #fff3cd;
    color: #856404;
}

form {
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: #fdfdfd;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #eee;
}

form input,
form button {
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
    transition: 0.3s ease;
}

form input:focus {
    border-color: #6c5ce7;
    outline: none;
    box-shadow: 0 0 6px rgba(108, 92, 231, 0.3);
}

form button {
    cursor: pointer;
    font-weight: bold;
    border: none;
    transition: transform 0.2s ease, opacity 0.2s ease;
}

form button:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

.btn-tambah {
    background: #2ecc71;
    color: white;
}

.btn-update {
    background: #3498db;
    color: white;
}

.btn-reset {
    background: #e74c3c;
    color: white;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

th,
td {
    padding: 14px;
    border: 1px solid #eee;
    text-align: left;
}

thead {
    background: linear-gradient(135deg, #6c5ce7, #0984e3);
    color: white;
}

tbody tr:nth-child(even) {
    background: #f9f9f9;
}

tbody tr:hover {
    background: #f1f7ff;
}

.actions a {
    padding: 7px 12px;
    border-radius: 6px;
    color: white;
    text-decoration: none;
    margin-right: 5px;
    font-size: 13px;
    transition: 0.2s ease;
}

.actions a:hover {
    opacity: 0.85;
}

.edit {
    background: #f39c12;
}

.delete {
    background: #e74c3c;
}

.product-img {
    max-width: 90px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.search-container {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.search-container form {
    display: flex;
    gap: 10px;
    width: 100%;
    max-width: 500px;
    background: transparent;
    border: none;
    padding: 0;
}

.search-container input {
    flex: 1;
    border-radius: 8px;
}

.search-container button {
    background: #9b59b6;
    color: white;
    border: none;
    border-radius: 8px;
}

.reset-container {
    text-align: center;
    margin-top: 20px;
}

.btn-showall {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 14px;
    background: #7f8c8d;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-showall:hover {
    opacity: 0.9;
}
</style>
</head>
<body>
<div class="container">
    <h1>⚡ Manajemen Produk Elektronik</h1>

    <?php if ($message): ?> 
        <div class="message <?= $message_type; ?>"><?= $message; ?></div>
    <?php endif; ?>

    <form action="Main.php" method="POST" enctype="multipart/form-data">
        <h2><?= $edit_id ? '✏️ Update Produk' : '➕ Tambah Produk'; ?></h2>
        <?php if ($edit_id): ?>
            <input type="hidden" name="id_produk" value="<?= htmlspecialchars($edit_id); ?>"> <input type="text" name="id_baru" value="<?= htmlspecialchars($edit_id); ?>" placeholder="ID Produk" required> <?php else: ?>
            <input type="text" name="id_produk" placeholder="ID Produk" required>
        <?php endif; ?>

        <input type="text" name="nama_produk" value="<?= htmlspecialchars($edit_nama); ?>" placeholder="Nama Produk" required>
        <input type="number" name="stok" value="<?= htmlspecialchars($edit_stok); ?>" placeholder="Stok" required>
        <input type="number" step="0.01" name="harga" value="<?= htmlspecialchars($edit_harga); ?>" placeholder="Harga" required>
        <input type="file" name="gambar">
        <?php if ($edit_gambar): ?>
            <p>📷 <a href="<?= htmlspecialchars($edit_gambar); ?>" target="_blank">Lihat Gambar</a></p>
        <?php endif; ?>
        <button type="submit" name="<?= $edit_id ? 'update' : 'tambah'; ?>" class="<?= $edit_id ? 'btn-update' : 'btn-tambah'; ?>">
            <?= $edit_id ? 'Update' : 'Tambah'; ?>
        </button>
    </form>

    <div class="search-container">
        <form action="Main.php" method="GET" style="display:flex; gap:10px; width:100%; max-width:500px;">
            <input type="text" name="cari_id" placeholder="Cari berdasarkan ID Produk" required>
            <button type="submit" name="cari">Cari</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($hasil_cari)): ?>
                <tr><td colspan="6" style="text-align:center;">🚫 Tidak ada data produk.</td></tr>
            <?php else: ?>
                <?php foreach ($hasil_cari as $produk): ?>
                    <tr>
                        <td><?= htmlspecialchars($produk->getId()); ?></td>
                        <td><?= htmlspecialchars($produk->getNama()); ?></td>
                        <td><?= htmlspecialchars($produk->getStok()); ?></td>
                        <td><?= 'Rp ' . number_format($produk->getHarga(), 2, ',', '.'); ?></td>
                        <td>
                            <?php if ($produk->getGambar()): ?>
                                <img src="<?= htmlspecialchars($produk->getGambar()); ?>" class="product-img">
                            <?php else: ?>
                                ❌ Tidak ada
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="Main.php?edit_id=<?= urlencode($produk->getId()); ?>" class="edit">Update</a>
                            <a href="Main.php?action=hapus&id=<?= urlencode($produk->getId()); ?>" class="delete" onclick="return confirm('Yakin hapus produk ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (isset($_GET['cari'])): ?>
        <div style="text-align:center;">
            <a href="Main.php" class="btn-showall">🔄 Tampilkan Semua</a>
        </div>
    <?php endif; ?>

    <div class="reset-container">
        <form action="Main.php" method="POST">
            <button type="submit" name="reset_data" class="btn-reset" onclick="return confirm('Hapus semua data?');">🧹 Reset Data</button>
        </form>
    </div>
</div>
</body>
</html>
