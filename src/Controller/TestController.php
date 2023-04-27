<?php
namespace App\Controller;
use App\Taxes\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    protected $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

     /**
     * @Route("/", name="index", host="127.0.0.1", methods={"GET", "POST"}, schemes={"https", "http"})
     */
    public function index()
    {
        $tva = $this->calculator->calcul(100);

        var_dump($tva);
        dd("ca fontionne grave par ici");
    }
    
    /**
     * @Route("/test/{age<\d+>?0}", name="test", host="127.0.0.1", methods={"GET", "POST"}, schemes={"https", "http"})
     */
    public function test(Request $request, int $age):Response
    {
        //$age = $request->query->get('age', 0);
        return new Response("Vous avez $age ans !");
    }
}