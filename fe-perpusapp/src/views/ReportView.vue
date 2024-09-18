<template>
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Laporan Peminjaman</h1>

    <!-- Filter Laporan -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 class="text-2xl font-bold mb-4">Filter Laporan</h2>

      <form @submit.prevent="fetchReport">
        <!-- Tanggal Mulai -->
        <div class="mb-4">
          <label
            for="start_date"
            class="block text-sm font-medium text-gray-700"
            >Tanggal Mulai</label
          >
          <input
            v-model="filters.start_date"
            type="date"
            id="start_date"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Tanggal Akhir -->
        <div class="mb-4">
          <label for="end_date" class="block text-sm font-medium text-gray-700"
            >Tanggal Akhir</label
          >
          <input
            v-model="filters.end_date"
            type="date"
            id="end_date"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
          <button
            type="submit"
            class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition duration-300"
          >
            Tampilkan Laporan
          </button>
        </div>
      </form>
    </div>

    <!-- Hasil Laporan -->
    <div
      v-if="reportData.length"
      class="bg-white shadow-md rounded-lg p-6 mb-6"
    >
      <h2 class="text-2xl font-bold mb-4">Hasil Laporan</h2>

      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Nama Peminjam
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Buku
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Jumlah
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Tanggal Peminjaman
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Tanggal Pengembalian
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="loan in reportData" :key="loan.id">
            <td class="px-6 py-4 whitespace-nowrap">
              {{ loan.nama_peminjam }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ loan.buku.judul_buku }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ loan.jumlah }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ loan.tanggal_peminjaman }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ loan.tanggal_pengembalian }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Kategori Buku yang Sering Dipinjam -->
    <div
      v-if="topCategories.length"
      class="bg-white shadow-md rounded-lg p-6 mb-6"
    >
      <h2 class="text-2xl font-bold mb-4">
        Kategori Buku yang Sering Dipinjam
      </h2>

      <ul class="list-disc pl-5">
        <li v-for="category in topCategories" :key="category.id">
          {{ category.name }} - {{ category.total_pinjam }} kali dipinjam
        </li>
      </ul>
    </div>

    <!-- Export Button -->
    <div class="flex justify-end space-x-4">
      <button
        @click="exportToPDF"
        class="bg-red-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-red-600 transition duration-300"
      >
        Export ke PDF
      </button>
      <button
        @click="exportToExcel"
        class="bg-green-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition duration-300"
      >
        Export ke Excel
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
//   import axios from 'axios';

// Filter data
const filters = ref({
  start_date: "",
  end_date: "",
});

// Report data
const reportData = ref([]);
const topCategories = ref([]);

// Fetch report based on filters
const fetchReport = async () => {
  try {
    const response = await axios.get("/api/v1/reports", {
      params: {
        start_date: filters.value.start_date,
        end_date: filters.value.end_date,
      },
    });
    reportData.value = response.data.loans;
    topCategories.value = response.data.top_categories;
  } catch (error) {
    console.error("Error fetching report:", error);
  }
};

// Export report to PDF
const exportToPDF = async () => {
  try {
    await axios
      .get("/api/v1/reports/export-pdf", {
        params: {
          start_date: filters.value.start_date,
          end_date: filters.value.end_date,
        },
        responseType: "blob",
      })
      .then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "LaporanPeminjaman.pdf");
        document.body.appendChild(link);
        link.click();
      });
  } catch (error) {
    console.error("Error exporting PDF:", error);
  }
};

// Export report to Excel
const exportToExcel = async () => {
  try {
    await axios
      .get("/api/v1/reports/export-excel", {
        params: {
          start_date: filters.value.start_date,
          end_date: filters.value.end_date,
        },
        responseType: "blob",
      })
      .then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "LaporanPeminjaman.xlsx");
        document.body.appendChild(link);
        link.click();
      });
  } catch (error) {
    console.error("Error exporting Excel:", error);
  }
};
</script>

<style scoped>
/* Custom styling */
</style>
