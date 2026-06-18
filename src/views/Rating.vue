<template>
  <div style="max-width: 1200px; margin: 30px auto; padding: 20px">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h1 style="color: #333;">Рейтинги</h1>
      <Button 
        label="Обновить" 
        icon="pi pi-refresh" 
        @click="refreshData" 
        class="p-button-outlined"
      />
    </div>
    
    <div v-if="dataPreLoading" style="display: flex; justify-content: center; padding: 50px;">
      <ProgressSpinner strokeWidth="4" style="width:50px;height:50px" />
    </div>
    
    <div v-else>
      <DataView :value="ratings" layout="grid">
        <template #grid="slotProps">
          <div class="p-col-12 p-md-3" style="padding: 0.5em;">
            <div class="product-grid-item card" style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 15px;">
              <Panel>
                <template #header>
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="pi pi-user" style="font-size: 1.5rem; color: #2196F3;"></i>
                    <span style="font-weight: bold; font-size: 1.1rem;">{{ slotProps.data.name }}</span>
                  </div>
                </template>
                <template #icons>
                  <i class="pi pi-star" style="color: #FFC107; font-size: 1.2rem;"></i>
                </template>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                  <span style="color: #666;">Оценка:</span>
                  <span style="font-size: 1.3rem; font-weight: bold; color: #2196F3;">
                    {{ slotProps.data.rating }}
                  </span>
                </div>
                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee; font-size: 0.8rem; color: #888;">
                  ID: {{ slotProps.data.id }}
                </div>
              </Panel>
            </div>
          </div>
        </template>
      </DataView>
      
      <Paginator 
        v-model:rows="rows" 
        :rowsPerPageOptions="[2, 5, 10, 50]" 
        :totalRecords="total" 
        @page="onPage"
        style="margin-top: 20px;"
      />
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import DataView from 'primevue/dataview'
import Panel from 'primevue/panel'
import ProgressSpinner from 'primevue/progressspinner'
import Paginator from 'primevue/paginator'
// ИСПРАВЛЕНО: Импортируем компонент кнопки из PrimeVue
import Button from 'primevue/button'

export default {
  name: 'Rating',
  components: {
    DataView,
    Panel,
    ProgressSpinner,
    Paginator,
    // ИСПРАВЛЕНО: Регистрируем компонент Button
    Button
  },
  data() {
    return {
      rows: 5,
      layout: 'grid'
    }
  },
  computed: {
    ...mapState({
      ratings: state => state.rating,
      dataPreLoading: state => state.dataPreLoading,
      total: state => state.pager.total || 0
    })
  },
  mounted() {
    if (this.$store.state.loggedIn) {
      this.getRating()
      this.$store.commit('setLoginError', false)
    } else {
      this.$router.push('/login')
    }
  },
  methods: {
    ...mapActions(['getRating']),
    onPage(event) {
      this.$store.commit('setPage', event.page + 1)
      this.getRating()
    },
    // ИСПРАВЛЕНО: Добавлен метод для обновления данных
    refreshData() {
      this.getRating()
    }
  }
}
</script>

<style scoped>
.p-text-center {
  text-align: center;
}
.card {
  background: white;
  transition: transform 0.2s ease;
}
.card:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>