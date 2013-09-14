<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reaction</title>
<link href="style/profile.css" rel="stylesheet" type="text/css" />
<link href="style/edit.css" rel="stylesheet" type="text/css" />
<!--
<style type="text/css">
	.ui-tooltip-success {
		color:#FFFFFF;
		font-size:14px;
		border:none;
		background:#61911B;
		width: 100px;
		height: 50px;
	}
</style>
<script type="text/javascript" src="js/jquery-1.3.2.min.js" ></script>
<script type="text/javascript" src="js/jquery.qtip.min.js"></script>
-->
<script type="text/javascript">
function showMessageTip(windowName, message)
{
	/*$('#recommendArtist').qtip('destroy');*/
	if(message)
	{
		/*$('#recommendArtist').qtip(
							{
								style: {classes:'ui-tooltip-success'},
								content: 	{text:'Blah'},
								position: 	{my:'top center',at:'bottom center'}
							}
						).qtip('show');*/
						
		alert(message);
	}
}
</script>

<script LANGUAGE="JavaScript">
function confirmSubmit()
{
    var agree=confirm("Are you sure you wish to accept this Artist's Dib? The gig will be booked and all other artists will automatically get rejected for this gig.");
    if (agree)
        return true ;
    else
        return false ;
}

/*$('#dibReaction').bind('submit',function(e) 
{
    e.preventDefault();

    var obj = {
            	linker:   		document.getElementById('linker').value,
                artist_id:   	document.getElementById('artist_id').value,
                acceptDib: 		document.getElementById('accept').value, 
                rejectDib: 		document.getElementById('reject').value  
              };
			
			dibReaction(obj);
}); */

</script>
</head>

<body>
	<span class="dibsList" style="width:96% padding-left:2% padding-right:2%">
		<?
		$dibs_exist = (json_decode($_POST['json'])->dibs_exist);
        $linker = (json_decode($_POST['json'])->linker); 
 		$dibList = (json_decode($_POST['json'])->dibLists);
        foreach($dibList as $row){ ?>
    	<?
    		$artist_name=$row[0];
           	$artist_id=$row[1]; 
			print("<div style='width:50%; margin-top: 10px; height:18px; text-align: center; float:left;'><a href='promoter.php?id=$artist_id' target='_top' class='whiteHoverRef' style='font-size: 16px;'>$artist_name</a></div>"); 
		?>
				<div style="width:45%; float:left; padding-top:10px; padding-right:5px; height:33px;">
					<a href='javascript:;' name="accept" id="accept" style="width: 45%; background:#B4F62F; float:left;"  onClick="showDibReaction('<?print("$linker");?>', '<?print("$artist_id");?>', 1);">ACCEPT</a>
					<a href='javascript:;' name="reject" id="reject" style="width: 45%; background:#FF3C35; float:right;" onClick="showDibReaction('<?print("$linker");?>', '<?print("$artist_id");?>', 0);">REJECT</a>
				</div>           
		<?
		} 

		if($dibs_exist == 1)
		{
		?>
			<div style="width:100%; height: 40px; margin-top: 10px; text-align: center; float:left;">
				<input type="submit" value="Recommend Artist" name="recommendartist" style="width: 200px; color:#fff; background:#000; float:center;" onClick="recommendArtist('<? print("$linker"); ?>')">
			</div>
		<?
		}
		?>

<script type="text/javascript">
	$('#loading-indicator').hide();
</script>

</body>
</html>