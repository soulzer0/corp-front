<template>
  <div class="prodisplay">
    <div class="imgs">
      <img :src="selImg.img_grande" class="img-grande" />
      <div class="imgs-peq">
        <img
          v-for="(img, index) in imgs"
          v-bind:img="img"
          v-bind:index="index"
          v-bind:key="img.id"
          :src="img.img_pequena"
          @click="changeImg(img)"
          :class="selImg.id == img.id ? 'img_sel' : ''"
          class="i"
        />
      </div>
    </div>
    <div class="text">
      <h2>{{ nome }}</h2>
      <br />
      <h3 class="te">{{ codigo }}</h3>
      <br />
      <p>R$ {{ preco }}</p>
      <br />
      <p>{{ desc }}</p>
      <br />
      <div>
        <select
          v-model="tam"
          name="tamanho"
          @change="onChange($event)"
          required
        >
          <option selected disabled value="">Selecione um tamanho</option>
          <option v-if="m > 0" value="m">M</option>
          <option v-if="g > 0" value="g">G</option>
          <option v-if="gg > 0" value="gg">GG</option>
          <option v-if="xg > 0" value="xg">XG</option>
        </select>

        <input
          type="number"
          v-model="qtd"
          name="qtd"
          :min="1"
          :max="this.qtd_max"
          required
          placeholder="Quantidade"
        />
        <input type="submit" @click="addCart()" value="ADCIONAR AO CARRINHO" />
      </div>
    </div>
  </div>
  <!-- <div class="hello">
      {{ $route.params.id }}
  </div> -->
</template>

<script>
import axios from "axios";
// import faCartPlus  from '@fortawesome/free-solid-svg-icons'
export default {
  name: "ShopDetail",
  props: {
    msg: String,
  },
  computed: {
    userID() {
      return this.$store.getters.user_id;
    },
    logado() {
      return this.$store.getters.logado;
    },
    cart() {
      return this.$store.getters.cart;
    },
  },
  data: function () {
    return {
      id: this.$route.params.id,
      codigo: "",
      nome: "",
      desc: "",
      preco: "",
      m: "",
      g: "",
      gg: "",
      xg: "",
      qtd: "0",
      qtd_max: "0",
      tam: "",
      imgs: [],
      selImg: "",
    };
  },
  methods: {
    onChange: function (event) {
      switch (event.target.value) {
        case "m":
          this.qtd_max = this.m;
          break;

        case "g":
          this.qtd_max = this.g;
          break;

        case "gg":
          this.qtd_max = this.gg;
          break;

        case "xg":
          this.qtd_max = this.xg;
          break;
      }
    },
    addCart: function () {
      this.$toasted.show("Produto adcionado ao carrinho",{
        icon :'cart-plus'
        
});
      var userID = "0";
      var pedidoID = " 0";
      if (this.logado) {
        userID = this.userID;
        pedidoID = this.cart.id;
      }
      // var prod = {
      //      'produtoID' : this.id,
      //      'clienteID' : userID,
      //      'pedID' : pedidoID,
      //      'img_pequena': this.selImg.img_pequena,
      //      'nome': this.nome,
      //      'precoU': this.preco,
      //      'quantidade': this.qtd,
      //      'precototal': this.qtd * this.preco,
      //      'tamanho': this.tam
      //   };
      if(this.qtd >= 1 && this.tam != ""){
        this.$store.commit({
        type: "addCart",
        item: {
          produtoID: this.id,
          clienteID: userID,
          pedID: pedidoID,
          img_pequena: this.selImg.img_pequena,
          nome: this.nome,
          precoU: this.preco,
          quantidade: this.qtd,
          precototal: this.qtd * this.preco,
          tamanho: this.tam,
          limite: this.qtd_max
        },
      });
      // console.log(this.$store.getters.cart)
      this.flashInfo("Produto adcionado ao carrinho!");
      } else{
      this.flashError("Selecione o tamanho e quantidade para adcionar ao carrinho!");
      }
      
      //
    },
    changeImg: function (img) {
      this.selImg = img;
    },
  },
  created: function () {
    axios({
      method: "post",
      url: "http://localhost/corpiro.co/incs/api/productAPI.php",
      data: {
        action: "gets",
        id: this.id,
      },
    })
      .then((response) => {
        // // this.products = response.data
        // // this.flashSuccess(response.data[0]);
        console.log(response.data);
        this.id = response.data.prod_data[0].id;
        this.codigo = response.data.prod_data[0].codigo;
        this.nome = response.data.prod_data[0].nome;
        this.desc = response.data.prod_data[0].descricao;
        this.preco = response.data.prod_data[0].preco;

        this.m = response.data.prod_data[0].m;
       
        this.g = response.data.prod_data[0].g;
        
        this.gg = response.data.prod_data[0].gg;
        
        this.xg = response.data.prod_data[0].xg;
        response.data.prod_imgs.forEach((el) => {
          this.imgs.push(el);
        });
        this.selImg = this.imgs[0];
      })
      .catch(function (error) {
        alert(error);
      });
   
  },
};
</script>
<style>
.img_sel {
  border: 1px solid black;
}
div.prodisplay {
  width: 80%;
  display: flex;
  justify-content: center;
}

div.prodisplay .imgs {
  width: 50%;
}

div.prodisplay .imgs .img-grande {
  width: 100%;
  height: 600px;
  background-size: contain;
  background-repeat: no-repeat;
}

div.imgs-peq {
  width: 100%;
  display: flex;
}

div.imgs-peq .i {
  width: 120px;
  background-position: center;
  background-size: contain;
  height: 120px;
  margin: 15px;
}
</style>