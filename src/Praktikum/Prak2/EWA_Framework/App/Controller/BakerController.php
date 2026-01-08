<?php
require_once __DIR__ . '/../Model/BakerModel.php';

class BakerController extends BaseController
{
    // 1 - Daten holen (READ)
    public function getData(): array
    {
        $model = new BakerModel();
        return $model->getOpenPizzas();
    }

     // 2 - Formular verarbeiten (UPDATE)
    public function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $model = new BakerModel();

        // Alle Status-Änderungen durchgehen
        foreach ($_POST as $key => $value){
            // Suche nach "status_123" (123 = ordered_article_id)
            if(str_starts_with($key , 'status_')){  
                $id = (int)substr($key , 7);
                $status = (int)$value;
                $model->update($id, $status);
            }
        }

        // PRG Pattern
        header('Location: baker.php');
        exit;
    }

    // 3 - Seite anzeigen
    public function generateResponse(array $data): void
    {
        $viewData = [
            'data'  => $data,
            'title' => 'Bäckeransicht'
        ];
        $this->renderHtml(__DIR__ . '/../View/baker.view.php', $viewData);
    }
}
