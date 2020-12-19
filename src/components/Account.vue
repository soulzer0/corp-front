<template>
  <div id="acc_home">
    <div class="acc_opt">Meus Pedidos</div>
    <div class="acc_opt">Meus Endereços</div>
    <div class="acc_opt">Minha Conta</div>
    <div id="acc_ped" class="acc_opt_block">
      <div class="pedi">
        <p>Codigo do Pedido:</p>
        <p>Data do pedido:</p>
        <p>Status do pedido:</p>
      </div>
    </div>
    <div id="acc_end" class="acc_opt_block">Endereços</div>
    <div id="acc_acc" class="acc_opt_block">
      <div id="edit_acc">
        <h4>Dados da conta</h4>
        <h5>
          Nessa seção você pode tanto cadastrar como alterar seu nome, email e
          telefone.
        </h5>
        <h5>
          Para solicitar uma alteração de senha você só precisa apertar
          <a class="old_link">aqui</a> e será enviado um email com as instruções
          para alteração de senha!
        </h5>
        <div>
          <label for="nome">Nome Completo:</label>
          <input type="text" name="nome" id="ac_nome" :value="infos.nome" />
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" name="email" id="ac_email" :value="infos.email" />
        </div>
        <div>
          <label for="telefone">Telefone</label>
          <input type="text" name="telefone" :value="infos.telefone" />
        </div>
        <input type="submit" value="Editar informações" style="margin: auto" />
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "Account",
  data: function () {
    return {
      pedidos: [],
      enderecos: [],
      infos: {
        nome: "",
        telefone: "",
        email: "",
      },
    };
  },
  computed: {
    logado() {
      return this.$store.getters.logado;
    },
    userid() {
      return this.$store.getters.user_id;
    },
    cartItens() {
      return this.$store.getters.cartItens;
    },
    totalProdutos() {
      return this.$store.getters.totalProdutos;
    },
  },
  methods: {},
  created() {
    axios({
      method: "post",
      url: "http://localhost/corpiro.co/incs/api/accountAPI.php",
      data: {
        action: "get_info",
        userid: this.userid,
      },
    }).then((response) => {
      var data = response.data.split("-");
      this.infos.email = data[2];
      this.infos.nome = data[0];
      this.infos.telefone = data[1];
    });
    // console.log(this.cartItens);
    // console.log(this.$store.getters.itemQtd);
    // this.itens = this.cartItens;
  },
};
</script>
<style>
div#acc_home {
  width: 70%;
  margin: auto;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  justify-content: space-between;
}

div#acc_home .acc_opt {
  width: 30%;
  height: 55px;
  display: flex;
  background: aliceblue;
  justify-content: center;
  align-items: center;
  transition: 0.5s box-shadow;
  cursor: pointer;
  text-decoration: none;
}

.acc_opt:hover {
  -webkit-box-shadow: 0px 18px 40px -12px rgba(255, 255, 255, 1);
  -moz-box-shadow: 0px 18px 40px -12px rgba(255, 255, 255, 1);
  box-shadow: 0px 18px 40px -12px rgba(255, 255, 255, 1);
}

.acc_opt.sel {
  text-decoration: underline;
}

.acc_opt_block {
  width: 100%;
  height: max-content;
  background: aliceblue;
  /* display: none; */
}

.acc_opt_block .pedi {
  width: 80%;
  margin: 2%;
  padding: 3%;
  height: max-content;
  background-color: transparent;
}
#edit_acc {
  width: 90%;
  margin: 5%;
  background-color: transparent;
  height: max-content;
  display: flex;
  flex-wrap: wrap;
}

#edit_acc h4,
#edit_acc h5 {
  width: 100%;
  background-color: transparent;
}

#edit_acc div {
  width: 230px;
  margin: 15px 15px 15px 0px;
  background-color: transparent;
}

#edit_acc div label {
  background-color: transparent;
}
</style>