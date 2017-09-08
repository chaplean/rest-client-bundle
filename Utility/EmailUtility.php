<?php

namespace Chaplean\Bundle\RestClientBundle\Utility;

use Chaplean\Bundle\RestClientBundle\Api\ResponseInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class EmailUtility.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Utility
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     4.0.0
 */
class EmailUtility
{
    /** @var array */
    protected $parameters;

    /** @var \Swift_Mailer */
    protected $mailer;

    /** @var TranslatorInterface */
    protected $translator;

    /** @var TwigEngine */
    protected $templating;

    /**
     * RestLogUtility constructor.
     *
     * @param array               $parameters
     * @param \Swift_Mailer       $mailer
     * @param TranslatorInterface $translator
     * @param TwigEngine          $templating
     */
    public function __construct(array $parameters, \Swift_Mailer $mailer = null, TranslatorInterface $translator = null, TwigEngine $templating = null)
    {
        $this->parameters = $parameters;

        if ($this->parameters['enable_email_logging'] && ($mailer === null || $translator === null || $templating === null)) {
            throw new \InvalidArgumentException('Email logging is enabled, you must register the mailer, translator and twig services');
        }

        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->templating = $templating;
    }

    /**
     * Persists in database a log entity representing the request just ran.
     *
     * @param ResponseInterface $response
     *
     * @return void
     */
    public function sendRequestExecutedNotificationEmail(ResponseInterface $response)
    {
        if (!$this->parameters['enable_email_logging']) {
            return;
        }

        $code = $response->getCode();
        if (!$this->isStatusCodeConfiguredForNotifications($code)) {
            return;
        }

        $message = new \Swift_Message();
        $message
            ->setFrom($this->parameters['email_logging']['address_from'])
            ->setTo($this->parameters['email_logging']['address_to'])
            ->setSubject($this->translator->trans('chaplean_rest_client.email.request_executed_notification.subject'))
            ->setBody(
                $this->templating->render('ChapleanRestClientBundle:Email:request_executed_notification.txt.twig', ['response' => $response])
            );

        $this->mailer->send($message);
    }

    /**
     * Compares the given $code against the configuration and tells if we need to send
     * a notification.
     *
     * @param integer $code
     *
     * @return boolean
     */
    public function isStatusCodeConfiguredForNotifications($code)
    {
        $code = (string) $code;
        $config = $this->parameters['email_logging']['codes_listened'];

        // Test exact match
        if (in_array($code, $config, true)) {
            return true;
        }

        // Test by familly (eg. 1XX, 2XX, ...)
        $code = $code[0] . 'XX';
        if (in_array($code, $config, true)) {
            return true;
        }

        return false;
    }
}
