<?php
declare(strict_types=1);

namespace Drupal\offres_emploi;

use Drupal\Core\Database\Connection;


class OffreEmploiRepository
{

    private $tableName = 'offres_emploi';

    /**
     * @var Connection
     */
    private $connection;


    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    /**
     * Save an Offer in DB
     * @param array $entry
     * @return int|null
     */
    public function insert(array $entry): ?int
    {
        try {
            $return_value = $this->connection->insert($this->tableName)
                ->fields($entry)
                ->execute();
        } catch(\Exception $e) {
            \Drupal::logger('offres_emploi')->error('Insert failed. Message => ' . $e->getMessage());
        }


        return intval($return_value) ?? null;
    }

    /**
     * Update an Offer and return the number of row updated
     * @param array $entry
     * @return int
     */
    public function update(array $entry): int
    {
        try {
            $count = $this->queryUpdate()
                        ->fields($entry)
                        ->condition('codeRecrutement', $entry['codeRecrutement'])
                        ->execute()
            ;
        } catch(\Exception $e) {
            \Drupal::logger('offres_emploi')->error('Update failed. Message => ' . $e->getMessage());
        }


        return intval($count) ?? 0;
    }

    /**
     * Increment the Number View
     * @param $ref
     * @return int
     */
    public function updateNbVue($ref): int
    {
        try {
            $count = $this->queryUpdate()
                ->expression('nbVue', 'nbVue + 1')
                ->condition('codeRecrutement', $ref)
                ->execute()
            ;
        } catch(\Exception $e) {
            \Drupal::logger('offres_emploi')->error('Update Nombre View failed. Message => ' . $e->getMessage());
        }

        return intval($count) ?? 0;
    }

    /**
     * Delete an entry
     * @param array $entry
     */
    public function delete(array $entry)
    {
        try {
            $this->connection->delete($this->tableName)
                ->condition('pid', $entry['pid'])
                ->execute();
        } catch(\Exception $e) {
            \Drupal::logger('offres_emploi')->error('Delete failed. Message => ' . $e->getMessage());
        }
    }


    /**
     * Disable Offer that are not more active
     * Return the number of row Updated
     * @param array $entry
     * @return int
     */
    public function disable(array $entry): int
    {
        try {
            $count = $this->queryUpdate()
                        ->fields(['active'=>0])
                        ->condition('codeRecrutement', $entry, 'NOT IN')
                        ->execute()
            ;
        } catch(\Exception $e) {
            \Drupal::logger('offres_emploi')->error('Disable Offre failed. Message => ' . $e->getMessage());
        }

        return $count ?? 0;
    }


    /**
     * @param array $entry
     * @return array
     */
    public function findBy(array $entry = []): array
    {
        $query = $this->querySelect();

        foreach ($entry as $field => $value) {
            $query->condition($field, $value);
        }

        return $query->execute()->fetchAll();
    }

    /**
     * Return All Active Offers
     * @return array
     */
    public function findAllActive(): array
    {
        return $this->querySelect()
            ->condition('active', 1, '=')
            ->execute()
            ->fetchAll()
        ;
    }


    private function queryUpdate()
    {
        return $this->connection->update($this->tableName);
    }

    private function querySelect()
    {
        return $this->connection->select($this->tableName)
            ->fields($this->tableName);
    }
}
