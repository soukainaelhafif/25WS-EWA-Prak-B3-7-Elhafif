<?php
require_once __DIR__ . '/../Model/DriverModel.php';

class DriverController extends BaseController
{

    public function getData(): array
    {
        $model = new DriverModel();
        return $model->getDeliveries();
    }

    public function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $model = new DriverModel();
        
        foreach ($_POST as $key => $value) {
            if (str_starts_with($key, 'status_')) {
                $orderingId = (int)substr($key, 7);
                $status     = (int)$value;

                if ($status === 4 || $status === 5) {
                    $model->updateOrderStatus($orderingId, $status);

                    if ($status === 5) {
                        // Optional: komplett löschen
                        $model->deleteDelivered($orderingId);
                    }
                }
            }
        }

        header('Location: driver.php');
        exit;
    }

    public function generateResponse(array $data): void
    {
        $viewData = [
            'data'  => $data,
            'title' => 'Fahreransicht'
        ];
        $this->renderHtml(__DIR__ . '/../View/driver.view.php', $viewData);
    }
}
