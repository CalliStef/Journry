<?php 

namespace Services;

use \Controllers\DbController;

class ImageServices{

    private static $conn;

    public function __construct(){
        ImageServices::$conn = DbController::get_connection();
    }

    public function addImage($image_file, $journal_id){
        // convert to long blob and store in database
        $image_data = base64_encode(file_get_contents($image_file));
        $insert_image_stmt = ImageServices::$conn->prepare("INSERT INTO images (filename, journal_id) VALUES (?, ?)");
        $insert_image_stmt->execute([$image_data, $journal_id]);
    }

    public function getImages($journal_id){
        $get_images_stmt = ImageServices::$conn->prepare("SELECT * FROM images WHERE journal_id = ?");
        $get_images_stmt->execute([$journal_id]);
        $images = $get_images_stmt->fetchAll();
        return $images;
    }

    public function deleteImage($image_id){
        $journal_id_stmt = ImageServices::$conn->prepare("SELECT journal_id FROM images WHERE id = ?");
        $journal_id_stmt->execute([$image_id]);
        $journal_id = $journal_id_stmt->fetchColumn();

        $delete_image_stmt = ImageServices::$conn->prepare("DELETE FROM images WHERE id = ?");
        $delete_image_stmt->execute([$image_id]);

        header("Location: /note/$journal_id");
    }

}




?>