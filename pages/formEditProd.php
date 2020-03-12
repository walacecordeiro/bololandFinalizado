<?php
require_once("controller\ctrlProduto.php");
?>
<section class="container bg-branco">
    <h3 class="center">Dados do produto</h3>
    <form method="post" action="admin.php?pag=editProd" enctype="multipart/form-data">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id_produto" value="<?= $prod['id_produto'] ?>">

        <div class="form-group">
            <label for="file">Foto 1</label>
            <img src="img\ofertas\<?= $prod['foto1'] ?>" style="width:60px">
            <input type="file" class="form-control-file" id="file" name="foto1">
        </div>

        <div class="form-group">
            <label for="file">Foto 2</label>
            <img src="img\ofertas\<?= $prod['foto2'] ?>" style="width:60px">
            <input type="file" class="form-control-file" id="file" name="foto2">
        </div>

        <div class="form-group">
            <label for="file">Foto 3</label>
            <img src="img\ofertas\<?= $prod['foto3'] ?>" style="width:60px">
            <input type="file" class="form-control-file" id="file" name="foto3">
        </div>

        <div class="form-group">
            <label for="file">Foto 4</label>
            <img src="img\ofertas\<?= $prod['foto4'] ?>" style="width:60px">
            <input type="file" class="form-control-file" id="file" name="foto4">
        </div>

        <div class="form-group">
            <label for="file">Foto 5</label>
            <img src="img\ofertas\<?= $prod['foto5'] ?>" style="width:60px">
            <input type="file" class="form-control-file" id="file" name="foto5">
        </div>

        <div class="form-group">
            <label>Nome</label>
            <input type="text" class="form-control" name="nome" value=<?= $prod['nome'] ?> required>
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <input type="text" class="form-control" name="descricao" value='<?= $prod['descricao'] ?>' required>
        </div>

        <div class="form-group">
            <label>Quantidade</label>
            <input type="number" class="form-control" name="quant" value='<?= $prod['quant'] ?>' required>
        </div>

        <div class="form-group">
            <label>Valor</label>
            <input type="number" class="form-control" name="valor" value='<?= $prod['valor'] ?>' required>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="ativo" checked='<?=$prod['ativo']?>'>
            <label class="form-check-label" for="">
                Ativo
            </label>
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn bg-azul branco">Enviar</button>
            <button type="reset" class="btn btn-danger branco">Cancelar</button>
        </div>
    </form>
</section>