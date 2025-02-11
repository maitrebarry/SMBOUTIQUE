  <!--------header------->
  <?php require_once ('partials/header.php') ?>
      <body>
   <!-------------sidebare----------->
    <?php require_once ('partials/sidebar.php')?>
 <!-------------navebare----------->
 <?php require_once ('partials/navbar.php')?>
    <!-------------contenu----------->
    
    <style>
    body {
    font-family: 'Lato', sans-serif;
        }

        .btn{
            border-radius: 50px;
            
        }

    </style>


    
    
<main id="main" class="main">
    <div class="card info-card sales-card">
		<div class="container-fluid">
    <h5 class="card-title">&emsp;Gestion des Commandes</h5>

    <div class="row justify-content-center">
			<div class="col-12 col-md-12 col-lg-12">
				<form action="" method="post" class="card card-sm">
					<div class="card-body row no-gutters align-items-center">
					
						<!--end of col-->
						<div class="col">            
						<select name="id" id="" class="form-control p-3" required>
						<option value="">Selectionner l'article</option>
						<?php foreach ($datas AS $row ) :?>
						<option value="<?=$row->id ?>"><?= $row->name ?></option>
						<?php endforeach ?>
						</select>
						</div>
					<!--end of col-->
					<div class="col-auto">
					<input type="submit" name="add_to_cart" style="margin-top:5px;"
           class="btn btn-primary float-right" value="Ajouter dans le panier" />	
					</div>
					<!--end of col-->
				</div>
			</form>
		</div>
		<!--end of col-->
	</div>
    <section class="section mt-5">
      <div class="row">
        <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
          <div class="card">
            <div class="card-body">
             
              <!-- Table with stripped rows -->
              <table class="col-md-12  table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>DESIGNATION</th>
                    <th>QUANTITE</th>
                    <th>PRIX ANGRO</th>
                    <th>PRIX UNITAIRE</th>
                    <th>MONTANT</th>
                    <th>ACTION</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                    <select name="" id=""class="form-control">
                      <option value=""class="form-control"></option>
                      <option value=""class="form-control"></option>
                    </select>
                    </td>
                    <td>
                    <input type="number" name="" class="form-control" value="">
                  </td>
                  <td>
                  <input type="number" name="" class="form-control" value="">
                  </td>
                  <td>
                  <input type="number" name="" class="form-control" value="" disabled="disabled">
                  </td>
                  <td>
                  <input type="text" name="" class="form-control" value=""disabled="disabled" >
                  </td>
                  <td>
                  <input type="text" name="" class="form-control" value="" >
                  </td>
                  </tr>
                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
                <div class="col-xl-4">
                      <div class="card text-left">
                      <div class="card-body">
                      <label>Référence </label><br><br>
                      <input type="" name="" class="form-control" value="" disabled="disabled"><br><br>
                      <label>Date </label><br><br>
                      <input type="date" name="" class="form-control" value=""><br><br>

                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
                          Client
                        </label>
                      </div>
                      <select name="" id=""class="form-control">
                          <option value=""class="form-control">Selectionner le Client</option>
                          <option value=""class="form-control"></option>
                        
                        </select>
                        <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
                          Nouveau Client
                        </label>
                      </div>
                      </div>
                    </div>
                </div>
            </div>
        <div class="row">
          <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
          <div class="card">
            <div class="card-body mt-3">
              <label for="">Date paiement</label><br><br>
            <input type="Date" name="" class="form-control" value=""><br><br>
            <button type="submit" class="btn btn-primary">Passer la commande</button>
              </div>
              </div>
              </div>

                <div class="col-xl-4">
                      <div class="card text-left">
                      <div class="card-body">
                      <label class="mt-2">REMISE</label><br><br>
                      <input type="number" name="" class="form-control" value=""><br><br>
                      <label>NET A PAYER </label><br><br>
                      <input type="number" name="" class="form-control" value=""><br><br>
                      </div>
                    </div>
                </div>
            </div>
          
        </section>





    <?php require_once ('partials/footer.php')?>
  </body>
</html>