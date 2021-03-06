<?php

namespace Drupal\newsletter\Update;

use Drupal\newsletter\Config\NewsletterInitConfig;

class UpdateController extends NewsletterInitConfig
{
    public function getUpdate()
    {
        switch ($this->currentSitename) {
            case self::SITENAME_C2E:
                $schemaTable = new CestDeuxEurosUpdate();
                break;
            case self::SITENAME_CDF:
                $schemaTable = new BaseUpdate();
                break;
            case self::SITENAME_COTE_TABLE:
                $schemaTable = new CoteTableUpdate();
                break;
            case self::SITENAME_MERCHCIE:
                $schemaTable = new BaseUpdate();
                break;
            case self::SITENAME_SITRAM:
                $schemaTable = new BaseUpdate();
                break;
            case self::SITENAME_YLIADES:
                $schemaTable = new YliadesUpdate();
                break;
            case self::SITENAME_SEMA_DESIGN:
                $schemaTable = new SemaDesignUpdate();
                break;
            case self::SITENAME_GL:
                $schemaTable = new BaseUpdate();
                break;
            default:
                $schemaTable = null;
        }
        return $schemaTable;
    }
}
