<template>
  <div class="container">
    <div class="row justify-content-center">
      <modal-component
        id_modal="modal_marcas"
        modal_label="modal_marcas_label"
        modal_title="Adicionar Marca"
      >
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
                  />
                </input-container-component>
              </div>
              <div class="col-12"></div>
            </template>
            <template v-slot:card-footer-data>
              <button type="submit" class="btn btn-primary">Pesquisar</button>
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
              <table-component></table-component>
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
      nomeMarca: "",
      arquivoImagem: [],
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
        console.log(resposta);
      } catch (erro) {
        console.log(erro);
      }
    },
  },
};
</script>
