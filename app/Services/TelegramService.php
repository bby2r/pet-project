<?php

namespace App\Services;

class TelegramService
{
    private ApiRequestService $apiService;
    public function __construct()
    {
        $this->apiService = (new ApiRequestService(config('services.telegram.url') . config('services.telegram.token') . '/'));
    }

    public function sendMessage(string $message,string $chat_id = null): array
    {
        $chat_id = $chat_id ?? config('services.telegram.default_chat_id');
        $response = $this->apiService
            ->withHeaders(['Accept' => 'application/json'])
            ->withUrl('sendMessage')
            ->withData(['chat_id' => $chat_id, 'text' => $message])
            ->get();

        return $response->json();
    }

    public function getMe() {
        return $this->apiService->withUrl('getMe')->get()->body();
    }
}
