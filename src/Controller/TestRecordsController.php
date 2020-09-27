<?php

namespace App\Controller;

use App\Entity\TestPhone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestRecordsController extends AbstractController
{
    CONST CORRECT_LENGTH = 11;
    CONST MESSAGE_CORRECT = "CORRECT";
    CONST MESSAGE_TO_CORRECT = "TO CORRECT";
    CONST MESSAGE_FAILED = "FAILED";

    /**
     * @Route("/test/records", name="test_records", methods={"POST"})
     */
    public function index(Request $request): JsonResponse
    {
        $result = null;
        $correctList = [];
        $toCorrectList = [];
        $failedList = [];
        $serviceList = "";

        try{
            $uploadedFile = $request->files->get('file');
            $entityManager = $this->getDoctrine()->getManager();

            if ( $result == null and ($fp = fopen($uploadedFile, "r")) !== FALSE) {
                while (($row = fgetcsv($fp)) !== FALSE ){
                    $num = count($row);

                    for ($i=0; $i < $num; $i++) {
                        if(is_numeric($row[$i])){
                            if(strlen($row[$i]) == self::CORRECT_LENGTH){
                                array_push($correctList, getTestPhone($row[$i], self::MESSAGE_CORRECT));
                            }else{
                                array_push($toCorrectList, getTestPhone($row[$i], self::MESSAGE_TO_CORRECT));
                            }
                        }else{
                            array_push($failedList, getTestPhone($row[$i], self::MESSAGE_FAILED));
                        }
                    }
                }
            }

            $serviceList.= "sms_phone,reason\n";

            if(count($correctList> 0)){
                $serviceList.= "CORRECT_SMS_PHONE,\n";
            }

            foreach ($correctList as $key => $value){
                $serviceList.= $value->getSmsPhone(). ",\n";
                $entityManager->persist($value);
            }
            if(count($toCorrectList> 0)){
                $serviceList.= "TO_CORRECT_SMS_PHONE,\n";
            }

            foreach ($toCorrectList as $key => $value){
                $serviceList.= $value->getSmsPhone(). ",".$value->getReason(). "\n";
                $entityManager->persist($value);
            }

            if(count($failedList> 0)){
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

    private  function getTestPhone(string $phoneNumber, string $message) : TestPhone{
        $record = new TestPhone();
        $record->setSmsPhone($phoneNumber);
        $record->setResult($message);

        if($message == self::MESSAGE_TO_CORRECT){
            $record->setReason("TOO LONG. ORIGINAL:".$phoneNumber);
            $record->setSmsPhone(substr( $phoneNumber, 0, self::CORRECT_LENGTH));

        }

        return $record;
    }
}
