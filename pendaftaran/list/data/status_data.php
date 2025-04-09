<?php
class StatusDataHandler {
    private $dataFile;
    private $data;

    public function __construct() {
        $this->dataFile = __DIR__ . '/status.json';
        $this->loadData();
    }

    private function loadData() {
        if (file_exists($this->dataFile)) {
            $jsonContent = file_get_contents($this->dataFile);
            $this->data = json_decode($jsonContent, true) ?? [];
        } else {
            $this->data = [];
        }
    }

    private function saveData() {
        try {
            if (!is_dir(dirname($this->dataFile))) {
                mkdir(dirname($this->dataFile), 0777, true);
            }
            
            $jsonContent = json_encode($this->data, JSON_PRETTY_PRINT);
            if ($jsonContent === false) {
                throw new Exception('Failed to encode JSON data');
            }
            
            $result = file_put_contents($this->dataFile, $jsonContent, LOCK_EX);
            if ($result === false) {
                throw new Exception('Failed to write to status file');
            }
            
            return true;
        } catch (Exception $e) {
            error_log('Status save error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateStatus($id, $status) {
        if (empty($id)) {
            throw new Exception('Invalid ID provided');
        }
        
        if (empty($status)) {
            throw new Exception('Invalid status provided');
        }

        $this->data[$id] = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
            'last_message_sent' => $this->data[$id]['last_message_sent'] ?? null
        ];
        
        return $this->saveData();
    }

    public function getStatus($id) {
        return $this->data[$id] ?? null;
    }

    public function getAllStatuses() {
        return $this->data;
    }

    public function updateMessageSent($id, $messageType) {
        if (!isset($this->data[$id])) {
            $this->data[$id] = ['status' => 'belum_diproses'];
        }
        $this->data[$id]['last_message_sent'] = [
            'type' => $messageType,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        return $this->saveData();
    }
}
?>
