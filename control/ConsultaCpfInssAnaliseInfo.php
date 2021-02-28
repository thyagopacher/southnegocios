<?php
session_start();
include "../model/Conexao.php";
include "../model/BeneficioCliente.php";
$conexao = new Conexao();

$beneficio = new BeneficioCliente($conexao);
if (isset($_GET["cpf"]) && $_GET["cpf"] != NULL && $_GET["cpf"] != "") {
    $num = $beneficio->consultaCpfInss3($_GET["cpf"]);
}
?>
<div class="box-body">
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="example2" class="table table-bordered table-striped dataTable"
                       role="grid" aria-describedby="example2_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                Beneficio
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                colspan="1" aria-label="Browser: activate to sort column ascending">
                                Espécie
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                DIB
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($num->result as $key => $dadosBeneficio) {
                            $dadosBeneficio = (array) $dadosBeneficio;
                            ?>
                            <tr role="row" class="<?= $classe_linha ?>">
                                <td class="sorting_1">
                                    <a style='color: blue;' href='javascript: consultaBeneficioInssAnaliseInfo(<?= $dadosBeneficio['nb'] ?>)'><?= $dadosBeneficio['nb'] ?></a>
                                </td>
                                <td>
                                    <?= $dadosBeneficio['esp'] ?>
                                </td>
                                <td>
                                    <?= $dadosBeneficio['dib'] ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>   
<?php


