<?php 

namespace Controllers;

require_once '../Services/NoteServices.php';

use Services\NoteServices;

class NoteController{

    private static $note_services;
    
    
        public function __construct(){
            NoteController::$note_services = new NoteServices();
        }

        public function updateNote($journal_id){


            $title = $_POST['title'];
            $content = $_POST['content'];
            $user_email = $_SESSION['user'];

            // prevent xss on title and content
            $title = htmlspecialchars($title);
            $content = htmlspecialchars($content);
            $images = $_FILES['images']['tmp_name'];

            NoteController::$note_services->updateNote($title, $content, $user_email, $journal_id, $images);


        }


    
    
}



?>