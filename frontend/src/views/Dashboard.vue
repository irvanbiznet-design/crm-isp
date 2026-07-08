<template>
  <div class="dashboard">
    <div class="container">
      <h1>Dashboard</h1>
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-value">{{ stats.totalCustomers }}</div>
          <div class="stat-label">Total Pelanggan</div>
        </div>
        <div class="stat-card">
          <div class="stat-value">{{ stats.activeCustomers }}</div>
          <div class="stat-label">Pelanggan Aktif</div>
        </div>
        <div class="stat-card">
          <div class="stat-value">{{ stats.unpaidInvoices }}</div>
          <div class="stat-label">Invoice Belum Dibayar</div>
        </div>
        <div class="stat-card">
          <div class="stat-value">{{ stats.openTickets }}</div>
          <div class="stat-label">Tiket Terbuka</div>
        </div>
      </div>
      <div class="charts-grid">
        <div class="chart-card">
          <h3>Pelanggan Per Paket</h3>
          <div ref="chartCustomers" style="height: 300px"></div>
        </div>
        <div class="chart-card">
          <h3>Invoice Status</h3>
          <div ref="chartInvoices" style="height: 300px"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as echarts from 'echarts'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Dashboard',
  data() {
    return {
      stats: {
        totalCustomers: 0,
        activeCustomers: 0,
        unpaidInvoices: 0,
        openTickets: 0,
      },
    }
  },
  computed: {
    ...mapGetters('customer', ['customers']),
    ...mapGetters('invoice', ['invoices']),
    ...mapGetters('ticket', ['tickets']),
  },
  methods: {
    ...mapActions('customer', ['fetchCustomers']),
    ...mapActions('invoice', ['fetchInvoices', 'fetchUnpaidInvoices']),
    ...mapActions('ticket', ['fetchTickets', 'fetchOpenTickets']),
    async loadData() {
      await this.fetchCustomers()
      await this.fetchInvoices()
      await this.fetchTickets()
      await this.fetchUnpaidInvoices()
      await this.fetchOpenTickets()
      this.updateStats()
      this.renderCharts()
    },
    updateStats() {
      this.stats.totalCustomers = this.customers.data?.length || 0
      this.stats.activeCustomers = this.customers.data?.filter(c => c.status === 'active').length || 0
      this.stats.unpaidInvoices = this.invoices.data?.filter(i => i.status !== 'paid').length || 0
      this.stats.openTickets = this.tickets.data?.filter(t => ['open', 'pending'].includes(t.status)).length || 0
    },
    renderCharts() {
      this.renderCustomerChart()
      this.renderInvoiceChart()
    },
    renderCustomerChart() {
      const chart = echarts.init(this.$refs.chartCustomers)
      const option = {
        title: { text: '' },
        tooltip: { trigger: 'axis' },
        legend: { data: ['Aktif', 'Suspend', 'Tidak Aktif'] },
        xAxis: { type: 'category', data: ['Paket A', 'Paket B', 'Paket C'] },
        yAxis: { type: 'value' },
        series: [
          { name: 'Aktif', data: [10, 15, 8], type: 'bar' },
          { name: 'Suspend', data: [2, 3, 1], type: 'bar' },
          { name: 'Tidak Aktif', data: [1, 2, 1], type: 'bar' },
        ],
      }
      chart.setOption(option)
    },
    renderInvoiceChart() {
      const chart = echarts.init(this.$refs.chartInvoices)
      const option = {
        title: { text: '' },
        tooltip: { trigger: 'item' },
        legend: { orient: 'vertical', left: 'left' },
        series: [
          {
            name: 'Invoice',
            type: 'pie',
            radius: '50%',
            data: [
              { value: 35, name: 'Dibayar' },
              { value: 25, name: 'Belum Dibayar' },
              { value: 15, name: 'Telat' },
            ],
            emphasis: {
              itemStyle: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: 'rgba(0, 0, 0, 0.5)',
              },
            },
          },
        ],
      }
      chart.setOption(option)
    },
  },
  mounted() {
    this.loadData()
  },
}
</script>

<style scoped>
.dashboard {
  padding: 30px;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

h1 {
  color: #2c3e50;
  margin-bottom: 30px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.stat-card {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.stat-value {
  font-size: 32px;
  font-weight: bold;
  color: #41b883;
  margin-bottom: 10px;
}

.stat-label {
  color: #666;
  font-size: 14px;
}

.charts-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: 20px;
}

.chart-card {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.chart-card h3 {
  margin-top: 0;
  color: #2c3e50;
}
</style>
