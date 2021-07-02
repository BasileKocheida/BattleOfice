<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/", name="payment_index", methods={"GET"})
     */
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render('payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}/stripe", name="payment_new_stripe", methods={"GET","POST"})
     */
    public function new(Payment $payment, Request $request): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        
        $idApiResponse = $payment->getRefCommande();
        //dd($idApiResponse);
        if ($request->isMethod('POST')) {

            // STRIPE
            \Stripe\Stripe::setApiKey('sk_test_51IueAQGX60abp50EyYKFGohbPeYRnAUxWGUbd9mANHukMlTMxkod0JHbaPfwVk37W4GzktC9oQx0StEazJg1yXPU00SGBfJk4w');
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => ($payment->getAmount()),
                'currency' => 'eur',
            ]);
            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            $payment->setStatus("PAID");

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();

            $this->callApi( $idApiResponse);

            //MAIL



            // dd($status, $content);


            return $this->redirectToRoute('confirmation');
        }

        return $this->render('payment/new.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }

/**
* @Route("/new/{id}/paypal", name="payment_new_paypal", methods={"GET","POST"})
*/
    public function new_paypal(Request $request, Payment $payment): Response
    {

        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $idApiResponse = $payment->getRefCommande();

            $payment->setStatus("PAID");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();
            $this->callApi( $idApiResponse);


            return $this->redirectToRoute('confirmation');
        }

        return $this->render('payment/new_paypal.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),

        ]);
    }

    public function callApi($idApiResponse){
        $token = 'mJxTXVXMfRzLg6ZdhUhM4F6Eutcm1ZiPk4fNmvBMxyNR4ciRsc8v0hOmlzA0vTaX';
        $data = [
            "status"=> "PAID"
        ];

        $data = json_encode($data);
        
        $httpClient = HttpClient::create();
        $response = $httpClient->request('POST', 'https://api-commerce.simplon-roanne.com/order/' . $idApiResponse . '/status',[
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-type' => 'application/json'
            ],
            'body' => $data
        ]);
        
        $status = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0] ;
        $content = $response->getContent();
        $content = $response->toArray() ;
        return $content;
    }







    /**
     * @Route("/{id}", name="payment_show", methods={"GET"})
     */
    public function show(Payment $payment): Response
    {
        return $this->render('payment/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Payment $payment): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payment_index');
        }

        return $this->render('payment/edit.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_delete", methods={"POST"})
     */
    public function delete(Request $request, Payment $payment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($payment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payment_index');
    }
}
