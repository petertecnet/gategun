<template>
    <div>
      <!-- Select da cidade e ícone de notificação -->
      <div class="header">
        <select v-model="selectedCity">
          <option value="">Selecione a cidade</option>
          <option v-for="city in cities" :value="city">{{ city }}</option>
        </select>
        <i class="notification-icon"></i>
      </div>
  
      <!-- Carrossel de datas dos eventos -->
      <div class="date-carousel">
        <div v-for="(date, index) in dates" :key="index" class="date-item">
          <div class="day-of-week">{{ date.dayOfWeek }}</div>
          <div class="day-of-month">{{ date.dayOfMonth }}</div>
        </div>
      </div>
  
      <!-- Timeline de cards de eventos -->
      <div class="event-timeline">
        <div v-for="event in events" :key="event.id" class="event-card">
          <img :src="event.imageUrl" alt="Imagem do evento" class="event-image">
          <h3 class="event-title">{{ event.title }}</h3>
          <p class="event-location">{{ event.location }}</p>
          <p class="event-date">{{ event.date }}</p>
          <p class="event-price">{{ event.price }}</p>
          <div class="event-classification">{{ event.classification }}</div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        selectedCity: '',
        cities: ['Cidade 1', 'Cidade 2', 'Cidade 3'],
        dates: [
          { dayOfWeek: 'Seg', dayOfMonth: '01' },
          { dayOfWeek: 'Ter', dayOfMonth: '02' },
          { dayOfWeek: 'Qua', dayOfMonth: '03' },
          { dayOfWeek: 'Qui', dayOfMonth: '04' },
          { dayOfWeek: 'Sex', dayOfMonth: '05' },
          { dayOfWeek: 'Sáb', dayOfMonth: '06' },
          { dayOfWeek: 'Dom', dayOfMonth: '07' }
        ],
        events: [
          {
            id: 1,
            imageUrl: 'path/to/event-image.jpg',
            title: 'Título do Evento 1',
            location: 'Local do Evento 1',
            date: 'Quinta 18 Maio | 20:00',
            price: 'R$ 20,00',
            classification: 'Classificação 1'
          },
          {
            id: 2,
            imageUrl: 'path/to/event-image.jpg',
            title: 'Título do Evento 2',
            location: 'Local do Evento 2',
            date: 'Sexta 19 Maio | 19:30',
            price: 'R$ 15,00',
            classification: 'Classificação 2'
          },
          {
            id: 3,
            imageUrl: 'path/to/event-image.jpg',
            title: 'Título do Evento 3',
            location: 'Local do Evento 3',
            date: 'Sábado 20 Maio | 21:00',
            price: 'R$ 25,00',
            classification: 'Classificação 3'
          }
        ]
      };
    }
  };
  </script>
  <style scoped>
  /* Outros estilos específicos do componente LoginView.vue */
  
  @import url('@/assets/css/gategun.css');
  </style>