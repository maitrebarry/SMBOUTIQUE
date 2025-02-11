
 <title>detail depense</title>
</head>

<body>
    <!-- Header -->
    <?php 
    require_once('partials/header.php') ?>

    <!-- Sidebar -->
    <?php require_once('partials/sidebar.php') ?>

    <!-- Navbar -->
    <?php require_once('partials/navbar.php') ?>
     <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px; /* Hauteur du pied de page */
            background-color: #f5f5f5; /* Ajoutez la couleur de fond souhaitée */
        }
    </style>
    <!-- Contenu principal -->
<section class="section">
  <main id="main" class="main" >
       <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                <li class="breadcrumb-item">Caisse</li>
                <li class="breadcrumb-item active">Dépenses</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
   <div class="row">
    <div class="col-lg-1">
    </div>
    <div class="col-lg-10">
        <div class="card">
             <?php require_once('partials/afficher_message.php') ?>
            <div class="card-body">
                <h5 class="card-title"></h5>
                <!-- General Form Elements -->
                <form method="POST" >
                    <div class="row mb-4">
                        <label for="inputText" class="col-sm-2 col-form-label">Référence caisse<span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <input type="text" name="ref_caisse" class="form-control"value="<?=$recuperer->reference_caisse?>"readOnly> 
                        </div>
                        <label for="inputText" class="col-sm-3 col-form-label">Libellé(50 lettres au max)<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" name="libelle" class="form-control" value="<?=$recuperer->libelle?>"readOnly>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Montant<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="number" name="montant" class="form-control"value="<?=$recuperer->montant?>"readOnly>
                        </div>
                        <label for="inputDate" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                       <div class="col-sm-4">
                            <?php $formattedDate = date_format(date_create($recuperer->date), 'Y-m-d');?>
                            <input type="date" name="date" class="form-control" value="<?= $formattedDate ?>" readOnly>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label for="inputNote" class="col-sm-3 col-form-label">Notes(200 mots au max)</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="note" style="height: 100px"readOnly><?=$recuperer->note?></textarea>
                        </div>
                    </div>
                    <div class="text-center">
                        <!-- <button type="submit" class="btn btn-info"  name="enregistrer">Enregistrer</button> -->
                        <a href="liste_depense_caisse.php" class="btn btn-primary btn ">Liste des depenses</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

  </main>
</section>
       <!-- Footer -->
        <footer class="footer">
            <?php require_once('partials/foot.php') ?>
            <?php require_once('partials/footer.php') ?>
        </footer>