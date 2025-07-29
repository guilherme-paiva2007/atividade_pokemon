<?php
include 'php/conexao.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $localizacao = $_POST['localizacao'];
    $hp = $_POST['hp'];
    $ataque = $_POST['ataque'];
    $defesa = $_POST['defesa'];
    $observacoes = $_POST['observacoes'];

    $sql = "INSERT INTO pokemon (nome, tipo, localizacao, hp, ataque, defesa, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssiiis", $nome, $tipo, $localizacao, $hp, $ataque, $defesa, $observacoes);

    if($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo '<script type="text/javascript">alert("Erro ao cadastrar Pokémon: ' . $stmt->error . '");</script>';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/cadastrar.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Arabic:wght@100..900&family=Noto+Serif+Old+Uyghur&display=swap" rel="stylesheet">
        <title>Cadastrar - PokeLost</title>
    </head>
    <body>

        <?php
        $sql = "SHOW COLUMNS FROM pokemon LIKE 'tipo'";
        $result = $conexao->query($sql);
        $row = $result->fetch_assoc();

        preg_match("/^enum\('(.*)'\)$/", $row['Type'], $matches);
        $enum_values = explode("','", $matches[1]);
        ?>

        <form action="" method="post">
            <h1>Cadastrar Pokémon</h1>

            <div class="campos">
                <label for="">Nome do Pokémon</label>
                <input type="text" name="nome" class="inputs-normais">
            </div>

            <div class="campos">
                <label for="">Tipo do Pokémon</label>
                <select name="tipo">
                    <option value="">Selecionar</option>
                    <?php foreach ($enum_values as $value): ?>
                        <option value="<?= $value ?>"><?= $value ?></option>
                    <?php 
                    endforeach;
                    $conexao->close();
                    ?>
                </select>
            </div>

            <div class="campos">
                <label for="">Localização de encontro</label>
                <input type="text" name="localizacao" class="inputs-normais">
            </div>

            <div class="campos">
                <label for="">Observações adicionais</label>
                <textarea name="observacoes"></textarea>
            </div>

            <div class="status">
                <h2>Status base</h2>

                <label for="">HP do Pokémon</label>
                <input type="text" name="hp" id="hp">
    
                <label for="">Ataque do Pokémon</label>
                <input type="text" name="ataque" id="ataque">
    
                <label for="">Defesa do Pokémon</label>
                <input type="text" name="defesa" id="defesa">
            </div>

            <button type="submit">Enviar</button>
        </form>
    </body>
</html>