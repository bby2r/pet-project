<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function __invoke(Request $request)
    {
        $files = Storage::disk('public')->files('test');
        $urls = [];

        foreach ($files as $file) {
            $title = Str::afterLast($file, '/');
            $urls[$title] = base64_encode(Storage::temporaryUrl(
                $file, now()->addMinutes(5)
            ));
        }

        return view('index', ['urls' => $urls]);
    }

    public function showFile(string $base64) {
        $url = base64_decode($base64);
        return view('pages.show-file', ['url' => $url]);
    }

    public function uploadFile(Request $request) {
        return redirect('home')->with(['success' => 'File successfully uploaded']);
    }
}
