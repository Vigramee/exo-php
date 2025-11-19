<?php
$connexion = new PDO('mysql:host=localhost;dbname=jo;charset=utf8', 'root', '');
  
$colonnes = ['nom','pays','course','temps'];
$colonneTri = in_array($_GET['sort'] ?? '', $colonnes) ? $_GET['sort'] : 'nom';
$ordreTri = (strtolower($_GET['order'] ?? '') === 'desc') ? 'DESC' : 'ASC';
 
$resultats = $connexion->query("SELECT * FROM `100` ORDER BY $colonneTri $ordreTri")->fetchAll();
 
function fleche($col, $colTri, $ordre) {
    if ($col === $colTri) {
        $fleche = $ordre === 'ASC' ? '↑' : '↓';
        return " <span class='fleche'>$fleche</span>";
    }
    return '';
}

 
function lienTri($col,$colTri,$ordre) {
    $nouvelOrdre = ($col === $colTri && $ordre==='ASC') ? 'desc' : 'asc';
    return "<a href='?sort=$col&order=$nouvelOrdre'>$col" . fleche($col,$colTri,$ordre) . "</a>";
}
 
?>
 
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