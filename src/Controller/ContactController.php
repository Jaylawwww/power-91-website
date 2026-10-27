<?php

namespace App\Controller;

use App\Dto\ContactMessage;
use App\Form\ContactType;
use App\Station\StationCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    public function __construct(
        private readonly StationCatalog $catalog,
        private readonly MailerInterface $mailer,
        #[Autowire('%env(RADIO_STREAM_URL)%')]
        private readonly string $streamUrl,
        #[Autowire('%env(RADIO_REQUEST_INBOX)%')]
        private readonly string $inbox,
    ) {
    }

    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request): Response
    {
        $message = new ContactMessage();
        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from(new Address('studio@power91.local', StationCatalog::NAME))
                ->replyTo(new Address((string) $message->email, (string) $message->name))
                ->to($this->inbox)
                ->subject(sprintf('[Power 91] %s from %s', $message->subjectLabel(), $message->name))
                ->text((string) $message->message)
            ;

            $this->mailer->send($email);
            $this->addFlash('success', 'Got it. The studio will take it from here.');

            return $this->redirectToRoute('contact');
        }

        $response = $this->render('station/contact.html.twig', [
            'form' => $form,
            'onAir' => $this->catalog->onAir(),
            'streamUrl' => $this->streamUrl,
            'stationName' => StationCatalog::NAME,
            'stationTagline' => StationCatalog::TAGLINE,
            'stationCity' => StationCatalog::CITY,
            'studioLine' => StationCatalog::STUDIO_LINE,
            'studioAddress' => StationCatalog::STUDIO_ADDRESS,
            'studioHours' => StationCatalog::STUDIO_HOURS,
            'stationTimezone' => StationCatalog::TIMEZONE,
            'timezoneLabel' => StationCatalog::TIMEZONE_LABEL,
        ]);

        if ($form->isSubmitted() && !$form->isValid()) {
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $response;
    }
}
