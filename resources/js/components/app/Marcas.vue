<template>
  <div class="container">
    <div class="row justify-content-center">
      <modal-component
        id_modal="modal_marcas"
        modal_label="modal_marcas_label"
        modal_title="Adicionar Marca"
      >
        <template v-slot:alertas>
          <alert-component
            v-if="sucesso == true"
            type="success"
            message="Registo gravado com sucesso!"
          ></alert-component>
          <alert-component
            v-if="sucesso == false"
            type="danger"
            :message="mensagem_erro"
          ></alert-component>
        </template>
        <template v-slot:conteudo>
          <div class="mb-3">
            <input-container-component titulo="Nome" idInput="novoNome">
              <input
                type="text"
                class="form-control"
                id="nome"
                placeholder="Introduza o nome"
                v-model="nomeMarca"
              />
            </input-container-component>
            {{ nomeMarca }}
          </div>

          <div class="mb-3">
            <input-container-component titulo="Imagem" idInput="imagem">
              <input
                type="file"
                class="form-control"
                id="imagem"
                placeholder="Selecione a imagem"
                @change="carregarImagem($event)"
              />
            </input-container-component>
            {{ arquivoImagem }}
          </div>
        </template>

        <template v-slot:botoes>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Fechar
          </button>
          <button type="button" class="btn btn-primary" @click="gravarMarca()">
            Gravar
          </button>
        </template>
      </modal-component>

      <modal-component
        id_modal="ver_marca_modal"
        modal_label="modal_ver_marca_label"
        modal_title="Ver Marca"
      >
        <template v-slot:alertas></template>
        <template v-slot:conteudo>
          <input-container-component titulo="ID">
            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
          </input-container-component>
          <input-container-component titulo="Marca">
            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
          </input-container-component>
          <input-container-component titulo="Imagem">
            <img :src="'/storage/' + $store.state.item.imagem"  v-if="$store.state.item.imagem" alt="">
          </input-container-component>
          <input-container-component titulo="Cria????o">
            <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
          </input-container-component>
        </template>
        <template v-slot:botoes>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Fechar
          </button>
        </template>
      </modal-component>

      <modal-component
        id_modal="eliminar_marca_modal"
        modal_label="modal_eliminar_marca_label"
        modal_title="Eliminar Marca"
      >
        <template v-slot:alertas>
           <alert-component
            v-if="$store.state.transacao.status == 'sucesso'"
            type="success"
            :message="$store.state.transacao.mensagem" 
          ></alert-component>
          <alert-component
            v-if="$store.state.transacao.status == 'erro'"
            type="danger"
            :message="$store.state.transacao.mensagem" 
          ></alert-component>
        </template>
        <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
          Deseja eliminar a marca?
          <input-container-component titulo="ID">
            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
          </input-container-component>
          <input-container-component titulo="Marca">
            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
          </input-container-component>
        </template>
        <template v-slot:botoes>
          <button type="button" class="btn btn-danger" @click="eliminarMarca()" v-if="$store.state.transacao.status != 'sucesso'">
            Sim
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Fechar
          </button>
        </template>
      </modal-component>

      <div class="col-md-8">
        <div class="card">
          <card-component titulo="Pesquisar marcas" fc="card-footer">
            <template v-slot:card-body-data>
              <div class="mb-3">
                <input-container-component titulo="Id" idInput="id">
                  <input
                    type="number"
                    class="form-control"
                    id="id"
                    placeholder="Introduza o id"
                    v-model="busca.id"
                  />
                </input-container-component>
              </div>
              <div class="mb-3">
                <input-container-component titulo="Nome" idInput="nome">
                  <input
                    type="text"
                    class="form-control"
                    id="nome"
                    placeholder="Introduza o nome"
                    v-model="busca.nome"
                  />
                </input-container-component>
              </div>
              <div class="col-12"></div>
            </template>
            <template v-slot:card-footer-data>
              <button type="submit" class="btn btn-primary" @click="pesquisar()">Pesquisar</button>
            </template>
          </card-component>
        </div>
      </div>

      <div class="col-md-8 mt-3">
        <div class="card">
          <card-component
            titulo="Apresentar Marcas"
            fc="card-footer d-flex justify-content-end"
          >
            <template v-slot:card-body-data>
              <table-component
                :dados="marcas"
                :ver="{visivel: true,  dataBsToggle: 'modal', dataBsTarget: '#ver_marca_modal'}"
                :editar=true
                :eliminar="{visivel: true,  dataBsToggle: 'modal', dataBsTarget: '#eliminar_marca_modal'}"
                :titulos="titulos"
              ></table-component>
            </template>

            <template v-slot:pagination>
              <paginate-component class="d-flex justify-content-center">
                <li
                  v-for="(link, key) in links_pagination"
                  :key="key"
                  :class="link.active ? 'page-item active'  : 'page-item'"
                >
                  <a
                    class="page-link"
                    v-html="link.label"
                    @click="paginacao(link)"
                    style="cursor:pointer"
                    
                  ></a>
                </li>
              </paginate-component>
            </template>

            <template v-slot:card-footer-data>
              <button
                class="btn btn-primary"
                btn-sm
                data-bs-toggle="modal"
                data-bs-target="#modal_marcas"
              >
                Adicionar
              </button>
            </template>
          </card-component>
        </div>
      </div>
    </div>
  </div>
