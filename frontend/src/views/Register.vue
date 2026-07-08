<template>
  <div class="container">
    <div class="header">
      <h2>Daftar</h2>
      <p>Buat akun baru</p>
    </div>
    <el-form @submit.prevent="handleRegister" :model="form" label-width="120px">
      <el-form-item label="Nama">
        <el-input v-model="form.name" placeholder="Masukkan nama" />
      </el-form-item>
      <el-form-item label="Email">
        <el-input v-model="form.email" type="email" placeholder="Masukkan email" />
      </el-form-item>
      <el-form-item label="Telepon">
        <el-input v-model="form.phone" placeholder="Masukkan nomor telepon" />
      </el-form-item>
      <el-form-item label="Password">
        <el-input v-model="form.password" type="password" placeholder="Masukkan password" />
      </el-form-item>
      <el-form-item label="Konfirmasi Password">
        <el-input v-model="form.password_confirmation" type="password" placeholder="Konfirmasi password" />
      </el-form-item>
      <el-form-item>
        <el-button @click="handleRegister" type="primary" style="width: 100%">Daftar</el-button>
      </el-form-item>
      <p class="text-center">
        Sudah punya akun? <router-link to="/login">Login di sini</router-link>
      </p>
    </el-form>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'Register',
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        password: '',
        password_confirmation: '',
      },
    }
  },
  methods: {
    ...mapActions('auth', ['register']),
    async handleRegister() {
      try {
        await this.register(this.form)
        this.$message.success('Pendaftaran berhasil, silakan login')
        this.$router.push('/login')
      } catch (error) {
        this.$message.error(error.error || 'Pendaftaran gagal')
      }
    },
  },
}
</script>

<style scoped>
.container {
  max-width: 400px;
  margin: 50px auto;
  padding: 30px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

.header {
  text-align: center;
  margin-bottom: 30px;
}

.header h2 {
  margin: 0;
  color: #2c3e50;
}

.header p {
  color: #666;
  margin-top: 8px;
}

.text-center {
  text-align: center;
  margin-top: 15px;
}

.text-center a {
  color: #41b883;
  text-decoration: none;
}
</style>
