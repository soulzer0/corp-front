<template>
  <div class="board">
    <div id="signupForm">
      <h3 class="f1">CRIE SUA CONTA</h3>
      <!-- <label for="nome">NAME</label>
            <input type="text" name="nome" id=""> -->
      <div class="fw">
        <label for="nome">NOME COMPLETO</label>
        <input type="text" name="nome" v-model="nome" required />
        <label for="email">EMAIL</label>
        <input type="email" v-model="pemail" name="email" required />
      </div>
      <div class="fw">
        <label for="telefone">TELEFONE</label>
        <input
          type="tel"
          v-model="telefone"
          name="telefone"
          placeholder="(xx)xxxxx-xxxx"
          pattern="([0-9]{2})[0-9]{5}-[0-9]{4}"
          required
        />
      </div>
      <div class="fw">
        <label for="pwd">SENHA</label>
        <input type="password" v-model="psenha" name="pwd" required />
      </div>
      <div class="fw">
        <label for="cpwd">CONFIRME SUA SENHA</label>
        <input type="password" v-model="csenha" name="cpwd" required />
      </div>
      <input type="submit" @click="create()" class="l_btn" value="REGISTRAR" />
    </div>

    <div id="loginForm">
      <h3 class="f1">LOG IN</h3>

      <div class="fw">
        <label for="email">EMAIL</label>
        <input type="email" v-model="email" name="email" required />
      </div>
      <div class="fw">
        <label for="pwd">SENHA</label>
        <input type="password" v-model="senha" name="pwd" required />
      </div>

      <input type="submit" @click="login()" value="LOG IN" />
      <div class="tac">
        <!-- <div>
                    <label id="ls" for="lembrar_senha">LEMBRAR SENHA</label>
                    <input type="checkbox" name="lembrar_senha">
                </div> -->
        <a class="old-link f8" href="">ESQUECEU A SENHA?</a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Login",
  data() {
    return {
      email: "",
      senha: "",
      errors: [],
      nome: "",
      telefone: "",
      pemail: "",
      psenha: "",
      csenha: "",
      reg:
        '/^(([^<>()[].,;:s@"]+(.[^<>()[].,;:s@"]+)*)|(".+"))@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}])|(([a-zA-Z-0-9]+.)+[a-zA-Z]{2,24}))$/',
    };
  },
  methods: {
    checkFormRegister: function () {
      this.errors = [];
      if (
        this.nome &&
        this.telefone &&
        this.pemail &&
        this.csenha &&
        this.psenha
      ) {
        // if (this.reg.test(this.pemail)) {
        //   return true;
        // } else {
        //   this.errors.push("Email Inválido.");
        // }
        return true;
      }

      if (!this.nome) {
        this.errors.push("O nome é obrigatório.");
      }
      if (!this.pemail) {
        this.errors.push("O email é obrigatório.");
      }
      if (!this.psenha) {
        this.errors.push("A senha é obrigatória.");
      }
      if (!this.csenha) {
        this.errors.push("Confirmação de senha é obrigatória.");
      }

      if (!this.telefone) {
        this.errors.push("Telefone é obrigatório.");
      }
    },
    checkFormLogin: function () {
      this.errors = [];
      if (this.email && this.senha) {
        return true;
      }
      if (!this.email) {
        this.errors.push("O email é obrigatório.");
      }
      if (!this.senha) {
        this.errors.push("A senha é obrigatória.");
      }
    },
    login: function () {
      if (this.checkFormLogin()) {
        axios({
          method: "post",
          url: "http://localhost/corpiro.co/incs/api/accountAPI.php",
          data: {
            action: "enter_ac",
            mail: this.email,
            pwd: this.senha,
          },
        })
          .then((response) => {
            // this.msg = response.data
            // this.flashSuccess(this.msg);
            this.$store.commit("login", response.data);
            console.log(response.data);
            this.flashSuccess("Login realizado com sucesso!");
          })
          .catch(function (error) {
            this.flashError(error);
          });
      } else {
       this.errors.forEach((el) => {
          this.flashError(el);
        });
      }
    },
    create: function () {
      if (this.checkFormRegister()) {
        axios({
          method: "post",
          url: "http://localhost/corpiro.co/incs/api/accountAPI.php",
          data: {
            action: "create_ac",
            email: this.pemail,
            senha: this.psenha,
            telefone: this.telefone,
            csenha: this.csenha,
            nome: this.nome,
          },
        })
          .then((response) => {
            this.resp = response.data;
            console.log(this.resp);

            // if (response.data[0].status == 1) {
            //  alert('Login Successfully');
            // } else {
            //  alert("User does not exist");
            // }
          })
          .catch(function (error) {
            alert(error);
          });
      } else {
        this.errors.forEach((el) => {
          this.flashError(el);
        });
      }
    },
  },
};
</script>
<style>
/* #loginForm,
#signupForm {
  width: 40%;
  height: max-content;
} */
</style>
