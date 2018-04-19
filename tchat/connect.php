<?php
	mysql_connect('localhost', 'root', '');
	mysql_select_db('tchat');
	mysql_query("set names 'utf8'");
	
function mepd($date)
{
		if(intval($date) == 0) return $date;
        
        $tampon = time();
        $diff = $tampon - $date;
        
        $dateDay = date('d', $date);
        $tamponDay = date('d', $tampon);
        $diffDay = $tamponDay - $dateDay;
        
        if($diff < 60 && $diffDay == °)
        {
            return 'Il y a '.$diff.'s';
        }
        
        else if($diff < 600 && $diffDay == 0)
        {
            return 'Il y a '.floor($diff/60).'m et '.floor($diff%60).'s';
        }
        
        else if($diff < 3600 && $diffDay == 0)
        {
            return 'Il y a '.floor($diff/60).'m';
        }
        
        else if($diff < 7200 && $diffDay == 0)
        {
            return 'Il y a '.floor($diff/3600).'h et '.floor(($diff%3600)/60).'m';
        }
        
        else if($diff < 24*3600 && $diffDay == 0)
        {
            return 'Aujourd\'hui à '.date('H\hi', $date);
        }
        
        else if($diff < 48*3600 && $diffDay == 1)
        {
            return 'Hier à '.date('H\hi', $date);
        }
        
        else
        {
            return 'Le '.date('d/m/Y', $date).' à '.date('h\hi', $date).'';
        }
}
?>