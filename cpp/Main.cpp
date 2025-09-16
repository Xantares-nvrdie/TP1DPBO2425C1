#include "Elektronik.cpp"
#include <vector>
#include <limits>

using namespace std;

vector<Elektronik> daftarProduk; //deklarasi array

// Fungsi untuk memeriksa apakah ID sudah ada
bool isIdExists(const string& id) {
    for (const auto& produk : daftarProduk) //looping untuk seluruh elemen dalam array
    {
        if (produk.getId() == id) //jika id nya terdapat kesamaan
        {
            return true; //mengembalikan nilai true
        }
    }
    return false; //jika tidak ditemukan id yang sama maka false
}

//prosedur untuk menampilkan menu yang bisa diakses
void tampilkanMenu()
{
    //print
    cout << "\n<======== Menu Toko Elektronik Bintang Jaya ========>" << endl
        << "1. Tambah Data Produk" << endl
        << "2. Tampilkan Semua Data Produk" << endl
        << "3. Update Data Produk" << endl
        << "4. Hapus Data Produk" << endl
        << "5. Cari Data Produk" << endl
        << "6. Keluar" << endl
        << "Masukkan pilihan: ";
}

//prosedur untuk menambah data
void tambahData()
{
    //deklarasi variabel
    string id, nama;
    int stok;
    double harga;

    cout << "\n--- Tambahkan Data Produk ---" << endl;
    //do while untuk error handling jika id yang dimasukkan sudah ada
    do {
        cout << "\nId: ";
        cin >> id;
        if (isIdExists(id)) {
            //jika id sudah ada
            cout << "ID ini sudah ada. Silakan masukkan ID lain." << endl;
        }
    } while (isIdExists(id)); //selama id yang dimasukkan masih ada, maka akan meminta input yang valid

    cin.ignore(numeric_limits<streamsize>::max(), '\n');
    cout << "\nNama: ";
    getline(cin, nama); //membersihkan newline//getnput nama produk

    // Error handling untuk input stok yang berisikan non number dan angka negatif
    while (true) {
        cout << "\nStok: ";
        cin >> stok;
        if (cin.fail() || stok < 0)
        {
            //jika input tidak valid dan negatif
            cout << "Input tidak valid. Silakan masukkan angka positif." << endl;
            cin.clear(); //membersihkan input
            cin.ignore(numeric_limits<streamsize>::max(), '\n');
        }
        else
        {
            cin.ignore(numeric_limits<streamsize>::max(), '\n'); // membersihkan buffer setelah input valid
            break;
        }
    }

    // Error handling untuk input harga
    while (true) {
        cout << "\nHarga: ";
        cin >> harga; //input
        if (cin.fail() || harga <= 0)
        {
            //jika input tidak valid dan negatif
            cout << "Input tidak valid. Silakan masukkan harga positif." << endl;
            cin.clear(); //membersihkan input
            cin.ignore(numeric_limits<streamsize>::max(), '\n'); // membersihkan buffer setelah input valid
        }
        else
        {
            cin.ignore(numeric_limits<streamsize>::max(), '\n'); // membersihkan buffer setelah input valid
            break;
        }
    }

    // Tambahkan objek Elektronik tanpa atribut gambar
    daftarProduk.push_back(Elektronik(id, nama, stok, harga)); //menambahkan data kedalam array
    cout << "\nData berhasil ditambahkan"<<endl; //pesan berhasil
}

//prosedur untuk menampilkan data
void tampilkanData()
{
    cout << "\n--- Daftar Produk ---" << endl;
    if (daftarProduk.empty())
    {
        //jika array produk kosong
        cout << "\nData produk kosong" << endl;
    }
    //looping untuk menampilkan data
    for(const auto& produk : daftarProduk)
    {
        produk.tampilkanData(); //menampilkan data
        cout << "\n"; //print newline
    }
}

