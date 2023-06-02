<?php

namespace App\Console\Commands;

use App\Models\Product;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all articles to Elasticsearch';

    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing all products. This might take a while...');

        $this->withProgressBar(Product::cursor(), function ($product) {
            $this->elasticsearch->index([
                'index' => $product->getSearchIndex(),
                'type' => $product->getSearchType(),
                'id' => $product->getKey(),
                'body' => $product->toSearchArray(),
            ]);
        });

        $this->info("\nDone!");
        return Command::SUCCESS;
    }
}
