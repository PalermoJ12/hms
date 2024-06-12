
<template>
  <div class="home">
    <h1>Appointment Management System</h1>
    
    <nav>
      <router-link to="/admin">Admin Dashboard</router-link> |
      <router-link to="/doctor">Doctor Dashboard</router-link> |
      <router-link to="/patient">Patient Dashboard</router-link>
    </nav>
  </div>
</template>

<style scoped>
.home {
  text-align: center;
  margin-top: 2rem;
}
nav {
  margin-top: 1rem;
}
nav a {
  margin: 0 1rem;
}
</style>
