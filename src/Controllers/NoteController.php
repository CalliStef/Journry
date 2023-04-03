<?php 

namespace Controllers;

use \Controllers\DbController;
use \Services\UserServices;

class NoteController{
    
        private static $conn; 
        private static $user_services;
    
        public function __construct(){
            NoteController::$conn = DbController::get_connection();
            NoteController::$user_services = new UserServices();
        }

        public function addNote(){

            // echo "add note <br>";
            // // echo var_dump($_POST);

            // $title = $_POST['title'];
            // $content = $_POST['content'];
            // $user_email = $_SESSION['user'];

            // // filter out empty images
            // $image_files = array_filter($_FILES['images']['tmp_name']);
            
            // // echo var_dump($images);
            
            // // get user id
            // $user_id = NoteController::$user_services->getUserIdByEmail($user_email);
          
            // // insert journal into journals table
            // $insert_journal_stmt = NoteController::$conn->prepare("INSERT INTO journals (title, content, user_id, created_date) VALUES (?, ?, ?, NOW())");
            // $insert_journal_stmt->execute([$title, $content, $user_id]);
            // $journal_id = NoteController::$conn->lastInsertId();

            // // insert images into images table
            // foreach($image_files as $image_file){
            //     // convert to long blob and store in database
            //     $image_data = base64_encode(file_get_contents($image_file));
            //     $insert_image_stmt = NoteController::$conn->prepare("INSERT INTO images (filename, journal_id) VALUES (?, ?)");
            //     $insert_image_stmt->execute([$image_data, $journal_id]);
            // }

            // header("Location: /note/$journal_id");

        }

        public function updateNote($journal_id){

            // echo " aksdjflaks " .var_dump($_POST);

            $title = $_POST['title'];
            $content = $_POST['content'];
            $user_email = $_SESSION['user'];

            // filter out empty images
            $image_files = array_filter($_FILES['images']['tmp_name']);

            foreach($image_files as $image_file){
                $image_data = base64_encode(file_get_contents($image_file));
            }
            
            // get user id
            $user_id = NoteController::$user_services->getUserIdByEmail($user_email);

            // update journal in journals table
            $update_journal_stmt = NoteController::$conn->prepare("UPDATE journals SET title = ?, content = ?, user_id = ? WHERE id = ?");
            $update_journal_stmt->execute([$title, $content, $user_id, $journal_id]);

            // insert images into images table
            foreach($image_files as $image_file){
                // convert to long blob and store in database
                $insert_image_stmt = NoteController::$conn->prepare("INSERT INTO images (filename, journal_id) VALUES (?, ?)");
                $insert_image_stmt->execute([$image_data, $journal_id]);
            }

            header("Location: /note/$journal_id");


        }


    
    
}



?>