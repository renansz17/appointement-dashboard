<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router';
import { PhHouse } from '@phosphor-icons/vue';
</script>

<template>
  <div class="layout">
    <header class="sidebarMenu">
      <RouterLink to="/">
        <PhHouse :size="32" color="white" />
      </RouterLink>
    </header>
    <main class="main">
      <RouterView />
    </main>
  </div>
</template>

<style scoped lang="scss">
.layout {
  display: flex;
  height: 100vh; 
}

.sidebarMenu {
  display: flex;
  flex-direction: column;
  width: 60px;
  background-color: rgb(31, 31, 31);
  align-items: center;
  border-top-right-radius: 10px;
  padding-top: 10px;
}

.main {
  flex: 1;
  padding: 48px; 
  align-items: center;
  justify-content: center;
}
</style>
