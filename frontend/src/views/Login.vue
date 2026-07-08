<template>
  <div class="container">
    <div class="header">
      <h2>Login</h2>
      <p>Masuk ke akun Anda</p>
    </div>
    <el-form @submit.prevent="handleLogin" :model="form" label-width="120px">
      <el-form-item label="Email">
        <el-input v-model="form.email" type="email" placeholder="Masukkan email" />
      </el-form-item>
      <el-form-item label="Password">
        <el-input v-model="form.password" type="password" placeholder="Masukkan password" />
      </el-form-item>
      <el-form-item>
        <el-button @click="handleLogin" type="primary" style="width: 100%">Login</el-button>
      </el-form-item>
      <p class="text-center">
        Belum punya akun? <router-link to="/register">Daftar di sini</router-link>
      </p>
    </el-form>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'Login',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
    }
  },
  methods: {
    ...mapActions('auth', ['login']),
    async handleLogin() {
      try {
        await this.login(this.form)
        this.$message.success('Login berhasil')
        this.$router.push('/')
      } catch (error) {
        this.$message.error(error.error || 'Login gagal')
      }
    },
  },
}
</script>

<style scoped>
.container {
  max-width: 400px;
  margin: 100px auto;
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
