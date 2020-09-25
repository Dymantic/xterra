<?php


namespace App;


class JsonToBladeParser
{

    private $viewRoot;

    public function __construct($viewRoot)
    {
        $this->viewRoot = $viewRoot;
    }

    public function html($json)
    {
        $data = is_array($json) ? $json : json_decode($json, true);
        $blocks = collect($data['blocks'] ?? []);

        return $blocks->map(fn ($block) => $this->parseBlock($block))->join("\n");
    }

    private function parseBlock($block)
    {
        switch ($block['type']) {
            case 'paragraph':
                return view("{$this->viewRoot}.paragraph", ['text' => $block['data']['text'] ?? ''])->render();
            case 'illustratedText':
                return view("{$this->viewRoot}.illustratedText", [
                    'header' => $block['data']['header'] ?? '',
                    'text' => $block['data']['text'] ?? '',
                    'image_src' => $block['data']['image_src'] ?? '',
                    'align' => $block['data']['image_side'] ?? '',
                ])->render();
            case 'image':
                return view("{$this->viewRoot}.image", [
                    'src' => $block['data']['file']['url'] ?? '',
                    'caption' => $block['data']['caption'] ?? '',
                ])->render();
            case 'table':
                return view("{$this->viewRoot}.table", [
                    'data' => $block['data']['content'] ?? [],
                ])->render();
            default:
                return '';
        }
    }


}