</template>




<script>
export default {
  data() {
    return {
      urlBase: "http://127.0.0.1:8000/api/v1/marca",
      urlPaginacao: "",
      urlFiltro: "",
      nomeMarca: "",
      arquivoImagem: [],
      sucesso: null,
      mensagem_erro: "",
      marcas: [],
      links_pagination: [],
      titulos: ["Id", "Nome", "Imagem", "Created At"],
      busca: {
        id: '',
        nome: ''
      }
    };
  },
  computed: {
    getToken() {
      let name = "token" + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(";");
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return "Bearer " + c.substring(name.length, c.length);
        }
      }
      return "";
    },
  },
  methods: {
    carregarImagem(e) {
      this.arquivoImagem = e.target.files;
    },
    async gravarMarca() {
      let formData = new FormData();
      formData.append("nome", this.nomeMarca);
      formData.append("imagem", this.arquivoImagem[0]);

      let config = {
        headers: {
          "Content-Type": "multipart/form-data",
          Accept: "application/json",
          Authorization: this.getToken,
        },
      };

      try {
        const resposta = await axios.post(this.urlBase, formData, config);
        //console.log(resposta);
        this.sucesso = true;
      } catch (erro) {
        console.log(erro.response);
        this.sucesso = false;
        this.mensagem_erro = "Erro na grava????o: " + erro.response.data.message;
      }
    },
    async obterMarcas() {
      let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro;
      console.log(url);

      let config = {
        headers: {
          Accept: "application/json",
          Authorization: this.getToken,
        },
      };

      try {
        const resposta = await axios.get(url, config);
        const marcas_temp = resposta.data.data;

        this.marcas = marcas_temp.map((marca) => {
          return {
            id: marca.id,
            nome: marca.nome,
            imagem: marca.imagem,
            created_at: marca.created_at,
          };
        });

        this.links_pagination = resposta.data.links;
      } catch (erro) {
        console.log(erro.response);
      }
    },
    async paginacao(l) {
      if(l.url != null) {
        this.urlPaginacao = l.url.split("?")[1];
        this.obterMarcas();
      }
    },
    async pesquisar(){
      let filtro = "";
      for(let key in this.busca) {
        if(this.busca[key]) {
          if(filtro != '') {
            filtro += ";";
          }
          filtro += key + ':like:' + this.busca[key];
        }
      }
      if(filtro != '') {
        this.urlPaginacao = "page=1";
        this.urlFiltro = '&filtros=' + filtro;
      }else{
        this.urlFiltro = '';
      }
      this.obterMarcas();
    },
    async eliminarMarca() {
      let confirmacao = confirm("Tem a certeza que deseja eliminar o item?");
      if(!confirmacao) {
        return;
      }

      let config = {
        headers: {
          Accept: "application/json",
          Authorization: this.getToken,
        },
      };

      let url = this.urlBase + "/" + this.$store.state.item.id;

      let formData = new FormData();
      formData.append("_method", "delete");

      //this.$store.state.transacao.status = "erro";
      //this.$store.state.transacao.mensagem = "Registo eliminado com sucesso";
      
      try {
        const resposta = await axios.post(url, formData, config);
        this.$store.state.transacao.status = "sucesso";
        this.$store.state.transacao.mensagem = resposta.data.msg;
        this.obterMarcas();
      } catch (erro) {
          this.$store.state.transacao.status = "erro";
          this.$store.state.transacao.mensagem = erro.response.data.erro;
      }
      
      
    }
  },
  mounted() {
    this.obterMarcas();
  },
};
</script>
