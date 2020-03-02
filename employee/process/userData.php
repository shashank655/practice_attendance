<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
$db = new MySQLCN();
$aColumns = array('id','first_name','last_name','email_address','company_name');
$aResultColumns = array('id','first_name','last_name','email_address','company_name','from_company_phone','cell_phone_number','pick_up_date','senders_number');
/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id";

/* DB table to use */
$sTable = "users";

/* Paging */
$sLimit = "";
if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
   $sLimit = "LIMIT " . $db->realEscapeString($_GET['iDisplayStart']) . ", " .
           $db->realEscapeString($_GET['iDisplayLength']);
}
/* Ordering */
if (isset($_GET['iSortCol_0'])) {
   $sOrder = "ORDER BY  ";
   for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
      if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
         $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
				 	" . $db->realEscapeString($_GET['sSortDir_' . $i]) . ", ";
      }
   }

   $sOrder = substr_replace($sOrder, "", -2);
   if ($sOrder == "ORDER BY") {
      $sOrder = "";
   }
}

/*
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */

$sWhere = "WHERE 1=1";
if ($_GET['sSearch'] != "") {
   $sWhere = $sWhere." AND (";
   for ($i = 0; $i < count($aColumns); $i++) {
      $sWhere .= $aColumns[$i] . " LIKE '%" . $db->realEscapeString($_GET['sSearch']) . "%' OR ";
   }
   $sWhere = substr_replace($sWhere, "", -3);
   $sWhere .= ')';
}

$sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aResultColumns)) . "
	   FROM   $sTable
	   $sWhere
	   $sOrder
	   $sLimit
	";
$rResult = $db->selectForJason($sQuery);
/* Data set length after filtering */

$sQuery = "SELECT FOUND_ROWS()";
$aResultFilterTotal = $db->select($sQuery);
$iFilteredTotal = $aResultFilterTotal[0][0];

/* Total data set length */
$sQuery = "SELECT COUNT(" . $sIndexColumn . ")
           FROM   $sTable 
          WHERE 1=1";
$aResultTotal = $db->select($sQuery);
$iTotal = $aResultTotal[0][0];

/* Output */

$output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
);
for ($i = 0; $i < count($rResult); $i++) {
   $row = array();
   $row = $rResult[$i];
   $row['userName'] = $row['first_name']." ".$row['last_name'];
   $output['aaData'][] = $row;
}
echo json_encode($output);
?>