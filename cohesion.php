<?php
session_start();
error_reporting(0);
$dbServername = "DocGenerate.com:3306";
$dbUsername = "documentAutomated";
$dbPassword = "pass@123";
$dbName = "documentAutomated";
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
if (!$conn) {
die('Could not connect: ' . mysql_error());
}
function generate_doc($conn) {
$doc_id = mysqli_real_escape_string($conn, $_POST['doc_id']);
$uid = mysqli_real_escape_string($conn,$_POST['user_id']);
$quantity = mysqli_real_escape_string($conn,$_POST['qty']);
$option = mysqli_real_escape_string($conn,$_POST['option']);
if($option!='NA') {
$sql = "SELECT * FROM details WHERE details.user_id='$uid' AND details.doc_id='$doc_id' AND details.option='$optin'";
	}
else {
$sql = "SELECT * FROM details WHERE details.user_id='$uid' AND details.doc_id='$doc_id'";
	}
$result=mysqli_query($conn, $sql);
$item_count = mysqli_num_rows($result);
if($item_count==1)
{
if($quantity==-1)
{
$row = mysqli_fetch_assoc($result);
$qty=$row['qty']+1;
$sql="UPDATE details SET qty='$qty' WHERE user_id='$uid' AND doc_id='$doc_id'";
$result=mysqli_query($conn, $sql);
}
else
{
$qty=$quantity;
$sql="UPDATE details SET qty='$qty' WHERE user_id='$uid' AND doc_id='$doc_id'";
$result=mysqli_query($conn, $sql);
}
}
else {
$qty="1";
if($option=='NA') {
$sql="INSERT INTO details (user_id, doc_id ,qty) VALUES ('$uid','$doc_id','$qty')";
}
else {
$sql="INSERT INTO details (user_id, doc_id ,qty, option) VALUES ('$uid','$doc_id','$qty','$option')";
		}
$result=mysqli_query($conn, $sql);
echo mysqli_error($conn);
}
$sql = "SELECT * FROM details WHERE details.user_id='$uid';";
$result=mysqli_query($conn, $sql);
$item_count = mysqli_num_rows($result);
return $item_count;
}
function remove_from_details($conn) {
$doc_id = mysqli_real_escape_string($conn, $_POST['doc_id']);
$uid = mysqli_real_escape_string($conn,$_POST['user_id']);
$sql = "DELETE FROM details WHERE details.user_id='$uid' AND details.doc_id='$doc_id';";
$result=mysqli_query($conn, $sql);
$sql = "SELECT * FROM details WHERE details.user_id='$uid';";
$result=mysqli_query($conn, $sql);
$item_count = mysqli_num_rows($result);
return $item_count;
}
function get_user_details_for_checkout($conn) {
$uid=$_SESSION['user_id'];
$sql_user = "SELECT * FROM users WHERE users.user_id='$uid'";
$sql_result = mysqli_query($conn, $sql_user);
$user_row = mysqli_fetch_assoc($sql_result);
return  $user_row
}
function get_details_doc_for_checkout($conn) {
if(isset($_SESSION['user_id']))  {
$uid=$_SESSION['user_id'];
$sql = "SELECT * FROM details WHERE details.user_id='$uid'";
$result=mysqli_query($conn, $sql);
$item_count = mysqli_num_rows($result);
if ($item_count==0) {
echo "<p style='text-align: center;'><b>No documents!</b></p>";
} 
else {
while (($row = mysqli_fetch_assoc($result))){
$fid = $row['doc_id'];
$docsql = "SELECT * FROM documents WHERE documents.doc_id='$did' 
$docresult = mysqli_query($conn, $docsql);
$sql_doc = "SELECT * FROM doc WHERE doc_id='$fid'";
$docresult = mysqli_query($conn, $sql_doc);
$docrow = mysqli_fetch_assoc($docresult);
$sql_details_doc="SELECT * FROM details WHERE details.user_id='$uid' AND  details.doc_id='$fid'";
$sql_details_doc_result=mysqli_query($conn, $sql_details_doc);
$sql_details_doc_result_row = mysqli_fetch_assoc($sql_details_doc_result);
		}
return $doc_row;
}
