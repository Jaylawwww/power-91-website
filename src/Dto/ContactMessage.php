<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class ContactMessage
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    public ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email = null;

    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['request', 'shoutout', 'ads', 'general'])]
    public string $subject = 'request';

    #[Assert\NotBlank]
    #[Assert\Length(min: 10, max: 2000)]
    public ?string $message = null;

    public function subjectLabel(): string
    {
        return match ($this->subject) {
            'request' => 'Song request',
            'shoutout' => 'On-air shout-out',
            'ads' => 'Advertising',
            default => 'Studio message',
        };
    }
}
