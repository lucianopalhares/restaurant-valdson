<?php

    function states()
    {        
        $ufs_array = array();
        $ufs_array[] = array('code' => 'AC','name' => 'Acre');
        $ufs_array[] = array('code' => 'AL','name' => 'Alagoas');
        $ufs_array[] = array('code' => 'AP','name' => 'Amapá');
        $ufs_array[] = array('code' => 'AM','name' => 'Amazonas');
        $ufs_array[] = array('code' => 'BA','name' => 'Bahia');
        $ufs_array[] = array('code' => 'CE','name' => 'Ceara');
        $ufs_array[] = array('code' => 'DF','name' => 'Distrito Federal');
        $ufs_array[] = array('code' => 'ES','name' => 'Espirito Santo');
        $ufs_array[] = array('code' => 'GO','name' => 'Goiás');
        $ufs_array[] = array('code' => 'MA','name' => 'Maranhão');
        $ufs_array[] = array('code' => 'MT','name' => 'Mato Grosso');
        $ufs_array[] = array('code' => 'MS','name' => 'Mato Grosso do Sul');
        $ufs_array[] = array('code' => 'MG','name' => 'Minas Gerais');
        $ufs_array[] = array('code' => 'PA','name' => 'Pará');
        $ufs_array[] = array('code' => 'PB','name' => 'Paraíba');
        $ufs_array[] = array('code' => 'PR','name' => 'Paraná');
        $ufs_array[] = array('code' => 'PE','name' => 'Pernambuco');
        $ufs_array[] = array('code' => 'PI','name' => 'Piauí');
        $ufs_array[] = array('code' => 'RJ','name' => 'Rio de Janeiro');
        $ufs_array[] = array('code' => 'RN','name' => 'Rio Grande do Norte');
        $ufs_array[] = array('code' => 'RS','name' => 'Rio Grande do Sul');
        $ufs_array[] = array('code' => 'RO','name' => 'Rondônia');
        $ufs_array[] = array('code' => 'RR','name' => 'Roraima');
        $ufs_array[] = array('code' => 'SC','name' => 'Santa Catarina');
        $ufs_array[] = array('code' => 'SP','name' => 'São Paulo');
        $ufs_array[] = array('code' => 'SE','name' => 'Sergipe');
        $ufs_array[] = array('code' => 'TO','name' => 'Tocantins');
        return collect($ufs_array);
    }

?>