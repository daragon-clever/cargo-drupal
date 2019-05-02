<?php
namespace Drupal\newsletter\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\newsletter\Controller\Company;

class NewsletterController extends ControllerBase
{
    protected $company;

    public $connection;
    public $tableSubscriber;
    public $tableSubscription;

    private $userApi;
    private $passApi;

    public function __construct()
    {
        $this->company = \Drupal::config('system.site')->get('name');

        $this->connection = \Drupal::database();
        $this->tableSubscriber = "newsletter_subscriber";
        $this->tableSubscription = "newsletter_subscription";

        $this->userApi = "poleweb_admin";
        $this->passApi = hash("sha512",hash("sha256","57Hc!a5sQ"));
    }

    public function displayForm()
    {
        switch (strtolower($this->company)) {
            case "turbocar":
                $myForm = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\Company\TurbocarForm');
                break;
            case "yliades":
                $myForm = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\Company\YliadesForm');
                break;
            case "blog-sitram":
                $myForm = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\Company\BlogSitramForm');
                break;
        }
        if (isset($myForm)) {
            $build['#form'] = $myForm;
        } else {
            $build['#msg'] = $this->t("Pas de formulaire newsletter pour ce site");//todo: à traduire
        }
        $build['#theme'] = 'inscription';

        return $build;
    }

    public function displayMsg($return)
    {
        if ($return == 'insert') {
            $msg = $this->t("You have just signed up for the newsletter");
            $type = 'status';
        } else if ($return == 'update') {
            $msg = $this->t("You have just updated your newsletter preferences");
            $type = 'status';
        } else if ($return == 'update') {
            $msg = $this->t("You have just unsubscribed for the newsletter");//todo: ajouter la traduction mais pas encore utilisé
            $type = 'status';
        } else {
            $msg = $this->t("Error");
            $type = 'error';
        }

        return array(
            'msg' => $msg,
            'type' => $type
        );
    }

    public function savePeopleInActito($dataUser)
    {
        $userConnect = $this->userApi;
        $passConnect = $this->passApi;
        $entityActito = "GersEquipement";
        $tableActito = "GersEquipement";
        $url='http://dcp.cargo-webproject.com/api/web/api_v2/req/profile/import.php?&entity='.$entityActito.'&table='.$tableActito."&allowTest=true";
        $dataString = json_encode($dataUser);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_USERPWD, "$userConnect:$passConnect");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dataString))
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//to return data resp

        $result = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $obj = json_decode($result);

        return $obj;
    }
}