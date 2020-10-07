<?php


namespace App\Occasions;


use App\JsonToBladeParser;
use App\Translation;

trait HasPrizes
{
    public function setPrizes($prize_data, string $lang)
    {
        $this->prizes->translations[$lang] = $prize_data;
        $this->save();
    }

    public function prizesHtml($lang)
    {
        $parser = new JsonToBladeParser('editorjs.prizes');

        return $parser->html($this->prizes->translations[$lang]);
    }
}
