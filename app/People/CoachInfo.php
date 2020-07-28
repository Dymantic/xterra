<?php


namespace App\People;


use App\Translation;

class CoachInfo
{
    public Translation $name;
    public Translation $location;
    public Translation $certifications;
    public Translation $experience;
    public Translation $philosophy;
    public string $email;
    public string $phone;
    public string $website;
    public string $line;
    public array $social_links;

    public function __construct($info)
    {
        $this->name = new Translation($info['name']);
        $this->location = new Translation($info['location']);
        $this->certifications = new Translation($info['certifications']);
        $this->experience = new Translation($info['experience']);
        $this->philosophy = new Translation($info['philosophy']);
        $this->email = $info['email'] ?? '';
        $this->phone = $info['phone'] ?? '';
        $this->website = $info['website'] ?? '';
        $this->line = $info['line'] ?? '';

        $this->social_links = $info['social_links'];
    }

    public function toArray(): array
    {
        return [
            'name'           => $this->name,
            'location'       => $this->location,
            'certifications' => $this->certifications,
            'experience'     => $this->experience,
            'philosophy'     => $this->philosophy,
            'email'          => $this->email,
            'phone'          => $this->phone,
            'website'        => $this->website,
            'line'           => $this->line,
        ];
    }
}
