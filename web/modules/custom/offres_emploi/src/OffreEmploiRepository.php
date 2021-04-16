<?php
declare(strict_types=1);

namespace Drupal\offres_emploi;

use Drupal\Core\Database\Connection;
use Drupal\Core\Database\Query\SelectInterface;
use Drupal\Core\Database\Query\Update;
use Drupal\Core\Database\StatementInterface;


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
            \Drupal::logger('offres_emploi')->error('Update Number View failed. Message => ' . $e->getMessage());
        }

        return intval($count) ?? 0;
    }

    /**
     * Increment the Number of Candidature
     * @param $ref
     * @return int
     */
    public function updateNbCandidature($ref): int
    {
        try {
            $count = $this->queryUpdate()
                ->expression('nbCandidature', 'nbCandidature + 1')
                ->condition('codeRecrutement', $ref)
                ->execute()
            ;
        } catch(\Exception $e) {
            \Drupal::logger('offres_emploi')->error('Update Number Candidature failed. Message => ' . $e->getMessage());
        }

        return intval($count) ?? 0;
    }

    /**
     * Delete an entry
     * @param array $entry
     */
    public function delete(array $entry): int
    {
        try {
            $count = $this->connection->delete($this->tableName)
                ->condition('codeRecrutement', $entry['codeRecrutement'])
                ->execute();
        } catch(\Exception $e) {
            \Drupal::logger('offres_emploi')->error('Delete failed. Message => ' . $e->getMessage());
        }

        return intval($count) ?? 0;
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
            $query = $this->queryUpdate()
                ->fields(['active'=>0]);
            if (!empty($entry)) {
                $query = $query->condition('codeRecrutement', $entry, 'NOT IN');
            }
            $count = $query->execute();
        } catch(\Exception $e) {
            \Drupal::logger('offres_emploi')->error('Disable Offre failed. Message => ' . $e->getMessage());
        }

        return $count ?? 0;
    }


    /**
     * Find All by
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
     * Find Many Offers by []
     * @param array $entry
     * @return array
     */
    public function findByMany(array $entry = []): array
    {
        $query = $this->querySelect();

        foreach ($entry as $field => $value) {
            $query->condition($field, $value, 'IN');
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

    /**
     * @return StatementInterface|null
     */
    public function queryFindAllRessources(): ?StatementInterface
    {
        return $this->querySelect()
            ->condition('active', 1, '=')
            ->execute()
        ;
    }


    /**
     * @return Update
     */
    private function queryUpdate(): Update
    {
        return $this->connection->update($this->tableName);
    }

    /**
     * @return SelectInterface
     */
    private function querySelect(): SelectInterface
    {
        return $this->connection->select($this->tableName)
            ->fields($this->tableName);
    }
}
