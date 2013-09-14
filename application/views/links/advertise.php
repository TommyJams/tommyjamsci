<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>TommyJams - Advertise</title>

    <link href="/style/style.css" rel="stylesheet" type="text/css" />

    <link href="/style/edit.css" rel="stylesheet" type="text/css" />

    <link href="/style/supersized/supersized.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="/script/jquery.min.js" ></script>

    <script type="text/javascript" src="/script/jquery.supersized.min.js"></script>

    <script type="text/javascript" src="/script/main.js"></script> <!--contains document ready function-->

    <script type="text/javascript">

    function advertiseCallback(a) 
    {
        $("#loading-indicator").show();      
        if(a == 1)
        {
            alert('Sorry! There was some error while processing your request. Please try again.');
            window.location.assign("http://testcodeigniter.azurewebsites.net/advertise") 
        }
        else
        {
           alert('Your request has been received. We will contact you shortly.');
          window.location.assign("http://testcodeigniter.azurewebsites.net/advertise")   
        }
    }
    
    function advertise() 
    {
        $("#loading-indicator").show();      
        $.post('links/contactFunc',$('#advertise-form').serialize(),advertiseCallback,'json');
    }

    </script>

</head>

<body>
 
	<?
	include("include/leftCommon.php");
	?>

	<div id="main-container">
        <div id="inner-container">
            <div class="head">
                <h1>Advertise</h1>
            </div>
            <div id="textContainer">                
                <p>
                    TommyJams is a fast growing community of Artists, Venues and Fans.
                    <br>
                    <br>
                    There are a lot of target advertising opportunities available on the website:
                    <br>
                    1. Full Screen Banners
                    <br>
                    2. Sidebar Advertisements
                    <br>
                    3. Targeting based on user type, location, and music genre
                    <br>
                    <br>
                    For advertising with us, please drop a message using the form below and we shall get in touch with you.
                </p>
                <form action="" method="post" id="advertise-form" name="advertise-form" style="width:50%; margin-top:20px; left:50%; margin-left:25%;">
                    <table style="border:0px; width:100%;">
                        <tr style="width:100%;">
                            <td style="width:100%;">
                                <!--Your name-->
                                <input type="text" value="Your name" name="cf_name" style="width:50%; margin-top:10px;">
                            </td>
                        </tr>
                        <tr style="width:100%;">
                            <td style="width:100%;">
                                <!--Your e-mail-->
                                <input type="text" value="Your e-mail" name="cf_email" style="width:50%; margin-top:10px;">
                            </td>
                        </tr>
                        <tr style="width:100%;">
                            <td style="width:100%;">
                                <!--Your Requirement-->
                                <textarea name="cf_message" style="height:200px; width:100%; margin-top:10px; font-family: Arial; font-size: 14px;">Your requirement</textarea>
                            </td>
                        </tr>
                        <tr style="width:100%;">
                            <td style="width:100%;">
                                <input type="submit" value="Send" style="width:auto; margin: 10px auto;">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        
        </div>

    </div> <!--main-container-->

	<?
	include("include/rightCommon.php");
	?>    

</body>

<script> 
    $("#advertise-form").bind("submit", function(e)
    {
        e.preventDefault();
        advertise();
    });

</script>

</html>