<?php
include './php/conexao.php';

if (isset($_GET['search'])) {
    $sql = "SELECT * FROM pokemon WHERE nome LIKE ? ";
    $stmt = $conexao->prepare($sql);
    $searchTerm = "%" . $_GET['search'] . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM pokemon LIMIT 200";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Início - PokeLost</title>
        <link rel="stylesheet" href="./styles/index.css">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="./">Início</a></li>
                    <li><a href="./cadastrar.php">Cadastrar</a></li>
                </ul>
            </nav>
        </header>
        <script>
            window.search = "";

            function submitSearch() {
                window.location.href = "./?search=" + encodeURIComponent(search);
            }
        </script>
        <main>
            <div class="container">
                <div class="container-content">
                    <div class="search-container">
                        <div class="input-container">
                            <input
                                type="text"
                                id="input-search-pokemon"
                            >
                            <div style="
                                padding: 0 8px;
                                display: inline;
                            ">
                                <img src="./assets/svgs/magnifying-glass.svg" alt="Lupa de pesquisa" class="small-icon">
                            </div>
                            <script>
                                const input = document.getElementById("input-search-pokemon");
                                input.addEventListener("keydown", (event) => {
                                    if (event.key == "Enter") {
                                        submitSearch();
                                    }
                                });
                                input.addEventListener("input", () => {
                                    search = input.value;
                                });
                            </script>
                        </div>
                    </div>
                    <div class="table-content">
                        <table>
                            <thead>
                                <tr id="table-head">
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Registro</th>
                                    <th>HP</th>
                                    <th>Ataque</th>
                                    <th>Defesa</th>
                                    <th>Observações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$row['nome']}</td>
                                        <td>{$row['tipo']}</td>
                                        <td>{$row['data']}</td>
                                        <td>{$row['hp']}</td>
                                        <td>{$row['ataque']}</td>
                                        <td>{$row['defesa']}</td>
                                        <td>{$row['observacoes']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>