<?php
 
 namespace App\Service;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;

use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Endroid\QrCode\Writer\SvgWriter;
use App\Entity\Patient;


class QrCodeGenerator 
{
 
public function createQrCode( Patient $patient): ResultInterface
{
    // Récupérez les informations du patient
    $id = $patient->getId();
    $nom = $patient->getNom();
    $prenom = $patient->getPrenom();
    $email = $patient->getEmail();
    $numtel = $patient->getNumtel();
    $birth = $patient->getBirth()->format('Y-m-d');   
    $Gender = $patient->getGender();

    $info = "
    $id
    $prenom
    $nom
    $email
    $numtel
    $Gender
    $birth
    ";

    // Générez le code QR avec les informations du patient
    $result = Builder::create()
        ->writer(new SvgWriter())
        ->writerOptions([])
        ->data($info)
        ->encoding(new Encoding('UTF-8'))
        ->size(200)
        ->margin(10)
        ->labelText('Vous trouvez vos informations ici')
        ->labelFont(new NotoSans(20))
        ->validateResult(false)
        ->build();

    return $result;
}}