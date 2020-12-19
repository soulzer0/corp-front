<template>
  <section id="header" class="col-12">
   
      <div class="navbar">
        <Marquee class="Marquee" content="33,33333/100 OFFFF" />
        <div id="Menu">
          <router-link to="/shop/" class="link-menu">SHOP</router-link>

          <router-link to="/about/" class="link-menu">ABOUT</router-link>


          <router-link to="/login/" v-if="!logado" class="link-menu"
            >LOG IN</router-link>

          <router-link to="/cart/" class="link-menu">CART</router-link>

          <router-link to="/account/" v-if="logado" class="link-menu"
            >ACCOUNT</router-link>

          <a v-if="logado" @click="logout()" class="link-menu">LOGOUT</a>
        </div>
      </div>
    <div class="logo"></div>
    <div class="fixText">
      <p>
        Materializing technical effects to personal utility <br />of a recent
        past projected for the future
      </p>
      <Clock />
      <img src="../assets/_img/rosa_ponta.png" alt="" />
      <p>Built to stay and Age</p>
      <!-- <p>{{ hoverCode }}</p> -->
    </div>
    <!-- <flash-message class="notifications" transitionIn="animated swing"></flash-message> -->
  </section>
</template>
<script>
import Marquee from "./Marquee.vue";
import Clock from "./Clock.vue";
export default {
  name: "Header",

  props: {
    msg: String,
  },
  computed: {
    hoverCode() {
      return this.$store.getters.hoverCode;
    },
    logado() {
      return this.$store.getters.logado;
    },
    cart() {
      return this.$store.getters.cart;
    },
  },
  components: {
    Marquee: Marquee,
    Clock: Clock,
  },
  methods: {
    logout: function () {
      this.$store.commit("logout");
      this.flashInfo("Logout realizado!");
    },
  },
  created() {},
};
</script>