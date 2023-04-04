<?php 

namespace Services;

use \Controllers\DbController;
use \Services\UserServices;

class NoteServices {

    private static $conn;
    private static $user_services;

    public function __construct(){ 
        NoteServices::$conn = DbController::get_connection();
        NoteServices::$user_services = new UserServices();
    }

    public function getNotes(){
        $user_email = $_SESSION['user'];

        // get user id
        $user_id_stmt = NoteServices::$conn->prepare("SELECT id FROM users WHERE username = ?");
        $user_id_stmt->execute([$user_email]);
        $user_id = $user_id_stmt->fetchColumn();

        // get all journals and reorder them by recent date
        $get_journals_stmt = NoteServices::$conn->prepare("SELECT * FROM journals WHERE user_id = ? ORDER BY created_date DESC");
        $get_journals_stmt->execute([$user_id]);
        $journals = $get_journals_stmt->fetchAll();

        // get the images for each journal
        foreach($journals as &$journal){
            $journal_id = $journal['id'];
            $get_images_stmt = NoteServices::$conn->prepare("SELECT * FROM images WHERE journal_id = ?");
            $get_images_stmt->execute([$journal_id]);
            $images = $get_images_stmt->fetchAll();
            $journal['images'] = $images;
        }
        
        // Remove the reference to avoid any unintended side effects
        unset($journal);
        
        return $journals;
    }

    public function getNoteById($id){
        $stmt = NoteServices::$conn->prepare("SELECT * FROM journals WHERE id = ?");
        $stmt->execute([$id]);
        $journal = $stmt->fetch();

        $images_stmt = NoteServices::$conn->prepare("SELECT * FROM images WHERE journal_id = ?");
        $images_stmt->execute([$id]);
        $images = $images_stmt->fetchAll();

        $journal['images'] = $images;

        return $journal;
    }
    public function createNote(){
        $user_email = $_SESSION['user'];
        $user_id = NoteServices::$user_services->getUserIdByEmail($user_email);
        $stmt = NoteServices::$conn->prepare("INSERT INTO journals (user_id, created_date) VALUES (?, NOW())");
        $stmt->execute([$user_id]);
        $journal_id = NoteServices::$conn->lastInsertId();
        
        header("Location: /note/$journal_id");
    }

    public function addNote(){

       
    }

    public function updateNote(){
        

    }

    public function deleteNoteById($note_id){
        // delete the note and all images associated with it
        $delete_images_stmt = NoteServices::$conn->prepare("DELETE FROM images WHERE journal_id = ?");
        $delete_images_stmt->execute([$note_id]);

        $delete_note_stmt = NoteServices::$conn->prepare("DELETE FROM journals WHERE id = ?");
        $delete_note_stmt->execute([$note_id]);
       
        
        header("Location: /notes");
        
    }

}

?>
