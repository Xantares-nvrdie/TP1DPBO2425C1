#include <iostream>
#include <string>
#include <iomanip> //librari biar bisa nampilin output nya bagus dan gapake angka ilmiah

using namespace std;

//deklarasi class
class Elektronik
{
    private:
        //private atribut
        string id_produk;
        string nama_produk;
        int stok;
        double harga;

    public:
    // constructor
    Elektronik(string id, string nama, int stok, double harga)
    {
        setId(id); //inisialisasi
        setNama(nama); //inisialisasi
        setStok(stok); //inisialisasi
        setHarga(harga); //inisialisasi
    }

    //setter
    void setId(const string& id) 
    {
        this->id_produk = id; //inisialisasi 
    }

    void setNama(const string& nama) 
    {
        this->nama_produk = nama; //inisialisasi
    }

    void setStok(const int& stok) 
    {
        this->stok = stok; //inisialisasi
    }

    void setHarga(const double& harga) 
    {
        this->harga = harga; //inisialisasi
    }


    // getter
    string getId() const
    {
        return id_produk; //mengambil value
    }

    string getNama() const
    {
        return nama_produk; //mengambil value
    }

    int getStok() const
    {
        return stok; //mengambil value
    }

    double getHarga() const
    {
        return harga; //mengambil value
    }
    
    //prosedur untuk menampilkan data
    void tampilkanData() const 
    {
        //print
        cout << "ID : " << getId() << endl
            << "Nama Produk : " << getNama() << endl
            << "Stok : " << getStok() << endl
            << "Harga : " << fixed << setprecision(0) << getHarga() << endl;
    }
    
    //destructor
    ~Elektronik()
    {
    }
};
