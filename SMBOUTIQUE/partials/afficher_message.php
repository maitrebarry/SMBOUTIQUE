
<?php
if(isset($_SESSION["notification"]["message"])): ?>
    <div class="alert alert-<?=$_SESSION["notification"]["type"] ?>" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><?=$_SESSION["notification"]["message"]?></h4>
    </div>

    <?php $_SESSION["notification"]=[] ?>

<?php endif ?>
