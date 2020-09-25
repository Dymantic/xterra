<?php


namespace Tests\Unit\Events;


use App\Campaigns\Campaign;
use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityRulesHtmlTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_convert_raw_rules_data_to_html()
    {
        $race = factory(Activity::class)->create();
        $race->updateRules($this->getTestRules(), 'en');

        $expected_block_one = view('editorjs.races.paragraph', [
            'text' => 'test paragraph text'
        ])->render();
        $expected_block_two = view('editorjs.races.illustratedText', [
            'header'    => 'test header',
            'text'      => 'test illustrated-text text',
            'image_src' => '/test/image/test.jpeg',
            'align'     => 'right',
        ])->render();
        $expected_block_three = view('editorjs.races.image', [
            'src'     => '/test/image/test.jpeg',
            'caption' => 'test caption',
        ])->render();
        $expected_block_four = view('editorjs.races.table', [
            'data' => [
                ['head one', 'head two', 'head three'],
                ['data one', 'data two', 'data three'],
            ]
        ])->render();

        $expected = sprintf("%s\n%s\n%s\n%s", $expected_block_one, $expected_block_two, $expected_block_three,
            $expected_block_four);

        $this->assertEquals($expected, $race->rulesHtml('en'));
    }

    private function getTestRules()
    {
        return '{
    "time": 1600228637788,
    "blocks": [
        {
            "data": {
                "text": "test paragraph text"
            },
            "type": "paragraph"
        },
        {
            "data": {
            "header": "test header",
                "text": "test illustrated-text text",
                "image_src": "\/test\/image\/test.jpeg",
                "image_side": "right"
            },
            "type": "illustratedText"
        },
        {
            "data": {
                "file": {
                    "url": "\/test\/image\/test.jpeg"
                },
                "caption": "test caption",
                "stretched": false,
                "withBorder": false,
                "withBackground": false
            },
            "type": "image"
        },
        {
            "data": {
                "content": [ ["head one", "head two", "head three"], ["data one", "data two", "data three"]]
            },
            "type": "table"
        }
    ],
    "version": "2.18.0"
}';
    }
}
