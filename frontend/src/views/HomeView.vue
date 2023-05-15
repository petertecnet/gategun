<template>
    <div class="home-screen">
      <div class="header">
        <select v-model="selectedCity">
          <option v-for="city in cities" :value="city.id" :key="city.id">{{ city.name }}</option>
        </select>
        <div class="notification-icon">
          <i class="fas fa-bell"></i>
        </div>
      </div>
      <div class="events-carousel">
        <div v-for="event in events" :key="event.id" class="event-item">
          <div class="day-of-week">{{ getDayOfWeek(event.date) }}</div>
          <div class="day-of-month">{{ getDayOfMonth(event.date) }}</div>
        </div>
      </div>
      <div class="timeline">
        <div v-for="event in events" :key="event.id" class="event-card">
          <div class="event-image">
            <img :src="event.image" alt="Event Image" />
          </div>
          <div class="event-title">{{ event.title }}</div>
          <div class="event-location">{{ event.location }}</div>
          <div class="event-date">{{ formatDate(event.date) }}</div>
          <div class="event-price">{{ event.price }}</div>
          <div class="event-rating">
            <span class="rating-label">Classificação:</span>
            <div class="rating-stars">
              <i v-for="eventStar in event.rating" class="fas fa-star"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>


<script>
export default {
  data() {
    return {
      selectedCity: null,
      cities: [
        { id: 1, name: "City A" },
        { id: 2, name: "City B" },
        { id: 3, name: "City C" },
      ],
      events: [
        {
          id: 1,
          title: "Event 1",
          location: "Location 1",
          date: "2023-05-20",
          price: "$10",
          rating: 4,
          image: "https://example.com/event1.jpg",
        },
        {
          id: 2,
          title: "Event 2",
          location: "Location 2",
          date: "2023-05-21",
          price: "$15",
          rating: 5,
          image: "https://example.com/event2.jpg",
        },
        {
          id: 3,
          title: "Event 3",
          location: "Location 3",
          date: "2023-05-22",
          price: "$20",
          rating: 3,
          image: "https://example.com/event3.jpg",
        },
      ],
    };
  },
  methods: {
    getDayOfWeek(date) {
      const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      const eventDate = new Date(date);
      return daysOfWeek[eventDate.getDay()];
    },
    getDayOfMonth(date) {
      const eventDate = new Date(date);
      return eventDate.getDate();
    },
    formatDate(date) {
      const eventDate = new Date(date);
      const options = { weekday: "long", month: "short", day: "numeric", hour: "numeric", minute: "numeric" };
      return eventDate.toLocaleString("en-US", options);
    },
  },
};
</script>


  <style scoped>
  /* Estilos específ
  
  <style scoped>
  /* Outros estilos específicos do componente LoginView.vue */
  
  @import url('@/assets/css/gategun.css');
  </style>