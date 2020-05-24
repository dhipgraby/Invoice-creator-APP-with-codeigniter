<?php

function switch_db_dinamico($licencia)
{
    $config_app['hostname'] = '';
    $config_app['username'] = '';
    $config_app['password'] = '';
    $config_app['database'] = $licencia;
    $config_app['dbdriver'] = 'mysqli';
    $config_app['dbprefix'] = '';
    $config_app['pconnect'] = FALSE;
    $config_app['db_debug'] = FALSE;
    return $config_app;
}

function get_lvl($id)
   {

      switch ($id) {
         case 'SLIV_001':
            $level = 1;
            break;
         case 'SLIV_002':
            $level = 2;
            break;
         case 'SLIV_003':
            $level = 3;
            break;
      }
      return $level;
   }

   function get_plan_id($id)
   {
      switch ($id) {
         case '':
            $id_name = 'SLIV_001';
            break;
         case '':
            $id_name = 'SLIV_002';
            break;
         case '':
            $id_name = 'SLIV_003';
            break;
      }
      return $id_name;
   }
?>