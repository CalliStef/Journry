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
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_email = $_SESSION['user'];

        // filter out empty images
        $image_files = array_filter($_FILES['images']['tmp_name']);
        
        // echo var_dump($images);
        
        // get user id
        $user_id_stmt = NoteServices::$conn->prepare("SELECT id FROM users WHERE username = ?");
        $user_id_stmt->execute([$user_email]);
        $user_id = $user_id_stmt->fetchColumn();

        // insert journal into journals table
        $insert_journal_stmt = NoteServices::$conn->prepare("INSERT INTO journals (title, content, user_id, created_date) VALUES (?, ?, ?, NOW())");
        $insert_journal_stmt->execute([$title, $content, $user_id]);
        $journal_id = NoteServices::$conn->lastInsertId();

        // insert images into images table
        foreach($image_files as $image_file){
            // convert to long blob and store in database
            $image_data = base64_encode(file_get_contents($image_file));
            $insert_image_stmt = NoteServices::$conn->prepare("INSERT INTO images (filename, journal_id) VALUES (?, ?)");
            $insert_image_stmt->execute([$image_data, $journal_id]);
        }

        header("Location: /note/$journal_id");
    }

    public function updateNote(){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_email = $_SESSION['user'];

        // filter out empty images
        $image_files = array_filter($_FILES['images']['tmp_name']);

        $journal_id = $_POST['journal_id'];

        // update journal
        $update_journal_stmt = NoteServices::$conn->prepare("UPDATE journals SET title = ?, content = ? WHERE id = ?");
        $update_journal_stmt->execute([$title, $content, $journal_id]);

        // insert images into images table
        foreach($image_files as $image_file){
            // convert to long blob and store in database
            $image_data = base64_encode(file_get_contents($image_file));
            $insert_image_stmt = NoteServices::$conn->prepare("INSERT INTO images (filename, journal_id) VALUES (?, ?)");
            $insert_image_stmt->execute([$image_data, $journal_id]);
        }

    }

}

?>
