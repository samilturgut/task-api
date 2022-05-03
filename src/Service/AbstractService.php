<?php

namespace App\Service;

use App\Validation\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractService
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $_em;
    
    /**
     * @var Serializer
     */
    protected Serializer $serializer;
    
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;
    
    /**
     * @var Security
     */
    protected Security $security;
    
    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;
    
    public function __construct(
        ManagerRegistry $doctrine,
        LoggerInterface $logger,
        Security $security,
        ValidatorInterface $validator
    ) {
        $this->_em = $doctrine->getManager();
        $this->serializer = new Serializer([
            new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => "Y-m-d H:i:s"]),
            new ObjectNormalizer(),
        ], []);
        $this->logger = $logger;
        $this->security = $security;
        $this->validator = $validator;
    }
}