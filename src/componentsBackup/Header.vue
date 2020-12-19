<template>

    <section id="header">
            <fixed-header >
                <div class="navbar">
  <Marquee content="33,33333/100 OFFFF" />
            <div class="menu">
                <router-link to="/shop/" class="link-menu ">SHOP</router-link>
                
                <router-link to="/about/" class="link-menu ">ABOUT</router-link>
               
                    
                
                
                <router-link to="/login/" v-if="!logado" class="link-menu">LOG IN</router-link>
                
               
                <router-link to="/cart/" class="link-menu">CART</router-link>
                
                
                <router-link to="/account/" v-if="logado"  class="link-menu">ACCOUNT</router-link>

                <a v-if="logado" @click="logout()" class="link-menu">LOGOUT</a>
              
            </div>
                </div>
         
              </fixed-header>
            <div class="logo"></div>
            <div class="fixText">
                <p>Materializing technical effects to personal utility <br>of a recent past projected for the future</p>
                <Clock />
                <img src="../assets/_img/rosa_ponta.png" alt="">
                <p>Built to stay and Age</p>
                <p>{{ hoverCode }}</p>
            </div>
            <flash-message class="notifications" transitionIn="animated swing"></flash-message>
    </section>
  
</template>
<script>
import Marquee from './Marquee.vue'
import Clock from './Clock.vue'
import FixedHeader from 'vue-fixed-header'
export default {
  name: 'Header',
  
  props: {
    msg: String
  },
  computed: {
      hoverCode (){
          return this.$store.getters.hoverCode
      },
      logado (){
         return this.$store.getters.logado
      },
      cart (){
         return this.$store.getters.cart
      }
  },
  components:{
      Marquee:Marquee,
      Clock:Clock,FixedHeader
  },
  methods:{
      logout: function(){
          
          this.$store.commit('logout');
          this.flashInfo("Logout realizado!");
      }
  },
  created() {
      

  }
}

</script>
<style>
.navbar{
    width: 100vw;
    z-index: 100000;
}
.navbar.vue-fixed-header--isFixed {
  position: fixed;
  left: 0;
  top: 0;

}
.notifications{
    position: absolute;
    right: 10px;
    top: 60px;
}
.flash__message {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    padding: 15px 30px 15px 15px;
    margin-bottom: 10px;
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: #ccc;
    position: relative;
}
.flash__close-button {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    position: absolute;
    top: 0;
    right: 0;
    color: inherit;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
    line-height: 10px;
    margin: 0;
    padding: 8px;
}
.flash__message.error {
    color: #a94442;
    background-color: transparent;
    border-color: #a94442;
}
.flash__message.success {
    color: #3c763d;
    background-color: transparent;
    border-color: #3c763d;
}
.flash__message.info {
    color: #37516a;
    background-color: transparent;
    border-color: #37516a;
}
.flash__message.warning {
    color: #8a6d3b;
    background-color: transparent;
    border-color: #8a6d3b;
}
.link-menu {
    background: black;
}
div.menu {
    padding: 0 30%;
    background: black;
    color: white;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: space-around;
}

div.logo {
    background-image: url('../assets/_img/logo.png');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    width: 100%;
    height: 40px;
    margin: 5% 0;
}

div.fixText {
    width: 360px;
    font-weight: 700;
    position: absolute;
    top: 130px;
    left: 80px;
    background-color: transparent;
}

div.fixText img {
    width: 100px;
    margin: auto;
    background-color: transparent;
}

div.fixText p {
    background-color: transparent;
}

</style>