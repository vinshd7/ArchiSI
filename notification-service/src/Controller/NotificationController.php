<?php

namespace App\Controller;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NotificationController extends AbstractController
{
    #[Route('/notify', name: 'send_notification', methods: ['POST'])]
    public function sendNotification(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['emailRecipient']) || empty($data['sujet']) || empty($data['message'])) {
            return new JsonResponse(['status' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $notification = new Notification();
        $notification->setEmailRecipient($data['emailRecipient']);
        $notification->setSujet($data['sujet']);
        $notification->setMessage($data['message']);

        $entityManager->persist($notification);
        $entityManager->flush();

        $this->sendEmail($mailer, $notification);

        return new JsonResponse(['status' => 'Notification sent and saved!'], JsonResponse::HTTP_CREATED);
    }

    private function sendEmail(MailerInterface $mailer, Notification $notification)
    {
        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($notification->getEmailRecipient())
            ->subject($notification->getSujet())
            ->text($notification->getMessage());

        $mailer->send($email);
    }
}
