//deklarasi class
public class Elektronik
{
    //private atribut
    private String id_produk;
    private String nama_produk;
    private int stok;
    private double harga;

    // Constructor
    public Elektronik(String id_produk_baru, String nama_produk_baru, int stok_baru, double harga_baru)
    {
        this.id_produk = id_produk_baru; //inisialisasi
        this.nama_produk = nama_produk_baru; //inisialisasi
        this.stok = stok_baru; //inisialisasi
        this.harga = harga_baru; //inisialisasi
    }

    // Getter (untuk mendapatkan nilai atribut)
    public String getId()
    {
        return id_produk; //mengembalikan nilai atribut
    }

    public String getNama()
    {
        return nama_produk; //mengembalikan nilai atribut
    }

    public int getStok()
    {
        return stok; //mengembalikan nilai atribut
    }

    public double getHarga()
    {
        return harga; //mengembalikan nilai atribut
    }


    // Setter (untuk mengubah nilai atribut)
    public void setId(String id_produk)
    {
        this.id_produk = id_produk; //menginisialisasi atribut dengan value baru
    }

    public void setNama(String nama_produk)
    {
        this.nama_produk = nama_produk; //menginisialisasi atribut dengan value baru
    }

    public void setStok(int stok)
    {
        if (stok >= 0) //stok tidak boleh negatif
        {
            this.stok = stok; //menginisialisasi atribut dengan value baru
        }
        else
        {
            //jika stok negatif
            System.out.println("Stok tidak boleh negatif.");
        }
    }

    public void setHarga(double harga)
    {
        if (harga > 0) //harga tidak boleh negatif
        {
            this.harga = harga; //menginisialisasi value baru
        }
        else
        {
            //jika harga negatif
            System.out.println("Harga harus lebih dari 0.");
        }
    }

    //prosedur untuk menampilkan data
    void tampilkanData()
    {
        //print data
        System.out.println("ID : " + getId());
        System.out.println("Nama Produk : " + getNama());
        System.out.println("Stok : " + getStok());
        System.out.printf("Harga : %.0f\n", getHarga());
    }
}
