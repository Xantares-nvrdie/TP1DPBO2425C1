from Elektronik import Elektronik #import class

daftarProduk = [] #deklarasi array

#fungsi untuk menentukan id unik
def isIdExists(id_produk):
    for produk in daftarProduk: #looping ke semua elemen
        if produk.getId() == id_produk: #jika elemen ada yang sama
            return True #mengembalikan nilai true
    return False #jika elemen itu unik mengembalikan nilai false

#prosedur menampilkan menu
def tampilkanMenu():
    #print menu
    print("\n<======== Menu Toko Elektronik Bintang Jaya ========>")
    print("1. Tambah Data Produk")
    print("2. Tampilkan Semua Data Produk")
    print("3. Update Data Produk")
    print("4. Hapus Data Produk")
    print("5. Cari Data Produk")
    print("6. Keluar")

#prosedur menambahkan data
def tambahData():
    print("\n--- Tambahkan Data Produk ---")
    # Validasi ID unik
    while True:
        id_produk = input("Id: ") #input
        if not isIdExists(id_produk): #jika id unik
            break
        print("ID ini sudah ada. Silakan masukkan ID lain.") #jika id tidak unik
    
    nama_produk = input("Nama: ") #input
    # Validasi input numerik untuk stok
    while True:
        try:
            stok = int(input("Stok: "))
            if(stok < 0): #jika input negatif
                print("Input tidak valid. Stok tidak boleh negatif.")
                continue #lembali ke awal loop
            break
        except ValueError: #jika input bukan angka
            print("Input tidak valid. Masukkan angka.")
            
    # Validasi input numerik untuk harga
    while True:
        try:
            harga = float(input("Harga: "))
            if(harga < 0): #jika input negatif
                print("Input tidak valid. Harga tidak boleh negatif.")
                continue #lembali ke awal loop
            break
        except ValueError: #jika input bukan angka
            print("Input tidak valid. Masukkan angka.")

    produk_baru = Elektronik(id_produk, nama_produk, stok, harga)
    daftarProduk.append(produk_baru) #memasukkan objek ke dalam array
    print("\nData berhasil ditambahkan")

#prosedur menampilkan data
def tampilkanData():
    print("\n--- Daftar Produk ---")
    if not daftarProduk: #jika daftar produk kosong
        print("\nData produk kosong")
    else:
        #jika daftar produk ada
        for produk in daftarProduk: #looping ke semua elemen array
            produk.tampilkanData() # menampilkan data
            print() #newline

#prosedur untuk memperbarui data
def updateData():
    print("\n--- Update Data Produk ---")
    id_update = input("Masukkan ID Produk yang akan diupdate: ") #input

    found = False #flag
    for produk in daftarProduk: #looping ke semua elemen produk
        if produk.getId() == id_update: #jika prduk ditemukan
            found = True

            # update ID produk
            id_baru = input(f"ID baru ({produk.getId()}): ")
            if id_baru:  # kalau user isi
                if id_baru != produk.getId() and isIdExists(id_baru): #jika input beda dari id awal dan tidak unik
                    print("ID baru sudah digunakan, ID tidak diubah.")
                else:
                    produk.setId(id_baru) #jika input valid

            # update nama produk
            print(f"Nama Produk baru ({produk.getNama()}): ", end="")
            nama_baru = input()  #input
            if nama_baru:
                produk.setNama(nama_baru)

            # update stok produk
            print(f"Stok baru ({produk.getStok()}): ", end="")
            stok_baru = input() #input
            if stok_baru:
                try:
                    stok_baru_int = int(stok_baru)
                    if stok_baru_int < 0: # jika input negatif
                        print("Input stok tidak valid. Stok tidak boleh negatif.")
                    else:
                        produk.setStok(stok_baru_int) #memasukkan value
                except ValueError: #jika input bukan angka
                    print("Input stok tidak valid. Data tidak diubah.")

            # update harga produk
            print(f"Harga baru ({produk.getHarga()}): ", end="")
            harga_baru = input() #input
            if harga_baru:
                try:
                    harga_baru_float = float(harga_baru)
                    if harga_baru_float < 0:
                        print("Input harga tidak valid. Harga tidak boleh negatif.")
                    else:
                        produk.setHarga(harga_baru_float) #memasukkan value
                except ValueError: #jika input tidak valid
                    print("Input harga tidak valid. Data tidak diubah.")

            print("\nData produk berhasil diupdate")
            break

    if not found: #jika id tidak ditemukan
        print(f"Produk dengan ID {id_update} tidak ditemukan")

#prosedur menghapus data
def hapusData():
    print("\n--- Hapus Data Produk ---")
    id_hapus = input("Masukkan ID Produk yang akan dihapus: ") #input

    found = False #flag
    for produk in daftarProduk: #looping ke semua elemen
        if produk.getId() == id_hapus: #jika ditemukan id yang dicari
            daftarProduk.remove(produk) #hapus data
            found = True #flag true
            print("\nData produk berhasil dihapus")
            break

    if not found: #jika tidak ditemukan
        print(f"Produk dengan ID {id_hapus} tidak ditemukan")

#prosedur mencari data
def cariData():
    print("\n--- Cari Data Produk ---")
    id_cari = input("Masukkan ID Produk yang akan dicari: ") #input

    found = False #flag
    for produk in daftarProduk: #looping ke semua elemen
        if produk.getId() == id_cari: #jika ditemukan id yang dicari
            print("\nData produk ditemukan")
            produk.tampilkanData() #menampilkan data
            found = True
            break

    if not found: #jika tidak ditemukan
        print(f"Produk dengan ID {id_cari} tidak ditemukan")

#main program
def main():
    while True:
        tampilkanMenu() #menampilkan menu
        pilihan = input("Pilihan: ") #input opsi

        if pilihan == '1': #opsi 1
            tambahData() #menambah data
        elif pilihan == '2': #opsi 2
            tampilkanData() #menampilkan data
        elif pilihan == '3': #opsi 3
            updateData() #memperbarui data
        elif pilihan == '4': #opsi 4
            hapusData() #menghapus data
        elif pilihan == '5': #opsi 5
            cariData() #mencari data
        elif pilihan == '6': #opsi 6
            print("Terima kasih telah menggunakan program ini")
            break
        else:
            print("Pilihan tidak valid. Coba lagi")

if __name__ == "__main__":
    main()
