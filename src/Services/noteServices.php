<?php 

namespace Services;



use Repositories\UserRepositories;
use Repositories\NoteRepositories;
use Repositories\ImageRepositories;


class NoteServices{

    private static $user_repositories;
    private static $note_repositories;
    private static $image_repositories;

    public function __construct(){
        NoteServices::$user_repositories = new UserRepositories();
        NoteServices::$note_repositories = new NoteRepositories();
        NoteServices::$image_repositories = new ImageRepositories();
    }

    public function updateNote($title, $content, $user_email, $journal_id, $image_files){
            strlen($title) > 250 && header("Location: /note/$journal_id?error-msg=title-too-long");
            strlen($content) > 500 && header("Location: /note/$journal_id?error-msg=content-too-long");

            // filter images so that there is none empty being sent into the database
            $image_files = array_filter($image_files);

             foreach($image_files as $image_file){
                 $image_data = base64_encode(file_get_contents($image_file));
             }
       
            // get user id
            $user_id = NoteServices::$user_repositories->getUserIdByEmail($user_email);

            // update journal in journals table
            NoteServices::$note_repositories->updateNote($title, $content, $user_id, $journal_id);

             // insert images into images table
             foreach($image_files as $image_file){
                // convert to long blob and store in database
                NoteServices::$image_repositories->addImage($image_data, $journal_id);
            }
            
            header("Location: /note/$journal_id");
    }

   

}



?>