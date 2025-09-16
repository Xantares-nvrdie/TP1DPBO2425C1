class Elektronik:
    # constructor
    def __init__(self, id_produk:str , nama_produk:str, stok:int, harga:float):

        self.__id_produk = str(id_produk) #inisialisasi
        self.__nama_produk = str(nama_produk) #inisialisasi
        self.__stok = int(stok) #inisialisasi
        self.__harga = float(harga) #inisialisasi
    
    # Getter untuk mengambil data
    def getId(self):
        return self.__id_produk #mengembalikan nilai

    def getNama(self):
        return self.__nama_produk #mengembalikan nilai

    def getStok(self):
        return self.__stok #mengembalikan nilai

    def getHarga(self):
        return self.__harga #mengembalikan nilai

    # Setter untuk merubah value
    def setId(self, id_produk):
        self.__id_produk = id_produk #mengubah value atribut dengan value baru

    def setNama(self, nama_produk):
        self.__nama_produk = nama_produk #mengubah value atribut dengan value baru

    def setStok(self, stok):
        if stok >= 0: #tidak boleh angka negatif
            self.__stok = stok #mengubah value atribut dengan value baru
        else:
            print("Stok tidak boleh negatif.") #pesan jika angka negatif

    def setHarga(self, harga):
        if harga > 0: #tidak boleh angka negatif
            self.__harga = harga #mengubah value atribut dengan value baru
        else:
            print("Harga harus lebih dari 0.") #pesan jika angka negatif

    #prosedur untuk menampilkan data
    def tampilkanData(self): 
        #print data
        print("ID :", self.getId())
        print("Nama Produk :", self.getNama())
        print("Stok :", self.getStok())
        print("Harga :", self.getHarga())

