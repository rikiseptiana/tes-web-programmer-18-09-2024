<template>
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Dashboard Perpustakaan Admin</h1>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Card: Total Books -->
      <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <h2 class="text-xl font-semibold text-gray-700">Total Buku</h2>
        <p class="text-3xl font-bold text-blue-500 mt-4">{{ totalBooks }}</p>
        <p class="text-gray-500 mt-2">Total buku yang tersedia</p>
      </div>

      <!-- Card: Total Loans -->
      <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <h2 class="text-xl font-semibold text-gray-700">Total Peminjaman</h2>
        <p class="text-3xl font-bold text-green-500 mt-4">{{ totalLoans }}</p>
        <p class="text-gray-500 mt-2">Total peminjaman aktif</p>
      </div>

      <!-- Card: Reports -->
      <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <h2 class="text-xl font-semibold text-gray-700">Laporan Bulan Ini</h2>
        <p class="text-3xl font-bold text-yellow-500 mt-4">
          {{ monthlyLoans }}
        </p>
        <p class="text-gray-500 mt-2">Peminjaman bulan ini</p>
      </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Button: Manajemen Buku -->
      <RouterLink to="/manajemen-buku">
        <button
          class="bg-blue-500 text-white py-3 px-6 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300"
        >
          Manajemen Buku
        </button>
      </RouterLink>
      <RouterLink to="/manajemen-peminjaman">
        <button
          class="bg-green-500 text-white py-3 px-6 rounded-lg shadow-lg hover:bg-green-600 transition duration-300"
        >
          Manajemen Peminjaman
        </button>
      </RouterLink>

      <!-- Button: Laporan -->
      <RouterLink to="/report">
        <button
          class="bg-yellow-500 text-white py-3 px-6 rounded-lg shadow-lg hover:bg-yellow-600 transition duration-300"
        >
          Laporan
        </button>
      </RouterLink>
    </div>

    <!-- Recent Activity -->
    <div class="mt-10">
      <h2 class="text-2xl font-bold mb-4">Aktivitas Terbaru</h2>
      <div class="bg-white shadow-md rounded-lg p-6">
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2">ID Pengguna</th>
              <th class="py-2">Buku</th>
              <th class="py-2">Tanggal Pinjam</th>
              <th class="py-2">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="loan in recentLoans" :key="loan.id" class="border-b">
              <td class="py-2">{{ loan.user_id }}</td>
              <td class="py-2">{{ loan.book.title }}</td>
              <td class="py-2">{{ loan.loan_date }}</td>
              <td class="py-2">
                <span
                  :class="statusClass(loan.status)"
                  class="py-1 px-3 rounded-full text-white"
                  >{{ loan.status }}</span
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
//   import axios from 'axios';

const router = useRouter();
const totalBooks = ref(0);
const totalLoans = ref(0);
const monthlyLoans = ref(0);
const recentLoans = ref([]);

const fetchDashboardData = async () => {
  try {
    const booksResponse = await axios.get("/api/v1/books");
    totalBooks.value = booksResponse.data.length;

    const loansResponse = await axios.get("/api/v1/loans");
    totalLoans.value = loansResponse.data.filter(
      (loan) => loan.status === "borrowed"
    ).length;

    const monthlyLoansResponse = await axios.get("/api/v1/reports/monthly");
    monthlyLoans.value = monthlyLoansResponse.data.length;

    recentLoans.value = loansResponse.data.slice(0, 5);
  } catch (error) {
    console.error("Error fetching dashboard data:", error);
  }
};

const goTo = (route) => {
  router.push(route);
};

const statusClass = (status) => {
  return status === "borrowed" ? "bg-green-500" : "bg-gray-500";
};

onMounted(fetchDashboardData);
</script>

<style scoped>
/* Custom styling for dashboard buttons */
</style>
