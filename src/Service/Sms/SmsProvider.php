<?php

namespace App\Service\Sms;

use Ovh\Exceptions\InvalidParameterException;
use Psr\Log\LoggerInterface;
use Ovh\Api;

class SmsProvider
{


    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {

//        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * @param $phoneNumber
     * @param string $message
     */
    public function sendMessage($phoneNumber, $message)
    {

        //On récupère les variables d'environnements pour l'api d'ovh
        $applicationKey = getenv('APP_KEY');
        $applicationSecret = getenv('APPSMS_SECRET');
        $consumer_key = getenv('CONSUMER_KEY');
        $endpoint = getenv('END_POINT');

        //On crée un tableau de numéros car c'est ce qui est attendu dans l'api
        $phoneNumbers = (array)$phoneNumber;

        try {
            //On instancie l'api
            $ovh = new Api(
                $applicationKey,
                $applicationSecret,
                $endpoint,
                $consumer_key
            );

            //On récupère le nom du service (le premier)
            $smsServices = $ovh->get('/sms/');
            foreach ($smsServices as $smsService) {
                print_r($smsService);
            }

            //On crée le contenu
            $content = (object)array(
                "charset" => "UTF-8",
                "class" => "phoneDisplay",
                "coding" => "7bit",
                'message' => $message,
                "noStopClause" => false,
                "priority" => "high",
                'receivers' => $phoneNumbers,
                "senderForResponse" => true,
                "validityPeriod" => 2880
            );

            //Ici on log le message envoyé ainsi que le numéro pour le suivi
            $this->logger->debug('We have sent the message: '. $message . ' to '. $phoneNumber);

//            $this->logger->get('monolog.logger.ovh');
//            $logger->info("This one goes to test channel!!")

            //Pour les tests j'ai désactivé l'envoi de sms
            //A la place on dump
//            dd($content);

            //Finalement on sollicite l'api en post pour rendre effective l'envoi de message
            //$resultPostJob = $ovh->post('/sms/' . $smsServices[0] . '/jobs/', $content); //appel sur le 1er compte SMS

            //Ici on a la possibilité d'afficher en commande l'échec ou le succès de la commande
            //print_r($resultPostJob);
            //$smsJobs = $ovh->get('/sms/' . $smsServices[0] . '/jobs/');
            //print_r($smsJobs);
        } catch (\Exception $e) {
            echo "erreur";
            if (null !== $this->logger) {
                $this->logger->critical(
                    sprintf("Erreur lors de l'envoi SMS : %s . Trace : %s", $e->getMessage(), $e->getTraceAsString()),
                    [
                        'paramsOvh' => $content
                    ]
                );
            }

            $result = false;
        }

//        return $result;
    }

    /**
     * @param $phoneNumber
     * @return array|bool
     * @throws InvalidParameterException
     * @throws \Exception
     */
    public function removeFromBlacklist($phoneNumber)
    {
        $conn = $this->connectToApi();

        try {
            $smsServices = $conn->get('/sms/');
            $result = $conn->delete(sprintf('/sms/%s/blacklists/%s', $smsServices[0], $phoneNumber));
        } catch (\Exception $e) {
            if (null !== $this->logger) {
                $this->logger->critical(
                    sprintf('Erreur lors de la suppression du numéro de la blacklist : %s . Trace : %s', $e->getMessage(), $e->getTraceAsString())
                );
            }

            $result = false;
        }

        return $result;
    }

    /**
     * @return array|bool
     * @throws InvalidParameterException
     * @throws \Exception
     */
    public function getBlacklist()
    {
        $conn = $this->connectToApi();

        try {
            $smsServices = $conn->get('/sms/');
            $result = $conn->get(sprintf('/sms/%s/blacklists', $smsServices[0]));
        } catch (\Exception $e) {
            if (null !== $this->logger) {
                $this->logger->critical(
                    sprintf('Erreur lors de la requête GET blacklist : %s . Trace : %s', $e->getMessage(), $e->getTraceAsString())
                );
            }

            $result = false;
        }

        return $result;
    }

    /**
     * @return Api
     * @throws InvalidParameterException
     * @throws \Exception
     */
    private function connectToApi()
    {
        $config['application_key'] = getenv('APP_KEY');
        $config['application_secret'] = getenv('APPSMS_SECRET');
        $config['consumer_key'] = getenv('CONSUMER_KEY');
        $config['end_point'] = getenv('END_POINT');

//        dd($config);

        if (!isset($config['application_key'],
            $config['application_secret'],
            $config['consumer_key'],
            $config['end_point'])
        ) {
            $this->logger->error('OVH config parameters are missing');
            throw new \Exception('OVH config parameters are missing');
        }

        $applicationKey = $config['application_key'];
        $applicationSecret = $config['application_secret'];
        $consumerKey = $config['consumer_key'];
        $endPoint = $config['end_point'];

        try {
            $conn = new Api(
                $applicationKey,
                $applicationSecret,
                $endPoint,
                $consumerKey
            );
        } catch (InvalidParameterException $e) {
            $this->logger->critical(
                sprintf("Erreur lors de la connexion à l'API OVH : %s . Trace : %s", $e->getMessage(), $e->getTraceAsString())
            );

            throw $e;
        }

        return $conn;
    }


    public function getHappyMessage()
    {
        $this->logger->info('About to find a happy message!');

        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }
}