//prosedur untuk memperbarui data
void updateData()
{
    string id_update; //atribut untuk menyimpan id tujuan
    cout << "\n--- Update Data Produk  ---" << endl;
    cout << "Masukkan ID Produk yang akan diupdate: ";
    cin >>id_update; //input
    cin.ignore(numeric_limits<streamsize>::max(), '\n');
    //looping untuk semua data didalam array
    for (auto& produk : daftarProduk)
    {
        //jika id yang dicari cocok
        if(produk.getId() == id_update)
        {
            string id_baru;
            cout << "ID baru (" << produk.getId() << "): ";
            getline(cin, id_baru);
            if (!id_baru.empty())
            {
                // cek apakah id baru dipakai produk lain
                if (id_baru != produk.getId() && isIdExists(id_baru))
                {
                    cout << "ID baru sudah digunakan, ID tidak diubah." << endl;
                }
                else
                {
                    produk.setId(id_baru);
                }
            }
            string nama_baru;
            cout << "Nama Produk baru (" << produk.getNama() << "): ";
            getline(cin, nama_baru); //input 
            if(!nama_baru.empty())
            {
                //jika nama yang diinput valid
                produk.setNama(nama_baru); //masukkan value kedalam data
            }

            string stok_baru;
            cout << "Stok baru (" << produk.getStok() << "): ";
            getline(cin, stok_baru); //input
            if(!stok_baru.empty())
            {
                //jika nama yang diinput valid
                produk.setStok(stoi(stok_baru)); //masukkan value kedalam data dalam tipe data int
            }

            string harga_baru;
            cout << "Harga baru (" << produk.getHarga() << "): ";
            getline(cin, harga_baru); //input
            if(!harga_baru.empty())
            {
                //jika nama yang diinput valid
                produk.setHarga(stod(harga_baru)); //masukkan value kedalam data dalam tipe data double
            }

            cout << "\nData produk berhasil diupdate" <<endl;
            return;
        }
    }
    //jika tidak ditemukan id tujuan
    cout << "Produk dengan ID " << id_update << " tidak ditemukan" << endl;
}

//prosedut untuk menghapus data
void hapusData()
{
    string id_hapus; //atribut untuk id yang ingin dihapus
    cout << "\n--- Hapus Data Produk ---" << endl;
    cout << "Masukkan ID Produk yang akan dihapus: ";
    cin >> id_hapus; //input

    //looping untuk semua elemen dalam array
    for(auto iterator = daftarProduk.begin(); iterator != daftarProduk.end(); ++iterator)
    {
        if(iterator->getId() == id_hapus) //jika id ditemukan
        {
            daftarProduk.erase(iterator); //hapus data
            cout << "\nData produk berhasil dihapus" << endl;
            return;
        }
    }
}

//prosedur untuk mencari data
void cariData()
{
    string id_cari; //atribut untuk id yang dicari
    bool found = false;
    cout << "\n--- Cari Data Produk ---" << endl;
    cout << "Masukkan ID Produk yang akan dicari: ";
    cin >> id_cari; //input

    //looping untuk semua elemen dalam array
    for(const auto& produk : daftarProduk)
    {
        if(produk.getId() == id_cari) //jika id ditemukan
        {
            cout << "\nData produk ditemukan" << endl;
            produk.tampilkanData(); //menampilkan data
            found = true;
            return;
        }
    }
    if(!found){
        cout << "\nData produk tidak ditemukan" << endl;
    }
}

int main(){
    int pilihanHidupIniYangSangatSulit; //var untuk operator
    
    //selama belum input opsi keluar, maka proses akan terus berlanjut
    do
    {
        tampilkanMenu(); //menampilkan menu
        cin >> pilihanHidupIniYangSangatSulit; //input opsi
        switch (pilihanHidupIniYangSangatSulit)
        {
            case 1: tambahData(); break; //opsi 1 menambah data
            case 2: tampilkanData(); break; //opsi 2 menampilkan data
            case 3: updateData(); break; //opsi 3 memperbarui data
            case 4: hapusData(); break; //opsi 4 menghapus data
            case 5: cariData(); break; //opsi 5 mencari data
            case 6: cout << "Terima kasih telah menggunakan program ini" << endl; break; //opsi 6 keluar/quit
            default: cout << "Pilihan tidak valid. Coba lagi" << endl; //opsi tidak valid
        }
    } while (pilihanHidupIniYangSangatSulit != 6); //selama belum input opsi keluar
    return 0;
}
