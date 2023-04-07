<?php 

namespace Repositories;

require_once __DIR__ . '/src/Controllers/DbController.php';
require_once 'UserRepositories.php';

use Controllers\DbController;
use Repositories\UserRepositories;

class NoteRepositories {

    private static $conn;
    private static $user_repositories;

    public function __construct(){ 
        NoteRepositories::$conn = DbController::get_connection();
        NoteRepositories::$user_repositories = new UserRepositories();
    }

    public function getNotes(){
        $user_email = $_SESSION['user'];

        // get user id
        $user_id_stmt = NoteRepositories::$conn->prepare("SELECT id FROM users WHERE username = ?");
        $user_id_stmt->execute([$user_email]);
        $user_id = $user_id_stmt->fetchColumn();

        // get all journals and reorder them by recent date
        $get_journals_stmt = NoteRepositories::$conn->prepare("SELECT * FROM journals WHERE user_id = ? ORDER BY created_date DESC");
        $get_journals_stmt->execute([$user_id]);
        $journals = $get_journals_stmt->fetchAll();

        // get the images for each journal
        foreach($journals as &$journal){
            $journal_id = $journal['id'];
            $get_images_stmt = NoteRepositories::$conn->prepare("SELECT * FROM images WHERE journal_id = ?");
            $get_images_stmt->execute([$journal_id]);
            $images = $get_images_stmt->fetchAll();
            $journal['images'] = $images;
        }
        
        // Remove the reference to avoid any unintended side effects
        unset($journal);
        
        return $journals;
    }

    public function getNoteById($id){
        $stmt = NoteRepositories::$conn->prepare("SELECT * FROM journals WHERE id = ?");
        $stmt->execute([$id]);
        $journal = $stmt->fetch();

        $images_stmt = NoteRepositories::$conn->prepare("SELECT * FROM images WHERE journal_id = ?");
        $images_stmt->execute([$id]);
        $images = $images_stmt->fetchAll();

        $journal['images'] = $images;

        return $journal;
    }
    public function createNote(){
        $user_email = $_SESSION['user'];
        $user_id = NoteRepositories::$user_repositories->getUserIdByEmail($user_email);
        $stmt = NoteRepositories::$conn->prepare("INSERT INTO journals (user_id, created_date) VALUES (?, NOW())");
        $stmt->execute([$user_id]);
        $journal_id = NoteRepositories::$conn->lastInsertId();
        
        header("Location: /note/$journal_id");
    }

    public function updateNote($title, $content, $user_id, $journal_id){
        $update_journal_stmt = NoteRepositories::$conn->prepare("UPDATE journals SET title = ?, content = ?, user_id = ? WHERE id = ?");
        $update_journal_stmt->execute([$title, $content, $user_id, $journal_id]);
    }


    public function deleteNoteById($note_id){
        // delete the note and all images associated with it
        $delete_images_stmt = NoteRepositories::$conn->prepare("DELETE FROM images WHERE journal_id = ?");
        $delete_images_stmt->execute([$note_id]);

        $delete_note_stmt = NoteRepositories::$conn->prepare("DELETE FROM journals WHERE id = ?");
        $delete_note_stmt->execute([$note_id]);
       
        
        header("Location: /notes");
        
    }

}

?>
