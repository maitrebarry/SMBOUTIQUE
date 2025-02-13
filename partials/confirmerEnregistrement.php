
        <style>
            .bi-exclamation-triangle{
                    font-size: 90px;
                }
                
        </style>
         <!-- modal -->
              <div class="modal fade" id="basicModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-center"><i class="bi bi-exclamation-triangle text-primary"></i></p>
                          <h5 class="text-center text-primary"> Avertissement !</h5>
                       <p class="text-center"> Voulez-vous vraiment confirmer cette action ?</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">                  
                        <button type="submit" name="<?=$button_name?>"  class="btn btn-primary">Confirmer</button>
                         <button type="button" class="btn btn-info" data-bs-dismiss="modal">Annuler</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- End Basic Modal-->
    <!-- modal -->
              <div class="modal fade" id="basicModal1" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-center"><i class="bi bi-exclamation-triangle text-danger"></i></p>
                          <h5 class="text-center text-danger"> Attention !</h5>
                       <p class="text-center"> Le montant reçu ne doit pas être négatif ?</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal"id="annuler_button1">Annuler</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- End Basic Modal--><!-- modal -->
              <div class="modal fade" id="basicModal2" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-center"><i class="bi bi-exclamation-triangle text-danger"></i></p>
                          <h5 class="text-center text-danger"> Attention !</h5>
                       <p class="text-center"> La remise ne doit pas être négative ?</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal"id="annuler_button">Annuler</button>
                    </div>
                  </div>
                </div>
              </div>
          <!-- End Basic Modal-->