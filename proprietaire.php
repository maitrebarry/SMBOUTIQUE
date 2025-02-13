 <?php
    require_once('rentrer_anormal.php') ;
    // Détermine quel bouton doit être actif en fonction de l'URL actuelle
    $current_page = basename($_SERVER['PHP_SELF']);

    $active_user = ($current_page == 'creer_utilisateur.php') ? 'active' : '';
    $active_unit = ($current_page == 'unite.php') ? 'active' : '';
    $active_boutique = ($current_page == 'boutique.php') ? 'active' : '';
    $active_owner = ($current_page == 'proprietaire.php') ? 'active' : '';
    ?>

<!--------header------->
<?php require_once ('partials/header.php') ?>
<!-------------sidebare----------->
<?php require_once ('partials/sidebar.php')?>
<!-------------navebare----------->
<?php require_once ('partials/navbar.php')?>
<style>
    .btn-block {
            width: 100%;
            margin-bottom: 10px;
            padding: 25px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-weight: bolder;
            color: black;
        }
        .card-body a.btn-outline-primary {
        position: relative;
        cursor: pointer;
        }
        
        .card-body a.btn-outline-primary.active {
        outline: 2px solid #007bff;
        outline-offset: 2px;
        }
    .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px; 
            background-color: #f5f5f5; 
        }
    .header-table {
        width: 100%;
        text-align: center;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .header-table img {
        width: auto;
        height: 150px; /* Ajustez la taille selon vos besoins */
    }
    .header-table th, .header-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    .header-text {
        font-size: 34px;
        color: #8B4513; /* Marron */
        font-weight: bold;
    }
    .sub-header-text {
        font-size: 14px;
        color: #000; /* Noir */
    }
    .action-buttons {
        text-align: center;
        margin-top: 20px;
    }
    .action-buttons button {
        margin: 5px;
        padding: 10px 20px;
    }
</style>

<body>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Propriétaire</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index1.php">Accueil</a></li>
                <li class="breadcrumb-item">Propriétaire</li>
            </ol>
        </nav>
    </div>
    
    <?php require_once('partials/afficher_message.php');?>

    <section class="section profile">
        <form action="">
            <div class="row">
                 <div class="col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <h6>MENU</h6>
                        </div>
                        <div class="card-body">
                            <a href="creer_utilisateur.php" class="btn btn-outline-primary btn-block <?= $active_user; ?>">Compte utilisateur</a>
                            <a href="unite.php" class="btn btn-outline-primary btn-block <?= $active_unit; ?>">Unités</a>
                            <a href="boutique.php" class="btn btn-outline-primary btn-block <?= $active_boutique?>">Supermarchés</a>
                            <a href="proprietaire.php" class="btn btn-outline-primary btn-block <?= $active_owner; ?>">Proprietaire</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="card">                      
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <table class="header-table">
                                <tr>
                                    <td><img src="assets/img/nido1.png" alt="Logo Nido"></td>
                                    <td>
                                        <div class="header-text">S M MARKET</div>
                                        <div class="sub-header-text">COMMERCANT</div>
                                        <div class="sub-header-text">Sebougou</div>
                                        <div class="sub-header-text">Tel: 78760717 / 92190993</div>
                                        <div class="sub-header-text">Lieu: Ségou</div>
                                    </td>
                                    <td><img src="assets/img/nutrilac.png" alt="Logo Nutrilac"></td>
                                </tr>
                            </table>

                            <!-- <div class="action-buttons">
                                <button type="button" onclick="location.href='modifier_proprietaire.php'">Modifier</button>
                                <button type="button" onclick="location.href='ajouter_proprietaire.php'">Ajouter un autre propriétaire</button>
                            </div> -->
                        </div>
                    </div>
                </div>

            </div>
        </form>                    
    </section>
</main><!-- End #main -->

<?php require_once ('partials/foot.php')?>
<?php require_once ('partials/footer.php')?>
 <script>
        document.querySelectorAll('.card-body .btn-outline-primary').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.card-body .btn-outline-primary').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>
</body>
</html>
