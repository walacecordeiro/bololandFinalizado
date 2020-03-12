<?php
require_once("./controller/ctrlProduto.php");
?>
<section>
    <table class="table">
        <tr>
            <th>id</th>
            <th>Nome</th>
            <th>Descricao</th>
            <th>Quant.</th>
            <th>Valor</th>
            <th>Ativo</th>
            <th>Foto 1</th>
            <th>Foto 2</th>
            <th>Foto 3</th>
            <th>Foto 4</th>
            <th>Foto 5</th>
            <th>
                <!-- <i class="material-icons">edit</i> -->
            </th>
            <th>
                <!-- <i class="material-icons">delete_forever</i> -->
            </th>
        </tr>
        <?php
        //for ($x = 0; $x < lenght(getAll()); $x++){
        foreach (getAll() as $c) {
            echo "
            <tr>
                <td>$c[id_produto]</td>
                <td>$c[nome]</td>
                <td>$c[descricao]</td>
                <td>$c[quant]</td>
                <td>$c[valor]</td>
                <td>" . ($c['ativo'] ? 'Sim' : 'Não') . "</td>
                <td><img src='img/ofertas/$c[foto1]' style='width:40px'></td>
                <td><img src='img/ofertas/$c[foto2]' style='width:40px'></td>
                <td><img src='img/ofertas/$c[foto3]' style='width:40px'></td>
                <td><img src='img/ofertas/$c[foto4]' style='width:40px'></td>
                <td><img src='img/ofertas/$c[foto5]' style='width:40px'></td>
                <td>
                    <a href='admin.php?pag=editProd&action=getProd&id=" . $c['id_produto'] . "'>
                        <i class='material-icons'>edit</i>
                    </a>
                </td>
                <td>
                    <a href='admin.php?pag=removeProd&action=remove&id=" . $c['id_produto'] . "&status=$c[ativo]' onclick=\"return confirm('Apagar registro do produto $c[nome]?')\">
                    <i class='material-icons'>delete_forever</i>
                    </a>
                </td>
            </tr>
            ";
        } ?>
    </table>
</section>