<template>
  <div id="app">
    <Header msg="teste" />
    <div class="fw" id="content">
      <div class="col-2 col-m-1">

      </div>
      <div class="col-8 col-m-10">

      <router-view></router-view>

      </div>
      <div class="col-2 col-m-1">

      </div>
    </div>
    
    <Footer msg="CORPIRO" />
  </div>
</template>

<script>
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
// import axios from 'axios'
export default {
  name: "App",
  components: {
    Header,
    Footer,
  },
  created() {},
};
</script>

