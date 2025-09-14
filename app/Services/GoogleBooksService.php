<?php

namespace App\Services;

use App\Enums\GoogleBooksApiUri;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GoogleBooksService
{
    private ApiRequestService $apiService;
    public function __construct()
    {
        $this->apiService = new ApiRequestService(config('services.google_books.url'));
    }

    public function list(string $search): array
    {
        $response = $this->apiService
            ->withUrl(GoogleBooksApiUri::List->value)
            ->withData([
                'q' => "$search",
                'maxResults' => 10,
                'orderBy' => 'relevance',
            ])
            ->get();

        return $this->getItemsArray($response->body());
    }

    public function getItemsArray($json): array {
        $items = json_decode($json, true)['items'];

        return array_map(fn($item) => [
            'title' => Arr::get($item, 'volumeInfo.title'),
            'subtitle' => Arr::get($item, 'volumeInfo.subtitle'),
            'authors' => Arr::get($item, 'volumeInfo.authors'),
            'published_date' => Arr::get($item, 'volumeInfo.publishedDate'),
            'imageLinks' => Arr::get($item, 'volumeInfo.imageLinks'),
        ], $items);
    }
}
