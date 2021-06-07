<?php

namespace Drupal\offres_emploi\Helper;


class OffresEmploiUpdate
{
    const TABLE = "offres_emploi";

    private $schema;

    public function __construct()
    {
        $this->schema = \Drupal::database()->schema();
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

    private function addColumn($columnName, $columnSpec)
    {
        $schemaNewFieldExist = $this->schema->fieldExists(self::TABLE, $columnName);
        if (!$schemaNewFieldExist) $this->schema->addField(self::TABLE, $columnName, $columnSpec);
        $this->logInfo('Ajout colonne '.$columnName.' OK');
    }

    private function removeColumn($columnName)
    {
        $schemaOldFieldExist = $this->schema->fieldExists(self::TABLE, $columnName);
        if ($schemaOldFieldExist) $this->schema->dropField(self::TABLE, $columnName);
        $this->logInfo('Suppression colonne '.$columnName.' OK');
    }

    private function logInfo($txt)
    {
        \Drupal::logger(self::TABLE)->notice('[UPDATE] '.$txt);
    }
}