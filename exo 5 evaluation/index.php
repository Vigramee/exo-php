<?php
$connexion = new PDO('mysql:host=localhost;dbname=jo;charset=utf8', 'root', '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ajout($connexion);
}

?>

<h1>ajouter un résulta : </h1>
<form method="post">

<label>Nom : </label>
<input type="text" name= "nom"></br>

<label>Pays : </label>
<input type="text" name= "pays"></br>

<label>Course : </label>
<?= listeCourses($connexion) ?>

<label>Temps : </label>
<input type="number" name="temps" step="0.01"></br>

<button type="submit">Ajouter</button>


</form>



<?php
$colonnes = ['nom','pays','course','temps'];
$colonneTri = in_array($_GET['sort'] ?? '', $colonnes) ? $_GET['sort'] : 'nom';
$ordreTri = (strtolower($_GET['order'] ?? '') === 'desc') ? 'DESC' : 'ASC';
 
$resultats = pagination($connexion, $colonneTri, $ordreTri);
 
function fleche($col, $colTri, $ordre) {
    if ($col === $colTri) {
        $fleche = $ordre === 'ASC' ? '↑' : '↓';
        return " <span class='fleche'>$fleche</span>";
    }
    return '';
}

function ajout($connexion) {
    if (!empty($_POST['nom']) && !empty($_POST['pays']) && !empty($_POST['course']) && !empty($_POST['temps'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $pays = strtoupper(substr(trim($_POST['pays']), 0, 3));
        $course = htmlspecialchars($_POST['course']);
        $temps = (float)$_POST['temps'];

        $requete = $connexion->prepare("INSERT INTO `100` (nom, pays, course, temps) VALUES (?, ?, ?, ?)");
        $requete->execute([$nom, $pays, $course, $temps]);
    }
}

function pagination($connexion, $colonneTri, $ordreTri, $parPage = 10) {
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $parPage;

    $recherche = $_GET['recherche'] ?? '';
    $sql = "SELECT * FROM `100`";
    $params = [];

    if (!empty($recherche)) {
        $sql .= " WHERE nom LIKE :rech OR pays LIKE :rech";
        $params[':rech'] = '%' . $recherche . '%';
    }

    $sql .= " ORDER BY $colonneTri $ordreTri LIMIT :limit OFFSET :offset";

    $requete = $connexion->prepare($sql);
    foreach ($params as $key => $value) {
        $requete->bindValue($key, $value);
    }
    $requete->bindValue(':limit', $parPage, PDO::PARAM_INT);
    $requete->bindValue(':offset', $offset, PDO::PARAM_INT);
    $requete->execute();

    return $requete->fetchAll();
}

function listeCourses($connexion) {
    $courses = $connexion->query("SELECT DISTINCT course FROM `100` ORDER BY course ASC")->fetchAll(PDO::FETCH_COLUMN);
    $html = "<select name='course'>";
    foreach ($courses as $c) {
        $html .= "<option value='" . htmlspecialchars($c) . "'>" . htmlspecialchars($c) . "</option>";
    }
    $html .= "</select><br>";
    return $html;
}
    
 
function lienTri($col,$colTri,$ordre) {
    $nouvelOrdre = ($col === $colTri && $ordre==='ASC') ? 'desc' : 'asc';
    return "<a href='?sort=$col&order=$nouvelOrdre'>$col" . fleche($col,$colTri,$ordre) . "</a>";
}
 
?>
<form method="get" style="margin-bottom: 20px;">
    <input type="text" name="recherche" placeholder="Rechercher par nom ou pays" value="<?= htmlspecialchars($_GET['recherche'] ?? '') ?>">
    <button type="submit">Rechercher</button>
</form>
<table border="3">
    <tr>
        <th><?= lienTri('nom',$colonneTri,$ordreTri) ?></th>
        <th><?= lienTri('pays',$colonneTri,$ordreTri) ?></th>
        <th><?= lienTri('course',$colonneTri,$ordreTri) ?></th>
        <th><?= lienTri('temps',$colonneTri,$ordreTri) ?></th>
    </tr>
    <style>
        .fleche {
        color: red;
        font-weight: bold;
    }

    </style>
    <?php foreach($resultats as $ligne): ?>
    <tr>
        <td><?= $ligne['nom'] ?></td>
        <td><?= $ligne['pays'] ?></td>
        <td><?= $ligne['course'] ?></td>
        <td><?= $ligne['temps'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
$recherche = $_GET['recherche'] ?? '';
if (!empty($recherche)) {
    $stmt = $connexion->prepare("SELECT COUNT(*) FROM `100` WHERE nom LIKE :rech OR pays LIKE :rech");
    $stmt->execute([':rech' => '%' . $recherche . '%']);
    $totalLignes = $stmt->fetchColumn();
} else {
    $totalLignes = $connexion->query("SELECT COUNT(*) FROM `100`")->fetchColumn();
}
$totalPages = ceil($totalLignes / 10);
$pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
?>

<div style="margin-top: 20px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>&sort=<?= $colonneTri ?>&order=<?= strtolower($ordreTri) ?>" style="margin-right: 5px;<?= $i === $pageActuelle ? 'font-weight:bold;' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>