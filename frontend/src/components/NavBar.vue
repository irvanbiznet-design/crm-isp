<template>
  <div class="navbar">
    <div class="navbar-brand">
      <h1>CRM ISP</h1>
    </div>
    <div class="navbar-menu">
      <router-link to="/" class="nav-item">Dashboard</router-link>
      <router-link to="/customers" class="nav-item">Pelanggan</router-link>
      <router-link to="/invoices" class="nav-item">Invoice</router-link>
      <router-link to="/tickets" class="nav-item">Tiket</router-link>
    </div>
    <div class="navbar-user">
      <span class="user-name">{{ user?.name }}</span>
      <el-button @click="logout" type="danger" size="small">Logout</el-button>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'NavBar',
  computed: {
    ...mapGetters('auth', ['user']),
  },
  methods: {
    ...mapActions('auth', ['logout']),
    async handleLogout() {
      await this.logout()
      this.$router.push('/login')
    },
  },
}
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 30px;
  background-color: #2c3e50;
  color: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.navbar-brand h1 {
  margin: 0;
  font-size: 24px;
}

.navbar-menu {
  display: flex;
  gap: 25px;
}

.nav-item {
  color: white;
  text-decoration: none;
  transition: color 0.3s;
}

.nav-item:hover {
  color: #41b883;
}

.navbar-user {
  display: flex;
  align-items: center;
  gap: 15px;
}

.user-name {
  font-weight: 500;
}
</style>
