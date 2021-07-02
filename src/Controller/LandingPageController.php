<?php

namespace App\Controller;
use App\Entity\Client;
use App\Entity\Payment;
use App\Form\ClientType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class LandingPageController extends AbstractController
{
    /**
     * @Route("/", name="landing_page")
     * @throws \Exception
     */
    public function index(  Request $request, 
                            ProductRepository $productRepository 
                        )
    {
        //Your code her
        
       
        $client = new Client();
        $date = new \DateTime();
        $client-> setCreatedAt($date);
        
        
        $form = $this->createForm(ClientType::class, $client);
        $products = $productRepository->findAll();
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $paymentMethode = $request->get('payment');
            $idProduct = $request->get('product');
         
            $product = $productRepository->findOneBy(['id' => $idProduct]);
            // dd($paymentMethode, $product);
            $deliveryAdress = $client->getDelivery();
            //todo création payment + enregistrer le payment
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
            
            //declaration payment
            $payment = new Payment;
            $payment->setClient($client);
            $payment->setAmount($product->getPricePromo());
            $payment->setDelivery($client->getDelivery());

            //clé API + données json
            $token = 'mJxTXVXMfRzLg6ZdhUhM4F6Eutcm1ZiPk4fNmvBMxyNR4ciRsc8v0hOmlzA0vTaX';
          
        if ($deliveryAdress->getFirstname() === null && $deliveryAdress->getName() === null && $deliveryAdress->getAdress() === null){

            $data =
                [
                        "order"=> [
                            "id"=> "1",
                            "product"=> $product->getName(),
                            "payment_method"=> $paymentMethode,
                            "status"=> "WAITING",
                        "client"=> [
                            "firstname"=> $client->getFirstname(),
                            "lastname"=> $client->getName(),
                            "email"=> $client->getEmail()
                            ],
                        "addresses"=> [
                            "billing"=> [
                            "address_line1"=> $client->getAdress(),
                            "address_line2"=> $client->getComplementAdress(),
                            "city"=> $client->getCity(),
                            "zipcode"=> $client->getCp(),
                            "country"=> $client->getCountry(),
                            "phone"=> $client->getTel()
                            ],
                        "shipping"=> [
                            "address_line1"=> $client->getAdress(),
                            "address_line2"=> $client->getComplementAdress(),
                            "city"=> $client->getCity(),
                            "zipcode"=> $client->getCp(),
                            "country"=> $client->getCountry(),
                            "phone"=> $client->getTel()
                            ]
                        ]   
                    ]
                
            ];



        }else{
 
            $data =
                [
                        "order"=> [
                            "id"=> "1",
                            "product"=> $product->getName(),
                            "payment_method"=> $payment->getModePayment(),
                            "status"=> "WAITING",
                        "client"=> [
                            "firstname"=> $client->getFirstname(),
                            "lastname"=> $client->getName(),
                            "email"=> $client->getEmail()
                            ],
                        "addresses"=> [
                            "billing"=> [
                            "address_line1"=> $client->getAdress(),
                            "address_line2"=> $client->getComplementAdress(),
                            "city"=> $client->getCity(),
                            "zipcode"=> $client->getCp(),
                            "country"=> $client->getCountry(),
                            "phone"=> $client->getTel()
                            ],
                        "shipping"=> [
                            "address_line1"=> $deliveryAdress->getAdress(),
                            "address_line2"=> $deliveryAdress->getComplementAdress(),
                            "city"=> $deliveryAdress->getCity(),
                            "zipcode"=> $deliveryAdress->getCp(),
                            "country"=> $deliveryAdress->getCountry(),
                            "phone"=> $deliveryAdress->getTel()
                            ]
                        ]   
                    ]
                
            ];
 }
            $data = json_encode($data);
            // dd($data);
            //Mise en place API
            $httpClient = HttpClient::create();
            $response = $httpClient-> request('POST', 'https://api-commerce.simplon-roanne.com/order',[
                'headers' => [
                'Authorization' => 'Bearer ' . $token,
                
                ],

                'body' => $data
            ]);

            $status = $response->getStatusCode();
            $contentType = $response->getHeaders()['content-type'][0] ;
            $content = $response->getContent();
            $content = $response->toArray() ;
            //  dd($content);
            $payment->setRefCommande($content['order_id']);
            $payment->setModePayment($paymentMethode);
            // $payment->setStatus();


            $entityManager->persist($payment);
            $entityManager->flush();
// dd($payment);
            //redirection par la method_payment
            if ($paymentMethode === 'stripe'){

                return $this->redirectToRoute('payment_new_stripe', [
                'id' => $payment->getId()
            ]);

            }else{
                return $this->redirectToRoute('payment_new_paypal', [
                    'id' => $payment->getId()
                ]);
            }

            
        }

        return $this->render('landing_page/index_new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
            'products' => $products,

        ]);

    }
    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function confirmation(MailerInterface $mailer)
    {
        $this->sendEmail($mailer);
        return $this->render('landing_page/confirmation.html.twig', [

        ]);
    }
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!');
            // -ee Twig integration for better HTML integration!</p>');

        $mailer->send($email);
    }


}
