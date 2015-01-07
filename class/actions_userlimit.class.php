<?php
class ActionsUserlimit
{ 
     /** Overloading the doActions function : replacing the parent's function with the one below 
      *  @param      parameters  meta datas of the hook (context, etc...) 
      *  @param      object             the object you want to process (an invoice if you are in invoice module, a propale in propale's module, etc...) 
      *  @param      action             current action (if set). Generally create or edit or null 
      *  @return       void 
      */
    function afterLogin($parameters, &$object, &$action, $hookmanager) {
    	global $langs,$user,$conf,$db;
		
		if (in_array('login',explode(':',$parameters['context']))) 
        {
        	
			dol_include_once('/userlimit/lib/userlimit.lib.php');
			
			if(!testNbUser(false) && $conf->global->USERLIMIT_STOP_LOGIN) {
				
				// Destroy session
				$prefix=dol_getprefix();
				$sessionname='DOLSESSID_'.$prefix;
				$sessiontimeout='DOLSESSTIMEOUT_'.$prefix;
				if (! empty($_COOKIE[$sessiontimeout])) ini_set('session.gc_maxlifetime',$_COOKIE[$sessiontimeout]);
				session_name($sessionname);
				session_destroy();
				dol_syslog("End of session ".$sessionname);
				
				// Not sure this is required
				unset($_SESSION['dol_login']);
				unset($_SESSION['dol_entity']);
				
				$url=DOL_URL_ROOT."/index.php";	
				
				print $langs->trans('userlimitBlockLoginMsg');exit;
				
				//header("Location: ".$url);				
			}
			
		}
		
    }
      
	function printTopRightMenu($parameters, &$object, &$action, $hookmanager){
		
		if (in_array('login',explode(':',$parameters['context']))) 
        {
        	
			dol_include_once('/userlimit/lib/userlimit.lib.php');
			
			testNbUser();
			
		}
		
		return 0;
	}
}