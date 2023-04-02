<?php 

namespace Controllers;

use \Controllers\DbController;

class NoteController{
    
        private static $conn; 
    
        public function __construct(){
            NoteController::$conn = DbController::get_connection();
        }

        public function addNote(){

            echo "add note <br>";
            // echo var_dump($_POST);

            $title = $_POST['title'];
            $content = $_POST['content'];
            $user_email = $_SESSION['user'];

            // filter out empty images
            $image_files = array_filter($_FILES['images']['tmp_name']);
            
            // echo var_dump($images);
            
            // get user id
            $user_id_stmt = NoteController::$conn->prepare("SELECT id FROM users WHERE username = ?");
            $user_id_stmt->execute([$user_email]);
            $user_id = $user_id_stmt->fetchColumn();

            // insert journal into journals table
            $insert_journal_stmt = NoteController::$conn->prepare("INSERT INTO journals (title, content, user_id, created_date) VALUES (?, ?, ?, NOW())");
            $insert_journal_stmt->execute([$title, $content, $user_id]);
            $journal_id = NoteController::$conn->lastInsertId();

            // insert images into images table
            foreach($image_files as $image_file){
                // convert to long blob and store in database
                $image_data = base64_encode(file_get_contents($image_file));
                $insert_image_stmt = NoteController::$conn->prepare("INSERT INTO images (filename, journal_id) VALUES (?, ?)");
                $insert_image_stmt->execute([$image_data, $journal_id]);
            }

            header("Location: /note/$journal_id");

        }

        public function updateNote(){

            echo " aksdjflaks " .var_dump($_POST);

            // $title = $_POST['title'];
            // $content = $_POST['content'];
            // $user_email = $_SESSION['user'];

            // // filter out empty images
            // $image_files = array_filter($_FILES['images']['tmp_name']);
            
            // // echo var_dump($images);
            
            // // get user id
            // $user_id_stmt = NoteController::$conn->prepare("SELECT id FROM users WHERE username = ?");
            // $user_id_stmt->execute([$user_email]);
            // $user_id = $user_id_stmt->fetchColumn();

            // // update journal in journals table
            // $update_journal_stmt = NoteController::$conn->prepare("UPDATE journals SET title = ?, content = ?, user_id = ?, created_date = NOW() WHERE id = ?");
            // $update_journal_stmt->execute([$title, $content, $user_id, $journal_id]);

            // // delete images from images table
            // $delete_images_stmt = NoteController::$conn->prepare("DELETE FROM images WHERE journal_id = ?");
            // $delete_images_stmt->execute([$journal_id]);

            // // insert images into images table
            // foreach($image_files as $image_file){
            //     // convert to long blob and store in database
            //     $image_data = base64_encode(file_get_contents($image_file));
            //     $insert_image_stmt = NoteController::$conn->prepare("INSERT INTO images (filename, journal_id) VALUES (?, ?)");
            //     $insert_image_stmt->execute([$image_data, $journal_id]);
            // }

            // header("Location: /note/$journal_id");


        }

        public function getNoteById($id){
            $stmt = NoteController::$conn->prepare("SELECT * FROM journals WHERE id = ?");
            $stmt->execute([$id]);
            $journal = $stmt->fetch();

            $images_stmt = NoteController::$conn->prepare("SELECT * FROM images WHERE journal_id = ?");
            $images_stmt->execute([$id]);
            $images = $images_stmt->fetchAll();

            $journal['images'] = $images;

            return $journal;
        }
    
    
}



?>