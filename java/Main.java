import java.util.Scanner;
import java.util.ArrayList;
import java.util.InputMismatchException;

public class Main
{
    // arraylist untuk menyimpan daftar produk elektronik
    private static ArrayList<Elektronik> daftarProduk = new ArrayList<>();
    // scanner untuk input dari user
    private static Scanner scanner = new Scanner(System.in);

    // fungsi untuk cek apakah id sudah ada di daftarProduk
    private static boolean isIdExists(String id) {
        for (Elektronik produk : daftarProduk) //looping ke semua elemen
        {
            if (produk.getId().equals(id)) //jika id ditemukan ada yang sama
            {
                return true; //mengembalikan nilai true
            }
        }
        return false; //jika id tidak ada yang sama maka mengembalikan nilai false
    }

    // fungsi untuk menampilkan menu utama
    private static void tampilkanMenu()
    {
        //print
        System.out.println("\n<======== Menu Toko Elektronik Bintang Jaya ========>");
        System.out.println("1. Tambah Data Produk");
        System.out.println("2. Tampilkan Semua Data Produk");
        System.out.println("3. Update Data Produk");
        System.out.println("4. Hapus Data Produk");
        System.out.println("5. Cari Data Produk");
        System.out.println("6. Keluar");
        System.out.print("Masukkan pilihan: ");
    }

    // fungsi untuk menambahkan data produk baru
    // Fungsi untuk menambahkan data produk baru
    private static void tambahData()
    {
        System.out.println("\n--- Tambahkan Data Produk ---");
        String id;
        // loop untuk memastikan id produk unik
        do
        {
            System.out.print("\nId: ");
            id = scanner.nextLine(); //input
            if (isIdExists(id))
            {
                System.out.println("ID ini sudah ada. Silakan masukkan ID lain."); //pesan error karena id sudah ada
            }
        } while (isIdExists(id)); //selama belum ada input valid maka akan terus looping
        
        System.out.print("\nNama: ");
        String nama = scanner.nextLine(); //input

        int stok;
        // Validasi input numerik dan non-negatif untuk stok
        while (true)
        {
            try
            {
                System.out.print("\nStok: ");
                stok = scanner.nextInt(); //jika input negatif
                if (stok < 0)
                {
                    System.out.println("Input tidak valid. Stok tidak boleh negatif.");
                }
                else //jika input valid
                {
                    break;
                }
            }
            catch (InputMismatchException e)
            {
                System.out.println("Input tidak valid. Silakan masukkan angka.");
                scanner.next(); // Buang input yang salah
            }
        }
        scanner.nextLine(); // Menghapus newline setelah nextInt()

        double harga;
        // Validasi input numerik dan non-negatif untuk harga
        while (true)
        {
            try
            {
                System.out.print("\nHarga: ");
                harga = scanner.nextDouble();
                if (harga < 0) //jika input negatif
                {
                    System.out.println("Input tidak valid. Harga tidak boleh negatif.");
                }
                else //jika inputvalid
                {
                    break;
                }
            }
            catch (InputMismatchException e)
            {
                System.out.println("Input tidak valid. Silakan masukkan angka.");
                scanner.next(); // Buang input yang salah
            }
        }
        scanner.nextLine(); // Menghapus newline setelah nextDouble()

        // membuat objek baru elektronik dan menambahkannya ke arraylist
        Elektronik produkBaru = new Elektronik(id, nama, stok, harga);
        daftarProduk.add(produkBaru); //memasukkan objek ke array
        System.out.println("\nData berhasil ditambahkan");
    }

    // fungsi untuk menampilkan semua data produk
    private static void tampilkanData()
    {
        System.out.println("\n--- Daftar Produk ---");
        if (daftarProduk.isEmpty()) //jika array kosong
        {
            System.out.println("\nData produk kosong"); //pesan error untuk array kosong
        }
        else
        {
            //jika array tidak kosong
            for (Elektronik produk : daftarProduk) //looping ke semua elemen array
            {
                produk.tampilkanData(); //menampilkan produk
                System.out.println(); //newline
            }
        }
    }

