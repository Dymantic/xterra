<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\Models\Media;

class WipeContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:wipe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wipe all content from the system';

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
        Media::all()->each(function($m) {
            $m->delete();
        });
        \Illuminate\Support\Facades\DB::table('tags')->truncate();
        \Illuminate\Support\Facades\DB::table('translations')->truncate();
        \Illuminate\Support\Facades\DB::table('articles')->truncate();
        \Illuminate\Support\Facades\DB::table('categories')->truncate();
        \Illuminate\Support\Facades\DB::table('article_category')->truncate();
        \Illuminate\Support\Facades\DB::table('tag_translation')->truncate();
        \Illuminate\Support\Facades\DB::table('comments')->truncate();
        \Illuminate\Support\Facades\DB::table('replies')->truncate();
        \Illuminate\Support\Facades\DB::table('slides')->truncate();
        \Illuminate\Support\Facades\DB::table('flagged_comments')->truncate();
        \Illuminate\Support\Facades\DB::table('media')->truncate();
    }
}
