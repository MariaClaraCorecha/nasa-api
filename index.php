<?php
// Incluir a API
require_once 'api.php';

// Criar instância da API
$api = new MarsPhotoAPI();

// Obter fotos (simulação de galeria com IDs sequenciais)
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$photos = $api->getPhotos($currentPage);

// Obter câmeras para filtro
$cameras = $api->getCameras();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria de Marte - Rover Perseverance</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Galeria de Marte - Rover Perseverance</h1>
            <p>Fotos capturadas pelo Rover Perseverance em Marte</p>
        </header>
        
        <?php if (!empty($photos)): ?>
            <div class="gallery">
                <?php foreach ($photos as $photo): ?>
                    <div class="photo-card">
                        <img src="<?php echo htmlspecialchars($photo['img_src']); ?>" 
                             alt="Foto de Marte" 
                             class="photo-image"
                             onerror="this.src='https://via.placeholder.com/400x200/333/666?text=Imagem+Indispon%C3%ADvel'">
                        
                        <div class="photo-info">
                            <h3 class="photo-title">Foto ID: <?php echo $photo['id']; ?></h3>
                            <div class="photo-details">
                                <p><strong>Sol:</strong> <?php echo $photo['sol']; ?></p>
                                <p><strong>Câmera:</strong> <?php echo $photo['camera']['full_name']; ?></p>
                                <p><strong>Data Terra:</strong> <?php echo $photo['earth_date']; ?></p>
                            </div>
                            <div class="photo-meta">
                                <span>Rover: <?php echo $photo['rover']['name']; ?></span>
                                <span>Total: <?php echo $photo['rover']['total_photos']; ?> fotos</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?php echo $currentPage - 1; ?>" class="page-btn">Anterior</a>
                <?php endif; ?>
                
                <span class="current-page">Página <?php echo $currentPage; ?></span>
                
                <a href="?page=<?php echo $currentPage + 1; ?>" class="page-btn">Próxima</a>
            </div>
            
        <?php else: ?>
            <div class="loading">
                <p>Nenhuma foto encontrada. Tente novamente.</p>
                <a href="index.php" class="page-btn">Recarregar</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="./script.js"></script>
</body>
</html>