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

        public function updateNote($journal_id){


            $title = $_POST['title'];
            $content = $_POST['content'];
            $user_email = $_SESSION['user'];

            // prevent xss on title and content
            $title = htmlspecialchars($title);
            $content = htmlspecialchars($content);

            strlen($title) > 250 && header("Location: /note/$journal_id?error-msg=title-too-long");
            strlen($content) > 500 && header("Location: /note/$journal_id?error-msg=content-too-long");
            
       
            // get user id
            $user_id = NoteController::$user_services->getUserIdByEmail($user_email);

            // update journal in journals table
            $update_journal_stmt = NoteController::$conn->prepare("UPDATE journals SET title = ?, content = ?, user_id = ? WHERE id = ?");
            $update_journal_stmt->execute([$title, $content, $user_id, $journal_id]);


            header("Location: /note/$journal_id");


        }


    
    
}



?>