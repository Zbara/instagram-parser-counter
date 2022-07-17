<?php

namespace App\Controller;

use App\Entity\Instagram;
use App\Form\InstagramType;
use App\Parser\Parser;
use App\Repository\InstagramRepository;
use App\Service\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return new Response('OK');
    }

    #[Route('/parse', name: 'app_parse')]
    public function parse(Request $request, FormError $formError, Parser $parser, InstagramRepository $repository): Response
    {
        $instagram = new Instagram();

        $form = $this->createForm(InstagramType::class, $instagram);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            if ($form->isSubmitted() && $form->isValid()) {
                return $this->json($parser->handle($instagram));
            }
            return $this->json(['status' => 0, 'error' => ['messages' => $formError->getErrorMessages($form)]]);
        }
        return $this->render('main/parse.html.twig',[
            'form' => $form->createView(),
            'users' => $repository->getItems()
        ]);
    }
}
