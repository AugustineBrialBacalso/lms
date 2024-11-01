<?php

//fetch.php;

$connect = new PDO("mysql:host=localhost; dbname=library", "root", "");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if($received_data->query != '')
{
 $query = "
 SELECT title FROM books
 WHERE title LIKE '%".$received_data->query."%' 
 ORDER BY title ASC 
 LIMIT 10
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row;
 }
}

echo json_encode($data);

?>
