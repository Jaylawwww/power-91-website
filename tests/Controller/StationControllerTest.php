<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class StationControllerTest extends WebTestCase
{
    public function testHomePagePresentsTheStation(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Music from every decade');
        self::assertSelectorExists('#live-player');
        self::assertSelectorExists('#live-player [data-controller="clock"]');
        self::assertGreaterThan(0, $crawler->filter('[data-controller="clock"]')->count());
        self::assertSelectorTextContains('#program-schedule h2', 'Program Schedule');
        self::assertSelectorTextContains('.site-footer', 'Our Station Address');
        self::assertGreaterThan(0, $crawler->filter('a[href="/schedule"]')->count());
    }

    public function testOnAirTeamListsCurrentHosts(): void
    {
        $client = static::createClient();
        $client->request('GET', '/team');

        self::assertResponseIsSuccessful();
        foreach (['John Navarro', 'Dions Manaban', 'Ms. Jo', 'Anthony', 'Charlie'] as $name) {
            self::assertSelectorTextContains('.host-grid', $name);
        }
    }

    public function testCorePagesRender(): void
    {
        $client = static::createClient();

        foreach (['/schedule', '/team', '/about', '/contact'] as $path) {
            $client->request('GET', $path);
            self::assertResponseIsSuccessful($path);
        }
    }

    public function testNowPlayingReturnsJson(): void
    {
        $client = static::createClient();
        $client->request('GET', '/now-playing');

        self::assertResponseIsSuccessful();
        $payload = json_decode($client->getResponse()->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('title', $payload);
        self::assertArrayHasKey('host', $payload);
        self::assertNotSame('', $payload['title']);
    }

    public function testContactFormRejectsEmptySubmission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');
        $form = $crawler->selectButton('Send to the studio')->form([
            'contact[name]' => '',
            'contact[email]' => 'not-an-email',
            'contact[message]' => 'short',
        ]);
        $client->submit($form);

        self::assertResponseIsUnprocessable();
    }

    public function testContactFormSendsAValidRequest(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');
        $form = $crawler->selectButton('Send to the studio')->form([
            'contact[name]' => 'Listener from Dumaguete',
            'contact[email]' => 'listener@example.com',
            'contact[subject]' => 'request',
            'contact[message]' => 'Please play September and say hi to the boat crew.',
        ]);
        $client->submit($form);

        self::assertResponseRedirects('/contact');
        $client->followRedirect();
        self::assertSelectorTextContains('.flash', 'Got it');
    }
}
