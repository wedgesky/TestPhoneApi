<?php

namespace App\Controller;

use App\Entity\TestPhone;
use App\Form\TestPhoneType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestRecordsController extends AbstractController
{
    CONST CORRECT_LENGTH = 11;
    CONST MESSAGE_CORRECT = "CORRECT";
    CONST MESSAGE_TO_CORRECT = "TO CORRECT";
    CONST MESSAGE_FAILED = "FAILED";



    /**
     * @Route("/new", name="test_phone_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $testPhone = new TestPhone();


        if($request->query->get('result') != null){
            $testPhone->setResult($request->query->get('result'));
        }


        if($request->query->get('reason') != null){
            $testPhone->setReason($request->query->get('reason'));
        }

        if($request->query->get('sms_phone') != null){
            $testPhone->setSmsPhone($request->query->get('sms_phone'));
        }


        $form = $this->createForm(TestPhoneType::class, $testPhone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testedPhone = $this->getTestPhone( $testPhone->getSmsPhone() );
            $testPhone->setResult($testedPhone->getResult());


            if(strlen($testedPhone->getReason())>0){
                $testPhone->getReason($testedPhone->getReason());

            }

            return $this->redirectToRoute("test_phone_new",["reason"=>$testPhone->getReason(),
                "sms_phone" => $testPhone->getSmsPhone(),
                "result" => $testPhone->getResult()]);

        }

        return $this->render('test_phone/new.html.twig', [
            'test_phone' => $testPhone,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/test/records", name="test_records", methods={"POST"})
     */
    public function testRecords(Request $request): JsonResponse
    {
        $result = null;
        $correctList = [];
        $toCorrectList = [];
        $failedList = [];
        $serviceList = "";
        $numRow = 0;

        try{
            $uploadedFile = $request->files->get('file');
            $entityManager = $this->getDoctrine()->getManager();

            if ( ($fp = fopen($uploadedFile, "r")) !== FALSE) {
                while (($row = fgetcsv($fp)) !== FALSE ){
                    $num = count($row);
                    if($numRow>0){
                        $record = $this->getTestPhone($row[1]);

                        if($record->getResult() == self::MESSAGE_CORRECT){
                            array_push($correctList, $record);
                        }elseif ($record->getResult() == self::MESSAGE_TO_CORRECT){
                            array_push($toCorrectList, $record);
                        }else{
                            array_push($failedList, $record);
                        }
                    }

                    $numRow++;

                }
            }

            $serviceList.= "sms_phone,reason\n";

            if(count($correctList)> 0){
                $serviceList.= "CORRECT_SMS_PHONE,\n";
            }

            foreach ($correctList as $key => $value){
                $serviceList.= $value->getSmsPhone(). ",\n";
                $entityManager->persist($value);
            }
            if(count($toCorrectList)> 0){
                $serviceList.= "TO_CORRECT_SMS_PHONE,\n";
            }

            foreach ($toCorrectList as $key => $value){
                $serviceList.= $value->getSmsPhone(). ",".$value->getReason(). "\n";
                $entityManager->persist($value);
            }

            if(count($failedList)> 0){
                $serviceList.= "FAILED_SMS_PHONE,\n";
            }
            foreach ($failedList as $key => $value){
                $serviceList.= $value->getSmsPhone(). ",\n";
                $entityManager->persist($value);
            }


            $entityManager->flush();

            $result = new JsonResponse($serviceList, JsonResponse::HTTP_OK);


        }catch (\Exception $e){
            $result = new JsonResponse($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } finally {
            return $result;
        }

    }

    /**
     * @param string|null $row
     * @return TestPhone
     */
    public static function getTestPhone(?string $phone): TestPhone
    {
        $record = new TestPhone();
        $record->setSmsPhone($phone);

        if(is_numeric($phone)){
            if(strlen($phone) == self::CORRECT_LENGTH){
                $record->setResult(self::MESSAGE_CORRECT);
            }else{
                $record->setResult( self::MESSAGE_TO_CORRECT);
                if (strlen($phone) > self::CORRECT_LENGTH) {
                    $record->setReason("TOO LONG. ORIGINAL: " . $phone);
                } else {
                    $record->setReason("TOO SHORT. ORIGINAL: " . $phone);
                }
                $record->setSmsPhone(substr($phone, 0, self::CORRECT_LENGTH));

            }
        }else{
            $record->setResult( self::MESSAGE_FAILED);

        }

        return $record;
    }
}
