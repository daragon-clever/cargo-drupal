<?php
namespace Drupal\newsletter\Controller;


use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Model\Subscriber;

abstract class AbstractCompanyController extends ControllerBase
{
    private const ACTION_INSERT = 'insert';
    private const ACTION_UPDATE = 'update';
    public const TYPE_MSG_STATUS = "status";
    public const TYPE_MSG_ERROR = "error";

    protected const USER_API_ACTITO = "poleweb_admin";
    private const PASS_API_ACTITO = "57Hc!a5sQ";
    public const ENTITY_ACTITO = "";
    public const TABLE_ACTITO = "";
    const URL_API_ACTITO = "http://dcp.cargo-webproject.com/actito/api/req";

    /**
     * @var Subscriber
     */
    protected $subscriberModel;

    /**
     * @var DrupalDateTime
     */
    public $date;

    /**
     * @var string
     */
    protected $passApi;

    /**
     * @var string
     */
    private $allowTestApi;

    public function __construct()
    {
        $this->subscriberModel = new Subscriber();
        $this->date = new DrupalDateTime();
        $this->setPassApi();
        $this->setAllowTestApi();
    }

    public function doAction(array $arrayData): array
    {
        $email = $arrayData['email'];
        //Save or update people on database
        $people = $this->subscriberModel->getSubscriber($email);

        if (empty($people)) {
            $this->insertPeople($arrayData);
            $action = self::ACTION_INSERT;
        } else {
            $this->updatePeople($arrayData);
            $action = self::ACTION_UPDATE;
        }

        //actito
        $dataForActito = $this->setDataToSaveOnActito($arrayData);
        $saveActito = $this->savePeopleInActito($dataForActito);

        if ($saveActito) {
            $this->subscriberModel->updateSubscriber($email, ['exported' => 1]);
        }

        return $this->displayMsg($action);
    }

    protected function insertPeople(array $arrayData): void
    {
        $dataToInsert = $this->setDataToInsertPeopleOnDb($arrayData);
        $this->subscriberModel->insertSubscriber($dataToInsert);
    }

    protected function updatePeople(array $arrayData): void
    {
        $dataToUpdate = $this->setDataToUpdatePeopleOnDb($arrayData);
        $this->subscriberModel->updateSubscriber($arrayData['email'], $dataToUpdate);
    }

    protected function setDataToInsertPeopleOnDb($arrayData): array
    {
        return [
            "email" => $arrayData['email'],
            "created_at" => $this->date->format("Y-m-d H:i:s"),
            "updated_at" => $this->date->format("Y-m-d H:i:s"),
            "active" => 1,
            "exported" => 0,
        ];
    }

    protected function setDataToUpdatePeopleOnDb($arrayData): array
    {
        $fields["updated_at"] = $this->date->format("Y-m-d H:i:s");
        if (isset($arrayData['active'])) $fields['active'] = $arrayData['active'];
        if (isset($arrayData['exported'])) $fields['exported'] = $arrayData['exported'];

        return $fields;
    }

    public function setDataToSaveOnActito(array $arrayData): array
    {
        $dataForActito = [
            'email' => $arrayData['email'],
        ];
        return $dataForActito;
    }

    /**
     * Call api to save people on actito
     *
     * @param array $dataUser
     * @return bool
     */
    public function savePeopleInActito(array $dataUser): bool
    {
        $client = \Drupal::httpClient();
        $urlReq = '/profile/import.php';
        $configApi = $this->configApi($urlReq, $dataUser);

        try {
            $response = $client->post($configApi['url'], $configApi['options']);

            if ($response->getStatusCode() == 200) {
                $jsonResponseBody = Json::decode($response->getBody()->getContents());
                if ($jsonResponseBody['successResp'] == "true" || $jsonResponseBody['successResp'] === true) {
                    return TRUE;
                }
            }
        } catch (\HttpRequestExceptioneption $e) {
            watchdog_exception('newsletter_module', $e);
        }

        return FALSE;
    }

    /**
     * Call api to delete segmentation people on actito
     *
     * @param array $dataUser
     */
    public function deleteSegmentInActito(array $dataUser): void
    {
        $client = \Drupal::httpClient();
        $urlReq = '/profile/segmentation/delete.php';
        $configApi = $this->configApi($urlReq, $dataUser);

        try {
            $client->post($configApi['url'], $configApi['options']);
        } catch (\HttpRequestExceptioneption $e) {
            watchdog_exception('newsletter_module', $e);
        }
    }

    private function displayMsg(string $return): array
    {
        switch ($return) {
            case self::ACTION_INSERT:
                $msg = $this->t("You have just signed up for the newsletter");
                $type = self::TYPE_MSG_STATUS;
                break;
            case self::ACTION_UPDATE:
                $msg = $this->t("You have just updated your newsletter preferences");
                $type = self::TYPE_MSG_STATUS;
                break;
            default:
                $msg = $this->t("Error");
                $type = self::TYPE_MSG_ERROR;
        }

        return [
            'msg' => $msg,
            'type' => $type
        ];
    }

    public function setSchemaTableSubscriber(): array
    {
        $array = [
            'description' => 'Stores email for newsletter.',
            'fields' => [
                'id' => [
                    'type' => 'serial',
                    'not null' => TRUE,
                    'description' => 'Primary Key: Unique email ID.',
                ],
                'created_at' => [
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => TRUE,
                ],
                'updated_at' => [
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => TRUE,
                ],
                'active' => [
                    'type' => 'int',
                    'length' => 11,
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => 'Active subscription of the person.',
                ],
                'exported' => [
                    'type' => 'int',
                    'size' => 'tiny',
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => '',
                ],
                'email' => [
                    'type' => 'varchar',
                    'length' => 255,
                    'not null' => TRUE,
                    'default' => '',
                    'description' => 'Email of the person.',
                ],
            ],
            'primary key' => ['id'],
            'indexes' => [
                'email' => ['email'],
            ],
        ];

        return $array;
    }

    private function configApi($urlReq, $data)
    {
        $return['url'] = sprintf(
            '%s%s?&entity=%s&table=%s&allowTest=%s',
            self::URL_API_ACTITO,
            $urlReq,
            static::ENTITY_ACTITO,
            static::TABLE_ACTITO,
            $this->allowTestApi
        );

        $return['options'] = [
            'auth' => [
                self::USER_API_ACTITO,
                $this->passApi,
            ],
            'body' => Json::encode($data),
            'headers' => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(Json::encode($data))
            ]
        ];

        return $return;
    }

    private function setPassApi()
    {
        $this->passApi = hash("sha512",hash("sha256",self::PASS_API_ACTITO));
    }

    private function setAllowTestApi()
    {
        $this->allowTestApi = \Drupal::config('system.newsletter')->get('allowTest', FALSE); //get config on setting.php
    }
}