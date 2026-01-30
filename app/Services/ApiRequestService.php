<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class ApiRequestService
{
    protected string $domain;

    protected string $entry_point;

    protected ?string $token;

    protected array $query_params;

    protected array $data = [];

    protected array $headers = [];

    protected int $timeout = 30;

    protected int $tries = 1;

    protected int $delay = 0;

    public function __construct(string $domain, ?string $token = null)
    {
        $this->domain = $domain;
        $this->token = $token;
    }

    public function withUrl(string $url): self
    {
        $this->entry_point = $url;

        return $this;
    }

    public function withHeaders(array $headers): self {

        $this->headers = $headers;

        return $this;
    }

    public function withData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function withQueryParams(array $params): self
    {
        $this->query_params = $params;

        return $this;
    }

    public function withTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function post(): Response
    {
        return Http::timeout($this->timeout)
            ->acceptJson()
            ->withHeaders($this->headers)
            ->withToken($this->token)
            ->retry($this->tries, $this->delay)
            ->post($this->getRequestUrl(), $this->data);
    }

    public function get(): Response
    {
        return Http::timeout($this->timeout)
            ->acceptJson()
            ->withHeaders($this->headers)
            ->withToken($this->token)
            ->retry($this->tries, $this->delay)
            ->get($this->getRequestUrl(), $this->data);
    }

    public function getRequestUrl(): string
    {
        $url = $this->domain.$this->entry_point;
        if (isset($this->query_params)) {
            $url .= '?'.http_build_query($this->query_params);
        }

//        dd($url);

        return $url;
    }

    public function withRetries(int $tries, int $seconds): self
    {
        $this->tries = $tries;
        $this->delay = $seconds * 1000;

        return $this;
    }
}
