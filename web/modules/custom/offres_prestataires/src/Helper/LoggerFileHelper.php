<?php
declare(strict_types=1);

namespace Drupal\offres_prestataires\Helper;

class LoggerFileHelper
{
    private const NAME_LOG_FILE = 'logip--annonce-presta.csv';

    private const NUMBER_DAYS_TO_DELETE = 7;

    private $fileLogIPAnnonce;

    private $actualTime;

    private $ipAddress;

    public function __construct()
    {
        $this->actualTime = time();
        $this->ipAddress = md5($_SERVER['REMOTE_ADDR']);

        //Create Log File
        $this->createLogger();

        //Delete the content every week 7 days
        $this->removeContent(self::NUMBER_DAYS_TO_DELETE);
    }

    /**
     * @param $ref
     * @return bool
     */
    public function searchInCSV($ref): bool
    {
        $found_time = null;
        $arrCSVcontent = $this->getCSV();

        if (!is_null($arrCSVcontent)) {
            $new_arr = array_reverse($arrCSVcontent);

            foreach ($new_arr as $val) {
                if ($val[1] == $this->ipAddress && $val[0] == $ref) {
                    $found_time = $val[2];
                    break;
                }
            }

            $fiveMin = $this->actualTime - (60 * 5);
            return (!empty($found_time) && $found_time > $fiveMin);
        }
    }

    /**
     * Log the record of a visitor
     * @param $ref
     */
    public function logIpAddressOnFile($ref)
    {
        file_put_contents($this->fileLogIPAnnonce, $ref . "," . $this->ipAddress . "," . $this->actualTime . "\n", FILE_APPEND | LOCK_EX);
    }

    /**
     * Init and Create the Log File
     */
    private function createLogger()
    {
        $folderFiles = \Drupal::service('file_system')->realpath(file_default_scheme() . "://");
        if (!file_exists($folderFiles . '/log')) {
            mkdir($folderFiles . "/log", 0777, true);
        }
        $this->fileLogIPAnnonce = $folderFiles . "/log/" . self::NAME_LOG_FILE;
        if (!file_exists($this->fileLogIPAnnonce)) {
            file_put_contents($this->fileLogIPAnnonce, "");
        }
    }

    /**
     * @return array
     */
    private function getCSV(): array
    {
        return array_map(function($line) {
            return (!empty($line)) ? str_getcsv($line) : false;
        }, file($this->fileLogIPAnnonce));
    }

    /**
     * Clear log content after self::NUMBER_DAYS_TO_DELETE
     * @param int $days
     */
    private function removeContent(int $days)
    {
        if ($this->actualTime - filemtime($this->fileLogIPAnnonce) >= 60 * 60 * 24 * $days) {
            file_put_contents($this->fileLogIPAnnonce, "");
        }
    }
}