<template>
  <section id="cart_checkout">
    <table id="cartDisplay">
      <thead>
        <tr>
          <th></th>
          <th>Nome do Produto</th>
          <th>Tamanho</th>
          <th>Quantidade</th>
          <th>Preço</th>
          <th>Remover</th>
        </tr>
      </thead>
      <tbody>
        
        <tr
          v-for="(item, index) in cartItens"
          v-bind:item="item"
          v-bind:index="index"
          v-bind:key="item.id"
        >
          <td> <img :src="item.img_pequena" alt="" srcset=""></td>
          <td>{{ item.nome }}</td>
          <td>{{ item.tamanho }}</td>
          <td>
            <div class="cql">
            <button class="qtd_btn menos" @click="subtraiQtd(index)">-</button>
            {{ item.quantidade }}
            <button class="qtd_btn mais" @click="somaQtd(index)">+</button>
          </div>
          </td>
          <td>
           R$ {{item.precototal}}
          </td>
          <td>
            <button class="delIt" @click="removeItem(index)"><font-awesome-icon icon="trash"  /></button>
            {{ item.itemID }}</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td>
            <input type="text" v-model='end.cep' @change="loadCep()" placeholder="CEP">
          </td>
          <td>
            <input type="text" v-model='end.uf' placeholder="Estado"> 
          </td>
          <td>
            <input type="text" v-model='end.cidade' placeholder="Cidade">
          </td>
          <td class="blast"></td>
          <td class="last">Total: R$ {{ totalProdutos }}</td>
        </tr>
        <tr>
          <td>
           <input type="text" v-model='end.bairro' placeholder="Bairro">
          </td>
          <td>
            <input type="text" v-model='end.numero' placeholder="Numero">
          </td>
          <td><input type="text" v-model='end.rua' placeholder="Rua"></td>
          <td class="blast"> </td>
          <td class="last">Frete: R$ {{ freteValor }}</td>
          <td> Entrega: até {{ freteTempo }} dias úteis</td>
        </tr>
        <tr>
          <td>
            
          </td>
          <td> 
          </td>
          <td></td>
          <td class="blast"> </td>
          <td class="last">Valor Final: R$ {{ valorTotal }}</td>
        </tr>

        <tr>
          <td>
            <input type="text" v-model='end.cpto' placeholder="Complemento">
          </td>
          <td> 
          </td>
          <td></td>
          <td class="blast"></td>
          <td class="last"></td>
        </tr>
        
      </tfoot>
    </table>
    <input type="submit" @click="procederCheckout()" value="Finalizar compra">
  </section>
</template>

<script>
import axios from 'axios';
// import cep from 'cep-promise'
 


