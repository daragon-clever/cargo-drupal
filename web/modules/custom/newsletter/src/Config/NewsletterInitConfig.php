<?php

namespace Drupal\newsletter\Config;

abstract class NewsletterInitConfig
{
    protected const SITENAME_C2E = "c'estdeuxeuros";
    protected const SITENAME_CDF = "comptoirdefamille";
    protected const SITENAME_COTE_TABLE = "côtétable";
    protected const SITENAME_MERCHCIE = "merch&cie";
    protected const SITENAME_SITRAM = "sitram";
    protected const SITENAME_YLIADES = "yliades";
    protected const SITENAME_SEMA_DESIGN = "semadesign";
    protected const SITENAME_GL = "genevièvelethu";

    /**
     * @var string
     */
    public $currentSitename;

    public function __construct()
    {
        $sitename = \Drupal::config('system.site')->getOriginal("name", false);
        $this->currentSitename = strtolower(str_replace(' ', '', $sitename));
    }
}
