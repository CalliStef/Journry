<?php 

namespace Services;

use \Controllers\DbController;

class NoteServices {

    private static $conn;

    public function __construct(){
        NoteServices::$conn = DbController::get_connection();
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
