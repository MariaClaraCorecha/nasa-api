<?php
class MarsPhotoAPI {
    private $baseUrl = 'https://rovers.nebulum.one/api/v1/photos/';
    
    // Busca uma foto específica pelo ID
    public function getPhoto($photoId) {
        $url = $this->baseUrl . $photoId;

        // Usar file_get_contents para buscar os dados
        $jsonData = @file_get_contents($url);
        
        // Verificar se a requisição foi bem-sucedida
        if ($jsonData === false) {
            return null;
        }
        
        // Decodificar o JSON
        $data = json_decode($jsonData, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }
        
        return isset($data['photo']) ? $data['photo'] : null;
    }
    
    // Busca uma lista de fotos com paginação
    public function getPhotos($page = 1, $limit = 9) {
        $photos = [];
        
        // Calcular IDs baseado na página
        $startId = ($page - 1) * $limit + 1;
        $endId = $startId + $limit - 1;
        
        // Buscar fotos sequencialmente
        for ($id = $startId; $id <= $endId; $id++) {
            $photo = $this->getPhoto($id);
            
            if ($photo) {
                $photos[] = $photo;
            } else {
                // Se não encontrar, tentar próximo ID
                $nextId = $id + 1;
                $photo = $this->getPhoto($nextId);
                if ($photo) {
                    $photos[] = $photo;
                    $id = $nextId;
                }
            }
            
            // Limitar ao número desejado
            if (count($photos) >= $limit) {
                break;
            }
        }
        
        return $photos;
    }
    
    // Busca as câmeras disponíveis para um rover específico
    public function getCameras($photoId = 878) {
        $photo = $this->getPhoto($photoId);
        
        if ($photo && isset($photo['rover']['cameras'])) {
            return $photo['rover']['cameras'];
        }
        
        return [];
    }
    
    // Busca fotos tiradas por uma câmera específica
    public function getPhotosByCamera($cameraName, $limit = 9) {
        $photos = [];
        $found = 0;
        $currentId = 1;
        
        // Buscar até encontrar fotos suficientes
        while ($found < $limit && $currentId < 1000) {
            $photo = $this->getPhoto($currentId);
            
            if ($photo && 
                isset($photo['camera']['name']) && 
                $photo['camera']['name'] === $cameraName) {
                $photos[] = $photo;
                $found++;
            }
            
            $currentId++;
        }
        
        return $photos;
    }
}


?>