<?php 

namespace Repositories;

require_once '../Controllers/DbController.php';

use Controllers\DbController;

class ImageRepositories{

    private static $conn;

    public function __construct(){
        ImageRepositories::$conn = DbController::get_connection();
    }

    public function addImage($image_data, $journal_id){
        // convert to long blob and store in database
        $insert_image_stmt = ImageRepositories::$conn->prepare("INSERT INTO images (filename, journal_id) VALUES (?, ?)");
        $insert_image_stmt->execute([$image_data, $journal_id]);
    }

    public function getImages($journal_id){
        $get_images_stmt = ImageRepositories::$conn->prepare("SELECT * FROM images WHERE journal_id = ?");
        $get_images_stmt->execute([$journal_id]);
        $images = $get_images_stmt->fetchAll();
        return $images;
    }

    public function deleteImageById($image_id){
        $journal_id_stmt = ImageRepositories::$conn->prepare("SELECT journal_id FROM images WHERE id = ?");
        $journal_id_stmt->execute([$image_id]);
        $journal_id = $journal_id_stmt->fetchColumn();

        $delete_image_stmt = ImageRepositories::$conn->prepare("DELETE FROM images WHERE id = ?");
        $delete_image_stmt->execute([$image_id]);

        header("Location: /note/$journal_id");
    }

}




?>