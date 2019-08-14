<?php

namespace Drupal\newsletter\Controller;


use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DrupalDateTime;

abstract class AbstractCompanyController extends ControllerBase
{
    private const ACTION_INSERT = 'insert';
    private const ACTION_UPDATE = 'update';
    private const TYPE_MSG_STATUS = "status";
    private const TYPE_MSG_ERROR = "error";

    const TABLE_SUBSCRIBER = "newsletter_subscriber";
    const TABLE_SUBSCRIBTION = "newsletter_subscription";

    protected const USER_API_ACTITO = "poleweb_admin";
    private const PASS_API_ACTITO = "57Hc!a5sQ";
    public const ENTITY_ACTITO = "";
    public const TABLE_ACTITO = "";
//    const URL_API_ACTITO = "http://dcp.cargo-webproject.com/api/web/api_v2/req";
    const URL_API_ACTITO = "http://web.api-actito-cargo.svd2pweb-stm.ressinfo.ad/api/req";

    public $connection;
    protected $passApi;

    public $date;

    public function __construct()
    {
        $this->connection = \Drupal::database();
        $this->passApi = hash("sha512",hash("sha256",self::PASS_API_ACTITO));

        $this->date = new DrupalDateTime();
    }

    abstract protected function getPeople(string $email): ?array;
    abstract protected function insertPeople(array $arrayData): void;
    abstract protected function updatePeople(array $arrayData): void;

    public function doAction(array $arrayData): array
    {
        //Save or update people on database
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

    private function displayMsg(string $return): array
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
        $client = \Drupal::httpClient();
        $allowTest =  \Drupal::config('system.newsletter')->get('allowTest', FALSE);
        $url=self::URL_API_ACTITO.'/profile/import.php?&entity='.static::ENTITY_ACTITO.'&table='.static::TABLE_ACTITO."&allowTest=".$allowTest;
        $options = [
            'auth' => [
                self::USER_API_ACTITO,
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
            }
        }
        catch (\HttpRequestExceptioneption $e) {
            watchdog_exception('newsletter_module', $e);
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
            ),
            'primary key' => array('id'),
            'indexes' => array(
                'email' => array('email'),
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
}