<?php
/*
 * Copyright 2011 Daniel Sloof
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
*/

class Danslo_ApiImport_Model_Import_Api extends Mage_Api_Model_Resource_Abstract {
    
    protected $_api;
    
    public function __construct() {
        $this->_api = Mage::getSingleton('api_import/import');
    }

    public function importEntities($entities, $entityType = null, $behavior = null) {
        $this->_setEntityTypeCode($entityType ? $entityType : Mage_Catalog_Model_Product::ENTITY);
        $this->_setBehavior($behavior ? $behavior : Mage_ImportExport_Model_Import::BEHAVIOR_REPLACE);
        
        $this->_api->getDataSourceModel()->setEntities($entities);
        try {
            $result = $this->_api->importSource();
        } catch(Mage_Core_Exception $e) {
            $this->_fault('import_failed', $e->getMessage());
        }

        return array($result);
    }
    
    protected function _setEntityTypeCode($entityType) {
        try {
            $this->_api->getDataSourceModel()->setEntityTypeCode($entityType);
        } catch(Mage_Core_Exception $e) {
            $this->_fault('invalid_entity_type', $e->getMessage());
        }
    }
    
    protected function _setBehavior($behavior) {
        try {
            $this->_api->getDataSourceModel()->setBehavior($behavior);
        } catch(Mage_Core_Exception $e) {
            $this->_fault('invalid_behavior', $e->getMessage());
        }
    }
    
}