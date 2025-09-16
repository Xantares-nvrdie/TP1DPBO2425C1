<?php
    class Elektronik {
        //private atribut
        private string $id_produk;
        private string $nama_produk;
        private int $stok;
        private float $harga;
        private string $gambar;

        //constructor
        public function __construct(string $id_produk, string $nama_produk, int $stok, float $harga, string $gambar)
        {
            $this->id_produk = $id_produk; //inisialisasi atribut
            $this->nama_produk = $nama_produk; //inisialisasi atribut
            $this->stok = $stok; //inisialisasi atribut
            $this->harga = $harga; //inisialisasi atribut
            $this->gambar = $gambar; //inisialisasi atribut
        }

        // Getter (untuk mendapatkan nilai atribut)
        public function getId(): string
        {
            return $this->id_produk; //mengembalikan nilai atribut
        }

        public function getNama(): string
        {
            return $this->nama_produk; //mengembalikan nilai atribut
        }

        public function getStok(): int
        {
            return $this->stok; //mengembalikan nilai atribut
        }

        public function getHarga(): float
        {
            return $this->harga; //mengembalikan nilai atribut
        }

        public function getGambar(): string
        {
            return $this->gambar; //mengembalikan nilai atribut
        }

        // Setter (untuk mengubah nilai atribut)
        public function setId(string $id_produk): void
        {
            $this->id_produk = $id_produk; //menginisialisasi atribut dengan value baru
        }

        public function setNama(string $nama_produk): void
        {
            $this->nama_produk = $nama_produk; //menginisialisasi atribut dengan value baru
        }

        public function setStok(int $stok): void
        {
            // Validasi: memastikan stok tidak negatif
            if ($stok >= 0) {
                $this->stok = $stok; //menginisialisasi atribut dengan value baru
            } else {
                echo "Stok tidak boleh negatif."; //jika input tidak valid
            }
        }

        public function setHarga(float $harga): void
        {
            // Validasi: memastikan harga lebih dari 0
            if ($harga > 0) {
                $this->harga = $harga; //menginisialisasi atribut dengan value baru
            } else {
                echo "Harga harus lebih dari 0."; //jika input tidak valid
            }
        }

        public function setGambar(string $gambar): void
        {
            $this->gambar = $gambar; //menginisialisasi atribut dengan value baru
        }

        //function untuk menampilkan data
        public function tampilkanData(): void
        {
            //print
            echo "ID: " . $this->getIdProduk() . "<br>";
            echo "Nama Produk: " . $this->getNamaProduk() . "<br>";
            echo "Stok: " . $this->getStok() . "<br>";
            echo "Harga: " . $this->getHarga() . "<br>";
            echo "Gambar: " . $this->getGambar() . "<br>";
        }
    }
