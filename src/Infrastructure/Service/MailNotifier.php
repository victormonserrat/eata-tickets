<?php

/*
 * This file is part of the EATA Dev Test package.
 *
 * (c) Victor Monserrat
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EataDevTest\Infrastructure\Service;

use EataDevTest\Application\Service\Notifier;
use EataDevTest\Domain\Code\Model\Code;
use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

final class MailNotifier implements Notifier
{
    /** @var Swift_Mailer */
    private $mailer;

    /** @var Twig_Environment */
    private $templating;

    /** @var string */
    private $email;

    public function __construct(Swift_Mailer $mailer, Twig_Environment $templating, string $email)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->email = $email;
    }

    /** @param Code[] $codes */
    public function sentCodesTo($codes, string $to): void
    {
        $message = new Swift_Message();

        $message
            ->setFrom($this->email)
            ->setTo($to)
            ->setSubject('EATA order')
            ->setBody(
                $this->templating->render('emails/codes.html.twig', [
                    'codes' => $codes,
                ]),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}
