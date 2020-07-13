<?php


namespace App\Occasions;


trait HasPrizes
{
    public function prizes()
    {
        return $this->hasMany(Prize::class);
    }

    public function setPrizes(array $prizes)
    {
        $this->clearPrizes();
        collect($prizes)->each(fn($prize) => $this->addPrize($prize));
    }

    private function addPrize(array $prize)
    {
        $this->prizes()->create([
            'category' => ['en' => $prize['category']['en'] ?? '', 'zh' => $prize['category']['zh'] ?? ''],
            'prize' => ['en' => $prize['prize']['en'] ?? '', 'zh' => $prize['prize']['zh'] ?? ''],
            'position' => $prize['position']
        ]);
    }

    public function clearPrizes()
    {
        $this->prizes()->delete();
    }
}
