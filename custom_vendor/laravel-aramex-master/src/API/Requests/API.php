<?php

namespace ExtremeSa\Aramex\API\Requests;

use ExtremeSa\Aramex\API\Classes\ClientInfo;
use ExtremeSa\Aramex\API\Classes\Transaction;
use ExtremeSa\Aramex\API\Interfaces\Normalize;

abstract class API implements Normalize
{
    /**
     * @var \SoapClient $soapClient
     * @var ClientInfo $clientInfo
     * @var Transaction $transaction
     */
    protected $soapClient;
    protected $clientInfo;
    protected $transaction;
    protected $v2_test_wsdl;
    protected $v2_live_wsdl;
    protected $v1_test_wsdl;
    protected $v1_live_wsdl;
    protected $environment;

    public function __construct()
    {
        config('aramex.ENV') === 'TEST' ? $this->useTestAsEnvironment() : $this->useLiveAsEnvironment();

        $this->fillClientInfoFromEnv();

        $this->soapClient = new \SoapClient($this->getWsdlAccordingToEnvironment(), array('trace' => 1));
    }

    public function setClientInfo(ClientInfo $clientInfo)
    {
        $this->clientInfo = $clientInfo;
        return $this;
    }

    /**
     * @return ClientInfo
     */
    public function getClientInfo()
    {
        return $this->clientInfo;
    }

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param $transaction
     * @return $this
     */
    public function setTransaction(Transaction $transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @param $environment
     * @return $this
     */
    protected function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    public function useTestAsEnvironment()
    {
        return $this->setEnvironment('TEST');
    }

    public function useLiveAsEnvironment()
    {
        return $this->setEnvironment('LIVE');
    }

    /**
     * @return bool
     */
    public function isTest()
    {
        return $this->environment === "TEST";
    }

    /**
     * @return bool
     */
    public function isLive()
    {
        return $this->environment === "LIVE";
    }

    /**
     * @return string
     */
    protected function getWsdlAccordingToEnvironment()
    {
        if ($this->isLive()) {
            return base_path($this->v1_live_wsdl);
        } else {
            return base_path($this->v1_test_wsdl);
        }
    }

    /**
     * @throws \Exception
     */
    protected function validate()
    {
        if (!$this->clientInfo) {
            throw new \Exception('Client Info Not Provided');
        }
    }

    /**
     * @return $this
     */
    private function fillClientInfoFromEnv()
    {
        $this->clientInfo = (new ClientInfo())
            ->useVersion1()
            ->setAccountCountryCode(config("aramex.$this->environment.AccountCountryCode"))
            ->setAccountEntity(config("aramex.$this->environment.AccountEntity"))
            ->setAccountNumber(config("aramex.$this->environment.AccountNumber"))
            ->setAccountPin(config("aramex.$this->environment.AccountPin"))
            ->setUserName(config("aramex.$this->environment.UserName"))
            ->setPassword(config("aramex.$this->environment.Password"))
            ->setSource(config("aramex.$this->environment.Source"));
        return $this;
    }

    public function getAccountNumber()
    {
        return config("aramex.$this->environment.AccountNumber");
    }

    public function normalize(): array
    {
        return [
            'ClientInfo' => $this->getClientInfo()->normalize(),
            'Transaction' => optional($this->getTransaction())->normalize()
        ];
    }
}
