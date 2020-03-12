<?php
require_once("./controller/ctrlProd.php");
?>
<section class="container bg-branco" id="ofertas">
    <div class="row">
    <?php
        //for ($x = 0; $x < lenght(getAll()); $x++){
        foreach (getAll() as $p) {
    ?>  
    <a href="index.php?pag=perfilProd&id=<?= $p['id_produto'] ?>">
        <div class="col-12 col-md-4 itens">
            <img src="img/produtos/<?=$p['foto1'] ?>" class="img-fluid" alt="">
            <h2><?= $p['nome'] ?></h2>
            <p><?= $p['descricao'] ?></p>
            <h3 class="vermelho"><?= $p['valor'] ?></h3>
        </div>
    </a>
    <? } ?>
    </div>
</section>