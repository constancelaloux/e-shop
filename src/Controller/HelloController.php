<?php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Taxes\Calculator;

class HelloController extends AbstractController
{
    protected $logger;
    protected $calculator;

    public function __construct(LoggerInterface $logger, Calculator $calculator)
    {
        $this->logger = $logger;
        $this->calculator = $calculator;
    }

    /**
     * @Route("/hello/{prenom}", name="hello", host="127.0.0.1", methods={"GET", "POST"}, schemes={"https", "http"})
     */
    public function hello(Request $request, string $prenom="World"): Response
    {
        $this->logger->error("mon message de log");

        $tva = $this->calculator->calcul(100);

        var_dump($tva);
        return new Response("Je m'appelle $prenom !");
    }
}
?>