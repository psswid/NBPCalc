<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Form\CurrencyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Service\NbpService;

/**
 * Class IndexController
 *
 * @package Controller
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET|POST"})
     * @return RedirectResponse|Response
     *
     */
    public function indexAction(Request $request, NbpService $nbpService)
    {
        $currency = new Currency();

        $form = $this->createForm(CurrencyType::class, $currency);

        $form->handleRequest($request);

        $currencyCalc = $nbpService->getCalculatedCurrencies($currency->getValue());

        return $this->render(
            'currency/calculate.html.twig', [
                'form' => $form->createView(),
                'currency' => $currency,
                'calculated' => $currencyCalc
            ]
        );
    }
}
