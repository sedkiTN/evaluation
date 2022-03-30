<?php
// Database Connection
include 'config.php';

// Reading value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchArray = array();

// Search
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " AND (nom LIKE :nom ) ";
   $searchArray = array( 
        'nom'=>"%$searchValue%",
        'dateAjout'=>"%$searchValue%"
   );
}

// Total number of records without filtering
$stmt = $bdd->prepare("SELECT COUNT(*) AS allcount FROM produits ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

// Total number of records with filtering
$stmt = $bdd->prepare("SELECT COUNT(*) AS allcount FROM produits WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

$sql = "SELECT prods.idPrd,
        prods.nom,
        prods.prix,
        prods.dateAjout,
        (SELECT SUM(stk.qt) FROM stock stk WHERE stk.idPrd = prods.idPrd AND stk.type = 'stock')-(SELECT SUM(stk.qt) FROM stock stk WHERE stk.idPrd = prods.idPrd AND stk.type = 'vente') AS stockProduit,
        (SELECT SUM(stk.qt) * prods.prix FROM stock stk WHERE stk.idPrd = prods.idPrd AND stk.type = 'vente') AS ChiffreAffaire
        FROM produits prods";

// Fetch records
$stmt = $bdd->prepare($sql . " WHERE 1 " . $searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

// Bind values
foreach ($searchArray as $key=>$search) {
   $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach ($empRecords as $row) {
    $ca = 0;$stockAff = 0;
    $stockAff = 0;

    $data[] = array(
        "nom" => $row['nom'],
        "dateAjout" => date("d/m/Y", strtotime($row['dateAjout'])),
        "nbJour" => date_diff(new DateTime($row['dateAjout']), new DateTime("now"))->format('%a jour(s)'),
        "stock" => $row['stockProduit'],
        "ca" => $row['ChiffreAffaire'] . ' &euro;',
    );
}

// Response
$response = array(
   "draw" => intval($draw),
   "iTotalRecords" => $totalRecords,
   "iTotalDisplayRecords" => $totalRecordwithFilter,
   "aaData" => $data
);

echo json_encode($response);