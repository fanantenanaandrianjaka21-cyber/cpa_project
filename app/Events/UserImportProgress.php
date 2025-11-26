<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserImportProgress implements ShouldBroadcast
{
    use SerializesModels;

    public $current;
    public $total;
    public $user;

    public function __construct($current, $total, $user = null)
    {
        $this->current = $current;
        $this->total = $total;
        $this->user = $user; // optionnel, pour mettre à jour la liste
    }

    public function broadcastOn()
    {
        return new Channel('import-progress');
    }

    public function broadcastAs()
    {
        return 'UserImportProgress';
    }
}
