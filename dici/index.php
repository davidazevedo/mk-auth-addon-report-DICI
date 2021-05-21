<?php
// INCLUE FUNCOES DE ADDONS -----------------------------------------------------------------------
include('addons.class.php');
include('conexao.php');

// VERIFICA SE O USUARIO ESTA LOGADO --------------------------------------------------------------
session_name('mka');
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['mka_logado'])) exit('Acesso negado...');
?>
<!DOCTYPE html>
<html lang="pt-BR" class="has-navbar-fixed-top">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="iso-8859-1">
    <title>MK - AUTH :: <?php echo $Manifest->{'name'}; ?></title>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">



    <link href="../../estilos/mk-auth.css" rel="stylesheet" type="text/css" />
    <link href="../../estilos/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="../../estilos/jquery-ui.css" rel="stylesheet" type="text/css" media="screen" />

    <script src="../../scripts/vue.js"></script>
    <script src="../../scripts/jquery.js"></script>
    <script src="../../scripts/jquery-ui.js"></script>
    <script src="../../scripts/mk-auth.js"></script>

    <link href="../../estilos/mk-auth.css" rel="stylesheet" type="text/css" />
    <link href="../../estilos/font-awesome.css" rel="stylesheet" type="text/css" />

    <script src="../../scripts/jquery.js"></script>
    <script src="../../scripts/mk-auth.js"></script>

</head>

