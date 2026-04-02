<?php include('ssp.class.php');
class ssp_new {
    function limit ( $request )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}

		return $limit;
	}    
}
$sspObj=new ssp_new();
/*function limit ( $request)
{
	$limit = '';

	if ( isset($request['start']) && $request['length'] != -1 ) {
		$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
	}
	return $limit;
}*/

#$LimitQry=limit($_GET);
?>