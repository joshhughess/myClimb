<?php
include('connect.php');
header('Content-Type:application/json');
$connect = mysqli_connect($host,$userName,$password, $db);
if(isset($_SESSION['username'])){
    $sql = "SELECT * FROM meetings WHERE userID='".$_SESSION['userID']."' OR user2id='".$_SESSION['userID']."' AND accepted='1' ORDER BY start ASC";
    $res = mysqli_query($connect,$sql);
    $json = array();

    $rows = array();
    while($r = mysqli_fetch_assoc($res)) {
        $rows[] = $r;
    }
    print json_encode($rows);

}
?>