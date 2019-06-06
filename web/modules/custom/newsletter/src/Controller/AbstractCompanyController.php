<?php

namespace Drupal\newsletter\Controller;


use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;

abstract class AbstractCompanyController extends ControllerBase
{
    const ACTION_INSERT = 'insert';
    const ACTION_UPDATE = 'update';

    const TYPE_MSG_STATUS = "status";
    const TYPE_MSG_ERROR = "error";

    protected $company;

    public $connection;
    public $tableSubscriber;
    public $tableSubscription;

    private $userApi;
    private $passApi;
    private $entityActito;
    private $tableActito;
    private $urlActito;

    public function __construct()
    {
        $this->company = \Drupal::config('system.site')->getOriginal("name", false);

        $this->connection = \Drupal::database();
        $this->tableSubscriber = "newsletter_subscriber";
        $this->tableSubscription = "newsletter_subscription";

        $this->userApi = "poleweb_admin";
        $this->passApi = hash("sha512",hash("sha256","57Hc!a5sQ"));
        $this->urlActito = "http://dcp.cargo-webproject.com/api/web/api_v2/req";

        $cleanCompany = strtolower(str_replace(' ', '', $this->company));
        switch ($cleanCompany) {
            case "blog.sitram.fr":
                $this->entityActito = "GersEquipement";
                $this->tableActito = "GersEquipement";
                break;
            default:
                $this->entityActito = "";
                $this->tableActito = "";
        }
    }

    public function doAction(array $arrayData): array
    {
        $people = $this->getPeople($arrayData['email']);

        if (empty($people)) {
            $this->insertPeople($arrayData);
            $action = self::ACTION_INSERT;
        } else {
            $this->updatePeople($arrayData);
            $action = self::ACTION_UPDATE;
        }

        return $this->displayMsg($action);
    }

    public function displayMsg(string $return): array
    {
        if ($return == self::ACTION_INSERT) {
            $msg = $this->t("You have just signed up for the newsletter");
            $type = self::TYPE_MSG_STATUS;
        } else if ($return == self::ACTION_UPDATE) {
            $msg = $this->t("You have just updated your newsletter preferences");
            $type = self::TYPE_MSG_STATUS;
        } else {
            $msg = $this->t("Error");
            $type = self::TYPE_MSG_ERROR;
        }

        return array(
            'msg' => $msg,
            'type' => $type
        );
    }

    public function savePeopleInActito(array $dataUser): void
    {
        $allowTest = $qrcodeadm =  \Drupal::config('system.newsletter')->get('allowTest', FALSE);
        $client = \Drupal::httpClient();
        $url=$this->urlActito.'/profile/import.php?&entity='.$this->entityActito.'&table='.$this->tableActito."&allowTest=".$allowTest;
        $options = [
            'auth' => [
                $this->userApi,
                $this->passApi,
            ],
            'json' => [
                $dataUser
            ],
            'headers' => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($dataUser))
            ]
        ];

        try {
            $response = $client->post($url, $options);
            $code = $response->getStatusCode();
            if ($code == 200) {
                $jsonResponseBody = $response->getBody()->getContents();
                $return = Json::decode($jsonResponseBody);
                if ($return['successResp'] == "true" || $return['successResp'] === true) {
                    $dataUser['exported'] = 1;
                    $this->updatePeople($dataUser);
                }
                return;
            }
        }
        catch (RequestException $e) {
            watchdog_exception('newsletter_module', $e);
            return;
        }
    }

    public function setSchemaTableSubscriber(): array
    {
        $array = array(
            'description' => 'Stores email for newsletter.',
            'fields' => array(
                'id' => array(
                    'type' => 'serial',
                    'not null' => TRUE,
                    'description' => 'Primary Key: Unique email ID.',
                ),
                'created_at' => array(
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => TRUE,
                ),
                'updated_at' => array(
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => TRUE,
                ),
                'email' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'not null' => TRUE,
                    'default' => '',
                    'description' => 'Email of the person.',
                ),
                'active' => array(
                    'type' => 'int',
                    'length' => 11,
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => 'Active subscription of the person.',
                ),
                'exported' => array(
                    'type' => 'int',
                    'size' => 'tiny',
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => '',
                ),
            ),
            'primary key' => array('id'),
            'indexes' => array(
                'email' => array('email'),
                'exported' => array('exported'),
            ),
        );

        return $array;
    }

    public function setSchemaTableSubscription(): array
    {
        $array = array(
            'description' => 'Stores subscription for newsletter subscriber.',
            'fields' => array(
                'id' => array(
                    'type' => 'serial',
                    'not null' => TRUE,
                    'description' => 'Primary Key: Unique email ID.',
                ),
                'id_subscriber' => array(
                    'type' => 'int',
                    'length' => 11,
                    'not null' => TRUE,
                    'description' => 'Subscriber ID.',
                )
            ),
            'primary key' => array('id')
        );

        return $array;
    }

    abstract public function getPeople(string $email): ?array;
    abstract protected function insertPeople(array $arrayData): void;
    abstract protected function updatePeople(array $arrayData): void;
}