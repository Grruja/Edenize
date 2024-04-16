<?php


namespace App\Models;


class Product
{
    public function saveImage(string $imageName): void
    {
        global $storagePath;
        $storagePath = __DIR__ . '/../..' . $storagePath . '/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $storagePath);
    }
}