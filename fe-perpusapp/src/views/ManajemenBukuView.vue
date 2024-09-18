<template>
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Manajemen Buku</h1>

    <!-- Form Input Buku -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold mb-4">Tambah Buku Baru</h2>

      <form @submit.prevent="submitBookForm">
        <!-- Kode Buku -->
        <div class="mb-4">
          <label for="kode_buku" class="block text-sm font-medium text-gray-700"
            >Kode Buku</label
          >
          <input
            v-model="form.kode_buku"
            type="text"
            id="kode_buku"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Masukkan kode buku"
            required
          />
        </div>

        <!-- Judul Buku -->
        <div class="mb-4">
          <label
            for="judul_buku"
            class="block text-sm font-medium text-gray-700"
            >Judul Buku</label
          >
          <input
            v-model="form.judul_buku"
            type="text"
            id="judul_buku"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Masukkan judul buku"
            required
          />
        </div>

        <!-- Kategori Buku -->
        <div class="mb-4">
          <label
            for="kategori_buku"
            class="block text-sm font-medium text-gray-700"
            >Kategori Buku</label
          >
          <select
            v-model="form.kategori_buku"
            id="kategori_buku"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required
          >
            <option value="">Pilih Kategori</option>
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>

        <!-- Stok Buku -->
        <div class="mb-4">
          <label for="stok_buku" class="block text-sm font-medium text-gray-700"
            >Stok Buku</label
          >
          <input
            v-model="form.stok_buku"
            type="number"
            id="stok_buku"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Masukkan stok buku"
            required
          />
        </div>

        <!-- Tahun Buku -->
        <div class="mb-4">
          <label
            for="tahun_buku"
            class="block text-sm font-medium text-gray-700"
            >Tahun Buku</label
          >
          <input
            v-model="form.tahun_buku"
            type="number"
            id="tahun_buku"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Masukkan tahun buku"
            required
          />
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
          <button
            type="submit"
            class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition duration-300"
          >
            Tambah Buku
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import customApi from "@/axios";

// Form Data
const form = ref({
  kode_buku: "",
  judul_buku: "",
  kategori_buku: "",
  stok_buku: 0,
  tahun_buku: new Date().getFullYear(),
});

// Categories Data
const categories = ref([]);

// Fetch categories from API
const fetchCategories = async () => {
  try {
    const response = await axios.get("/api/buku");
    categories.value = response.data;
  } catch (error) {
    console.error("Error fetching categories:", error);
  }
};

// Handle form submission
const submitBookForm = async () => {
  try {
    await axios.post("/api/buku", form.value);
    alert("Buku berhasil ditambahkan!");
    // Reset form after submission
    form.value = {
      kode_buku: "",
      judul_buku: "",
      kategori_buku: "",
      stok_buku: 0,
      tahun_buku: new Date().getFullYear(),
    };
  } catch (error) {
    console.error("Error submitting form:", error);
  }
};

onMounted(fetchCategories);
</script>

<style scoped>
/* Custom styling for form input */
</style>
