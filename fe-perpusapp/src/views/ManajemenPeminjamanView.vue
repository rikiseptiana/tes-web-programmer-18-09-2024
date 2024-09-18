<template>
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Manajemen Peminjaman</h1>

    <!-- Form Input Peminjaman -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold mb-4">Tambah Peminjaman Baru</h2>

      <form @submit.prevent="submitLoanForm">
        <!-- Nama Peminjam -->
        <div class="mb-4">
          <label
            for="nama_peminjam"
            class="block text-sm font-medium text-gray-700"
            >Nama Peminjam</label
          >
          <input
            v-model="form.nama_peminjam"
            type="text"
            id="nama_peminjam"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Masukkan nama peminjam"
            required
          />
        </div>

        <!-- Alamat Peminjam -->
        <div class="mb-4">
          <label
            for="alamat_peminjam"
            class="block text-sm font-medium text-gray-700"
            >Alamat Peminjam</label
          >
          <input
            v-model="form.alamat_peminjam"
            type="text"
            id="alamat_peminjam"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Masukkan alamat peminjam"
            required
          />
        </div>

        <!-- No Kontak Peminjam -->
        <div class="mb-4">
          <label
            for="kontak_peminjam"
            class="block text-sm font-medium text-gray-700"
            >No Kontak Peminjam</label
          >
          <input
            v-model="form.kontak_peminjam"
            type="text"
            id="kontak_peminjam"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Masukkan no kontak peminjam"
            required
          />
        </div>

        <!-- Tanggal Peminjaman -->
        <div class="mb-4">
          <label
            for="tanggal_peminjaman"
            class="block text-sm font-medium text-gray-700"
            >Tanggal Peminjaman</label
          >
          <input
            v-model="form.tanggal_peminjaman"
            type="date"
            id="tanggal_peminjaman"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required
          />
        </div>

        <!-- Buku yang Dipinjam -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700"
            >Buku yang Dipinjam</label
          >
          <div v-for="(book, index) in form.buku" :key="index" class="mb-4">
            <div class="flex gap-4">
              <div class="w-1/2">
                <select
                  v-model="book.id"
                  class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  required
                >
                  <option value="">Pilih Buku</option>
                  <option v-for="b in books" :key="b.id" :value="b.id">
                    {{ b.kode_buku }} - {{ b.judul_buku }}
                  </option>
                </select>
              </div>
              <div class="w-1/2">
                <input
                  v-model="book.jumlah"
                  type="number"
                  class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Jumlah Buku"
                  required
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Tambah Buku -->
        <div class="mb-4">
          <button
            type="button"
            @click="addBook"
            class="bg-green-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition duration-300"
          >
            Tambah Buku
          </button>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
          <button
            type="submit"
            class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition duration-300"
          >
            Tambah Peminjaman
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
// import axios from "axios";

// Form data
const form = ref({
  nama_peminjam: "",
  alamat_peminjam: "",
  kontak_peminjam: "",
  tanggal_peminjaman: "",
  buku: [{ id: "", jumlah: 1 }], // Default satu buku
});

// Books data
const books = ref([]);

// Fetch books from API
const fetchBooks = async () => {
  try {
    const response = await axios.get("/api/v1/books");
    books.value = response.data;
  } catch (error) {
    console.error("Error fetching books:", error);
  }
};

// Add another book input
const addBook = () => {
  form.value.buku.push({ id: "", jumlah: 1 });
};

// Handle form submission
const submitLoanForm = async () => {
  const loanData = {
    ...form.value,
    tanggal_pengembalian: calculateReturnDate(form.value.tanggal_peminjaman),
  };

  try {
    await axios.post("/api/v1/loans", loanData);
    alert("Peminjaman berhasil ditambahkan!");
    // Reset form after submission
    form.value = {
      nama_peminjam: "",
      alamat_peminjam: "",
      kontak_peminjam: "",
      tanggal_peminjaman: "",
      buku: [{ id: "", jumlah: 1 }],
    };
  } catch (error) {
    console.error("Error submitting loan:", error);
  }
};

// Calculate return date (3 days after loan date)
const calculateReturnDate = (loanDate) => {
  const date = new Date(loanDate);
  date.setDate(date.getDate() + 3); // Add 3 days
  return date.toISOString().split("T")[0]; // Return in YYYY-MM-DD format
};

onMounted(fetchBooks);
</script>

<style scoped>
/* Custom styling */
</style>
