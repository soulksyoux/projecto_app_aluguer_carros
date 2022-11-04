<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Pesquisar marcas</div>

          <div class="card-body">
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
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8 mt-3">
        <div class="card">
            <div class="card-header">Resultados pesquisa</div>
            <div class="card-body">
                <table-component></table-component>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button class="btn btn-primary btn-sm">Adicionar</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: ["marcas"],
    }
</script>
