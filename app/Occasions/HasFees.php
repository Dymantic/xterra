<?php


namespace App\Occasions;


trait HasFees
{
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function setFees(array $fees)
    {
        $this->clearFees();
        collect($fees)->each(fn ($fee) => $this->addFee($fee));
    }

    private function addFee(array $fee)
    {
        $this->fees()->create([
            'category' => $fee['category'],
            'fee' => $fee['fee'],
            'position' => $fee['position'],
        ]);
    }

    public function clearFees()
    {
        $this->fees()->delete();
    }
}
