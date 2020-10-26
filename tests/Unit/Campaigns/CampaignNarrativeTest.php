<?php


namespace Tests\Unit\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignNarrativeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_present_its_narrative_in_html()
    {
        $campaign = factory(Campaign::class)->create();
        $campaign->updateNarrative($this->getTestNarrative(), 'en');

        $expected_block_one = view('editorjs.campaigns.paragraph', [
            'text' => 'test paragraph text'
        ])->render();
        $expected_block_two = view('editorjs.campaigns.illustratedText', [
            'header'    => 'test header',
            'text'      => 'test illustrated-text text',
            'image_src' => '/test/image/test.jpeg',
            'align'     => 'right',
        ])->render();
        $expected_block_three = view('editorjs.campaigns.image', [
            'src'     => '/test/image/test.jpeg',
            'caption' => 'test caption',
        ])->render();
        $expected_block_four = view('editorjs.campaigns.paragraph', [
            'text' => 'test paragraph text'
        ])->render();

        $expected = sprintf("%s\n%s\n%s\n%s", $expected_block_one, $expected_block_two, $expected_block_three,
            $expected_block_four);

        $this->assertEquals(sprintf('<div class="admin-edited">%s</div>', $expected), $campaign->narrativeHtml('en'));
    }

    private function getTestNarrative()
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
                "text": "test paragraph text"
            },
            "type": "paragraph"
        }
    ],
    "version": "2.18.0"
}';
    }
}
