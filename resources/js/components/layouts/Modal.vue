<template>

      <!-- Modal -->
      <div class="modal fade" :id="id_modal" tabindex="-1" :aria-labelledby="modal_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" :id="modal_label">{{modal_title}}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <slot name="alertas"></slot>
              <slot name="conteudo"></slot>
            </div>
            <div class="modal-footer">
                <slot name="botoes"></slot>
            </div>
          </div>
        </div>
      </div>


</template>

<script>
export default {
  props: ["id_modal", "modal_label", "modal_title"],
};
</script>