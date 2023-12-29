<?php
class ProvedorVisualizacao {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function createCategoryPreviewVideo($categoryId) {
        $entitiesArray =  ProvedordeEntidade::getEntity($this->con, $categoryId, 1);

        if(sizeof($entitiesArray) == 0) {
            MensagemdeErro::programa("Nenhum programa de TV para exibir");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

        public function createTVShowPreviewVideo() {
            $entitiesArray = ProvedordeEntidade::getTVShowEntities($this->con, null, 1);

        if(sizeof($entitiesArray) == 0) {
            MensagemdeErro::programa("Nenhum programa de TV para exibir");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createMoviesPreviewVideo() {
        $entitiesArray =ProvedordeEntidade::getMoviesEntities($this->con, null, 1);

        if(sizeof($entitiesArray) == 0) {
            MensagemdeErro::programa("Nenhum filme para exibir");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createPreviewVideo($entity) {
        
        if($entity == null) {
            $entity = $this->getRandomEntity();
        }

        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail = $entity->getThumbnail();

        $videoId = ProvedordeVideo::getEntityVideoForUser($this->con, $id, $this->username);
        $video = new Video($this->con, $videoId);
        
        $inProgress = $video->isInProgress($this->username);
        $playButtonText = $inProgress ? "Continuar assistindo" : "Ver";

        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";

        return "<div class='previewContainer'>

                    <img src='$thumbnail' class='previewImage' hidden>

                    <video autoplay muted class='previewVideo' onended='previewEnded()'>
                        <source src='$preview' type='video/mp4'>
                    </video>

                    <div class='previewOverlay'>
                        
                        <div class='mainDetails'>
                            <h3>$name</h3>
                            $subHeading
                            <div class='buttons'>
                                <button onclick='watchVideo($videoId)'><i class='fa-sharp fa-solid fa-play fa-beat-fade'></i> $playButtonText</button>
                                <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                            </div>    

                        </div>

                    </div>
        
                </div>";

    }

    public function createEntityPreviewSquare($entity) {
        $id = $entity->getId();
        $thumbnail = $entity->getThumbnail();
        $name = $entity->getName();

        return "<a href='entidade.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>";
    }

    private function getRandomEntity() {

        $entity = ProvedordeEntidade::getEntity($this->con, null, 1);
        return $entity[0];
    }

}
?>