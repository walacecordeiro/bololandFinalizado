<?php
include_once('mensagens.php');
include_once('controller\ctrlProduto.php')
?>

<section class="container bg-branco">
    <h3 class="center">Dados do produto</h3>
    <form method="post" action="admin.php?pag=cad" enctype="multipart/form-data">

        <input type="hidden" name="action" value="add">

        <div class="form-group">
            <label for="file1">Foto 1</label>
            <input type="file" class="form-control-file" id="file1" name="foto1">
        </div>

        <div class="form-group">
            <label for="file2">Foto 2</label>
            <input type="file" class="form-control-file" id="file2" name="foto2">
        </div>

        <div class="form-group">
            <label for="file3">Foto 3</label>
            <input type="file" class="form-control-file" id="file3" name="foto3">
        </div>

        <div class="form-group">
            <label for="file4">Foto 4</label>
            <input type="file" class="form-control-file" id="file4" name="foto4">
        </div>

        <div class="form-group">
            <label for="file5">Foto 5</label>
            <input type="file" class="form-control-file" id="file5" name="foto5">
        </div>

        <div class="form-group">
            <label>Nome</label>
            <input type="text" class="form-control" name="nome" required>
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <input type="text" class="form-control" name="descricao" required>
        </div>

        <div class="form-group">
            <label>Quantidade</label>
            <input type="number" class="form-control" name="quant" required>
        </div>

        <div class="form-group">
            <label>Valor</label>
            <input type="number" class="form-control" name="valor" required>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="ativo" checked>
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