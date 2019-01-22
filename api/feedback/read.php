<?php
  header("Content-Type: application/json; charset=UTF-8");

  include_once '../config/database.php';
  include_once '../objects/feedbackObject.php';

  $database = new Database();
  $connection = $database->getConnection();

  $feedback = new feedback($connection);

  $stmt = $feedback->read();
  $count = $stmt->rowCount();

  if($count > 0){
      $feedback = array();
      $feedback["body"] = array();
      $feedback["count"] = $count;

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);

          $feedback_arr = array(
            "feedback_id" => $feedback_id,
            "guest_id" => $guest_id,
            "id" => $id
          );
          array_push($feedback["body"], $feedback_arr);
      }
      echo json_encode($feedback);
    }
    else
    {
      echo json_decode( array( "body" => array(), "count" => 0) );
  }

?>
