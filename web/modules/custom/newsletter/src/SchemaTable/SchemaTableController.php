<?php

namespace Drupal\newsletter\SchemaTable;

use Drupal\newsletter\Config\NewsletterInitConfig;

class SchemaTableController extends NewsletterInitConfig
{
    public function getSchemaTable()
    {
        switch ($this->currentSitename) {
            case self::SITENAME_C2E:
                $schemaTable = new CestDeuxEurosSchemaTable();
                break;
            case self::SITENAME_CDF:
                $schemaTable = new BaseSchemaTable();
                break;
            case self::SITENAME_COTE_TABLE:
                $schemaTable = new CoteTableSchemaTable();
                break;
            case self::SITENAME_MERCHCIE:
                $schemaTable = new MerchCieSchemaTable();
                break;
            case self::SITENAME_SITRAM:
                $schemaTable = new SitramSchemaTable();
                break;
            case self::SITENAME_YLIADES:
                $schemaTable = new YliadesSchemaTable();
                break;
            case self::SITENAME_SEMA_DESIGN:
                $schemaTable = new SemaDesignSchemaTable();
                break;
            case self::SITENAME_GL:
                $schemaTable = new BaseSchemaTable();
                break;
            default:
                $schemaTable = null;
        }
        return $schemaTable;
    }
}
