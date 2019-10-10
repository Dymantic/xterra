<?php

namespace App\Console\Commands;

use App\Blog\Translation;
use Illuminate\Console\Command;

class ImproveDummyText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:dummify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Better dummy text';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $en_headlines = collect([
            'Swimming routines for the pros',
            'Maui: More than just a place',
            'Benjamin Button Interview',
            'Training with your bestie is great',
            'Facing your pre-race anxieties and moving on',
            'Harry Kewel Interview',
            'Mountains are Immense: Here are our top 5',
            'Training until the cows come home',
            'Top 10 sunset trail runs',
            'Triathlons are better than biathlons',
        ]);

        $zh_headlines = collect([
            '売芸発処数航製',
            '届自京水正政掲昌時見唱提報必針庫',
            '何講質応的図深屋',
            '町判譲治両碁用魅低学学肇夫理鬼使要',
            '正員届自京水正政掲昌時見唱提報必針庫。様輪動回七務実試代容表告留情画浜',
            '講質応的図深屋整質合',
            '勝機校起子講',
            '受軍過了防職市勢毎不観試流況陽罪例速沈江',
            '院審命本縄言演賀化設用質自応',
            '庵典前都住辺券図党気間禁限開要陥。近生国病今手投灯式東起市',
        ]);

        $zh_intros = collect([
            '者広国文口導可無投作織隠勢著防果京次。発大潜人成割芸条野会捜営。必的発追氷競宿府論意屋先全。入裏芸曜問入閉方題界誕文番。地択産歌見氷真条実発行壮界属著命首。',
            '録時来市面康載真裂第付急。級最能容断部題始投野口話然旅引。類設督文世済招謙裁稿法発果酒側文新岡多。報能線今椎撃分観親県備道。資池辺稿減員囲権校幡般決塗隊意月月丸定構。',
            '費郵夏御住勝藤金示加換来沢一。景指記玄討記本分安済堀表。町判譲治両碁用魅低学学肇夫理鬼使要実賄。開彼思年滋家自目売芸発処数航製紙多難。'
        ]);

        Translation::all()->each(function($trans) use ($en_headlines, $zh_headlines, $zh_intros) {
            if($trans->language === 'en') {
                $trans->title = $en_headlines->random();
            }

            if($trans->language === 'zh') {
                $trans->title = $zh_headlines->random();
                $trans->intro = $zh_intros->random();
                $trans->body = '費郵夏御住勝藤金示加換来沢一。景指記玄討記本分安済堀表。町判譲治両碁用魅低学学肇夫理鬼使要実賄。開彼思年滋家自目売芸発処数航製紙多難。都友女問能信議調夜写奉翌測係亡。経環名断白元運近金写宿経真場調現内援同告。待情発去外金止雇区光要際意住得保聞和治表。編治太責会実審返属読急野広紙制鎌練載転。町直同治回報点写材製突函平。

正員届自京水正政掲昌時見唱提報必針庫。様輪動回七務実試代容表告留情画浜。局属火通遠松必著市距野思下試爆米家権定。受軍過了防職市勢毎不観試流況陽罪例速沈江。再転的圏人向候漫毎崎焦成奥。康界本問末回係暮世押戦薬同経。何講質応的図深屋整質合州撮全調併。球芸欧名座見更午卒新芸別。格用勝機校起子講最質出城郎新暮量憶。

掲果清西極渋掲岩辺判活数体言厘英。容著量設対工性話画発家能正記。期料加踏窓治様坂庭者比携震社。木軽楽新胸見極読助権提堂努界抗馬記嶋情。平引望意課織感供践更芸記有板達方結必月。動整文極存員修都向金負関京決秘発。済辺郷会供止端年戦由就向闘分氏未。就示速彰一抵文道狙趣井画酸門年伸携。栃早録囲写止止払素大応真内共我部元創削。

投役送品基放要京紅税著可間連川般覧最気応。立向碁握康欠緑仕合圧私賄賠列飛治新国子。信皇動充甘足本白器厳発引。常面転東可身教幅制満方容。野団紙書史海朝樫断州姿位申響大。馬水意皇勝他亡駒期古必校見就。回責国治符机辞会記三最研注入生。貧出女市人夜切無載義策帰大無武梨展。江戸知廟掲組記第取経校井志会。設果単置的馬個次住転位元。

院審命本縄言演賀化設用質自応器事室都。記捕朝栃若校呼一著川高掲麻主提件殿。松発月引格外若具公団面降予頭後。畑治発先代点報国高子場経書首。教際際平断点誕年障提延示温抗。山北線江電西仕監域熊位会齢者乗。経投迎飛上監球清新載同等府。掲阪森員余著報切概構紙健析海復果郊校載。野景国目急府半文測型治番注脳援太浩。';
            }

            $trans->save();


        });
    }
}
