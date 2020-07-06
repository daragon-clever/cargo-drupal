<?php
declare(strict_types=1);

namespace Drupal\offres_emploi\Helper;

class LoggerFileHelper
{

    private const NAMELOGFILE = 'logip--annonce.csv';

    private $fileLogIPAnnonce;

    private $actualTime;

    private $ipAddress;


    public function __construct()
    {
        $this->actualTime = time();
        $this->ipAddress = md5($_SERVER['REMOTE_ADDR']);

        $folderFiles = \Drupal::service('file_system')->realpath(file_default_scheme() . "://");
        if (!file_exists($folderFiles.'/log')) {
            mkdir($folderFiles . "/log",0777,true);
        }
        $this->fileLogIPAnnonce = $folderFiles . "/log/" . self::NAMELOGFILE;
        if (!file_exists($this->fileLogIPAnnonce)) {
            file_put_contents($this->fileLogIPAnnonce,"ref,ip,time"."\n");
        }

        //Delete the content every week 7 days
        $this->removeContent(7);
    }

    public function searchInCSV($ref)
    {
        $found_time = null;
        $arrCSVcontent = $this->getCSV();

        if (!is_null($arrCSVcontent)) {
            $new_arr = array_reverse($arrCSVcontent);

            foreach ($new_arr as $key => $val) {
                if ($val['ip'] == $this->ipAddress && $val['ref'] == $ref) {
                    $found_time = $val['time'];
                    break;
                }
            }

            $fiveMin = $this->actualTime - (60*5);
            if (!empty($found_time) && $found_time > $fiveMin) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function logIpAddressOnFile($ref)
    {
        file_put_contents($this->fileLogIPAnnonce, $ref.",".$this->ipAddress.",".$this->actualTime."\n", FILE_APPEND | LOCK_EX);
    }

    private function getCSV()
    {
        $csv = explode("\n", file_get_contents($this->fileLogIPAnnonce));
        foreach ($csv as $key => $line)
        {
            if (!empty($line)) $newcsv[$key] = str_getcsv($line);
        }
        $entete = $newcsv[0];
        unset($newcsv[0]);

        $combine = [];
        foreach ($newcsv as $item) {
            $combine[] = array_combine($entete,$item);
        }

        return $combine;
    }

    private function removeContent(int $days)
    {
        if ($this->actualTime - filemtime($this->fileLogIPAnnonce) >= 60 * 60 * 24 * $days) {
            file_put_contents($this->fileLogIPAnnonce,"ref,ip,time"."\n");
        }
    }
}