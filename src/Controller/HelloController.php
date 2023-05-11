<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class HelloController extends AbstractController
{
    protected $twig;
    public function __construct(Environment $twig){
        $this->twig = $twig;
    }

    /**
     * @Route("/hello/{prenom}", name="hello", host="127.0.0.1", methods={"GET", "POST"}, schemes={"https", "http"})
     */
    public function hello(string $prenom="World"): Response
    {
        return new Response($this->renders('hello.html.twig',['prenom' => $prenom]));
        /*$html = $this->twig->render('hello.html.twig', [
            'prenom' => $prenom, 
            'age' => 33, 
            'prenoms' => [
                'Lior', 
                'Magali', 
                'Elise'
            ],
            'ages' => [
                '12', 
                '18' ,
                '15', 
                '29'
            ],
            'formateur' => [
                'prenom' => 'Elon', 
                'nom' => 'Musk', 
                'age' => '33'
                ],
            'formateur1' => [
                'prenom' => 'Lior', 
                'nom' => 'Chamla'
                ],
            'formateur2' => [
                'prenom' => 'Jérome', 
                'nom' => 'Dupont'
                ]
        ]);
        return new Response($html);*/
    }

    /**
     * @Route("/example", name="example")
     */
    public function example(): Response
    {
        return new Response($this->renders('example.html.twig', ['age' => 33]));
    }

    protected function renders(string $path, array $variables)
    {
        $html = $this->twig->render($path, $variables);

        return new Response($html); 
    }
}
?>