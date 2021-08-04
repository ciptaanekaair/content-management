<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
      type="text/css"
      data-noprefix
    />
    <title>Tagihan Pembayaran Transaksi</title>
  </head>
  <body class="font-poppins bg-gray-200 md:px-20">
    <div class="bg-white mx-auto md:px-10 px-4 py-4">
      <img
        src="{{ asset('image/Online report_Outline.svg') }}"
        alt=""
        class="mx-auto w-44"
      />
      <div class="font-bold text-blue-900 text-xl text-center">Filterpedia</div>
      <div class="text-2xl text-center font-medium text-gray-600">
        Tagihan Pembayaran
      </div>

      <div class="bg-blue-800 p-2 mt-6 font-semibold text-white">
        Nomor Tagihan FILTERPEDIA1120128
      </div>
      <div class="mt-6 text-gray-600">
        <div class="font-semibold">Hai Gusti Maulana</div>
        <div>
          Pesanan mu sudah siap nih, Pesanan akan langsung di proses setelah
          kamu melakukan pembayaran. Jika pesanan tidak sampai ke lokasi mu
          <span class="font-semibold">dana akan di kemblikan 100%</span>
        </div>
      </div>
    </div>
    <div class="bg-white mx-auto md:px-10 px-4 mt-2 py-4">
      <div class="flex">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6 text-gray-600 mr-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
          />
        </svg>
        <div class="text-xl text-gray-600 mb-6">Items</div>
      </div>
      <div class="flex">
        <img
          src="{{asset('image/product/Rectangle 20-2.jpg')}}"
          alt=""
          class="w-32 mr-4"
        />
        <div class="ml-auto my-auto">
          <div>Produk Satu Membrane Filter</div>
          <div class="text-green-600">Rp. 2000.000</div>
          <div class="text-gray-500">Jumlah : 2</div>
        </div>
      </div>
    </div>
    <div class="bg-white mx-auto md:px-10 px-4 mt-2 py-4 flex">
      <div class="text-gray-600 font-semibold">Total Bayar</div>
      <div class="text-green-600 ml-auto">Rp.4000.000</div>
    </div>
    <div class="bg-white mx-auto md:px-10 px-4 mt-2 py-4">
      <div class="flex">
        <div class="text-gray-600 font-semibold mr-6">
          Panduan Pembayaran Tranfer Bank
        </div>
        <img src="{{ asset('image/BCA_logo_Bank_Central_Asia.png') }}" class="w-20" />
      </div>
      <div class="mt-4">Nomor Rekening</div>
      <div>
        <span class="font-semibold">10221010 (PT.Cipta Aneka Air)</span>
      </div>
      <div class="text-gray-600 mt-4">
        Pastikan pembayaran Anda sudah BERHASIL dan UNGGAH BUKTI untuk
        mempercepat proses verifikasi
      </div>
      <div class="flex mt-4">
        <img src="{{ asset('image/Credit Card_Outline.svg') }}" alt="" class="w-24" />
        <div class="my-auto">
          <div class="font-semibold">Pembayaran Terjamin</div>
          <div class="text-gray-600">
            Filterpedia akan menjamin semua pembayaran dengan uang kembali
          </div>
        </div>
      </div>
      <div class="flex mt-4">
        <img src="{{ asset('image/Security_Outline.svg') }}" alt="" class="w-24" />
        <div class="my-auto">
          <div class="font-semibold">Keamanan Transaksi</div>
          <div class="text-gray-600">
            Segala betuk transaksi akan terenkripsi dan rahasia
          </div>
        </div>
      </div>
      <div class="mt-4">
        <div class="text-blue-900 text-center font-semibold">
          Masih punya pertanyaan lain ? kontak kami
        </div>
        <div class="md:flex justify-around mt-4">
          <div
            class="bg-red-200 mt-4 md:mt-2 p-2 rounded text-red-800 font-medium"
          >
            email hub.filterpedia.co.id
          </div>
          <div
            class="
              bg-green-200
              mt-4
              md:mt-2
              p-2
              rounded
              text-green-800
              font-medium
            "
          >
            whatsapp 08991169229
          </div>
          <div
            class="
              bg-gray-200
              mt-4
              md:mt-2
              p-2
              rounded
              text-gray-800
              font-medium
            "
          >
            telepon 021221019
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
