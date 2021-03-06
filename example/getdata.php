<?php

/* * * mysql hostname ** */
$hostname = 'localhost';

/* * * mysql username ** */
$username = 'test';

/* * * mysql password ** */
$password = '123456';

/* * * mysql password ** */
$db = 'datafreedom';

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);
    /*     * * echo a message saying we have connected ** */
} catch (PDOException $e) {
    echo $e->getMessage();
}

$out = array();

$out['current_page'] = (!empty($_GET['page'])) ? (int) $_GET['page'] : 1;
$out['per_page'] = (!empty($_GET['limit'])) ? (int) $_GET['limit'] : 10;

$offset = (($out['current_page']-1) * $out['per_page']);
$out['from'] = $offset + 1;
$out['to'] = $out['from']+($out['per_page']-1);

$where = " WHERE 1=1";
if (!empty($_POST['search']['name'])) {
    $where .= " AND name like '%" . $_POST['search']['name'] . "%'";
}

if (!empty($_POST['sort'])) {
    foreach ($_POST['sort'] as $key => $val) {
        $where .= " ORDER BY " . $key . ' ' . $val;
    }
}

//get total rows
$sql = "SELECT count(*) FROM dummy_data" . $where;
$total = $dbh->query($sql)->fetchColumn(0);
$out['total'] = (int) $total;
$out['last_page'] = ceil($out['total'] / $out['per_page']);

/* * * The SQL SELECT statement ** */
$where .= " LIMIT " . $offset . "," . $out['per_page'];
$sql = "SELECT * FROM dummy_data" . $where;

$out['data'] = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($out);