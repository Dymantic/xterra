<?php


namespace Tests\Unit\Media;


use App\Blog\Article;
use App\Blog\Translation;
use App\Media\ContentCard;
use App\Media\ContentCardInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ContentCardsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function make_a_new_content_card()
    {
        $cardInfo = new ContentCardInfo([
            'category' => ['en' => 'test category', 'zh' => 'zh test category'],
            'title'    => ['en' => 'test title', 'zh' => 'zh test title'],
            'link'     => 'https://test.test',
        ]);

        $card = ContentCard::new($cardInfo);

        $this->assertSame('test category', $card->category->in('en'));
        $this->assertSame('zh test category', $card->category->in('zh'));

        $this->assertSame('test title', $card->title->in('en'));
        $this->assertSame('zh test title', $card->title->in('zh'));

        $this->assertSame('https://test.test', $card->link);
    }

    /**
     *@test
     */
    public function can_set_order_of_cards()
    {
        $cardA = factory(ContentCard::class)->create();
        $cardB = factory(ContentCard::class)->create();
        $cardC = factory(ContentCard::class)->create();
        $cardD = factory(ContentCard::class)->create();

        ContentCard::setOrder([$cardC->id, $cardB->id, $cardA->id, $cardD->id]);

        $this->assertSame(1, $cardC->fresh()->position);
        $this->assertSame(2, $cardB->fresh()->position);
        $this->assertSame(3, $cardA->fresh()->position);
        $this->assertSame(4, $cardD->fresh()->position);
    }

    /**
     *@test
     */
    public function creating_new_card_gives_it_a_position_at_back()
    {
        factory(ContentCard::class)->create(['position' => 1]);
        factory(ContentCard::class)->create(['position' => 4]);
        factory(ContentCard::class)->create(['position' => 5]);
        $cardInfo = new ContentCardInfo([
            'category' => ['en' => 'test category', 'zh' => 'zh test category'],
            'title'    => ['en' => 'test title', 'zh' => 'zh test title'],
            'link'     => 'https://test.test',
        ]);

        $card = ContentCard::new($cardInfo);

        $this->assertSame(6, $card->fresh()->position);
    }

    /**
     *@test
     */
    public function make_a_card_from_an_article()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $article = factory(Article::class)->create();
        $english = factory(Translation::class)
            ->state('en')
            ->create(['article_id' => $article->id]);
        $chinese = factory(Translation::class)
            ->state('zh')
            ->create(['article_id' => $article->id]);
        $image = $article->setTitleImage(UploadedFile::fake()->image('test.png'));
        $card = ContentCard::fromExistingContent($article);

        $this->assertSame($english->title, $card->title->in('en'));
        $this->assertSame($chinese->title, $card->title->in('zh'));
        $this->assertSame(Lang::get('content-cards.blog', [], 'en'), $card->category->in('en'));
        $this->assertSame(Lang::get('content-cards.blog', [], 'zh'), $card->category->in('zh'));
        $this->assertSame("/blog/{$article->slug}/", $card->link);
        $this->assertCount(1, $card->fresh()->getMedia(ContentCard::IMAGE));
    }

    /**
     *@test
     */
    public function making_a_card_from_existing_content_will_not_try_use_non_existing_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $article = factory(Article::class)->create();
        $english = factory(Translation::class)
            ->state('en')
            ->create(['article_id' => $article->id]);
        $chinese = factory(Translation::class)
            ->state('zh')
            ->create(['article_id' => $article->id]);
        $image = $article->setTitleImage(UploadedFile::fake()->image('test.png'));
        Storage::disk('media')->delete(Str::after($image->getUrl(), "/media"));

        $card = ContentCard::fromExistingContent($article);

        $this->assertCount(0, $card->fresh()->getMedia(ContentCard::IMAGE));
    }
}
