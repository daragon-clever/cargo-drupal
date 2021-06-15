<?php

namespace Drupal\offres_emploi\Helper;


class OffresEmploiUpdate
{
    const TABLE = "offres_emploi";

    /**
     * @var \Drupal\Core\Database\Connection
     */
    private $database;

    /**
     * @var \Drupal\Core\Database\Schema
     */
    private $schema;

    public function __construct()
    {
        $this->database = \Drupal::database();
        $this->schema = $this->database->schema();
    }

    public function update8101()
    {
        if ($this->schema->tableExists(self::TABLE)) {
            //drop column
            $oldColumn = "nbCandidature";
            $this->removeColumn($oldColumn);

            //add column
            $newColumn = "sirh_id";
            $spec = [
                'type' => 'int',
                'size' => 'medium',
            ];
            $this->addColumn($newColumn, $spec);
        }
    }

    public function update8102()
    {
        if ($this->schema->tableExists(self::TABLE)) {
            $columnsToRemove = ['descriptionMission', 'descriptionProfil'];
            foreach ($columnsToRemove as $column) {
                $this->removeColumn($column);
            }
        }
    }

    public function update8103()
    {
        if ($this->schema->tableExists(self::TABLE)) {
            $column = "typeContrat";
            $length = 150;
            $queryTxt = "ALTER TABLE `%s` MODIFY `%s` varchar(%d)";
            $query = sprintf($queryTxt, self::TABLE, $column, $length);
            $this->updateColumn($column, $query);
        }
    }

    private function addColumn($columnName, $columnSpec)
    {
        $schemaNewFieldExist = $this->schema->fieldExists(self::TABLE, $columnName);
        if (!$schemaNewFieldExist) {
            $this->schema->addField(self::TABLE, $columnName, $columnSpec);
            $this->logInfo('Ajout colonne '.$columnName.' OK');
        }
    }

    private function removeColumn($columnName)
    {
        $schemaOldFieldExist = $this->schema->fieldExists(self::TABLE, $columnName);
        if ($schemaOldFieldExist) {
            $this->schema->dropField(self::TABLE, $columnName);
            $this->logInfo('Suppression colonne '.$columnName.' OK');
        }
    }

    private function updateColumn($columnName, $query)
    {
        $fieldExist = $this->schema->fieldExists(self::TABLE, $columnName);
        if ($fieldExist) {
            $this->database->query($query);
            $this->logInfo('Modification colonne '.$columnName.' OK');
        }
    }

    private function logInfo($txt)
    {
        \Drupal::logger(self::TABLE)->notice('[UPDATE] '.$txt);
    }
}