export default {
  name: "Cart",
  props: {
    msg: String,
  },
  data: function () {
    return {
      itens:'',
      item:'',
      end:[{
        cep:'',
        uf:'',
        cidade:'',
        bairro:'',
        rua:'',
        numero:'',
        cpto:''
      }],
      freteValor:0,
      freteTempo:0,
      errors: [],
      

    };
  },
  computed: {
    logado() {
      return this.$store.getters.logado;
    },
       userID() {
      return this.$store.getters.userID;
    },
    cart() {
      return this.$store.getters.cart;
    },
    cartItens() {
      return this.$store.getters.cartItens;
    },
    totalProdutos() {
      return this.$store.getters.totalProdutos;
    },
    valorTotal(){
      return (parseFloat(this.freteValor) + parseFloat(this.totalProdutos)).toFixed(2)
    }
  },
  methods:{
    removeItem: function(index){
      this.flashInfo('Produto removido do carrinho');
      this.$store.commit({
        type:'removeCart',
        item: index
      })
    },
    somaQtd: function(index){
      // console.log(this.cartItens[index].limite );
      this.$store.commit({
        type: 'addQty',
        item: index
      })
       this.$store.commit({
        type: 'attPreco',
        item: index
      });
    },
    subtraiQtd: function(index){
      
      this.$store.commit({
        type: 'removeQty',
        item: index
      })
      this.$store.commit({
        type: 'attPreco',
        item: index
      });
    },
    loadCep: function (){
       axios({
          method: 'post',
          url: 'http://localhost/corpiro.co/incs/pagamento/correios.php',
          data: {
             action:'load_cep',
             cep:this.end.cep
           }
        }).then((response)=> {
        var newD = response.data.split("--"); 
        this.end.uf = newD[0];
        this.end.cidade = newD[1];
        this.end.bairro = newD[3];
        this.end.rua = newD[2];
        this.calculaFrete();
       })
       .catch(function(error) {
        this.flashError(error);
       });
    

    },
    checkCheckout: function () {

      this.errors = [];
     

      if (
        this.end.cep &&
        this.end.uf &&
        this.end.cidade &&
        this.end.bairro &&
        this.end.rua &&
        this.end.numero &&
        this.logado
      ) {
        return true;
      }
       if (!this.end.cep || this.end.cep =='') {
        this.errors.push("O campo de CEP é obrigatório.");
      }
      if (!this.end.uf || this.end.uf =='') {
        this.errors.push("O campo de UF é obrigatório.");
      }
    
      if (!this.end.cidade || this.end.cidade =='') {
        this.errors.push("O Cidade é obrigatório.");
      }
      if (!this.end.bairro || this.end.bairro =='') {
        this.errors.push("O campo de Bairro é obrigatório.");
      }

      if (!this.end.rua || this.end.rua =='') {
        this.errors.push("O campo de Rua é obrigatório.");
      }
      if (!this.end.numero || this.end.numero =='') {
        this.errors.push("O campo de numero é obrigatório.");
      }
      if (!this.logado) {
        this.errors.push("Você precisar estar logado para realizar uma compra!");
      }

     
    },
    procederCheckout: function(){
      console.log('teste');
      if(this.checkCheckout()){
        console.log('teste2');
         axios({
          method: 'post',
          url: 'http://localhost/corpiro.co/incs/pagamento/pagamento.php',
          data:{
              end: this.end,
              itens:this.cartItens,
              userID: this.userID
          }
        }).then((response)=> {
          console.log(response)
          // alert('ok');
          // this.cep = response.data
          // console.log(this.cep);
          // location.replace('https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code='+response.data);
       })
       .catch(function(error) {
        this.flashError(error);
       });
      } else{
        // console.log(this.errors);
        this.errors.forEach((el) => {
          console.log(el);
          this.flashError(el);
        });
      }
      
      
    },
    calculaFrete: function(){
      axios({
          method: 'post',
          url: 'http://localhost/corpiro.co/incs/pagamento/correios.php',
           data: {
             action:'calcula_frete',
             cep:this.end.cep
           }
        }).then((response)=> {
          console.log(response);
          var data = response.data.split('-')
          this.freteValor = parseFloat(data[0].replace(",", ".")).toFixed(2);
          this.freteTempo = data[1];
          // console.log(data[0]);
          // console.log(data[1]);
       })
       .catch(function(error) {
        this.flashError(error);
       });
    }
  },
  created() {
    console.log(this.cartItens);
    
    console.log(this.$store.getters.itemQtd);
    // this.itens = this.cartItens;
  },
};
</script>
<style >
.delIt{
  width:100px;
  border: none;
}
section#cart_checkout {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
}

table#cartDisplay {
  width: 100%;
  /* margin: 0 10%; */
  text-align: center;
  border-collapse: collapse;
}

thead tr {
  border-bottom: 1px solid black;
}

thead tr th:first-child {
  width: 10%;
}

thead tr th:nth-child(2) {
  width: 10%;
}

thead tr th:nth-child(3) {
  width: 30%;
}

thead tr th:nth-child(4) {
  width: 5%;
}

thead tr th:nth-child(5) {
  width: 25%;
}

thead tr th:nth-child(6) {
  width: 20%;
}

.cql {
  border-bottom: 1px solid blue;
  color: blue;
  width: max-content;
  /* width: 125px; */
  margin: auto;
}

th,
td {
  padding: 10px 30px;
}

td.blast {
  text-align: right;
}

td.last {
  text-align: left;
  padding: 10px 0;
}

tfoot {
  border-top: 1px solid black;
}

.cart_it_qt {
  -webkit-appearance: textfield;
  -moz-appearance: textfield;
  appearance: textfield;
  outline: none;
  border: none;
  height: 20px;
  width: 20px;
  padding: 1%;
  margin-bottom: 0;
  text-align: center;
}

.cart_it_qt::-webkit-inner-spin-button,
.cart_it_qt::-webkit-outer-spin-button {
  -webkit-appearance: none;
}

.qtd_btn {    
  height: 50px;
  width:50px;
  color: blue;
  font-size: 16px;
  padding: 1%;
  border: none;
  background-color: transparent;
  padding-left: 2%;
  padding-right: 2%;
  outline: none;
  cursor: pointer;
  margin-bottom: 0;
}
</style>