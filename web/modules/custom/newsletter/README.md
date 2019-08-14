A ajouter dans setting.php du site (Attention : fichier non versionné) :
$config['system.newsletter'] = [
    'allowTest' => 'true' // false si sur env prod 
];

Pour exporter les données de :
* Yliades

SELECT newsletter_subscriber.email, newsletter_subscriber.active, newsletter_subscriber.exported, newsletter_subscriber.created_at, newsletter_subscriber.updated_at, newsletter_subscription.sema_design, newsletter_subscription.comptoir_de_famille, newsletter_subscription.cote_table, newsletter_subscription.genevieve_lethu, newsletter_subscription.jardin_d_ulysse
            FROM newsletter_subscriber
            INNER JOIN newsletter_subscription
               ON newsletter_subscriber.id = newsletter_subscription.id_subscriber