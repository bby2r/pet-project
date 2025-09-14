<?php

namespace App\Services;

class TelegramService
{
    private ApiRequestService $apiService;
    public function __construct()
    {
        $this->apiService = (new ApiRequestService(config('services.telegram.url') . config('services.telegram.token') . '/'));
    }

    public function sendMessage(string $chat_id = null)
    {
        $chat_id = $chat_id ?? config('services.telegram.default_chat_id');
        $response = $this->apiService
            ->withUrl('sendMessage')
            ->withData(['chat_id' => $chat_id, 'text' => 'Hello world!'])
            ->get();
        return $response->body();
    }

    public function getMe() {
        return $this->apiService->withUrl('getMe')->get()->body();
    }
}
