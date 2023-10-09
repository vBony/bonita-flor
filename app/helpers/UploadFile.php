<?php
namespace helpers;

class UploadFile {
    private $file;

    // Variaveis para imagens
    public static $extensoesImagem =  ["jpg", "jpeg", "png"];

    public function __construct($file){
        $this->file = $file;
    }

    public function getWidth(){
        $imageInfo = getimagesize($this->file['tmp_name']);

        if ($imageInfo !== false) {
            return intval($imageInfo[0]);
        }
    }

    public function getHeight(){
        $imageInfo = getimagesize($this->file['tmp_name']);

        if ($imageInfo !== false) {
            return intval($imageInfo[1]);
        }
    }

    public function getMbSize(){
        $sizeBytes = $this->file['size'];
        return round($sizeBytes / (1024 * 1024), 2);
    }

    public function upload($caminho, $nomeArquivo){
        $tempFilePath = $this->file['tmp_name'];
        $caminhoComNomeArquivo = $caminho.$nomeArquivo;

        if (move_uploaded_file($tempFilePath, $caminhoComNomeArquivo)) {
            return true;
        } else {
            return false;
        }
    }

    public function getExtension(){
        $fileinfo = pathinfo($this->file['name']);

        return $fileinfo['extension'];
    }
}