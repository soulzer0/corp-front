<template>
  <div class="fw">
      <router-link 
        v-for="(prod, index) in products"
        v-bind:prod="prod"
        v-bind:index="index"
        v-bind:key="prod.id"
        :to="{ name: 'shop/:id', params: { id:prod.id}}"
        class="col-4 fw">
        <img :src="prod.img_grande" alt="">
        <p>{{ prod.nome }}</p>
        <p>{{ prod.preco }}</p>
      </router-link>
  </div>
</template>

<script>

import axios from 'axios'
export default {
  
  name: 'Products',

  data:function(){
    return {
      products:[
        // {
        //   id: 92,
        //   img:'../assets/_img/uploads/leque_frente.jpg',
        //   nome: 'Leque',
        //   preco: 'R$ 60,00'
        // },
        // {
        //   id: 2,
        //   img: '../assets/_img/uploads/rosto.png',
        //   nome: 'Rosto',
        //   preco: 'R$ 60,00'
        // },
        // {
        //   id: 3,
        //   img: '',
        //   nome: 'Posto',
        //   preco: 'R$ 60,00'
        // },
        // {
        //   id: 4,
        //   img: '../assets/_img/uploads/porta.jpg',
        //   nome: 'Porta',
        //   preco: 'R$ 60,00'
        // },
        // {
        //   id: 5,
        //   img: '../assets/_img/uploads/pasta.jpg',
        //   nome: 'Pasta',
        //   preco: 'R$ 60,00'
        // },
      ]
    }
  },
  created: function(){
        axios({
          method: 'post',
          url: 'http://localhost/corpiro.co/incs/api/productAPI.php',
          data: {
            action:'list'
          }
        }).then((response)=> {
        this.products = response.data
        // this.flashSuccess(response.data[0]);

       })
       .catch(function(error) {
        alert(error);
       });
  }
}
</script>
