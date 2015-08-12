<?php

class Application_Model_Acl extends Zend_Db_Table_Abstract {

    public function getDefault() {

        $select = new Zend_Db_Select(self::getDefaultAdapter());
        $query = $select->from('roles', array('id_role', 'role'))                
                ->where('role_default = ? ', 1)
                ->query();
        if ($query->rowCount() > 0) {
            return $query->fetchObject();
        } else {
            throw new Exception(" Não há Role padrão definido no banco ");
        }
    }

    public function getResources() {
        $select = new Zend_Db_Select(self::getDefaultAdapter());        
        return  $select->from('acl')
                        ->columns('controller')
                        ->group('controller')
                        ->query()
                        ->fetchAll();
    }

    public function getupPrivileges($id) {
        if(filter_var($id, FILTER_VALIDATE_INT)){
            $select = new Zend_Db_select(self::getDefaultAdapter());
            $select->from('roles', array('id_role', 'role'))
                    ->join('acl_roles', 'roles.id_role = acl_roles.id_role', null)
                    ->join('acl', 'acl_roles.id_acl = acl.id_acl', array('controller', 'action'))
                    ->where('roles.id_role = ?', $id);

            $select_inherit = new Zend_Db_select(self::getDefaultAdapter());
            $select_inherit->from('roles', array('id_role', 'role'))
                    ->join('inherit', 'roles.id_role = inherit.id_role', null)
                    ->join('acl_roles', 'inherit.id_role_rel = acl_roles.id_role', null)
                    ->join('acl', 'acl_roles.id_acl = acl.id_acl', array('controller', 'action'))
                    ->where('roles.id_role = ?', $id);

            $select3 = new Zend_Db_select(self::getDefaultAdapter());
            $rs = $select3->union(array($select, $select_inherit))->query()->fetchAll();

            $userAllowedResources = [];
            foreach ($rs as $r){        
                $userAllowedResources[$r['controller']][] = $r['action'];
            }

            return $userAllowedResources;
        }else{
            die(" o parâmetro '{$id}' não é inteiro ");
            
        }
    }

}
