<?php
function changeStatus($conn, $id, $status){

    $sql = "UPDATE delivery_assignments SET status = '$status' WHERE id = '$id'";

    return mysqli_query($conn, $sql);
}
?>