<body>

    <header class="navbar navbar-expand-md navbar-dark bd-navbar">
    </header>
    <?php include('../../topo.php'); ?>


    <nav class="breadcrumb has-bullet-separator is-centered" aria-label="breadcrumbs">
        <ul>
            <li><a href="#"> ADDON</a></li>
            <li class="is-active"><a href="#" aria-current="page"> <?php echo $Manifest->{'name'}; ?> </a></li>
        </ul>
    </nav>

    <div class="container">
        <form action="index.php" method="GET">

            <div class="row align-items-start">
                <div class="col-2">
                    <div class="form-check">
                        <input type="checkbox" name="desativado" value="sim" class="form-check-input">
                        <label class="form-check-label" for="flexCheckDefault">
                            Incluir Desativados
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="bloqueado" value="sim" class="form-check-input">
                        <label class="form-check-label" for="flexCheckDefault">
                            Incluir Bloqueados
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="ngerarsici" value="sim" class="form-check-input">
                        <label class="form-check-label" for="flexCheckDefault">
                            Nao SICI.
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="ngerarnf" value="sim" class="form-check-input">
                        <label class="form-check-label" for="flexCheckDefault">
                            Nao Possui NF
                        </label>
                    </div>
                </div>
                <div class="col-8">
                    <div>
                        <div class="form-group">
                            <label> Mes de Referencia</label>
                            <select name="mes" class="form-control  form-control-lg">
                                <option>Escolha o mes</option>
                                <option value="01">Janeiro</option>
                                <option value="02">Fevereiro</option>
                                <option value="03">Marco</option>
                                <option value="04">Abril</option>
                                <option value="05">Maio</option>
                                <option value="06">Junho</option>
                                <option value="07">Julho</option>
                                <option value="08">Agosto</option>
                                <option value="09">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label> Ano de Referencia</label>
                        <select name="ano" class="form-control  form-control-lg">
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label></label>
                        <input type="hidden" name="form_submitted" value="1" />
                        <button type="submit" class="btn btn-success btn-submit form-control  form-control-lg">Gerar DICI </button>
                    </div>
                </div>


        </form>

        <table class="table">
            <tr>
                <td>
                    <h6 style="display: none">VERSAO ADDON: <?php echo $Manifest->{'version'}; ?> / AUTOR: <?php echo $Manifest->{'author'}; ?></h6>

                    <?php

                    if ($_GET['form_submitted']) { // aqui é onde vai decorrer a chamada se houver um *request* POST

                        $csv_filename = 'dbexport' . time() . '.csv';
                        $csv_caminho = '/opt/mk-auth/admin/arquivos/' . $csv_filename . '';


                        $pdo = new PDO("mysql:host=localhost;dbname=mkradius", "root", "vertrigo");

                        if (!$pdo) {
                            echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
                            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                            exit;
                        }

                        $cli_bloqueado = "'nao'";
                        if (isset($_GET['bloqueado'])) {
                            $cli_bloqueado = "'nao' or a.bloqueado ='sim' ";
                        }

                        $cli_ativado = "'s'";
                        if (isset($_GET['desativado'])) {
                            $cli_ativado = "'s' or a.cli_ativado ='n' ";
                        }

                        $cli_mes = "";
                        if (isset($_GET['mes'])) {
                            $cli_mes = $_GET['mes'];
                        }

                        $cli_ano = "";
                        if (isset($_GET['ano'])) {
                            $cli_ano = $_GET['ano'];
                        }

                        $cli_gerarSici = "a.gsici = 1";
                        if (isset($_GET['ngerarsici'])) {
                            $cli_gerarSici = " (a.gsici = 1 or a.gsici = 0) ";
                        }

                        $cli_gerarNF = "a.geranfe = 'sim'";
                        if (isset($_GET['ngerarnf'])) {
                            $cli_gerarNF = " (a.geranfe = 'sim' or a.geranfe = 'nao') ";
                        }

                        $stmt  = $pdo->exec("select 'CNPJ', 'ANO', 'MES', 'COD_IBGE', 'TIPO_CLIENTE', 'TIPO_ATENDIMENTO', 'TIPO_MEIO', 'TIPO_PRODUTO', 'TIPO_TECNOLOGIA', 'VELOCIDADE', 'QT_ACESSOS'
    UNION
    select prov.cnpj, " . $cli_ano . ", " . $cli_mes . ", a.cidade_ibge COD_IBGE, IF(a.tipo_pessoa=3,'PF','PJ') TIPO_CLIENTE, if(instr(a.tags,'rural') <> 0, 'RURAL', 'URBANO') TIPO_ATENDIMENTO,
    if(p.tecnologia = 'H', 'fibra', if(p.tecnologia='k' or p.tecnologia='D' or p.tecnologia='C','radio', if(p.tecnologia = 'G', 'satelite', if(p.tecnologia = 'M', 'cabo_metalico', if(p.tecnologia = 'J', 'cabo_coaxial', 'cabo_metalico'))))) TIPO_MEIO,
    'INTERNET' TIPO_PRODUTO, 'ETHERNET' TIPO_TECNOLOGIA, format(p.veldown,0) VELOCIDADE, count(*) QT_ACESSOS 
    into outfile '" . $csv_caminho . "'fields terminated by ';' optionally enclosed by '' lines terminated by '\r\n'
    from sis_provedor prov, sis_cliente a inner join sis_plano p on a.plano = p.nome 
    where a.cli_ativado = " . $cli_ativado . "
    and a.bloqueado =" . $cli_bloqueado . "
    and " . $cli_gerarSici . "
    and " . $cli_gerarNF . "
    and a.cidade_ibge is not null
    and a.plano is not null
    and STR_TO_DATE(a.cadastro, '%d/%m/%Y') <= STR_TO_DATE('30/" . $cli_mes . "/" . $cli_ano . "', '%d/%m/%Y')
    group by a.cidade_ibge, a.tipo_pessoa,TIPO_ATENDIMENTO, tipo_meio, p.veldown");

                        $result  = $pdo->query("
    select prov.cnpj CNPJ, " . $cli_ano . " ANO, " . $cli_mes . " MES, a.cidade_ibge COD_IBGE, IF(a.tipo_pessoa=3,'PF','PJ') TIPO_CLIENTE, if(instr(a.tags,'rural') <> 0, 'RURAL', 'URBANO') TIPO_ATENDIMENTO,
    if(p.tecnologia = 'H', 'fibra', if(p.tecnologia='k' or p.tecnologia='D' or p.tecnologia='C','radio', if(p.tecnologia = 'G', 'satelite', if(p.tecnologia = 'M', 'cabo_metalico', if(p.tecnologia = 'J', 'cabo_coaxial', 'cabo_metalico'))))) TIPO_MEIO,
    'INTERNET' TIPO_PRODUTO, 'ETHERNET' TIPO_TECNOLOGIA, format(p.veldown,0) VELOCIDADE, count(*) QT_ACESSOS 
    from sis_provedor prov, sis_cliente a inner join sis_plano p on a.plano = p.nome 
    where a.cli_ativado = " . $cli_ativado . "
    and a.bloqueado =" . $cli_bloqueado . "
    and " . $cli_gerarSici . "
    and " . $cli_gerarNF . "
    and a.cidade_ibge is not null
    and a.plano is not null
    and STR_TO_DATE(a.cadastro, '%d/%m/%Y') <= STR_TO_DATE('30/" . $cli_mes . "/" . $cli_ano . "', '%d/%m/%Y')
    group by a.cidade_ibge, a.tipo_pessoa, TIPO_ATENDIMENTO, tipo_meio, p.veldown");

                        $resultSucesso  = $pdo->query("
    select a.nome NOME
    from sis_cliente a
    where a.cli_ativado = " . $cli_ativado . "
    and a.bloqueado =" . $cli_bloqueado . "
    and " . $cli_gerarSici . "
    and " . $cli_gerarNF . "
    and a.cidade_ibge is not null
    and a.plano is not null
    and STR_TO_DATE(a.cadastro, '%d/%m/%Y') <= STR_TO_DATE('30/" . $cli_mes . "/" . $cli_ano . "', '%d/%m/%Y')
    order by a.nome");

                    ?>
                        <br />

                        Relatorio Gerado - Mes de Referencia = <?php echo $cli_mes; ?> e Ano= <?php echo $cli_ano; ?>
                        <div style="display: grid;">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr class="tab_th">
                                        <th>CNPJ</th>
                                        <th>ANO</th>
                                        <th>MES</th>
                                        <th>COD_IBGE</th>
                                        <th>TIPO_CLIENTE</th>
                                        <th>TIPO_ATENDIMENTO</th>
                                        <th>TIPO_MEIO</th>
                                        <th>TIPO_PRODUTO</th>
                                        <th>TIPO_TECNOLOGIA</th>
                                        <th>VELOCIDADE</th>
                                        <th>QT_ACESSOS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($result as $row) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['CNPJ']; ?></td>
                                            <td><?php echo $row['ANO']; ?></td>
                                            <td><?php echo $row['MES']; ?></td>
                                            <td><?php echo $row['COD_IBGE']; ?></td>
                                            <td><?php echo $row['TIPO_CLIENTE']; ?></td>
                                            <td><?php echo $row['TIPO_ATENDIMENTO']; ?></td>
                                            <td><?php echo $row['TIPO_MEIO']; ?></td>
                                            <td><?php echo $row['TIPO_PRODUTO']; ?></td>
                                            <td><?php echo $row['TIPO_TECNOLOGIA']; ?></td>
                                            <td><?php echo $row['VELOCIDADE']; ?></td>
                                            <td><?php echo $row['QT_ACESSOS']; ?></td>
                                        </tr>
                                    <?php }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php

                        ?>
                        <div style="text-align: center">
                            <br /><br />
                            <a href="<?php echo '/admin/arquivos/' . $csv_filename; ?>" title="Download File" class="btn btn-success btn-submit form-control  form-control-lg">BAIXAR ARQUIVO</a>
                        </div>
                        <?php

                        ?>
                        <br />

                    <?php }
                    mysqli_close($pdo);
                    ?>

                </td>
            </tr>
        </table>
        </table>
        <?php include('../../baixo.php'); ?>
        <script src="../../menu.js.php"></script>

</body>

</html>