    // fungsi untuk mengupdate data produk berdasarkan id
    private static void updateData()
    {
        System.out.println("\n--- Update Data Produk ---");
        System.out.print("Masukkan ID Produk yang akan diupdate: ");
        String id_update = scanner.nextLine(); //input id yang ingin di update
        
        for (Elektronik produk : daftarProduk) //looping ke semua elemen produk
        {
            if (produk.getId().equals(id_update)) //jika elemen ditemukan
            {
                // update id produk
                System.out.print("ID baru (" + produk.getId() + "): ");
                String id_baru = scanner.nextLine();
                if (!id_baru.isEmpty())
                {
                    // kalau ID baru berbeda dengan ID lama
                    if (!id_baru.equals(produk.getId()) && isIdExists(id_baru))
                    {
                        System.out.println("ID baru sudah digunakan, ID tidak diubah.");
                    }
                    else
                    {
                        produk.setId(id_baru);
                    }
                }

                // update nama produk
                System.out.print("Nama Produk baru (" + produk.getNama() + "): ");
                String nama_baru = scanner.nextLine(); //input
                if (!nama_baru.isEmpty()) //jika input valid
                {
                    produk.setNama(nama_baru); //input value baru kedalam atribut
                }

                // update stok produk
                System.out.print("Stok baru (" + produk.getStok() + "): ");
                String stok_baru_str = scanner.nextLine(); //input
                if (!stok_baru_str.isEmpty()) //jika input valid
                {
                    try
                    {
                        int stok_baru_int = Integer.parseInt(stok_baru_str);
                        if (stok_baru_int < 0) //jika input negatif
                        {
                            System.out.println("Input stok tidak valid. Stok tidak boleh negatif.");
                        }
                        else //jika input valid
                        {
                            produk.setStok(stok_baru_int); //input nilai int pada atribut
                        }
                    }
                    catch (NumberFormatException e)
                    {
                        //jika input bukan berupa angka
                        System.out.println("Input stok tidak valid. Data tidak diubah.");
                    }
                }

                // update harga produk
                System.out.printf("Harga baru (%.0f): ", produk.getHarga());
                String harga_baru_str = scanner.nextLine();
                if (!harga_baru_str.isEmpty()) //jika input valid
                {
                    try
                    {
                        double harga_baru_double = Double.parseDouble(harga_baru_str);
                        if (harga_baru_double < 0) //jika input negatif
                        {
                            System.out.println("Input harga tidak valid. Harga tidak boleh negatif.");
                        }
                        else //jika input valid
                        {
                            produk.setHarga(harga_baru_double); //input nilai dengan tipe data double pada atribut
                        }
                    }
                    catch (NumberFormatException e)
                    {
                        //jika input bukan berupa angka
                        System.out.println("Input harga tidak valid. Data tidak diubah.");
                    }
                }
                System.out.println("\nData produk berhasil diupdate");
                return;
            }
        }
        System.out.println("Produk dengan ID " + id_update + " tidak ditemukan"); //jika tidak ditemukan
    }

    // fungsi untuk menghapus data produk berdasarkan id
    private static void hapusData() 
    {
        System.out.println("\n--- Hapus Data Produk ---");
        System.out.print("Masukkan ID Produk yang akan dihapus: ");
        String id_hapus = scanner.nextLine(); //input

        for (int i = 0; i < daftarProduk.size(); i++) //looping ke semua elemen
        {
            if (daftarProduk.get(i).getId().equals(id_hapus)) //jika ditemukan elemen yang ingin dihapus
            {
                daftarProduk.remove(i); //menghapus elemen
                System.out.println("\nData produk berhasil dihapus");
                return;
            }
        }
        System.out.println("Produk dengan ID " + id_hapus + " tidak ditemukan"); //jika tidak ditemukan
    }

    // fungsi untuk mencari data produk berdasarkan id
    private static void cariData() 
    {
        System.out.println("\n--- Cari Data Produk ---");
        System.out.print("Masukkan ID Produk yang akan dicari: ");
        String id_cari = scanner.nextLine(); //input

        for (Elektronik produk : daftarProduk) 
        {
            if (produk.getId().equals(id_cari)) //looping ke semua elemen
            {
                System.out.println("\nData produk ditemukan");
                produk.tampilkanData(); //menampilkan data
                return;
            }
        }
        System.out.println("Produk dengan ID " + id_cari + " tidak ditemukan"); //jika tidak ditemukan
    }

    // main program
    public static void main(String[] args)
    {
        int pilihanHidupIniYangSangatSulit; //var untuk opsi

        //selama belum input opsi keluar, maka proses akan terus berlanjut
        do
        {
            tampilkanMenu(); //menampilkan menu
            try
            {
                pilihanHidupIniYangSangatSulit = scanner.nextInt(); //input opsi
                scanner.nextLine(); // menghapus newline setelah input int
            }
            catch (InputMismatchException e)
            {
                //jika input tidak valid
                System.out.println("Input tidak valid. Silakan masukkan angka.");
                scanner.nextLine(); // membuang input yang salah
                pilihanHidupIniYangSangatSulit = 0; // nilai default agar loop berlanjut
            }

            // logika menu
            switch (pilihanHidupIniYangSangatSulit)
            {
            case 1: tambahData(); break; //opsi 1 menambah data
            case 2: tampilkanData(); break; //opsi 2 menampilkan data
            case 3: updateData(); break; //opsi 3 memperbarui data
            case 4: hapusData(); break; //opsi 4 menghapus data
            case 5: cariData(); break; //opsi 5 mencari data
            case 6: System.out.println("Terima kasih telah menggunakan program ini"); break; //opsi 6 keluar/quit
            default: System.out.println("Pilihan tidak valid. Coba lagi"); //opsi tidak valid
            }
        } while (pilihanHidupIniYangSangatSulit != 6); //selama belum input opsi keluar 
    }
}
