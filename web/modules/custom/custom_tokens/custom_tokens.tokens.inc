<?php
/**
* Implements hook_token_info().
*/
function custom_tokens_token_info()
{
    $info = [];
    $info['types']['custom_tokens_group'] = ['name' => t('Custom Tokens Group'), 'description' => t('Custom Tokens Group')];
    $info['tokens']['custom_tokens_group']['img_shared'][] = "A token to extract url and define a picture";
    return $info;
}

function  custom_tokens_tokens($type, $tokens, array $data, array $options, \Drupal\Core\Render\BubbleableMetadata $bubbleable_metadata) {
    $replacements = [];

    $site_name = getSiteName();
    $picture = getPictureName($site_name);

    /* Set value img in token */
    if ($type == 'custom_tokens_group') {
        foreach ($tokens as $name => $original) {
            switch ($name) {
                case 'img_shared':
                $replacements[$original] = $picture;
                break;
            }
        }
    }

    return $replacements;
}

function getSiteName() {
    $site_path = \Drupal::service('site.path');
    $site_path = explode('/', $site_path);
    $site_name = $site_path[1];

    return $site_name;
}

function getPictureName($site) {
    if (strtolower($site) == "yliades") {
        switch(strtolower(substr($_SERVER['REQUEST_URI'],1))) {
            case 'sema-design':
                $picture = "semadesign.png";
                break;
            case 'comptoir-de-famille':
                $picture = "comptoirdefamille.png";
                break;
            case 'cote-table':
                $picture = "cotetable.png";
                break;
            case 'genevieve-lethu':
                $picture = "genevievelethu.png";
                break;
            case 'jardin-ulysse':
                $picture = "jardinulysse.png";
                break;
            default:
                $picture = "yliades.png";
        }
    } else {
        $picture = "";
    }

    return $picture;
}