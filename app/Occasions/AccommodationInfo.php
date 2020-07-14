<?php


namespace App\Occasions;


class AccommodationInfo
{
    public array $name;
    public array $description;
    public string $link;
    public string $phone;
    public string $email;

    public function __construct($data)
    {
        $this->name = [
            'en' => $data['name']['en'] ?? '',
            'zh' => $data['name']['zh'] ?? '',
        ];
        $this->description = [
            'en' => $data['description']['en'] ?? '',
            'zh' => $data['description']['zh'] ?? '',
        ];

        $this->link = $data['link'] ?? '';
        $this->phone = $data['phone'] ?? '';
        $this->email = $data['email'] ?? '';
    }

    public function toArray()
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'link'        => $this->link,
            'phone'       => $this->phone,
            'email'       => $this->email,
        ];
    }

}
