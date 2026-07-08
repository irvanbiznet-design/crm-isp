<template>
  <div class="customers-page">
    <div class="container">
      <div class="header">
        <h1>Daftar Pelanggan</h1>
        <el-button type="primary" @click="showAddDialog">Tambah Pelanggan</el-button>
      </div>
      <div class="search-bar">
        <el-input v-model="searchQuery" placeholder="Cari pelanggan..." @input="searchCustomers" />
      </div>
      <el-table :data="customers.data" v-loading="loading" style="width: 100%">
        <el-table-column prop="customer_number" label="No. Pelanggan" width="150" />
        <el-table-column prop="name" label="Nama" width="200" />
        <el-table-column prop="phone" label="Telepon" width="150" />
        <el-table-column prop="email" label="Email" width="200" />
        <el-table-column prop="status" label="Status" width="120">
          <template #default="scope">
            <el-tag :type="scope.row.status === 'active' ? 'success' : 'danger'">{{ scope.row.status }}</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="Aksi" width="180">
          <template #default="scope">
            <el-button link type="primary" @click="viewCustomer(scope.row.id)">Lihat</el-button>
            <el-button link type="warning" @click="editCustomer(scope.row)">Edit</el-button>
            <el-button link type="danger" @click="deleteCustomer(scope.row.id)">Hapus</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Customers',
  data() {
    return {
      searchQuery: '',
    }
  },
  computed: {
    ...mapGetters('customer', ['customers', 'loading']),
  },
  methods: {
    ...mapActions('customer', ['fetchCustomers', 'deleteCustomer', 'searchCustomers']),
    async loadCustomers() {
      await this.fetchCustomers()
    },
    showAddDialog() {
      this.$message.info('Fitur tambah pelanggan akan segera hadir')
    },
    async viewCustomer(id) {
      this.$router.push(`/customers/${id}`)
    },
    editCustomer(customer) {
      this.$message.info('Fitur edit akan segera hadir')
    },
    async deleteCustomerConfirm(id) {
      this.$confirm('Yakin ingin menghapus pelanggan ini?', 'Peringatan', {
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
        type: 'warning',
      })
        .then(async () => {
          await this.deleteCustomer(id)
          this.$message.success('Pelanggan berhasil dihapus')
          await this.loadCustomers()
        })
        .catch(() => {})
    },
    async searchCustomers(query) {
      if (query) {
        await this.searchCustomers(query)
      } else {
        await this.loadCustomers()
      }
    },
  },
  mounted() {
    this.loadCustomers()
  },
}
</script>

<style scoped>
.customers-page {
  padding: 30px;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.header h1 {
  margin: 0;
  color: #2c3e50;
}

.search-bar {
  margin-bottom: 20px;
}
</style>
